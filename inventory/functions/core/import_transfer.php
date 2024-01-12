<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

global $con;
if (isset($_POST["sku"])) {
  if (!empty($_POST['sku'])) {
    $id = $_POST['sku'];
    $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$id'  ");
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {



          $supp_id = $item['supplier_id'];
          if (substr($supp_id, 0, 1) == "M") {
            $stmt2 = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id'  ");
            $stmt2->execute();
            $supp_info = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($supp_info['is_company'] == "1") {
              $name = $supp_info['company_name'];
              $company = '';
            } else {
              $name = $supp_info['first_name'] . " " . $supp_info['middle_name'] . " " . $supp_info['last_name'];
              $company = $supp_info['company_name'];
            }
          } else {
            $stmt2 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'  ");
            $stmt2->execute();
            $supp_info = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($supp_info['is_company'] == "1") {
              $name = $supp_info['company_name'];
              $company = '';
            } else {
              $name = $supp_info['first_name'] . " " . $supp_info['middle_name'] . " " . $supp_info['last_name'];
              $company = $supp_info['company_name'];
            }
          }


          $data = array(
            "name" => $item['name'],
            "cost" => $item['rate'],
            "img" => $item['img'],
            "quantity" => $item['quantity'],
            "sell" => $item['sell_rate'],
            "supp_name" => $name,
            "supp_comp" => $company,
            "unit" => $item['unit'],
            "item_id" => $item['item_id'],
            "id" => $item['sku'],
          );

          $json = json_encode($data);

          echo $json;
        }
      }
    } else {
    }
  }
}
