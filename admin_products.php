<?php

include 'config.php';
session_start();

$user_id = $_SESSION['admin_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['submit_add_product'])) {
    $decoration_price = $_POST['price'];
    $decoration_name = $_POST['name'];
    $decoration_type = $_POST['type'];
    $decoration_image = $_FILES['image']['name'];
    $decoration_image_size = $_FILES['image']['size'];
    $decoration_image_tmp_name = $_FILES['image']['tmp_name'];
    $decoration_image_folder = 'uploaded_img/' . $decoration_image;

    $check_product = mysqli_query($conn, "SELECT * FROM `decorations` WHERE price = '$decoration_price' AND name = '$decoration_name'") or die('query failed');

    if (mysqli_num_rows($check_product) > 0) {
        $message[] = 'Прикраса вже була додана';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `decorations` (name, price, image, type) VALUES('$decoration_name', '$decoration_price', '$decoration_image', '$decoration_type')") or die('query failed');

        if ($add_product_query) {
            if ($decoration_image_size > 2000000) {
                $message[] = 'Фото занадто велике';
            } else {
                move_uploaded_file($decoration_image_tmp_name, $decoration_image_folder);
                $message[] = 'Прикраса була успішно додана!';
            }
        } else {
            $message[] = 'Прикраса не була додана!';
        }
    }
}


if (isset($_POST['submit_update_product'])) {
    $decoration_id = $_POST['update_decoration_id'];
    $decoration_price = $_POST['update_price'];
    $decoration_name = $_POST['update_name'];
    $decoration_type = $_POST['update_type'];
    $decoration_image = $_FILES['update_image']['name'];
    $decoration_image_size = $_FILES['update_image']['size'];
    $decoration_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $decoration_image_folder = 'uploaded_img/' . $decoration_image;
    $decoration_old_image = $_POST['update_old_image'];

    $update = mysqli_query($conn, "UPDATE `decorations` SET price = '$decoration_price', name = '$decoration_name', type = '$decoration_type' WHERE id = '$decoration_id'") or die('query failed');

    if (!empty($decoration_image)) {
        if ($decoration_image_size > 2000000) {
            $message[] = 'image file size is too large';
        } else {
            $update = mysqli_query($conn, "UPDATE `decorations` SET image = '$decoration_image' WHERE id = '$decoration_id'") or die('query failed');
            move_uploaded_file($decoration_image_tmp_name, $decoration_image_folder);
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `decorations` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
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

    <section class="add-products">
        <h1 class="title">Прикраси</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Додати продукт</h3>
            <input type="text" name="name" placeholder="Назва прикраси" required>
            <input type="number" min="1" name="price" placeholder="Ціна прикраси" required>
            <select class="search-name" name="type" required>
                <option value="Каблучки">Каблучки</option>
                <option value="Сережки">Сережки</option>
                <option value="Ланцюжки">Ланцюжки</option>
                <option value="Колье">Колье</option>
                <option value="Підвіски">Підвіски</option>
                <option value="Браслети">Браслети</option>
                <option value="Хрестики">Хрестики</option>
                <option value="Годинники">Годинники</option>
            </select>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required>
            <input type="submit" value="Додати прикрасу" name="submit_add_product" class="about-btn">
        </form>

    </section>

    <section class="show-decorations">
        <div class="catalog">
            <?php
            $select_decorations = mysqli_query($conn, "SELECT * FROM `decorations`") or die('query failed');
            if (mysqli_num_rows($select_decorations) > 0) {
                while ($fetch_decoration = mysqli_fetch_assoc($select_decorations)) {
                    ?>
                    <div class="box-container">
                        <a href="admin_products.php?delete=<?php echo $fetch_decoration['id']; ?>" class="delete-btn once"
                            onclick="return confirm('Видалити прикрасу?');">&#10006;</a>
                        <img src="uploaded_img/<?php echo $fetch_decoration['image'] ?>" alt="">
                        <div class="name">
                            <?php echo $fetch_decoration['name'] ?>
                        </div>
                        <div class="price">
                            &#8372;
                            <?php echo $fetch_decoration['price'] ?>
                        </div>
                        <a href="admin_products.php?update=<?php echo $fetch_decoration['id'] ?>" class="option-btn">Оновити</a>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Немає ніяких продуктів</div>
            <?php } ?>
        </div>
    </section>

    <section class="edit-product-form">
        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `decorations` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_decoration_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required
                            placeholder="Введіть нову назву прикраси">
                        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box"
                            required placeholder="Введіть нову ціну">
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <select class="search-name" name="update_type" required>
                            <option value="Каблучки">Каблучки</option>
                            <option value="Сережки">Сережки</option>
                            <option value="Ланцюжки">Ланцюжки</option>
                            <option value="Колье">Колье</option>
                            <option value="Підвіски">Підвіски</option>
                            <option value="Браслети">Браслети</option>
                            <option value="Хрестики">Хрестики</option>
                            <option value="Годинники">Годинники</option>
                        </select>
                        <input type="submit" value="Оновити" name="submit_update_product" class="btn">
                        <input type="reset" value="Відмінити" id="close-update" class="option-btn">
                    </form>
                    <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>
    </section>
</body>