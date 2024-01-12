
<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year


global $con;

if (isset($_POST['amount']) && isset($_POST['date']) && !empty($_POST['date'])) {
  $amount = (float) str_replace(',', '', $_POST['amount']);
  $date = date("Y-m-d", strtotime($_POST['date'] . " -1 day"));
  $trim_date = substr($date, 0, 7);
  $full_date = $trim_date . "-01";

  echo $full_date . " / " . $amount;
  $stmt = $con->prepare("SELECT * FROM `income_tax` WHERE `date` = '$full_date'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $stmt5 = $con->prepare("UPDATE `income_tax` SET `amount` = '$amount'  WHERE `date` = '$full_date'");
    $stmt5->execute();
  } else {
    $stmt5 = $con->prepare("INSERT INTO `income_tax` (`amount`,`date`) VALUES ('$amount','$full_date')");
    $stmt5->execute();
  }
}

?>