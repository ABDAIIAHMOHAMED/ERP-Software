<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $transacs = array();
  $stmt2 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$id'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $status = '<span class="paid"><i class="fa-solid fa-check"></i> Paid</span>';
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
        $tra['amount'] = number_format($tra['amount'], 2, '.', ',');

        $transac = array(
          'trans_id' => $tra['id'],
          'type' => 'Payment',
          'created_time' => $tra['date'],
          'refere_order' => $order_view,
          'paid' => $tra['amount'],
          'status' => $status,
          'action' => '<button  print-data="' . $tra['id'] . '"><i class="fa-solid fa-print"></i></button>',
        );
        array_push($transacs, $transac);
      }
    }
  } else {
  }
}

echo json_encode($transacs);
