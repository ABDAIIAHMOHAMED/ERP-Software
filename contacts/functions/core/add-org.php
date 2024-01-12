
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
  "description" => "",
  "status" => "",
];
if (isset($_POST['add']) && !empty($_POST['add'])) {
  $name = ""; ///////
  $description = ""; ///////
  $status = "1"; ///////
  $type = $_POST['type'];

  if (isset($_POST['name'])) {
    if (!empty($_POST['name'])) {
      $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
      if (preg_match('~[0-9]+~', $name) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name)) {
        $errors["name"] = "Name can't contain numbers or special character";
      } else {
        if (strlen($name) < 2) {
          $errors["name"] = "Name is too small minimun 2 character";
        } elseif (strlen($name) > 128) {
          $errors["name"] = "Name is too long maximun 128 character";
        }
      }
    } else {
      $errors["name"] = "Name is required";
    }
  }


  if (isset($_POST['description'])) {
    if (!empty($_POST['description'])) {
      $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      if (strlen($description) > 300) {
        $errors["description"] = "Maximun characters are 300";
      }
    }
  }

  if (isset($_POST['status'])) {
    if (!empty($_POST['status'])) {
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
      if ($status == 1) {
        $status = 1;
      } else {
        $status = 0;
      }
    } else {
      $status = 0;
    }
  } else {
    $status = 0;
  }

  if (empty(array_filter($errors))) {
    $stmt4 = $con->prepare("INSERT INTO `$type`(`name`,`description`,`status`,`def`) VALUES ('$name','$description','$status','0')");
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