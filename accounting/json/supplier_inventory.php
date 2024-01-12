<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $purchases = array();
  $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `supplier_id` = '$id'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();

  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {
        if ($tra['quantity'] == 0) {
          $status = '<span class="closed stock">Out of Stock</span>';
        } else if ($tra['quantity'] < 0) {
          $status = '<span class="closed stock">' . (-1 * $tra['quantity']) . ' <span class="unt">( ' . $tra['unit'] . ' ) short of stock</span></span>';
        } else {
          $status = '<span class="paid stock">' . $tra['quantity'] . ' <span class="unt">( ' . $tra['unit'] . ' )</span></span>';
        }
        $tra['rate'] = number_format($tra['rate'], 2, '.', ',');
        $item = '<div class="flex fx-start">
                    <div class="img-frame"><img src="../assets/items/' . $tra['img'] . '" alt=""></div>
                    <div class="info">
                      <div class="name">' . $tra['name'] . '</div><div class="sku">#' . $tra['item_id'] . '</div>
                    </div>
                  </div>';
        if ($tra['storable'] == "1") {
          $warehouse = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $tra['warehouse_id'] . '">Warehouse #' . $tra['warehouse_id'] . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';
        } else {
          $warehouse = "Not Stored";
        }
        $purchase = array(
          'item_id' => $tra['id'],
          'item' => $item,
          'desc' => $tra['description'],
          'rate' => $tra['rate'],
          'storable' => $warehouse,
          'status' => $status,
          'date' => $tra['created_time'],
          'action' => '<a href="../inventory/itemdetails.php?uid=' . $tra["sku"] . '" target="_blank"><i class="fa-solid fa-eye"></i></a><button class="re_order_btn" re-order-data="' . $tra['sku'] . '"><i class="fa-solid fa-repeat"></i></button>',
        );
        array_push($purchases, $purchase);
      }
    }
  } else {
  }
}

echo json_encode($purchases);
