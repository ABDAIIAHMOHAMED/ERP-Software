<?php
ob_start();
$pg_name = "Wonder - Suspended";
session_start();

$functions_route = "../";
$css_route = "../";
$image_route = "../";
$js_route = "../";
$path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$path .= $_SERVER["SERVER_NAME"] . rtrim(dirname($_SERVER["PHP_SELF"])) . "/";
include  $functions_route . "functions/general.php";
if (login_redirect() == 1) {
  $user_info = login_info();
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
    <link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />
    <link href="../webfonts/felix.ttf" />
    <!-- End Fonts -->

    <link rel="stylesheet" href="<?= $css_route ?>styles/normalize.css" />
    <link rel="stylesheet" href="<?= $css_route ?>styles/all.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.css">
    <link rel="stylesheet" href="<?= $css_route ?>styles/media.css">
    <link rel="stylesheet" href="<?= $css_route ?>styles/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?= $css_route ?>styles/daterangepicker.css" />
    <link rel="stylesheet" href="<?= $css_route ?>styles/style.css">
    <link rel="stylesheet" href="<?= $css_route ?>styles/main.css" />
    <link rel="stylesheet" href="styles/style.css">



    <link rel="icon" type="image/png" href="<?= $image_route ?>images/icon.png">
    <script src="<?= $js_route ?>js/jquery-3.6.0.min.js"></script>
    <script src="<?= $js_route ?>js/moment.min.js"></script>
    <script src="<?= $js_route ?>js/daterangepicker.js"></script>
    <script src="<?= $js_route ?>js/main.js"></script>

    <script src="<?= $js_route ?>js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.6/vivus.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script src="js/papaparse.min.js"></script>
    <script src="<?= $js_route ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= $js_route ?>js/dataTables.buttons.min.js"></script>
    <script src="<?= $js_route ?>js/buttons.html5.min.js"></script>
    <script src="<?= $js_route ?>js/buttons.print.min.js"></script>
    <script src="<?= $js_route ?>js/pdfmake.min.js"></script>
    <script src="<?= $js_route ?>js/vfs_fonts.js"></script>
    <script src="js/jquery.js"></script>
    <script src="<?= $js_route ?>js/chart.min.js"></script>
    <script src="js/JsBarcode.all.js"></script>
    <style>
      .rside {
        width: 100vw;
        margin-left: 0;
      }

      .header {
        width: 100vw;
      }

      .body.container.warning-body {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-direction: column;
      }

      .left i {
        font-size: 100px;
        color: var(--main-color);
        opacity: 0.5;
      }

      .right h2 {
        margin: 0;
        font-weight: 800;
        color: var(--alt-color);
        margin-bottom: 3px;
      }

      span.date {
        font-size: 14px;
        font-weight: 300;
      }

      .right {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .right p {
        font-size: 16px;
        width: 75%;
        min-width: 300px;
        padding-bottom: 10px;
        border-bottom: 1px dashed var(--main-color);
      }
    </style>
    <title>
      <?= $pg_name ?>
    </title>
  </head>

  <body>
    <div class="contain">
      <div class="rside">
        <div class="header">
          <div class="lhead">
            <a href="<?= $path . "../" ?>" class="back">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 240.823 240.823" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                  <path d="M57.633 129.007 165.93 237.268c4.752 4.74 12.451 4.74 17.215 0 4.752-4.74 4.752-12.439 0-17.179l-99.707-99.671 99.695-99.671c4.752-4.74 4.752-12.439 0-17.191-4.752-4.74-12.463-4.74-17.215 0L57.621 111.816c-4.679 4.691-4.679 12.511.012 17.191z" fill="#332f2a" data-original="#000000" class=""></path>
                </g>
              </svg>
            </a>
          </div>
          <div class="rhead">
            <form action="search.php" method="get" class="searchform">
              <input type="text" name="q" placeholder="Search">
              <input type="submit" value="">
            </form>
            <div class="log-btn" title="Connected">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                  <circle cx="256" cy="403.113" r="47.692" fill="#63c667" transform="rotate(-80.8 255.93 403.135)" data-original="#000000" class=""></circle>
                  <path d="M497.765 161.344C429.036 92.616 340.65 61.195 256 61.195S82.964 92.616 14.235 161.344c-18.994 19.016-18.907 48.462-.177 67.271 23.39 23.65 54.014 14.236 67.727.064 46.554-46.492 108.419-72.096 174.215-72.096s127.661 25.604 174.215 72.096c13.713 14.172 44.337 23.586 67.727-.064 18.73-18.809 18.817-48.255-.177-67.271z" fill="#63c667" data-original="#000000" class=""></path>
                  <path d="M256 208.303c-47.421 0-98.304 17.63-137.733 57.05-19.237 19.236-18.854 48.818.192 67.663 18.911 18.782 48.334 18.703 67.24-.203 18.778-18.777 43.744-29.118 70.3-29.118s51.522 10.341 70.3 29.118c18.906 18.906 48.33 18.985 67.24.203 19.046-18.845 19.429-48.427.192-67.663-39.427-39.419-90.31-57.05-137.731-57.05z" fill="#63c667" data-original="#000000" class=""></path>
                </g>
              </svg>
            </div>


            <div class="profile">

              <div class="flex">
                <div class="profile-img">
                  <img src="<?= $image_route ?>images/ur-img/<?= $user_info['picture'] ?>" alt="">
                </div>
                <div class="profile-info">
                  <h5>
                    <?= ucfirst($user_info['fname']) . " " . ucfirst($user_info['mname']) ?>
                  </h5>
                  <?php

                  $stmt43 = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $user_info['role'] . "'");
                  $stmt43->execute();
                  $count43 = $stmt43->rowCount();
                  $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);

                  ?>
                  <p>
                    <?= ucfirst($row43['name']) ?>
                  </p>
                </div>
              </div>
              <span class="arrow">
                <img src="<?= $image_route ?>images/down.png" alt="">
              </span>
              <ul>
                <li><a href="<?= $path . "../logout.php" ?>"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="body container warning-body">
          <div class="left">
            <i class="fa-solid fa-triangle-exclamation"></i>
          </div>
          <div class="right">
            <h2>Software has been suspended!</h2>
            <span class="date">Issue Date : 2023-10-01</span>
          </div>
        </div>
      <?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/../login.php");
      exit();
    }
    include "includes/footer.inc";
      ?>