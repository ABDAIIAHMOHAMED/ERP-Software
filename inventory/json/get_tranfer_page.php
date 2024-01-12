<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {

  $order_id = $_POST['order_id'];
  $stmt = $con->prepare("SELECT * FROM `transfer_orders` WHERE `id` = '$order_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $resp_id = $row[0]['resp'];
      $stmt2 = $con->prepare("SELECT * FROM `users` WHERE `id` = '$resp_id'");
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);



      $dateString = $row[0]['date'];

      // Create a DateTime object with the initial format
      $dateTime = DateTime::createFromFormat("Y-m-d h:i A", $dateString);

      // Set the desired time format
      $timeFormat = "H:i";

      // Convert the time to the desired format
      $convertedTime = $dateTime->format($timeFormat);

      // Replace the time portion in the original date string with the converted time
      $convertedDateString = substr_replace($dateString, $convertedTime, 11, 8);



      $stmt3 = $con->prepare("SELECT * FROM `transfers` WHERE `transfer_id` = '$order_id' LIMIT 1");
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $row[0]['from'] = $row3['transfer_from'];
      $row[0]['to'] = $row3['transfer_to'];

      $row[0]['resp_name'] = ucfirst($row2['name']);
      $row[0]['resp_img'] = ucfirst($row2['picture']);
      $row[0]['date'] = $convertedDateString; // Output: 2023-09-01 22:01
      $result = $row[0];
    }
  } else {
  }
}

echo json_encode($result);
