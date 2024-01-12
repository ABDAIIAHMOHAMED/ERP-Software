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
    $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `id` = '$id'  ");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          if ($item['is_composite'] == 1) {
            $subitems = $item['sub_items'];
            $exp_subitems = explode("-", $subitems);
            $subquantity = $item['sub_quantity'];
            $exp_subquantity = explode("-", $subquantity);
            $limit_array = array();
            $i = 0;
            foreach ($exp_subitems as $subitem) {
              $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
              $stmt77->execute();
              $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
              $real_item_id = $row77['item_id'];
              $stmt88 = $con->prepare("SELECT SUM(`quantity`) as limit_quantity FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314'");
              $stmt88->execute();
              $row88 = $stmt88->fetch(PDO::FETCH_ASSOC);
              $limit_quantity = $row88['limit_quantity'];
              $limit_exact = $exp_subquantity[$i];
              $total_limit = intval($limit_quantity / $limit_exact);
              array_push($limit_array, $total_limit);
              $i++;
            }


            $sub_items_array = explode("-", $item['sub_items']);
            $sub_quantity_array = explode("-", $item['sub_quantity']);
            $i = 0;
            $total = 0;
            for ($i = 0; $i < count($sub_items_array); $i++) {
              $curr_id = $sub_items_array[$i];
              $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$curr_id'");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $item_id = $row['item_id'];

              $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' ORDER BY `created_time` ASC LIMIT 1");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $odd_amount = $row['rate'];
              $odd_quantity = $sub_quantity_array[$i];
              $total += ($odd_quantity * $odd_amount);
            }

            $limit = min($limit_array);
          } else {
            $total = $item['amount'];
            $limit = 999999999999999;
          }


          $data = array(
            "name" => $item['name'],
            "amount" => $total,
            "unit" => $item['unit'],
            "limit" => $limit,
            "id" => $item['code'],
          );

          $json = json_encode($data);

          echo $json;
        }
      }
    }
  }
}
