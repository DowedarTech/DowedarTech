<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal  | لوحة الأدمن </title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<center>
        <div class="main">
            <form action="insert.php" method="post" enctype="multipart/form-data">
                <h2> Dowedar Tech Admin  </h2>
                <img src="head.png" alt="logo" width="450px">
                <input type="text" name='name' required placeholder="Course Name">
                <br>
                <input type="text" name='price' required placeholder="Course Price">
                <br>
                <input type="file" id="file" name='image' style='display:none;'>
                <label for="file"> Chosse Course Or Book Photo </label>
                <button name='upload'> Upload Course Or Books ✅</button>
                <br><br>
                <a href="products.php"> View All Courses & Bokks </a>
            </form>
        </div>
        <p>Developer By Dowedar Tech</p>
    </center>
</body>
</html>