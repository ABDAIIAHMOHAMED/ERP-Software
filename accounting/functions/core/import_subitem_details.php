<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

global $con;
if (isset($_POST["data_id"])) {
  if (!empty($_POST['data_id'])) {
    $id = $_POST['data_id'];
    $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$id'  ");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          $item_id = $item['item_id'];
          $stmt2 = $con->prepare("SELECT SUM(`quantity`) AS `total_quantity` FROM `av_items` WHERE `item_id` = '$item_id' ");
          $stmt2->execute();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $total_quantity = $row2['total_quantity'];


          $data = array(
            "name" => $item['name'],
            "amount" => $item['rate'],
            "unit" => $item['unit'],
            "limit" => $total_quantity,
            "id" => $item['id'],
          );

          $json = json_encode($data);

          echo $json;
        }
      }
    } else {
    }
  }
}
