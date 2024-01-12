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
    $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$id' ORDER BY created_time ASC LIMIT 1 ");
    $stmt->execute();
    $count = $stmt->rowCount();
    $stmt77 = $con->prepare("SELECT SUM(`quantity`) as `total_quantity` FROM `av_items` WHERE `item_id` = '$id'");
    $stmt77->execute();
    $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
    $limit = $row77['total_quantity'];


    // COST NEW
    $stmt88 = $con->prepare("SELECT `rate` FROM `av_items` WHERE `item_id` = '$id' AND `quantity` > '0' ORDER BY created_time ASC");
    $stmt88->execute();
    $row88 = $stmt88->fetch(PDO::FETCH_ASSOC);
    $rate = $row88['rate'];
    // COST NEW
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          $data = array(
            "name" => $item['name'],
            "amount" => $item['sell_rate'],
            "unit" => $item['unit'],
            "id" => $item['item_id'],
            "limit" => $limit,
            "cost" => $rate,
          );

          $json = json_encode($data);

          echo $json;
        }
      }
    } else {
    }
  }
}
