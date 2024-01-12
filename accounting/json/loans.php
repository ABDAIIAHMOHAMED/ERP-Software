<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt = $con->prepare("SELECT * FROM `loan_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_balance = 0;
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $supp_id = $supp['id'];
        $name = $supp['bank'];
        $balance = $supp['amount'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");

        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);


        $paid = $row2['total_debit'];


        $due = $supp['amount'] - $paid;

        $months = $supp['duration'];
        $del_btn = '<button class="delete_order" btn-data="' . $supp_id . '"><i class="fa-solid fa-trash"></i></button>';

        $supplier = array(
          'no' => $i,
          'account' => $name,
          'created_time' => $supp['created_time'],
          'due_to' => $supp['due_to'],
          'duration' => $months,
          'balance' => number_format($balance, 2, '.', ','),
          'paid' => number_format($paid, 2, '.', ','),
          'due' => number_format($due, 2, '.', ','),
          'action' => $del_btn . '<a href="loan.php?uid=' . $supp_id . '"><i class="fa-solid fa-eye"></i></a>',
        );
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


echo json_encode($suppliers);
