<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {

  $order_id = $_POST['order_id'];
  $items = array();
  $stmt = $con->prepare("SELECT * FROM `transfers` WHERE `transfer_id` = '$order_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $i = 1;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $it) {

        $it['total'] = number_format($it['total'], 2, '.', ',');
        $it['amount'] = number_format($it['amount'], 2, '.', ',');
        $it['quantity'] = number_format($it['quantity'], 2, '.', ',');
        $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '" . $it['item_id'] . "'");
        $stmt2->execute();
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          $item_name = $row2[0]['name'];
          $item_img = $row2[0]['img'];
          $item_unit = $row2[0]['unit'];
        }
        $item = array(
          'no' => $i,
          'item_id' => $it['item_id'],
          'item_name' => $item_name,
          'item_unit' => $item_unit,
          'item_img' => $item_img,
          'item_quantity' => $it['quantity'],
          'item_amount' => $it['amount'],
          'item_total' => $it['total'],
        );
        array_push($items, $item);
        $i++;
      }
    }
  } else {
  }
}

echo json_encode($items);
