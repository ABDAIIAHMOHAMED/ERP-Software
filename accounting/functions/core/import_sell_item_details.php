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
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          $data = array(
            "name" => $item['name'],
            "amount" => $item['sell_rate'],
            "unit" => $item['unit'],
            "id" => $item['item_id'],
            "idy" => $item['id'],
          );

          $json = json_encode($data);

          echo $json;
        }
      }
    } else {
    }
  }
}
