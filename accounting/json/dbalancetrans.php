<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $transacs = array();
  $stmt2 = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE `supplier_id` = '$id'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $i = 1;
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {
        if ($tra['payment_method'] == "cash") {
          $payment_method = '<span class="pay_method"> <i class="fa-solid fa-money-bill"></i> Treasury Cash</span>';
        } else if ($tra['payment_method'] == "bank") {
          $payment_method =  '<span class="pay_method"> <i class="fa-solid fa-building-columns"></i> ' . $tra["bank_number"] . ' ( ' . $tra["bank_name"] . ' )</span>';
        } else {
          $payment_method = '<span class="pay_method"> <i class="fa-solid fa-circle-dollar-to-slot"></i> ' . ucfirst($tra["payment_method"]) . '</span>';
        }
        if ($tra['debit'] == '0') {
          $addition = -1 * $tra['credit'];
        } else {
          $addition = $tra['debit'];
        }
        $tra['debit'] = number_format($tra['debit'], 2, '.', ',');
        $tra['credit'] = number_format($tra['credit'], 2, '.', ',');
        $tra['balance'] = number_format($tra['balance'], 2, '.', ',');

        $action = '<button class="delete_order" btn-data="' . $tra["id"] . '" btn-balance="' . $addition . '" btn-date="' . $tra['date'] . '"><i class="fa-solid fa-trash"></i></button>';
        $transac = array(
          'number' => $i,
          'note' => $tra['note'],
          'payment' => $payment_method,
          'created_time' => $tra['date'],
          'debit' => $tra['debit'],
          'credit' => $tra['credit'],
          'balance' => $tra['balance'],
          'Action' => $action,
        );
        array_push($transacs, $transac);
        $i++;
      }
    }
  } else {
  }
}

echo json_encode($transacs);
