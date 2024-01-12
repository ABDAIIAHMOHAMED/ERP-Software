<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `manufacturers`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if ($supp['is_company'] == "1") {
        $name = '<a href="../contacts/manufacturerdetails.php?uid=' . $supp_id . '" class="flex fx-start" target="_blank"><div class="img-frame"><img src="../images/ur-img/company3.png" alt=""></div>
          <div class="info">
            <div class="name">' . $supp['company_name'] . '</div>
          </div></a>';
      } else {
        $name = '<a href="../contacts/manufacturerdetails.php?uid=' . $supp_id . '" class="flex fx-start" target="_blank"><div class="img-frame"><img src="../images/ur-img/profile3.png" alt=""></div>
            <div class="info">
              <div class="name">' . $supp['first_name'] . ' ' . $supp['middle_name'] . ' ' . $supp['last_name'] . '</div>
              <div class="profission">' . $supp['company_name'] . '</div>
            </div></a>';
      }
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE  `supplier_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE `supplier_id` = '$supp_id' AND `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE  `supplier_id` = '$supp_id' AND `date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE `supplier_id` = '$supp_id'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE  `supplier_id` = '$supp_id'");
      }

      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = $row2['total_debit'];
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_credit = $row3['total_credit'];
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $prev_debit = $row4['total_debit'];
      $prev_credit = $row5['total_credit'];













      // $total_vat_out = 0;
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `manufacturer_orders` WHERE `supplier_id` = '$supp_id' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
      // $stmt1->execute();
      // $count1 = $stmt1->rowCount();
      // if ($count1 > 0) {
      //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row1 as $supp) {
      //       $total_vat_out += $supp['vat_amount'];
      //       $total_vat_out -= $supp['withholding'];
      //       $total_debit -= $supp['vat_amount'];
      //       $total_debit += $supp['withholding'];
      //       $total_credit -= $supp['vat_amount'];
      //       $total_credit += $supp['withholding'];
      //     }
      //   }
      // }


      // $past_total_vat_out = 0;
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `manufacturer_orders` WHERE `supplier_id` = '$supp_id' AND `created_time` < '$start_date' ");
      // $stmt1->execute();
      // $count1 = $stmt1->rowCount();
      // if ($count1 > 0) {
      //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row1 as $supp) {
      //       $past_total_vat_out += $supp['vat_amount'];
      //       $past_total_vat_out -= $supp['withholding'];
      //       $prev_debit -= $supp['vat_amount'];
      //       $prev_debit += $supp['withholding'];
      //       $prev_credit -= $supp['vat_amount'];
      //       $prev_credit += $supp['withholding'];
      //     }
      //   }
      // }


      $open_balance = ($prev_credit - $prev_debit);
      $total_balance = (($prev_credit - $prev_debit) + ($total_credit - $total_debit));
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format($open_balance, 2, '.', ','),
        'debit' => number_format($total_debit, 2, '.', ','),
        'credit' => number_format($total_credit, 2, '.', ','),
        'balance' => number_format($total_balance, 2, '.', ','),
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
