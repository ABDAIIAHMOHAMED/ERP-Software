<?php
$pg_name = "Wonder - Employees";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();

  $num_per_page = 12;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $active = "('0','1')";
    } elseif ($status == "approved") {
      $active = "('1')";
    } elseif ($status == "active") {
      $active = "('1')";
    } elseif ($status == "inactive") {
      $active = "('0')";
    } else {
      $active = "('0','1')";
    }
  } else {
    $active = "('0','1')";
  }
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt60 = $con->prepare("SELECT * FROM `users` WHERE `name` LIKE '$search_name%' AND activate in $active ORDER BY `name` ");
    $stmt60->execute();
  } else {
    $stmt60 = $con->prepare("SELECT * FROM `users` WHERE activate in $active ORDER BY `name`");
    $stmt60->execute();
  }
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  $total_results = $start_from + $num_per_page;
  if ($total_results > $total_records) {
    $total_results = $total_records;
  }
  if ($start_from == 0) {
    $start_from = 1;
  }
?>


  <div class="att-part">
    <div class="title-head">
      <div class="headso">
        <h3>Employee Profile</h3>
        <hr class="head-line">
        <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "employees.php" ?>">Employees</a>
          / Employee Profile</p>
      </div>
    </div>
    <div class="main-prof">

      <div class="l-main-prof">
        <div class="l-main-prof-img">
          <img src="../images/ur-img/profile3.png" alt="">
        </div>
        <div class="l-main-prof-info">
          <h2>Abdallah Mohamed Omar<span>( User )</span></h2>
          <span>#1</span>
        </div>
      </div>

      <div class="r-main-prof">
        <div class="r-main-prof-part">
          <div class="r-main-prof-icon"><i class="fa-solid fa-phone"></i></div>
          <div class="r-main-prof-value">+201094432940</div>
        </div>
        <div class="r-main-prof-part">
          <div class="r-main-prof-icon"><i class="fa-solid fa-envelope"></i></div>
          <div class="r-main-prof-value">abdallahmohamed8862@gmail.com</div>
        </div>
        <div class="r-main-prof-part">
          <form action="" method="POST"><input type="submit" name="log-as" value="Login"></form>
          <div class="r-main-prof-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
          <div class="r-main-prof-value">Login as Abdallah Mohamed</div>
        </div>
      </div>

    </div>

    <div class="prof-tools">



      <a href="#"><i class="fa-solid fa-pen-to-square"></i> Edit</a>


      <a href="#"><i class="fa-regular fa-circle-xmark"></i>Disbale</a>


      <a href="#"><i class="fa-solid fa-table"></i>Track Attendance</a>
      <a href="#"><i class="fa-solid fa-money-bill"></i> &nbsp; Advance Payment</a>

      <a href="#" class="del-warn"><i class="fa-solid fa-trash"></i>Delete</a>

    </div>

    <div class="prof-details-box">
      <h6>
        <a href="#" class="active">Details</a>
        <a href="#">Contract</a>
        <a href="#">Logs</a>
      </h6>

      <div class="prof-details-section">
        <div class="prof-details-title">Employee Information</div>
        <div class="prof-infos">


          <div class="prof-r-info">
            <div class="prof-ex">
              <h5>Phone Number:</h5>
              <span>+201094432940</span>
            </div>
            <div class="prof-ex">
              <h5>Current Address:</h5>
              <span>222 Second District , The second region</span>
              <span>El Obour</span>
              <span>Cairo , Egypt</span>
              <span></span>
            </div>

          </div>

          <div class="prof-l-info">
            <div class="prof-ex">
              <h5>Personal Email:</h5>
              <span>abdallahmohamed8862@gmail.com</span>
            </div>
            <div class="prof-ex">
              <h5>Gender:</h5>
              <span>Male</span>
            </div>
            <div class="prof-ex">
              <h5>Birthday:</h5>
              <span>1920-09-10</span>
            </div>
          </div>


        </div>
        <div class="prof-details-title">Account Information</div>

        <div class="prof-infos">


          <div class="prof-r-info">

            <div class="prof-ex">
              <h5>Email:</h5>
              <span>abdallah@wonder-eg.com</span>
            </div>

            <div class="prof-ex">
              <h5>Job Title:</h5>
              <span>Head Office</span>
            </div>
            <div class="prof-ex">
              <h5>Category:</h5>
              <span>Accounting</span>
            </div>
            <div class="prof-ex">
              <h5>Career Level:</h5>
              <span>Senior</span>
            </div>

            <div class="prof-ex">
              <h5>Joining Date:</h5>
              <span>2022-07-31 <div>10 Month ago - 15 Days ago </div></span>
            </div>
          </div>

          <div class="prof-l-info">
            <div class="prof-ex">
              <h5>Job Role:</h5>
              <span>Admin</span>
            </div>
            <div class="prof-ex">
              <h5>Type of Job:</h5>
              <span>Office</span>
            </div>
            <div class="prof-ex">
              <h5>Status:</h5>
              <span><span class="gn">Active</span></span>
            </div>
            <div class="prof-ex">
              <h5>Notes:</h5>
              <span></span>
            </div>
          </div>


        </div>
      </div>
    </div>

  </div>
  <script>
    $(document).ready(function() {

      if (window.localStorage["active-menu"] == "details") {
        $("li.details-lnk").addClass("active");
        $("li.activity-lnk").removeClass("active");
        $("li.transaction-lnk").removeClass("active");
        $(".transaction-list").hide();
        $(".details-list").show();
        $(".activity-list").hide();
      } else if (window.localStorage["active-menu"] == "transaction") {
        $("li.transaction-lnk").addClass("active");
        $("li.activity-lnk").removeClass("active");
        $("li.details-lnk").removeClass("active");
        $(".transaction-list").show();
        $(".details-list").hide();
        $(".activity-list").hide();
      } else if (window.localStorage["active-menu"] == "activity") {
        $("li.activity-lnk").addClass("active");
        $("li.details-lnk").removeClass("active");
        $("li.transaction-lnk").removeClass("active");
        $(".activity-list").show();
        $(".transaction-list").hide();
        $(".details-list").hide();
      } else {
        $("li.details-lnk").addClass("active");
        $("li.activity-lnk").removeClass("active");
        $("li.transaction-lnk").removeClass("active");
        $("li.purchase-lnk").removeClass("active");
        $(".transaction-list").hide();
        $(".details-list").show();
        $(".activity-list").hide();
      }

    });
  </script>

<?php
} else {
  $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
  header("location:" . $path . "/../login.php");
  exit();
}
include "includes/footer.inc";
?>