<?php

include 'config.php';
session_start();

$user_id = $_SESSION['admin_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
}

if (isset($_POST['submit_update'])) {
    $order_id = $_POST['id'];
    $order_payment_status = $_POST['update_payment_status'];

    $update_order = mysqli_query($conn, "UPDATE `orders` SET payment_status = '$order_payment_status' WHERE id = '$order_id'") or die('query failed');
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

    <section class="orders">
        <h1 class="title">Всі замовлення</h1>
        <div class="box-container">
            <?php
            $your_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
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
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $order['id'] ?>">
                                    <select class="search-name" name="update_payment_status" required>
                                        <option value="" selected disabled>
                                            <?php echo $order['payment_status']; ?>
                                        </option>
                                        <option value="Очікується">Очікується</option>
                                        <option value="Виконано">Виконано</option>
                                    </select>
                                    <input type="submit" value="Оновити" name="submit_update" class="about-btn">
                                    <a href="admin_products.php?delete=<?php echo $order['id']; ?>" class="delete-btn once"
                                        onclick="return confirm('Видалити це замовлення?');">&#10006;</a>
                                </form>
                            </span></p>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Наразі у нас немає замовлень :(</div>
            <?php } ?>
        </div>
    </section>
</body>