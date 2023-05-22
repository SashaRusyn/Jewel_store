<?php

include 'config.php';
session_start();

$user_id = $_SESSION['admin_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_message.php');
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
        <h1 class="title">Повідомлення</h1>
        <div class="box-container">
            <?php
            $messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            if (mysqli_num_rows($messages) > 0) {
                while ($message = mysqli_fetch_assoc($messages)) {
                    ?>
                    <div class="user">
                        <p>User Id: <span>
                                <?php echo $message['user_id'] ?>
                            </span></p>
                        <p>Ім'я: <span>
                                <?php echo $message['name'] ?>
                            </span></p>
                        <p>Email: <span>
                                <?php echo $message['email'] ?>
                            </span></p>
                        <p>Номер телефону: <span>
                                <?php echo $message['number'] ?>
                            </span></p>
                        <p>Повідомлення: <span>
                                <?php echo $message['message'] ?>
                            </span></p>
                        <a href="admin_message.php?delete=<?php echo $message['id']; ?>" class="delete-btn"
                            onclick="return confirm('Видалити це повідомлення?');">&#10006;</a>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">Наразі у нас немає повідомлень</div>
            <?php } ?>
        </div>
    </section>
</body>