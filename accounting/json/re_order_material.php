<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['item_id']) && !empty($_POST['item_id'])) {

  $item_id = $_POST['item_id'];

  $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$item_id' ");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $status = '<span class="paid"><i class="fa-solid fa-check"></i> Paid</span>';
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $itm) {
        $item_id = $itm['item_id'];
        $stmt3 = $con->prepare("SELECT * FROM `items` WHERE `code` = '$item_id' ");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            $rate = $row3[0]['amount'];
          }
        }

        $items = array(
          'item_id' => $itm['item_id'],
          'name' => $itm['name'],
          'desc' => $itm['description'],
          'rate' => $rate,
          'unit' => $itm['unit'],
        );
      }
    }
  } else {
    $items = array(
      'item_id' => "0",
      'name' => "0",
      'desc' => "0",
      'rate' => "0",
      'unit' => "0",
    );
  }
}

echo json_encode($items);
