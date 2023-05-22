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
    <title>Магазин</title>

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
            <h3>Магазин</h3>
            <p><a href="home.php">Головна</a> / Магазин</p>
        </div>
    </section>

    <section class="search-form">
        <form action="" method="post">
            <div>
                <input class="search-name" type="text" name="search_name" placeholder="Пошук...">
                <input class="about-btn" style="margin-top: 0" type="submit" value="Пошук" name="submit">
            </div>
            <div>
                <input class="search-name" type="number" min="1" max="100000" value="1" name="min_price">
                <input class="search-name" type="number" min="1" max="100000" value="100000" name="max_price">
                <select class="search-name" name="type">
                    <option value="Все">Все</option>
                    <option value="Каблучки">Каблучки</option>
                    <option value="Сережки">Сережки</option>
                    <option value="Ланцюжки">Ланцюжки</option>
                    <option value="Колье">Колье</option>
                    <option value="Підвіски">Підвіски</option>
                    <option value="Браслети">Браслети</option>
                    <option value="Хрестики">Хрестики</option>
                    <option value="Годинники">Годинники</option>
                </select>
            </div>
        </form>
    </section>

    <section class="decorations">
        <div class="catalog">
            <?php
            if (isset($_POST['submit'])) {
                $search_item = $_POST['search_name'];
                $min_value = $_POST['min_price'];
                $max_value = $_POST['max_price'];
                $type = $_POST['type'];
                if ($type == 'Все') {
                    $select_decorations = mysqli_query($conn, "SELECT * FROM `decorations` WHERE name LIKE '%{$search_item}%' AND $min_value < price AND price < $max_value") or die('query failed');
                } else {
                    $select_decorations = mysqli_query($conn, "SELECT * FROM `decorations` WHERE name LIKE '%{$search_item}%' AND $min_value < price AND price < $max_value AND type LIKE '%{$type}%'") or die('query failed');
                }
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
                    <div class="empty">Наразі у нас немає такої продукції :(</div>
                <?php }
            } else {
                $select_decorations = mysqli_query($conn, "SELECT * FROM `decorations`") or die('query failed');
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
                    <div class="empty">Наразі у нас немає такої продукції :(</div>
                <?php }
            } ?>
        </div>
    </section>

    <?php include 'footer.php' ?>
</body>