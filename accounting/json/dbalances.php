<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `dbalances`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      $name = "<a href='dbalance.php?uid=" . $supp['id'] . "' target='_blank'>" . $supp['name'] . "</a>";
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE  `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE `supplier_id` = '$supp_id' AND `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE  `supplier_id` = '$supp_id' AND `date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE `supplier_id` = '$supp_id'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE  `supplier_id` = '$supp_id'");
      }

      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_credit = number_format($row3['total_credit'], 2, '.', ',');
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $prev_debit = $row4['total_debit'];
      $prev_credit = $row5['total_credit'];
      $open_balance = number_format(($prev_credit - $prev_debit), 2, '.', ',');
      $total_balance = number_format((($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
