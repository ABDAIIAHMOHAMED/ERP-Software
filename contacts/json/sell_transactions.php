<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $transactions = array();
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`type`,`order_total`,`paid`,`due_to`,`created_time`,`received` FROM `sell_orders` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $trans) {
        if ($trans['status'] == "paid") {
          $status = '<span class="paid"><i class="fa-solid fa-check"></i> Paid</span>';
        } else if ($trans['status'] == "overdue") {
          $status = '<span class="closed"><i class="fa-solid fa-circle"></i> Overdue</span>';
        } else {
          $status = '<span class="open"><i class="fa-solid fa-play"></i> Due</span>';
        }
        if ($trans['received'] == "1") {
          $received = "received";
          $del_btn = '';
        } else {
          $received = "not";
          if ($trans['paid'] == "0") {
            $del_btn = '<button class="delete_order" btn-data="' . $trans['order_id'] . '"><i class="fa-solid fa-trash"></i></button>';
          } else {
            $del_btn = '';
          }
        }
        $trans['order_total'] = number_format($trans['order_total'], 2, '.', ',');
        $trans['paid'] = number_format($trans['paid'], 2, '.', ',');
        $trans['balance_due'] = number_format($trans['balance_due'], 2, '.', ',');
        $transaction = array(
          'order_id' => $trans['order_id'],
          'type' => $trans['type'],
          'created_time' => $trans['created_time'],
          'due_to' => $trans['due_to'],
          'paid' => $trans['paid'],
          'balance_due' => $trans['balance_due'],
          'order_total' => $trans['order_total'],
          'status' => $status,
          'received' => $received,
          'action' => $del_btn . '<button class="print_purchase" print-data="' . $trans['order_id'] . '"><i class="fa-solid fa-print"></i></button><button class="view_purchase" btn-data="' . $trans['order_id'] . '"><i class="fa-solid fa-eye"></i></button>',
        );
        array_push($transactions, $transaction);
      }
    }
  } else {
  }
}

echo json_encode($transactions);
