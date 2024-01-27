<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
  
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'Course added to All Courses!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image) VALUES('$user_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
      $message[] = 'Course add to All Courses!';
   }

};



if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Dowedar Tech</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="css/style.css">
   
   <link rel="stylesheet" href="style.css">
   <script src="script.js"></script>
   <link class="icon" rel="shortcut icon" type="image/x-icon" href="head.png">
</head>
<body>



<header>
        <div id="navbar">
            <img src="./logo.png" alt="Dowedar Tech"  href="index.php">
            <nav role="navigation">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#My Courses">My Courses & Books</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li> <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm(' Are you sure you want to logout?');" > Logout </a></li>
                    
                    <?php
      $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
      };
   ?>
   
                    
                    <!-- <li><a href="#"><?php echo $fetch_user['name']; ?></a></li> --->
                    <li id="dark-mode-toggle"><a href="#home"> Dark Mode</a></li>
                </ul>
            </nav>
   </div>
   <div class="content">
            <h1>Welcome To <span class="primary-text"> Dowedar Tech </span> Academy</h1>
            <p>Here you can Learn Programming From Zero To Top Step By Step</p>
            <a href="#Courses" class="btn btn-primary">Courses</a>
        </div>
   </header>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>




<main>
        <!-- About Section Start -->
        <section id="about">
            <div class="container">
                <div class="title">
                    <h2>Dowedar Tech</h2>
                    <p>More than 3+ years of experience</p>
                </div>
                <div class="about-content">
                    <div>
                        <p>Hello there! I'm Ahmed Dowedar Web Developer Back-end, a passionate and innovative web developer with a strong flair for crafting 
                           captivating online experiences. With a keen eye for design and a love for coding, 
                           I thrive on bringing ideas to life through the power of technology..</p>
                        
                        <a href="#" class="btn btn-secondary">LEARN MORE</a>
                    </div>
                    <img src="./images/logo.png" alt="Dowedar Tech">
                </div>
            </div>
        </section>
<section id="Courses">
<div class="container">
<div class="Courses-items">
<div class="Courses-items-left">
                     

<div class="products">

   <h1 class="heading"> All Courses & Books</h1>

   <div class="box-container">

   <?php
   include('config.php');
   $result = mysqli_query($conn, "SELECT * FROM products");      
   while($row = mysqli_fetch_array($result)){
   ?>
      <form method="post" class="box" action="">
         <img src="admin/<?php echo $row['image']; ?>"  width="200">
         <div class="name"><?php echo $row['name']; ?></div>
         <div class="price"><?php echo $row['price']; ?></div>
         
         <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
         <input type="submit" value="Get Course" name="add_to_cart" class="btn">
      </form>
   <?php
      };
   ?>
</div>
</div>
</div>
</section>
<!-- Courses Section End -->
</main>

<div class="container">
<section id="My Courses">
<div class="box-container">
<div class="shopping-cart">

   <h1 class="heading"> My Courses & Books </h1>

   <table>
      <thead>
         <th> Photo</th>
         <th> Name</th>
         <th> Review</th>
         <th>View </th>
         <th>Delete </th>
      </thead>
      <tbody>
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <td><img src="admin/<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td> <a class="delete-btn" href="#">ReView</a> </td>
            <td> <a class="delete-btn" href="#">View</a> </td>
            <td><a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm(' Delete Course from Courses?');">Delete</a></td>
         </tr>
      <?php
         
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6"> You are not Subscripe in any Courses </td></tr>';
         }
      ?>
      
   </tbody>
   </table>



</div>

</div>

<br><br><br>
</section>

<!-- Contact Section Start -->


<section id="contact">
<div class="products"><h1 class="heading"> Our Society</h1></div>

            <div class="container">
                <div class="contact-content">
                    <div class="contact-info">
                        <div>
                            <h3>ADDRESS</h3>
                            <p><i class="fa-solid fa-location-dot"></i>Aga, Dakahlia, Egypt</p>
                            <p><i class="fa-solid fa-phone"></i> Phone: +201555594743</p>
                            <p><i class="fa-regular fa-envelope"></i> dowedartech@gmail.com</p>
                        </div>
                        <div>
                            <h3>WORKING HOURS</h3>
                            <p>Available 24 hours</p>
                        </div>
                        <div class="icon">
                            <h3>FOLLOW US</h3>

                            <a href="https://www.facebook.com/DowedarTech"><i class="fa-brands fa-facebook"></a></i>
                            <a href="https://wa.me/201555594743"><i class="fa-brands fa-whatsapp"></a></i>
                            <a href="https://www.instagram.com/ahmed.dowedar2004?igsh=YzljYTk1ODg3Zg=="><i class="fa-brands fa-instagram"></a></i>
                        </div>
                    </div>
                    <form>
                        <input type="text" name="Name" id="name" placeholder="Full Name">
                        <input type="email" name="email" id="email" placeholder="Email Address">
                        <input type="text" name="subject" id="subject" placeholder="Subject">
                        <textarea name="message" id="message" cols="30" rows="5" placeholder="Message"></textarea>
                        <button type="submit" class="btn btn-third">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- Contact Section End -->
    </main>
    <footer id="footer">
        <p>Copyright &copy; 2023 All rights reserved | made by <b> <a href="https://www.facebook.com/Ahmed.dowedar2004"
                    target="_blank"> Ahmed Dowedar</a> </b></p>
    </footer>
</main>





<script>
   const body = document.body;
   const container = document.querySelector('.container');
   function toggleDarkMode(){
      body.classList.toggle('dark-mode');
      container.classList.toggle('dark-mode');
   }
   document.getElementById('dark-mode-toggle').addEventListener('click', toggleDarkMode);

</script>











</body>
</html>