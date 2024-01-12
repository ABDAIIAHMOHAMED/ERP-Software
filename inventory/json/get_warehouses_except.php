<?php
require "../../functions/connect.php"; // Connect to database file
$warehouses = array();
if (isset($_POST['item_id']) && !empty($_POST['item_id']) && isset($_POST['sku']) && !empty($_POST['sku'])) {

  $sku = $_POST['sku'];
  $item_id = $_POST['item_id'];

  $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `sku` <> '$sku' AND `warehouse_id` != '314' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $ki) {
        $stmt2 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '" . $ki['warehouse_id'] . "'");
        $stmt2->execute();
        $count2 = $stmt2->rowCount();
        if ($count2 > 0) {
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $warehouse_name = $row2['name'];
        } else {
          $warehouse_name = "Not Stored";
        }
        $warehouse = array(
          'id' => $ki['warehouse_id'],
          'name' => $warehouse_name,
          'quantity' => $ki['quantity'],
          'sku' => $ki['sku'],
        );
        array_push($warehouses, $warehouse);
      }
    }
  }
}

echo json_encode($warehouses);
