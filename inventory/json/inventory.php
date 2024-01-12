<?php
require "../../functions/connect.php"; // Connect to database file


$inventorys = array();
$stmt = $con->prepare("SELECT * FROM `av_items` WHERE `quantity` > 0 AND `warehouse_id` != '314'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $name = '<div class="flex fx-start">
                <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $supp["img"] . '" alt=""></div>
                <div class="info">
                  <div class="name">' . $supp["name"] . '</div><div class="sku">#' . $supp['item_id'] . '</div>
                </div>
              </div>';

      $supp_id = $supp['supplier_id'];

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
        $type = 'f';
      } else {
        if (strpos($supp_id, "ORD-") !== 0) {
          $stmt3 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              $supp_manu = "Supplier";
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
        $type = 'm';
      }

      if ($supp['quantity'] == 0) {
        $status = '<span class="closed stock">Out of Stock</span>';
      } else if ($supp['quantity'] < 0) {
        $status = '<span class="closed stock">' . (-1 * $supp['quantity']) . ' <span class="unt">( ' . $supp['unit'] . ' ) short of stock</span></span>';
      } else {
        $status = '<span class="paid stock">' . $supp['quantity'] . ' <span class="unt">( ' . $supp['unit'] . ' ) <span class="hide">paid</span></span></span>';
      }

      if ($supp['storable'] == "1") {
        $warehouse_id = $supp['warehouse_id'];
        $stmt12 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$warehouse_id'");
        $stmt12->execute();
        $count12 = $stmt->rowCount();
        if ($count12 > 0) {
          while ($row12 = $stmt12->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            $warehouse_name = $row12[0]['name'];
          }
        }
        $warehouse = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $supp["warehouse_id"] . '" target="_blank">' . $warehouse_name . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';
      } else {
        $warehouse = 'Not Stored';
      }
      $supp['rate'] = number_format($supp['rate'], 2, '.', ',');
      if ($supp['sell_rate'] == "0") {
        $supp['sell_rate'] = "-";
      } else {
        $supp['sell_rate'] = number_format($supp['sell_rate'], 2, '.', ',');
      }

      $inventory = array(
        'no' => $i,
        'name' => $name,
        'supp_manu' => $supp_manu,
        'item_id' => $supp['item_id'],
        'quantity' => $status,
        'rate' => $supp['rate'],
        'margin' => $supp['margin'],
        'sell_rate' => $supp['sell_rate'],
        'warehouse' => $warehouse,
        'action' => '<a href="productreg.php?uid=' . $supp['item_id'] . '&type=' . $type . '" target="_blank"><i class="fa-solid fa-pen-to-square"></i></a><a href="itemdetails.php?uid=' . $supp['sku'] . '" target="_blank"><i class="fa-solid fa-eye"></i></a>',
      );

      $i++;

      array_push($inventorys, $inventory);
    }
  }
} else {
}


echo json_encode($inventorys);
