<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['submit_add'])) {
    $decoration_price = $_POST['decoration_price'];
    $decoration_name = $_POST['decoration_name'];
    $decoration_amount = $_POST['decoration_amount'];
    $decoration_image = $_POST['decoration_image'];

    $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id' AND name = '$decoration_name'") or die('query failed');

    if (mysqli_num_rows($check_cart) > 0) {
        $message[] = 'Прикраса вже була додана в кошик ;)';
    } else {
        mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, quantity, image) VALUES('$user_id', '$decoration_name', '$decoration_price', '$decoration_amount', '$decoration_image')") or die('query failed');
        $message[] = 'Прикраса додана до кошику';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>

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
    <section class="home">
        <div class="content">
            <h3>Створюємо моменти вічності</h3>
            <p>Ювелірна мережа, де мрії стають реальністю</p>
            <a class="about-btn" href="about.php">Дізнатися більше</a>
        </div>
    </section>
    <section class="decorations">
        <h3 class="title">Останні пропозиції</h3>
        <div class="catalog">
            <?php
            $select_decorations = mysqli_query($conn, "SELECT * FROM `decorations` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_decorations) > 0) {
                while ($fetch_decoration = mysqli_fetch_assoc($select_decorations)) {
                    ?>
                    <form action="" method="post">
                        <img src="uploaded_img/<?php echo $fetch_decoration['image'] ?>" alt="">
                        <div class="name">
                            <?php echo $fetch_decoration['name'] ?>
                        </div>
                        <div class="price">
                            &#8372;
                            <?php echo $fetch_decoration['price'] ?>
                        </div>
                        <input type="number" min="1" value="1" name="decoration_amount" class="amount">
                        <input type="hidden" value="<?php echo $fetch_decoration['name'] ?>" name="decoration_name">
                        <input type="hidden" value="<?php echo $fetch_decoration['price'] ?>" name="decoration_price">
                        <input type="hidden" value="<?php echo $fetch_decoration['image'] ?>" name="decoration_image">
                        <input type="submit" value="Додати до кошику" name="submit_add" class="btn">
                    </form>
                <?php }
            } else { ?>
                <div class="empty">Наразі у нас немає продукції :(</div>
            <?php } ?>
        </div>
        <div class="load">
            <a href="shop.php" class="option-btn">Більше прикрас</a>
        </div>
    </section>
    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="images/about-us.jpg">
            </div>
            <div class="content">
                <h3>Про нас</h3>
                <p>Ювелірна мережа яка допоможе тобі здійснити найзаповідніші мрії</p>
                <a href="about.php" class="about-btn">Читати більше</a>
            </div>
        </div>
    </section>
    <section class="home-contact">
        <div class="content">
            <h3>У вас є питання до нас?</h3>
            <p>Тоді напишіть нашій технічній підтримці і ми допоможемо вирішити вашу проблему</p>
            <a href="contact.php" class="option-btn">Напиши нам</a>
        </div>
    </section>
    <?php include 'footer.php' ?>
</body>