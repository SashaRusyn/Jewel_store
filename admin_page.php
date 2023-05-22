<?php

include 'config.php';
session_start();

$user_id = $_SESSION['admin_id'];

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
    <title>Адмін панель</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_page.css">

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

    <?php include 'admin_header.php' ?>
    <h1 class="title">Інформаційна дошка</h1>
    <section class="dashboard">
        <div class="box-container">
            <div class="box">
                <?php
                $result = 0;
                $total_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'Очікується'") or die('query failed');
                while ($fetch_total_pending = mysqli_fetch_assoc($total_pending)) {
                    $result += $fetch_total_pending['total_price'];
                }
                ?>
                <h3>&#8372;
                    <?php echo $result ?>
                </h3>
                <p>Сума замовлень з статусом "Очікується"</p>
            </div>
            <div class="box">
                <?php
                $result = 0;
                $total_complete = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'Виконано'") or die('query failed');
                while ($fetch_total_pending = mysqli_fetch_assoc($total_complete)) {
                    $result += $fetch_total_pending['total_price'];
                }
                ?>
                <h3>&#8372;
                    <?php echo $result ?>
                </h3>
                <p>Сума замовлень з статусом "Виконано"</p>
            </div>
            <div class="box">
                <?php
                $total_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                ?>
                <h3>
                    <?php echo mysqli_num_rows($total_orders) ?>
                </h3>
                <p>Кількість всіх замовлень</p>
            </div>
            <div class="box">
                <?php
                $total_decorations = mysqli_query($conn, "SELECT * FROM `decorations`") or die('query failed');
                ?>
                <h3>
                    <?php echo mysqli_num_rows($total_decorations) ?>
                </h3>
                <p>Кількість всіх доданих товарів</p>
            </div>
            <div class="box">
                <?php
                $total_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                ?>
                <h3>
                    <?php echo mysqli_num_rows($total_users) ?>
                </h3>
                <p>Звичайних користувачів</p>
            </div>
            <div class="box">
                <?php
                $total_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                ?>
                <h3>
                    <?php echo mysqli_num_rows($total_admins) ?>
                </h3>
                <p>Адмінів</p>
            </div>
            <div class="box">
                <h3>
                    <?php echo mysqli_num_rows($total_admins) + mysqli_num_rows($total_users) ?>
                </h3>
                <p>Всього користувачів</p>
            </div>
            <div class="box">
                <?php
                $total_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                ?>
                <h3>
                    <?php echo mysqli_num_rows($total_messages) ?>
                </h3>
                <p>Повідомлень</p>
            </div>
        </div>
    </section>
</body>