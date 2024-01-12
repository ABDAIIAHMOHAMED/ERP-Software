
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
  "account_number" => "",
  "bank_name" => "",
];
if (isset($_POST['add']) && !empty($_POST['add'])) {
  $account_number = ""; ///////
  $bank_name = trim(filter_var($_POST['bank_name'], FILTER_SANITIZE_STRING));

  if (isset($_POST['account_number'])) {
    if (!empty($_POST['account_number'])) {
      $account_number = trim(filter_var($_POST['account_number'], FILTER_SANITIZE_STRING));
      $stmt3 = $con->prepare("SELECT * FROM `bank_account` WHERE `bank_name` = '$bank_name' AND `account_number` = '$account_number'");
      $stmt3->execute();
      $count3 = $stmt3->rowCount();
      if ($count3 > 0) {
        $errors["account_number"] = "Account Number is already exist";
      }
    } else {
      $errors["account_number"] = "Account Number is required";
    }
  }

  if (empty(array_filter($errors))) {
    $stmt4 = $con->prepare("INSERT INTO `bank_account`(`bank_name`,`account_number`) VALUES ('$bank_name','$account_number')");
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