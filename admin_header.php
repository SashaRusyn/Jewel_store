<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php">Головна</a>
         <a href="admin_products.php">Прикраси</a>
         <a href="admin_orders.php">Замовлення</a>
         <a href="admin_users.php">Користувачі</a>
         <a href="admin_message.php">Повідомлення</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>username : <span>
               <?php echo $_SESSION['admin_name']; ?>
            </span></p>
         <p>email : <span>
               <?php echo $_SESSION['admin_email']; ?>
            </span></p>
         <a href="logout.php" class="delete-btn" style="margin-bottom: 1rem;">logout</a>
         <div><a href="login.php">login</a> | <a href="register.php">register</a></div>
      </div>

   </div>
   <script src="js/admin_script.js"></script>
</header>