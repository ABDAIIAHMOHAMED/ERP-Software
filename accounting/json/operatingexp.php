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
      $total_exp = 0;
      $expenses = 0;
      $stmt1 = $con->prepare("SELECT * FROM `expenses` WHERE  `quantity` > '0' AND `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_exp += $supp['total'];
            $expenses += $supp['total'];
          }
        }
      }

      $supplier = array(
        'id' => "3",
        'check' => "&nbsp;- Other Expenses",
        'name' => "",
        'type' => "E£ &nbsp;<span>" . number_format($expenses, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);


      $dep = 0;
      $stmt1 = $con->prepare("SELECT * FROM `dep_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_exp += $supp['amount'];
            $dep += $supp['amount'];
          }
        }
      }
      $supplier = array(
        'id' => "2",
        'check' => "&nbsp; - Fixed Assets depreciation",
        'name' => "",
        'type' => "E£ &nbsp;<span>" . number_format($dep, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);
      $supplier = array(
        'id' => "4",
        'check' => "- Total Expenses",
        'name' => "",
        'type' => "E£ (&nbsp; <span id='total_exp'>" . number_format($total_exp, 2, '.', ',') . "</span> &nbsp;)",
      );
      array_push($suppliers, $supplier);
      $supplier = array(
        'id' => "5",
        'check' => "Total Income before Tax.",
        'name' => "",
        'type' => "E£ &nbsp;<span id='net_income_before'>Calculating...</span>",
      );

      array_push($suppliers, $supplier);
    }
  }
}


echo json_encode($suppliers);
