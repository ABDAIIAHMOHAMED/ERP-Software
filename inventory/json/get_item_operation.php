<?php
require "../../functions/connect.php"; // Connect to database file


$warehouses = array();
if (isset($_GET['type']) && isset($_GET['item_id'])) {
  $item_id = $_GET['item_id'];
  $type = $_GET['type'];

  if ($type == 'm') {
    $stmt = $con->prepare("SELECT * FROM `supplier_orders` WHERE `received` = '1' AND `item_id` = '$item_id'");
  } else if ($type == 'f') {
    $stmt = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `received` = '1' AND `item_id` = '$item_id'");
  }
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $order = "Invoice #" . $supp['order_id'];

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
        }



        $warehouse = array(
          'no' => $i,
          'invoice' => $order,
          'supplier' => $supp_manu,
          'created_time' => $supp['created_time'],
          'quantity' => number_format($supp['quantity'], 2, '.', ','),
          'cost' => number_format($supp['amount'], 2, '.', ','),
          'total' => number_format($supp['total'], 2, '.', ','),
        );

        $i++;

        array_push($warehouses, $warehouse);
      }
    }
  }
}


echo json_encode($warehouses);
