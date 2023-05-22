<?php

include 'config.php';
session_start();

$user_id = $_SESSION['admin_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
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

    <section class="users">
        <h1 class="title">Користувачі</h1>
        <div class="box-container">
            <?php
            $users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            if (mysqli_num_rows($users) > 0) {
                while ($user = mysqli_fetch_assoc($users)) {
                    ?>
                    <div class="user">
                        <p>Ім'я: <span>
                                <?php echo $user['name'] ?>
                            </span></p>
                        <p>Email: <span>
                                <?php echo $user['email'] ?>
                            </span></p>
                        <p>User id: <span>
                                <?php echo $user['id'] ?>
                            </span></p>
                        <a href="admin_users.php?delete=<?php echo $user['id']; ?>" class="delete-btn"
                            onclick="return confirm('Видалити це користувача?');">&#10006;</a>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Наразі у нас немає користувачів :(</div>
            <?php } ?>
        </div>
    </section>
</body>