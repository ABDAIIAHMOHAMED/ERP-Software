<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`order_id`,`sell_cost`,`supplier_id` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' AND `received` = '1'");
  // $stmt = $con->prepare("SELECT MIN(`id`) AS `id`, `refere_order_id`, `supplier_id` FROM `sell_transactions` GROUP BY `refere_order_id`, `supplier_id`");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_balance = 0;
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $amount = $supp['subtotal'] - $supp['discount'];
        $cost = $supp['sell_cost'];
        $supp_id = $supp['supplier_id'];
        $stmt3 = $con->prepare("SELECT * FROM `customers` WHERE `id` = '$supp_id' LIMIT 1");
        $stmt3->execute();
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        $type = $row3['company_name'];

        $trans_id = $supp['order_id'];
        $name = "Invoice #  " . $trans_id;
        $supplier = array(
          'no' => $i,
          'name' => $name,
          'type' => $type,
          'open_balance' => number_format(0, 2, '.', ','),
          'debit' => number_format(0, 2, '.', ','),
          'credit' => number_format($amount, 2, '.', ','),
          'balance' => number_format($amount, 2, '.', ','),
          'cost' => number_format($cost, 2, '.', ','),
        );
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }


  $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
  // $stmt = $con->prepare("SELECT MIN(`id`) AS `id`, `refere_order_id`, `supplier_id` FROM `sell_transactions` GROUP BY `refere_order_id`, `supplier_id`");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_balance = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $amount = $supp['total'];
        $cost = $supp['cost'];
        $supp_id = $supp['item_id'];
        $stmt3 = $con->prepare("SELECT * FROM `assets` WHERE `id` = '$supp_id' LIMIT 1");
        $stmt3->execute();
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        $type = $row3['name'];

        $name = "Invoice for selling " . $type;
        $supplier = array(
          'no' => $i,
          'name' => $name,
          'type' => $type,
          'open_balance' => number_format(0, 2, '.', ','),
          'debit' => number_format(0, 2, '.', ','),
          'credit' => number_format($amount, 2, '.', ','),
          'balance' => number_format($amount, 2, '.', ','),
          'cost' => number_format($cost, 2, '.', ','),
        );
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


echo json_encode($suppliers);
