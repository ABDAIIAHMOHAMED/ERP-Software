<?php
require "../../functions/connect.php"; // Connect to database file

// Cash In LIST
$cashes = array();

$stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time` FROM `sell_orders` WHERE `vat_amount` != '0'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $order_id = "Sale Invoice #" . $supp['order_id'];
      $credit = number_format($supp['vat_amount'], 2);
      $debit = number_format(0, 2);
      $date = $supp['created_time'];
      $cash = array(
        'order_id' => $order_id,
        'date' => $date,
        'debit' => $debit,
        'credit' => $credit,
      );
      array_push($cashes, $cash);
    }
  }
}
$stmt3 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `vat_amount` != '0'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $item_id = $supp['item_id'];
      $stmt4 = $con->prepare("SELECT * FROM `assets` WHERE `id` =  '$item_id' LIMIT 1");
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $name = $row4['name'];
      $order_id = $name . " was sold as a fixed asset";
      $debit = number_format(0, 2);
      $credit = number_format($supp['vat_amount'], 2);
      $date = $supp['date'];
      $cash = array(
        'order_id' => $order_id,
        'date' => $date,
        'debit' => $debit,
        'credit' => $credit,
      );
      array_push($cashes, $cash);
    }
  }
}
// VAT FROM Returns

// Cash Out LIST
echo json_encode($cashes);
