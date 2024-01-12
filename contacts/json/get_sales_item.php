<?php
require "../../functions/connect.php"; // Connect to database file


$purchases = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt2 = $con->prepare("SELECT * FROM `sell_orders` WHERE `quantity` > '0' AND `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $i = 1;
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {



        $item_id = $tra['item_id'];
        $stmt15 = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id' LIMIT 1");
        $stmt15->execute();
        $count15 = $stmt15->rowCount();
        if ($count15 > 0) {
          $row15 = $stmt15->fetch(PDO::FETCH_ASSOC);
          $name = $row15['name'];
          $unit = $row15['unit'];
          $img = $row15['img'];
        } else {
          $stmt16 = $con->prepare("SELECT * FROM `items` WHERE `code` = '$item_id' LIMIT 1");
          $stmt16->execute();
          $count16 = $stmt16->rowCount();
          $row16 = $stmt16->fetch(PDO::FETCH_ASSOC);
          $name = $row16['name'];
          $unit = $row16['unit'];
          $img = $row16['img'];
        }


        $item = '<div class="flex fx-start" >
                    <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $img . '" alt=""></div>
                    <div class="info">
                      <div class="name">' . $name . '</div><div class="sku">#' . $item_id . '</div>
                    </div>
                  </div>';



        $supp_id = $tra['supplier_id'];



        $stmt3 = $con->prepare("SELECT * FROM `customers` WHERE `id` = '$supp_id'");
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



        $created_time = $tra['created_time'];



        if ($tra['quantity'] == 0) {
          $quantity = '<span class="closed stock">Out of Stock</span>';
        } else if ($tra['quantity'] < 0) {
          $quantity = '<span class="closed stock">' . (-1 * $tra['quantity']) . ' <span class="unt">( ' . $unit . ' ) short of stock</span></span>';
        } else {
          $quantity = '<span class="paid stock">' . $tra['quantity'] . ' <span class="unt">( ' . $unit . ' )</span></span>';
        }
        $amount = number_format($tra['amount'], 2, '.', ',');
        $total = number_format($tra['total'], 2, '.', ',');



        $purchase = array(
          'no' => $i,
          'item' => $item,
          'from' => $supp_manu,
          'date' => $created_time,
          'quantity' => $quantity,
          'amount' => $amount,
          'total' => $total,
        );
        $i++;
        array_push($purchases, $purchase);
      }
    }
  }
}
echo json_encode($purchases);
