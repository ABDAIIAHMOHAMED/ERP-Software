<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $transacs = array();
  $stmt2 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$id'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $i = 1;
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {
        if (empty($tra['refere_order_id'])) {
          $order_id = '-';
          $order_view = '-';
        } else {
          $orer_id = $tra['refere_order_id'];
          $order_view = '<button class="view_from_trans view_purchase" btn-data="' . $tra['refere_order_id'] . '">Order #' . $tra['refere_order_id'] . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></button>';
        }
        if ($tra['payment_method'] == "cash") {
          $payment_method = "Cash";
        } else if ($tra['payment_method'] == "bank") {
          $payment_method =  $tra['bank_number'] . " ( " . $tra['bank_name'] . " )";
        } else {
          $payment_method = ucfirst($tra['payment_method']);
        }
        $tra['debit'] = number_format($tra['debit'], 2, '.', ',');
        $tra['credit'] = number_format($tra['credit'], 2, '.', ',');
        $tra['balance'] = number_format($tra['balance'], 2, '.', ',');
        $transac = array(
          'number' => $i,
          'note' => $tra['note'],
          'refere_order' => $order_view,
          'payment' => $payment_method,
          'created_time' => $tra['date'],
          'debit' => $tra['debit'],
          'credit' => $tra['credit'],
          'balance' => $tra['balance'],
          'open_balance' => $tra['balance'],
          'action' => '<button print-data="' . $tra['id'] . '"><i class="fa-solid fa-print"></i></button>',
        );
        array_push($transacs, $transac);
        $i++;
      }
    }
  } else {
  }
}

echo json_encode($transacs);
