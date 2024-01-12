<?php
require "../../../functions/connect.php"; // Connect to database file


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



      $new_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));

      $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
      $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");
      $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

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
      $open_balance_share = $prev_credit - $prev_debit;
      $total_balance_share = $row3['total_credit'] - $row2['total_debit'];






      $supplier = array(
        'id' => "0",
        'check' => "Paid-in Capital",
        'name' => "E£&nbsp;<span id='last_capital'>" . number_format($open_balance_share, 2, '.', ',') . "</span>",
        'type' => "E£&nbsp;<span id='capital'>" . number_format($total_balance_share, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);
















      $supplier = array(
        'id' => "0",
        'check' => "Retained Earnings(loss)",
        'name' => "E£&nbsp;<span id='ret_earn_last'>Calculating...</span>",
        'type' => "E£&nbsp;<span id='ret_earn'>Calculating...</span>",
      );

      array_push($suppliers, $supplier);
      $supplier = array(
        'id' => "2",
        'check' => "Net Earnings(loss) this year",
        'name' => "E£&nbsp;<span id='earn_last'>Calculating...</span>",
        'type' => "E£&nbsp;<span id='earn'>Calculating...</span>",
      );

      array_push($suppliers, $supplier);
    }
    $supplier = array(
      'id' => "3",
      'check' => "Total Stockholders' Equity",
      'name' => "E£&nbsp;<span id='last_total_stock'>Calculating...</span>",
      'type' => "E£&nbsp;<span id='total_stock'>Calculating...</span>",
    );

    array_push($suppliers, $supplier);
  }
}


echo json_encode($suppliers);
