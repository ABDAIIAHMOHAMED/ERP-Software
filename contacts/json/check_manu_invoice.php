<?php
require "../../functions/connect.php"; // Connect to database file

$check = false;
if (isset($_POST['inv_number']) && !empty($_POST['inv_number'])) {
  $inv_number = trim($_POST['inv_number']);

  $stmt = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$inv_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $check = true;
  }
}

echo json_encode($check);
