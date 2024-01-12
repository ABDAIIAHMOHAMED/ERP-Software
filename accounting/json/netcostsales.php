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
      $total_cost = 0;
      $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`order_id` FROM `sell_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_cost += $supp['sell_cost'];
          }
        }
      }
      $supplier = array(
        'id' => "0",
        'check' => "- Net Cost of Sales",
        'name' => "",
        'type' => "E£ (&nbsp; <span id='total_costs'>" . number_format($total_cost, 2, '.', ',') . "</span> &nbsp;)",
      );

      array_push($suppliers, $supplier);

      $supplier = array(
        'id' => "1",
        'check' => "Gross Income",
        'name' => "",
        'type' => "E£ &nbsp;<span id='gross_income'>Calculating...</span>",
      );

      array_push($suppliers, $supplier);
    }
  }
}


echo json_encode($suppliers);
