<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['submit_update'])) {
    $decoration_price = $_POST['decoration_price'];
    $decoration_name = $_POST['decoration_name'];
    $decoration_amount = $_POST['decoration_amount'];
    $decoration_image = $_POST['decoration_image'];

    $check_cart = mysqli_query($conn, "UPDATE `cart` SET quantity = $decoration_amount WHERE user_id = '$user_id' AND name = '$decoration_name'") or die('query failed');

    if ($check_cart) {
        $message[] = 'Дані оновлено ;)';
    } else {
        $message[] = 'Відбулася помилка :(';
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кошик</title>

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

    <?php include 'header.php'; ?>

    <section class="home" style="min-height: 30rem">
        <div class="content">
            <h3>Кошик</h3>
            <p><a href="home.php">Головна</a> / Кошик</p>
        </div>
    </section>

    <section class="shopping-cart">
        <div class="catalog">
            <?php
            $select_decorations = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id") or die('query failed');
            if (mysqli_num_rows($select_decorations) > 0) {
                while ($fetch_decoration = mysqli_fetch_assoc($select_decorations)) {
                    ?>
                    <div class="box-container">
                        <a href="cart.php?delete=<?php echo $fetch_decoration['id']; ?>" class="delete-btn once"
                            onclick="return confirm('Ви справді хочете видалити з кошика?');">&#10006;</a>
                        <img src="uploaded_img/<?php echo $fetch_decoration['image'] ?>" alt="">
                        <div class="name">
                            <?php echo $fetch_decoration['name'] ?>
                        </div>
                        <div class="price">
                            &#8372;
                            <?php echo $fetch_decoration['price'] ?>
                        </div>
                        <form action="" method="post">
                            <input type="number" min="1" value="<?php echo $fetch_decoration['quantity'] ?>"
                                name="decoration_amount" class="amount">
                            <input type="hidden" value="<?php echo $fetch_decoration['name'] ?>" name="decoration_name">
                            <input type="hidden" value="<?php echo $fetch_decoration['price'] ?>" name="decoration_price">
                            <input type="hidden" value="<?php echo $fetch_decoration['image'] ?>" name="decoration_image">
                            <input type="submit" value="Оновити кількість" name="submit_update" class="btn">
                        </form>
                        <div class="sum-price">
                            <p>Загальна сума: </p>
                            &#8372;
                            <?php echo ($fetch_decoration['price'] * $fetch_decoration['quantity']); ?>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Ви нічого не додали до вашого кошика</div>
            <?php } ?>
        </div>

        <div class="delete-all" style="margin-top: 2rem; text-align:center;">
            <a href="cart.php?delete_all"
                class="delete-btn <?php echo (mysqli_num_rows($select_cart_number) > 0) ? '' : 'disabled'; ?>"
                onclick="return confirm('delete all from cart?');">Очистити кошик</a>
        </div>

        <div class="cart-total">
            <p>Загальна сума: &#8372;
                <?php $select_decorations = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id")
                    or die('query failed');
                $cart_total = 0;
                if (mysqli_num_rows($select_decorations) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_decorations)) {
                        $cart_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    }
                }
                echo $cart_total ?>
            </p>
            <div class="flex">
                <a class="option-btn" href="shop.php">Продовжити покупки</a>
                <a class="option-btn <?php echo (mysqli_num_rows($select_cart_number) > 0) ? '' : 'disabled'; ?>"
                    href="checkout.php">Перейти до замовлення</a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>