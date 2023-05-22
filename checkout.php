<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

$cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
if (mysqli_num_rows($cart) < 1) {
    header('location:home.php');
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'Область: ' . $_POST['state'] . ', Район: ' . $_POST['district'] . ', Населений пункт:  ' . $_POST['locality']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            array_push($cart_products, $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ');
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = substr(implode(', ', $cart_products), 2);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $message[] = 'Ваш кошик порожній';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $message[] = 'Ваше замовлення вже було прийняте!';
        } else {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $message[] = 'Ваше замовлення прийнято!';
            header('location:home.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформлення замовлення</title>

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
            <h3>Оформлення замовлення</h3>
            <p><a href="home.php">Головна</a> / <a href="cart.php">Кошик</a> / Оформлення замовлення</p>
        </div>
    </section>
    <section class="display-order">
        <?php while ($fetch_cart = mysqli_fetch_assoc($cart)) {
            ?>

            <p>
                <?php echo $fetch_cart['name'] ?>
                (&#8372;
                <?php echo $fetch_cart['price'] ?>
                &#10006;
                <?php echo $fetch_cart['quantity'] ?>
                )
            </p>

        <?php } ?>

        <div class="grand-total">Загальна сума: &#8372;
            <?php $select_decorations = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id")
                or die('query failed');
            $cart_total = 0;
            if (mysqli_num_rows($select_decorations) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_decorations)) {
                    $cart_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                }
            }
            echo $cart_total ?>
        </div>
    </section>
    <section class="checkout">
        <form action="" method="post">
            <h3>Розмістіть своє оголошення</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Ваше ім'я :</span>
                    <input type="text" name="name" required="" placeholder="Введіть ваше ім'я">
                </div>
                <div class="inputBox">
                    <span>Ваш номер телефону :</span>
                    <input type="text" name="number" required="" placeholder="Введіть ваш номер телефону">
                </div>
                <div class="inputBox">
                    <span>Ваш email :</span>
                    <input type="text" name="email" required="" placeholder="Введіть ваш email">
                </div>
                <div class="inputBox">
                    <span>Ваша область :</span>
                    <input type="text" name="state" required="" placeholder="Введіть вашу область">
                </div>
                <div class="inputBox">
                    <span>Ваш район :</span>
                    <input type="text" name="district" required="" placeholder="Введіть ваш район">
                </div>
                <div class="inputBox">
                    <span>Ваш населений пункт :</span>
                    <input type="text" name="locality" required="" placeholder="Введіть ваш населений пункт">
                </div>
                <div class="inputBox">
                    <span>Вид оплати :</span>
                    <select name="method">
                        <option value="Готівниковий платіж">Готівковий платіж</option>
                        <option value="Кредитна карта">Кредитна карта</option>
                        <option value="PayPal">PayPal</option>
                        <option value="GooglePay">GooglePay</option>
                        <option value="ApplePay">ApplePay</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Підтвердіть замовлення :</span>
                    <input type="submit" value="Замовити зараз" class="about-btn" name="submit">
                </div>
            </div>
        </form>
    </section>
    <?php include 'footer.php' ?>
</body>