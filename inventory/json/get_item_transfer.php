<?php
require "../../functions/connect.php"; // Connect to database file


$warehouses = array();
if (isset($_GET['type']) && isset($_GET['item_id'])) {
  $item_id = $_GET['item_id'];
  $type = $_GET['type'];

  $stmt = $con->prepare("SELECT * FROM `transfers` WHERE `item_id` = '$item_id'");

  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $order = "Transfer #" . $supp['transfer_id'];


        $warehouse_from = $supp['transfer_from'];
        $warehouse_to = $supp['transfer_to'];
        $stmt15 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$warehouse_from' LIMIT 1");
        $stmt15->execute();
        $count15 = $stmt15->rowCount();
        if ($count15 > 0) {
          $row15 = $stmt15->fetch(PDO::FETCH_ASSOC);
          $warehouse_name = $row15['name'];
        }
        $warehouse_from_name = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $warehouse_from . '">' . $warehouse_name . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';


        $stmt16 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$warehouse_to' LIMIT 1");
        $stmt16->execute();
        $count16 = $stmt16->rowCount();
        if ($count16 > 0) {
          $row16 = $stmt16->fetch(PDO::FETCH_ASSOC);
          $warehouse_name_to = $row16['name'];
        }
        $warehouse_to_name = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $warehouse_to . '">' . $warehouse_name_to . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';





        $warehouse = array(
          'no' => $i,
          'invoice' => $order,
          'created_time' => $supp['date'],
          'quantity' => number_format($supp['quantity'], 2, '.', ','),
          'from' => $warehouse_from_name,
          'to' => $warehouse_to_name,
        );

        $i++;

        array_push($warehouses, $warehouse);
      }
    }
  }
}


echo json_encode($warehouses);
