<?php
require "../../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt = $con->prepare("SELECT * FROM `suppliers`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries



      $stmt2 = $con->prepare("SELECT SUM(`init_price`) as `total_cost` FROM `assets` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt3 = $con->prepare("SELECT SUM(`cost`) as `total_exclusions` FROM `asset_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt5 = $con->prepare("SELECT SUM(`amount`) as `total_dep_ex` FROM `dep_ex_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");


      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_cost = number_format($row2['total_cost'], 2, '.', ',');


      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_exclusions = number_format($row3['total_exclusions'], 2, '.', ',');

      $total_total_cost = $row2['total_cost'] - $row3['total_exclusions'];
      $total_total_cost_format = number_format($total_total_cost, 2, '.', ',');

      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $total_dep = number_format($row4['total_dep'], 2, '.', ',');

      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $total_dep_ex = number_format($row5['total_dep_ex'], 2, '.', ',');

      $total_total_dep = $row4['total_dep'] - $row5['total_dep_ex'];
      $total_total_dep_format = number_format($total_total_dep, 2, '.', ',');

      $total = $total_total_cost - $total_total_dep;
      $total_format = number_format($total, 2, '.', ',');














      $new_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));
      $stmt6 = $con->prepare("SELECT SUM(`init_price`) as `total_cost` FROM `assets` WHERE  `date` BETWEEN '$start_date' AND '$new_end_date'");
      $stmt7 = $con->prepare("SELECT SUM(`cost`) as `total_exclusions` FROM `asset_transactions` WHERE  `date` BETWEEN '$start_date' AND '$new_end_date'");
      $stmt8 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_transactions` WHERE  `date` BETWEEN '$start_date' AND '$new_end_date'");
      $stmt9 = $con->prepare("SELECT SUM(`amount`) as `total_dep_ex` FROM `dep_ex_transactions` WHERE  `date` BETWEEN '$start_date' AND '$new_end_date'");


      $stmt6->execute();
      $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
      $total_cost = number_format($row6['total_cost'], 2, '.', ',');


      $stmt7->execute();
      $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
      $total_exclusions2 = number_format($row7['total_exclusions'], 2, '.', ',');

      $total_total_cost2 = $row6['total_cost'] - $row7['total_exclusions'];
      $total_total_cost_format2 = number_format($total_total_cost2, 2, '.', ',');

      $stmt8->execute();
      $row8 = $stmt8->fetch(PDO::FETCH_ASSOC);
      $total_dep2 = number_format($row8['total_dep'], 2, '.', ',');

      $stmt9->execute();
      $row9 = $stmt9->fetch(PDO::FETCH_ASSOC);
      $total_dep_ex2 = number_format($row9['total_dep_ex'], 2, '.', ',');

      $total_total_dep2 = $row8['total_dep'] - $row9['total_dep_ex'];
      $total_total_dep_format2 = number_format($total_total_dep2, 2, '.', ',');

      $total2 = $total_total_cost2 - $total_total_dep2;
      $total_format2 = number_format($total2, 2, '.', ',');







      $supplier = array(
        'id' => "0",
        'check' => "Fixed Assets",
        'name' => "E£ " . $total_format2,
        'type' => "E£ " . $total_format,
      );
      array_push($suppliers, $supplier);








      // VAT TAX - DISCOUNT TAX

      $total_def_tax = 0;
      $last_total_def_tax = 0;

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $total_def_tax += $supp['vat_amount'];
      //       $total_def_tax -= $supp['withholding'];
      //     }
      //   }
      // }

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `supplier_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $total_def_tax -= $supp['vat_amount'];
      //       $total_def_tax += $supp['withholding'];
      //     }
      //   }
      // }

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `manufacturer_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $total_def_tax -= $supp['vat_amount'];
      //       $total_def_tax += $supp['withholding'];
      //     }
      //   }
      // }
      // $vat_date = date("Y-m-d", strtotime($end_date . " +1 month"));
      // $stmt3 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` BETWEEN '$start_date' AND '$vat_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $total_def_tax -= $supp['debit'];
      //     }
      //   }
      // }

      // if ($total_def_tax > 0) {
      //   $total_def_tax = 0;
      // } else {
      //   $total_def_tax = -1 * $total_def_tax;
      // }




      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `received` = '1' AND  `created_time` BETWEEN '$start_date' AND '$new_end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $last_total_def_tax += $supp['vat_amount'];
      //       $last_total_def_tax -= $supp['withholding'];
      //     }
      //   }
      // }

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `supplier_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$new_end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $last_total_def_tax -= $supp['vat_amount'];
      //       $last_total_def_tax += $supp['withholding'];
      //     }
      //   }
      // }

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `manufacturer_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$new_end_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $last_total_def_tax -= $supp['vat_amount'];
      //       $last_total_def_tax += $supp['withholding'];
      //     }
      //   }
      // }
      // $new_vat_date = date("Y-m-d", strtotime($new_end_date . " +1 month"));
      // $stmt3 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_vat_date'");
      // $stmt3->execute();
      // $count3 = $stmt3->rowCount();
      // if ($count3 > 0) {
      //   while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row3 as $supp) {
      //       $last_total_def_tax -= $supp['debit'];
      //     }
      //   }
      // }


      // if ($last_total_def_tax > 0) {
      //   $last_total_def_tax = 0;
      // } else {
      //   $last_total_def_tax = -1 * $last_total_def_tax;
      // }



      // $supplier = array(
      //   'id' => "1",
      //   'check' => "Deferred Tax Assets",
      //   'name' => "E£ " . number_format($last_total_def_tax, 2, '.', ','),
      //   'type' => "E£ " . number_format($total_def_tax, 2, '.', ','),
      // );

      // array_push($suppliers, $supplier);









      $total_non_assets = $total + $total_def_tax;
      $last_total_non_assets = $total2 + $last_total_def_tax;

      $supplier = array(
        'id' => "2",
        'check' => "Total Non-Current Assets",
        'name' => "E£&nbsp;<span id='past_total_non_curr_assets'>" . number_format($last_total_non_assets, 2, '.', ',') . "</span>",
        'type' => "E£&nbsp;<span id='total_non_curr_assets'>" . number_format($total_non_assets, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);
    }
  }
}

echo json_encode($suppliers);
