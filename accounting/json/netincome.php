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
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries



      $total_tax = 0.00;
      $stmt2 = $con->prepare("SELECT * FROM `income_tax` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row2 as $supp) {
            $total_tax +=  $supp['amount'];
          }
        }
      }

      $supplier = array(
        'id' => "0",
        'check' => "- Income Taxes",
        'name' => "",
        'type' => "E£ ( <input type='text' value='" . $total_tax . "' id='income_taxes'> )",
      );

      array_push($suppliers, $supplier);
    }
    $supplier = array(
      'id' => "1",
      'check' => "Net Income",
      'name' => "",
      'type' => "E£ &nbsp;<span id='net_income'>Calculating...</span>",
    );

    array_push($suppliers, $supplier);
  }
}


echo json_encode($suppliers);
