<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) == 0) {
        if ($pass != $cpass) {
            $message[] = 'Ви не підтвердили пароль!';
        } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', 'user')") or die('query failed');
            $message[] = 'Ви успішно зареєстровані!';
            header('location:login.php');
        }

    } else {
        $message[] = 'Даний користувач існує!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>

    <div class="form-container">

        <form action="" method="post">
            <h3>реєстрація</h3>
            <input type="email" name="email" placeholder="Email" required class="box">
            <input type="text" name="name" placeholder="Ваше ім'я" required class="box">
            <input type="password" name="password" placeholder="Пароль" required class="box">
            <input type="password" name="cpassword" placeholder="Підтвердження паролю" required class="box">
            <input type="submit" name="submit" value="Зареєструватися" class="btn">
            <p>Вже є акаунт? <a href="login.php">Увійти в акаунт</a></p>
        </form>

    </div>

</body>

</html>