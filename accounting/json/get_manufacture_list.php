<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {

  $order_id = $_POST['order_id'];
  $items = array();
  $stmt = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $it) {
        $it['subtotal'] = number_format($it['subtotal'], 2, '.', ',');
        $it['total'] = number_format($it['total'], 2, '.', ',');
        $it['amount'] = number_format($it['amount'], 2, '.', ',');
        $it['quantity'] = number_format($it['quantity'], 2, '.', ',');
        $stmt2 = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '" . $it['item_id'] . "'");
        $stmt2->execute();
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          $item_name = $row2[0]['name'];
          $item_unit = $row2[0]['unit'];
        }
        $item = array(
          'item_id' => $it['item_id'],
          'item_name' => $item_name,
          'item_unit' => $item_unit,
          'item_quantity' => $it['quantity'],
          'item_amount' => $it['amount'],
          'item_total' => $it['total'],
          'item_desc' => $it['description'],
          'subtotal' => $it['subtotal'],
        );
        array_push($items, $item);
      }
    }
  } else {
  }
}

echo json_encode($items);
