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




      $stmt2 = $con->prepare("SELECT SUM(`total`) as `total_sale` FROM `asset_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt3 = $con->prepare("SELECT SUM(`cost`) as `total_cost` FROM `asset_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_ex_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");


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

      $loss_profit = $row2['total_sale'];
      $loss_profit_format = number_format($loss_profit, 2, '.', ',');







      $supplier = array(
        'id' => "0",
        'check' => "Net Fixed Assets Revenue",
        'name' => "",
        'type' => "E£ &nbsp;<span id='assets'>" . $loss_profit_format . "</span>",
      );
      array_push($suppliers, $supplier);



      $supplier = array(
        'id' => "1",
        'check' => "&nbsp; - Net Fixed Assets Costs",
        'name' => "",
        'type' => "E£ &nbsp;<span id='assets'>-" . $gross_carry_ex_format . "</span>",
      );
      array_push($suppliers, $supplier);










      $total_exchange = 0;
      $exchange_in = 0;
      $exchange_out = 0;
      $stmt2 = $con->prepare("SELECT * FROM `exchange_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row2 as $supp) {
            $exchange_in += $supp['credit'];
            $exchange_out += $supp['debit'];
          }
        }
      }
      $total_exchange = $exchange_in - $exchange_out;

      $supplier = array(
        'id' => "1",
        'check' => "Profit(Loss) Exchange Currency",
        'name' => "",
        'type' => "E£ " . number_format($total_exchange, 2, '.', ','),
      );
      array_push($suppliers, $supplier);




      $total_other = 0;
      $stmt2 = $con->prepare("SELECT * FROM `revenues` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row2 as $supp) {
            $total_other += $supp['total'];
          }
        }
      }

      $supplier = array(
        'id' => "2",
        'check' => "Other Revenues",
        'name' => "",
        'type' => "E£ " . number_format($total_other, 2, '.', ','),
      );
      array_push($suppliers, $supplier);



      $total_revenue = $loss_profit + $total_exchange + $total_other - $gross_carry_ex;
      $supplier = array(
        'id' => "3",
        'check' => "Gross Other Revenue",
        'name' => "",
        'type' => "E£ &nbsp;<span id='total_rev'>" . number_format($total_revenue, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);
    }
  }
}


echo json_encode($suppliers);
