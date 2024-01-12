<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {

  $order_id = $_POST['order_id'];

  if ($order_id !== "custom") {
    $order_details = array();
    $stmt = $con->prepare("SELECT * FROM `sell_orders` WHERE `order_id` = '$order_id' LIMIT 1");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $ord) {
          $order_details = array(
            'total' => $ord['order_total'],
            'due' => $ord['balance_due'],
            'opacity' => "1",
          );
        }
      }
    }
  } else {
    $order_details = array(
      'total' => "0.00",
      'due'   => "0.00",
      'opacity'   => "0.2",
    );
  }
}

echo json_encode($order_details);
