<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['item_id']) && !empty($_POST['item_id'])) {

  $item_id = $_POST['item_id'];
  $stmt = $con->prepare("SELECT * FROM `assets` WHERE `id` = '$item_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $stmt2 = $con->prepare("SELECT * FROM `dep_transactions` WHERE `item_id` = '$item_id'");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          $row[0]['dep_transactions'] = $row2;
        }
      } else {
        $row[0]['dep_transactions'] = array();
      }

      $stmt3 = $con->prepare("SELECT * FROM `dep_ex_transactions` WHERE `item_id` = '$item_id'");
      $stmt3->execute();
      $count3 = $stmt3->rowCount();
      if ($count3 > 0) {
        while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          $row[0]['dep_ex_transactions'] = $row3;
        }
      } else {
        $row[0]['dep_ex_transactions'] = array();
      }

      $dateString = $row[0]['date'];
      $dateTime = DateTime::createFromFormat("Y-m-d", $dateString);
      $formattedDate = date_format($dateTime, "M d, Y");
      $carry = $_POST['carry'];
      $row[0]['name'] = ucfirst($row[0]['name']);
      $row[0]['date'] = $formattedDate;
      // $row[0]['amount'] = number_format($row[0]['amount'], 2, '.', ',');
      $row[0]['total'] = number_format($row[0]['total'], 2, '.', ',');
      $row[0]['carry'] = $carry;
      $result = $row[0];
    }
  } else {
  }
}

echo json_encode($result);
