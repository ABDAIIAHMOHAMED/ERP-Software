<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT DISTINCT `item_id`,`category_id`,`vat_amount`,`withholding` FROM `asset_transactions`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $item_id = $supp['item_id'];
      $cat_id = $supp['category_id'];

      $stmt9 = $con->prepare("SELECT * FROM `assets` WHERE `id` = '$item_id'");
      $stmt9->execute();
      $row9 = $stmt9->fetch(PDO::FETCH_ASSOC);
      $name = $row9['name'];
      $stmt10 = $con->prepare("SELECT * FROM `assets_category` WHERE `id` = '$cat_id'");
      $stmt10->execute();
      $row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
      $cat_name = $row10['name'];

      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`total`) as `total_sale` FROM `asset_transactions` WHERE `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`cost`) as `total_cost` FROM `asset_transactions` WHERE `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_ex_transactions` WHERE `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
      }

      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_sale = number_format($row2['total_sale'], 2, '.', ',');


      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_cost = number_format($row3['total_cost'], 2, '.', ',');

      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $total_dep = number_format($row4['total_dep'], 2, '.', ',');

      $gross_carry_ex = $row3['total_cost'] - $row4['total_dep'];
      $gross_carry_ex_format = number_format($gross_carry_ex, 2, '.', ',');


      $loss_profit = $row2['total_sale'] - $gross_carry_ex;
      $loss_profit_format = number_format($loss_profit, 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'total_cost' => $cat_name,
        'total_exclusions' => $total_sale,
        'total_total_cost' => "(" .  $total_cost . ")",
        'total_dep' => $total_dep,
        'total_dep_ex' => "(" . $gross_carry_ex_format . ")",
        'total_total_dep' => $loss_profit_format,
        'vat' => number_format($supp['vat_amount'], 2, '.', ','),
        'withholding' => "(" . number_format($supp['withholding'], 2, '.', ',') . ")",
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
