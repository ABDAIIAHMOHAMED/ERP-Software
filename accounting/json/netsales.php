<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt = $con->prepare("SELECT * FROM `suppliers`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $total_sales = 0;
      $stmt1 = $con->prepare("SELECT DISTINCT `order_id`,`subtotal`,`discount` FROM `sell_orders` WHERE `received` = '1' AND `quantity` > '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_sales += ($supp['subtotal'] - $supp['discount']);
          }
        }
      }
      $supplier = array(
        'id' => "0",
        'check' => "Gross Sales",
        'name' => "",
        'type' => "E£ " . number_format($total_sales, 2, '.', ','),
      );
      array_push($suppliers, $supplier);

      $total_returns = 0;
      $stmt2 = $con->prepare("SELECT DISTINCT `subtotal`,`order_id`,`discount` FROM `sell_orders` WHERE `received` = '1' AND `quantity` < '0' AND  `created_time` BETWEEN '$start_date' AND '$end_date' ");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row2 as $supp) {
            $total_returns +=  ($supp['subtotal'] - $supp['discount']);
          }
        }
      }
      $supplier = array(
        'id' => "1",
        'check' => "&nbsp;&nbsp;&nbsp;&nbsp;- Sales returns",
        'name' => "",
        'type' => "E£ ( " . number_format($total_returns, 2, '.', ',') . " )",
      );

      $net_sales = number_format(($total_sales + $total_returns), 2, '.', ',');
      array_push($suppliers, $supplier);
      $supplier = array(
        'id' => "2",
        'check' => "Net Sales",
        'name' => "",
        'type' => "E£ &nbsp;<span id='net_sales'>" . $net_sales . "</span>",
      );

      array_push($suppliers, $supplier);
    }
  }
}


echo json_encode($suppliers);
