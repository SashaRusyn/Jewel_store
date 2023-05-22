<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['submit'])) {
    $message_name = $_POST['name'];
    $message_number = $_POST['number'];
    $message_email = $_POST['email'];
    $message_text = $_POST['message'];

    $message_send = mysqli_query($conn, "INSERT INTO `message` (user_id, number, email ,name, message) VALUES('$user_id', '$message_number', '$message_email', '$message_name', '$message_text')") or die('query failed');
    if ($message_send) {
        $message[] = 'Повідомлення надіслано';
    } else {
        $message[] = 'Нажаль відбулася помилка, повідомлення не надіслано';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конктакти</title>

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

    <?php include 'header.php' ?>
    <section class="home" style="min-height: 30rem">
        <div class="content">
            <h3>Контакти</h3>
            <p><a href="home.php">Головна</a> / Контакти</p>
        </div>
    </section>
    <section class="contact">
        <form action="" method="post">
            <h3>Опишіть нам свою проблему</h3>
            <div class="inputBox">
                <span>Ваше ім'я :</span>
                <input type="text" name="name" required="" placeholder="Введіть ваше ім'я">
            </div>
            <div class="inputBox">
                <span>Ваш email :</span>
                <input type="email" name="email" required="" placeholder="Введіть ваш email">
            </div>
            <div class="inputBox">
                <span>Ваш номер телефону :</span>
                <input type="text" name="number" required="" placeholder="Введіть ваш номер телефону">
            </div>
            <div class="inputBox">
                <span>Ваше питання :</span>
                <textarea type="text" name="message" required="" placeholder="Опишіть вашу проблему"></textarea>
            </div>
            <input type="submit" value="Надіслати" class="about-btn" name="submit">
        </form>
    </section>
    <?php include 'footer.php' ?>
</body>