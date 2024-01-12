<?php
require "../../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `suppliers`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    $supplier = array(
      'id' => "0",
      'check' => "Total Liabilities & Stockholders' Equity",
      'name' => "E£&nbsp;<span id='last_total_stock_lia'>Calculating...</span>",
      'type' => "E£&nbsp;<span id='total_stock_lia'>Calculating...</span>",
    );
    array_push($suppliers, $supplier);
  }
} else {
}


echo json_encode($suppliers);
