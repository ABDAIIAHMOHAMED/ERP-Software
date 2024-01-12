<?php
ob_start();
session_start();
$pg_name = "Login";
include "../functions/general.php";
if (login_redirect() == 0) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Faster way to communicate with your clients and sell your products in clear and easy way" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="theme-color" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- End Fonts -->

    <link rel="stylesheet" href="../styles/normalize.css" />
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/media.css">
    <link rel="icon" type="image/png" href="../images/icon.png">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery.js"></script>

    <title>
      <?= $pg_name ?>
    </title>
  </head>

  <body>
    <div class="login-form">
      <div class="contain">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="login-form" autocomplete="off">
          <input autocomplete="false" name="hidden" type="text" style="display:none;">
          <img src="../images/icon.png" alt="">
          <h2>Login</h2>
          <span class="log-error"><?= login_check() ?></span>
          <div class="input-box">
            <input type="text" name="email" auto-complete="off" required />
            <span>Email</span>
          </div>
          <div class="input-box">
            <input type="password" name="password" autocomplete="new-password" required />
            <span>Password</span>
          </div>
          <input type="submit" name="login" value="Login">
          <!-- <a href="forgot.php">Forgot password ?</a>
    <a href="signup.php">Create New Account</a> -->
        </form>
      </div>
    </div>
  <?php
} else {
  header("Location:index.php");
  exit();
}
include "includes/footer.inc";
  ?>