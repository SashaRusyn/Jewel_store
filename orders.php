<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Замовлення</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
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

    <?php include 'header.php'; ?>

    <section class="home" style="min-height: 30rem">
        <div class="content">
            <h3>Замовлення</h3>
            <p><a href="home.php">Головна</a> / Замовлення</p>
        </div>
    </section>

    <section>
        <h1 class="title">Ваші замовлення</h1>

        <div class="orders">
            <?php
            $your_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = $user_id") or die('query failed');
            if (mysqli_num_rows($your_orders) > 0) {
                while ($order = mysqli_fetch_assoc($your_orders)) {
                    ?>
                    <div class="order">
                        <p>Зроблене: <span>
                                <?php echo $order['placed_on'] ?>
                            </span></p>
                        <p>Ваше ім'я: <span>
                                <?php echo $order['name'] ?>
                            </span></p>
                        <p>Телефон: <span>
                                <?php echo $order['number'] ?>
                            </span></p>
                        <p>Email: <span>
                                <?php echo $order['email'] ?>
                            </span></p>
                        <p>Адреса: <span>
                                <?php echo $order['address'] ?>
                            </span></p>
                        <p>Спосіб оплати: <span>
                                <?php echo $order['method'] ?>
                            </span></p>
                        <p>Ваше замовлення: <span>
                                <?php echo $order['total_products'] ?>
                            </span></p>
                        <p>Сумарна вартість: <span>&#8372;
                                <?php echo $order['total_price'] ?>
                            </span></p>
                        <p>Статус замовлення: <span>
                                <?php echo $order['payment_status'] ?>
                            </span></p>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Наразі у нас немає продукції :(</div>
            <?php } ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>