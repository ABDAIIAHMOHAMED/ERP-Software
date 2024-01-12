<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $purchases = array();
  $stmt2 = $con->prepare("SELECT * FROM `transfers` WHERE `transfer_from` = '$id' OR `transfer_to` = '$id' ");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();

  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {
        $item_id = $tra['item_id'];
        $transfer_to = $tra['transfer_to'];
        $transfer_from = $tra['transfer_from'];
        $stmt33 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' LIMIT 1");
        $stmt33->execute();
        $row33 = $stmt33->fetch(PDO::FETCH_ASSOC);
        $item_name = $row33['name'];
        $item_img = $row33['img'];
        $item_unit = $row33['unit'];
        $item = '<div class="flex fx-start">
        <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $item_img . '" alt=""></div>
        <div class="info">
          <div class="name">' . $item_name . '</div><div class="sku">#' . $item_id . '</div>
        </div>
      </div>';
        $stmt66 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$transfer_to'");
        $stmt66->execute();
        $row66 = $stmt66->fetch(PDO::FETCH_ASSOC);
        $warehouse_name_1 = $row66['name'];
        $warehouse_1 = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $transfer_to . '" target="_blank">' . $warehouse_name_1 . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';
        $stmt77 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$transfer_from'");
        $stmt77->execute();
        $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
        $warehouse_name_2 = $row77['name'];
        $warehouse_2 = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $transfer_from . '" target="_blank">' . $warehouse_name_2 . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';
        if ($tra['quantity'] > 0) {
          $quantity = '<span class="paid stock">' . $tra['quantity'] . ' <span class="unt">( ' . $item_unit . ' )</span></span>';
        } else {
          $quantity = '<span class="closed stock">Out of Stock</span>';
        }

        $purchase = array(
          'transfer_id' => $tra['id'],
          'item' => $item,
          'tra_from' => $warehouse_2,
          'tra_to' => $warehouse_1,
          'quantity' => $quantity,
          'date' => $tra['date'],
          'action' => '<button class="view_transfer" btn-data="' . $tra['id'] . '"><i class="fa-solid fa-eye"></i></button>',
        );
        array_push($purchases, $purchase);
      }
    }
  }
}

echo json_encode($purchases);
