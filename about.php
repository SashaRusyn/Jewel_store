<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Про нас</title>

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
            <h3>Про нас</h3>
            <p><a href="home.php">Головна</a> / Про нас</p>
        </div>
    </section>
    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="images/about-us.jpg">
            </div>
            <div class="content">
                <h3>Про нас</h3>
                <p>Ювелірна мережа яка допоможе тобі здійснити найзаповідніші мрії. Ювелірна мережа Jewel - це
                    компанія, яка пропонує розкішні прикраси та ювелірні вироби. Jewel відома своїм
                    бездоганним дизайном, високою якістю матеріалів та майстерністю виготовлення. Основними аспектами,
                    які відрізняють Jewel, є елегантність, розкіш та індивідуальність.

                    <br>Jewel пропонує широкий асортимент прикрас, включаючи каблучки, намиста, сережки, кольє та
                    браслети.
                    Кожна прикраса створюється з надзвичайною увагою до деталей та використанням найкращих матеріалів,
                    таких як дорогоцінні камені, золото, срібло та платина.
                </p>
                <a href="contact.php" class="about-btn">Напишіть нам</a>
            </div>
        </div>
    </section>
    <section class="authors">
        <h1 class="title">Автори</h1>
        <div class="box-container">
            <div class="box">
                <img src="images/profile.jpg">
                <h3>Sasha Rusyn</h3>
            </div>
            <div class="box">
                <img src="images/profile.jpg">
                <h3>Sasha Rusyn</h3>
            </div>
            <div class="box">
                <img src="images/profile.jpg">
                <h3>Sasha Rusyn</h3>
            </div>
        </div>
    </section>
    <?php include 'footer.php' ?>
</body>