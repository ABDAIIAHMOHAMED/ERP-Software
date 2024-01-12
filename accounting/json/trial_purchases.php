<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`order_id` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_balance = 0;
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $amount = $supp['subtotal'] - $supp['discount'];
        $trans_id = $supp['order_id'];
        $name = "Purchase Order #  " . $trans_id;
        $supplier = array(
          'no' => $i,
          'name' => $name,
          'open_balance' => number_format(0, 2, '.', ','),
          'debit' => number_format($amount, 2, '.', ','),
          'credit' => number_format(0, 2, '.', ','),
          'balance' => number_format($amount, 2, '.', ','),
        );
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }

  $stmt = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`order_id` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_balance = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $amount = $supp['subtotal'] - $supp['discount'];
        $trans_id = $supp['order_id'];
        $name = "Manufacturing Order #  " . $trans_id;
        $supplier = array(
          'no' => $i,
          'name' => $name,
          'open_balance' => number_format(0, 2, '.', ','),
          'debit' => number_format($amount, 2, '.', ','),
          'credit' => number_format(0, 2, '.', ','),
          'balance' => number_format($amount, 2, '.', ','),
        );
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


$stmt = $con->prepare("SELECT * FROM `assets` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
// $stmt = $con->prepare("SELECT MIN(`id`) AS `id`, `refere_order_id`, `supplier_id` FROM `sell_transactions` GROUP BY `refere_order_id`, `supplier_id`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $amount = $supp['init_price'];
      $type = $supp['name'];

      $name = "Purchase Order " . $type;
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format($amount, 2, '.', ','),
        'credit' => number_format(0, 2, '.', ','),
        'balance' => number_format($amount, 2, '.', ','),
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}

echo json_encode($suppliers);
