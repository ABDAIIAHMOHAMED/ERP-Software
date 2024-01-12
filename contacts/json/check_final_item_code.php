<?php
require "../../functions/connect.php"; // Connect to database file

$check = false;
if (isset($_POST['item_number']) && !empty($_POST['item_number'])) {
  $item_number = trim($_POST['item_number']);

  $stmt = $con->prepare("SELECT * FROM `items` WHERE `code` = '$item_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $check = true;
  } else {
    $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      $check = true;
    }
  }
}

echo json_encode($check);
