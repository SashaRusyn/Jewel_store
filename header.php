<?php
include 'config.php';

$user_id = $_SESSION['user_id'];
?>

<header class="header">

    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
            <p><a href="login.php">Вхід</a> | <a href="register.php">Реєстрація</a> </p>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">
            <a href="home.php" class="logo">
                <p class="fa-regular fa-gem"></p>Jewel
            </a>

            <nav class="navbar">
                <a href="home.php">Головна</a>
                <a href="about.php">Про нас</a>
                <a href="shop.php">Магазин</a>
                <a href="contact.php">Контакти</a>
                <a href="orders.php">Замовлення</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="shop.php" class="fas fa-search"></a>
                <div id="user-btn" class="fas fa-user"></div>
                <?php
                $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_rows_number = mysqli_num_rows($select_cart_number);
                ?>
                <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(
                        <?php echo $cart_rows_number; ?>)
                    </span> </a>
            </div>

            <div class="user-box">
                <p>Ім'я : <span>
                        <?php echo $_SESSION['user_name']; ?>
                    </span></p>
                <p>Email : <span>
                        <?php echo $_SESSION['user_email']; ?>
                    </span></p>
                <a href="logout.php" class="delete-btn">Вихід</a>
            </div>
        </div>
    </div>

</header>
<script src="js/script.js"></script>