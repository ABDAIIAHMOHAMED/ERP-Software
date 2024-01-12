<?php
require "../../functions/connect.php"; // Connect to database file

// Cash In LIST
$cashes = array();

$stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time` FROM `supplier_orders` WHERE `vat_amount` != '0'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $order_id = "Purchase Invoice #" . $supp['order_id'];
      $debit = number_format($supp['vat_amount'], 2);
      $credit = number_format(0, 2);
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

$stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time` FROM `manufacturer_orders` WHERE `vat_amount` != '0'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $order_id = "Manufacturing Invoice #" . $supp['order_id'];
      $debit = number_format($supp['vat_amount'], 2);
      $credit = number_format(0, 2);
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

$stmt3 = $con->prepare("SELECT * FROM `assets` WHERE `vat_amount` != '0'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $order_id = $supp['name'] . " was bought  as a fixed asset";
      $debit = number_format($supp['vat_amount'], 2);
      $credit = number_format(0, 2);
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
