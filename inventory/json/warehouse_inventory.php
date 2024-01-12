<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  $purchases = array();
  $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `warehouse_id` = '$id' AND `quantity` > '0'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();

  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {


        $supp_id = $tra['supplier_id'];
        $supp_manu = $supp_id;
        if (substr($supp_id, 0, 1) == "M") {
          $stmt3 = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id'");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              $supp_manu = "Manufacture";
              foreach ($row3 as $suppliery) {
                if ($suppliery['is_company'] == "1") {
                  $img = "company3.png";
                  $cname = $suppliery['company_name'];
                  $company_name = "";
                } else {
                  $img = "profile3.png";
                  $cname = $suppliery['first_name'] . " " . $suppliery['middle_name'] . " " . $suppliery['last_name'];
                  $company_name = $suppliery['company_name'];
                }
                $supp_manu = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/' . $img . '" alt=""></div>
                <div class="info">
                <div class="hide">Manufacturer</div>
                  <div class="name" style="font-size: 13px;font-weight:400;">' . $cname . '</div>
                  <div class="profission" style="font-size: 10px;">' . $company_name . '</div>
                </div></div>';
              }
            }
          }
          $typo = 'f';
        } else {
          if (strpos($supp_id, "ORD-") !== 0) {
            $stmt66 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
            $stmt66->execute();
            $count66 = $stmt66->rowCount();
            if ($count66 > 0) {
              while ($row66 = $stmt66->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                $supp_manu = "Supplier";
                foreach ($row66 as $suppliery) {
                  if ($suppliery['is_company'] == "1") {
                    $img = "company3.png";
                    $cname = $suppliery['company_name'];
                    $company_name = "";
                  } else {
                    $img = "profile3.png";
                    $cname = $suppliery['first_name'] . " " . $suppliery['middle_name'] . " " . $suppliery['last_name'];
                    $company_name = $suppliery['company_name'];
                  }
                  $supp_manu = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/' . $img . '" alt=""></div>
                <div class="info">
                <div class="hide">Supplier</div>
                  <div class="name" style="font-size: 13px;font-weight:400;">' . $cname . '</div>
                  <div class="profission" style="font-size: 10px;">' . $company_name . '</div>
                </div></div>';
                }
              }
            }
          } else {
            $supp_manu = "-";
          }
          $typo = 'm';
        }
        $order = "Order #" . $tra['order_id'];




        if ($tra['quantity'] == 0) {
          $status = '<span class="closed stock">Out of Stock</span>';
        } else if ($tra['quantity'] < 0) {
          $status = '<span class="closed stock">' . (-1 * $tra['quantity']) . ' <span class="unt">( ' . $tra['unit'] . ' ) short of stock</span></span>';
        } else {
          $status = '<span class="paid stock">' . $tra['quantity'] . ' <span class="unt">( ' . $tra['unit'] . ' )</span></span>';
        }
        $tra['rate'] = number_format($tra['rate'], 2, '.', ',');
        $tra['sell_rate'] = number_format($tra['sell_rate'], 2, '.', ',');
        $item = '<div class="flex fx-start">
                    <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $tra['img'] . '" alt=""></div>
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
          'rate' => $tra['rate'],
          'sell_rate' => $tra['sell_rate'],
          'supplier' => $supp_manu,
          'order' => $order,
          'status' => $status,
          'date' => $tra['created_time'],
          'action' => '<a href="productreg.php?uid=' . $tra['item_id'] . '&type=' . $typo . '" target="_blank"><i class="fa-solid fa-pen-to-square"></i></a><a href="itemdetails.php?uid=' . $tra['sku'] . '" target="_blank"><i class="fa-solid fa-eye"></i></a>',
        );
        array_push($purchases, $purchase);
      }
    }
  } else {
  }
}

echo json_encode($purchases);
