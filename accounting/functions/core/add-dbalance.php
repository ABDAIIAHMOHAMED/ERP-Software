
<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year


global $con;
$errors = [
  "name" => "",
  "cdate" => "",
];
if (isset($_POST['add']) && !empty($_POST['add'])) {
  $name = ""; ///////
  $cdate = date("Y-m-d");

  if (isset($_POST['name'])) {
    if (!empty($_POST['name'])) {
      $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
      if (strlen($name) < 2) {
        $errors["name"] = "Name is too small minimun 3 character";
      } elseif (strlen($name) > 128) {
        $errors["name"] = "Name is too long maximun 128 character";
      }
    } else {
      $errors["name"] = "Name is required";
    }
  }
  if (isset($_POST['cdate'])) {
    if (!empty($_POST['cdate'])) {
      $cdate = $_POST['cdate'];
    } else {
      $cdate = date("Y-m-d");
    }
  }

  if (empty(array_filter($errors))) {
    $stmt4 = $con->prepare("INSERT INTO `dbalances`(`name`,`created_time`) VALUES ('$name','$cdate')");
    $stmt4->execute();
    echo "<div class='pop_box success_box'><div class='pop_title'>Loading...</div>";
    echo "</div><script>
        $(document).ready(function () {
          $('.pop_box').delay(2000).fadeOut(500);
        });
        </script>";
  } else {
    echo "<div class='pop_box error_box'><div class='pop_title'>Some Errors in inputs:</div>";
    foreach ($errors as $e) {
      if (!empty($e)) {
        echo "
                  <div class='pop-message'>
                  " . $e . "
                  </div>";
      }
    }
    echo "</div>
        <script>
        $(document).ready(function () {
          $('.pop_box').delay(2000).fadeOut(500);
        });
        </script>";
  }
}

?>