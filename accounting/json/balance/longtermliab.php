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
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $new_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));





      $total_loan = 0;
      $last_total_loan = 0;
      $stmt10 = $con->prepare("SELECT * FROM `loan_orders` WHERE `duration` > '12'");
      $stmt10->execute();
      $count10 = $stmt10->rowCount();
      if ($count10 > 0) {
        while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row10 as $supp) {
            $supp_id = $supp['id'];
            $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
            $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `loan_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
            $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
            $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `loan_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $stmt3->execute();
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $stmt4->execute();
            $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
            $stmt5->execute();
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);


            $total_loan += ($row3['total_credit'] - $row2['total_debit']);
            $last_total_loan += ($row5['total_credit'] - $row4['total_debit']);
          }
        }
      }




      $supplier = array(
        'id' => "0",
        'check' => "Long-term Loans Payable",
        'name' => "E£ " . number_format($last_total_loan, 2, '.', ','),
        'type' => "E£ " . number_format($total_loan, 2, '.', ','),
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


      // if ($total_def_tax < 0) {
      //   $total_def_tax = 0;
      // }




      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `received` = '1' AND `created_time` BETWEEN '$start_date' AND '$new_end_date'");
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
      // if ($last_total_def_tax <= 0) {
      //   $last_total_def_tax = 0;
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


      // $supplier = array(
      //   'id' => "1",
      //   'check' => "Deferred Tax Liability",
      //   'name' => "E£ " . number_format($last_total_def_tax, 2, '.', ','),
      //   'type' => "E£ " . number_format($total_def_tax, 2, '.', ','),
      // );

      // array_push($suppliers, $supplier);


      $total_non_lia = $total_loan + $total_def_tax;
      $last_total_non_lia = $last_total_loan + $last_total_def_tax;
      $supplier = array(
        'id' => "2",
        'check' => "Total Non-Current Liabilities",
        'name' => "E£&nbsp;<span id='last_total_non_curr_lia'>" . number_format($last_total_non_lia, 2, '.', ',') . "</span>",
        'type' => "E£&nbsp;<span id='total_non_curr_lia'>" . number_format($total_non_lia, 2, '.', ',') . "</span>",
      );

      array_push($suppliers, $supplier);
    }
  }
}

echo json_encode($suppliers);
