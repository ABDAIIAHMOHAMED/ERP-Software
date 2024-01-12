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

      $new_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));
      include "total_cashes.php";
      include "total_bank.php";
      $total_cash = $total_in - $total_out;
      $past_total_cash = $past_total_in - $past_total_out;

      $total_bank = $total_in_bank - $total_out_bank;
      $past_total_bank = $past_total_in_bank - $past_total_out_bank;

      $total_eq = $total_cash + $total_bank;
      $past_total_eq = $past_total_cash + $past_total_bank;


      $supplier = array(
        'id' => "0",
        'check' => "Cash & Cash Equivalents",
        'name' => "E£ " . number_format($past_total_eq, 2, '.', ','),
        'type' => "E£ " . number_format($total_eq, 2, '.', ','),
      );
      array_push($suppliers, $supplier);












      $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `sell_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `sell_transactions` WHERE  `date` BETWEEN '$start_date' AND '$end_date'");


      $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `sell_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
      $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `sell_transactions` WHERE  `date` BETWEEN '$start_date' AND '$new_end_date'");


      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $prev_debit = $row4['total_debit'];
      $prev_credit = $row5['total_credit'];
      $open_balance = $prev_debit - $prev_credit;
      $total_balance =  $row2['total_debit'] - $row3['total_credit'];






      // VAT TAX - DISCOUNT TAX

      // $total_def_tax = 0;
      // $last_total_def_tax = 0;

      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date'");
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

      // if ($total_def_tax > 0) {
      //   $total_def_tax = 0;
      // } else {
      //   $total_def_tax = -1 * $total_def_tax;
      // }




      // $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$new_end_date'");
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



      // if ($last_total_def_tax > 0) {
      //   $last_total_def_tax = 0;
      // } else {
      //   $last_total_def_tax = -1 * $last_total_def_tax;
      // }









      $supplier = array(
        'id' => "1",
        'check' => "Customers",
        'name' => "E£ " . number_format($open_balance, 2, '.', ','),
        'type' => "E£ " . number_format($total_balance, 2, '.', ','),
      );
      array_push($suppliers, $supplier);








      // Other Debit Balances
      $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
      $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
      $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_credit = number_format($row3['total_credit'], 2, '.', ',');
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $prev_debit = $row4['total_debit'];
      $prev_credit = $row5['total_credit'];
      $open_balance_debit = $prev_debit - $prev_credit;
      $total_balance_debit = $row2['total_debit'] - $row3['total_credit'];



      // // Expenses

      // $stmt9 = $con->prepare("SELECT SUM(`total`) as `total_debit` FROM `expenses` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      // $stmt9->execute();
      // $row9 = $stmt9->fetch(PDO::FETCH_ASSOC);
      // $total_expenses = $row9['total_debit'];

      // $stmt8 = $con->prepare("SELECT SUM(`total`) as `total_debit` FROM `expenses` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");
      // $stmt8->execute();
      // $row8 = $stmt8->fetch(PDO::FETCH_ASSOC);
      // $past_total_expeses = $row8['total_debit'];



      // // VAT PAYMENTS


      // $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `vat_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
      // $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `vat_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      // $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `vat_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
      // $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `vat_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

      // $stmt2->execute();
      // $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      // $stmt3->execute();
      // $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      // $stmt4->execute();
      // $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      // $stmt5->execute();
      // $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      // $prev_debit_vat = $row4['total_debit'];
      // $prev_credit_vat = $row5['total_credit'];
      // $open_balance_vat = $prev_debit_vat - $prev_credit_vat;
      // $total_balance_vat = $row2['total_debit'] - $row3['total_credit'];




      $total_debits = $total_balance_debit;
      $past_total_debits = $open_balance_debit;

      $supplier = array(
        'id' => "2",
        'check' => "Other Debit Balances",
        'name' => "E£ " . number_format($past_total_debits, 2, '.', ','),
        'type' => "E£ " . number_format($total_debits, 2, '.', ',')
      );
      array_push($suppliers, $supplier);






      $total_inventory = 0;
      $past_total_inventory = 0;
      $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `warehouse_id` != '314' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row2 as $supp2) {
            $total_inventory += ($supp2['quantity'] * $supp2['rate']);
          }
        }
      }

      $stmt3 = $con->prepare("SELECT * FROM `av_items` WHERE `warehouse_id` != '314' AND `created_time` BETWEEN '$start_date' AND '$new_end_date'");
      $stmt3->execute();
      $count3 = $stmt3->rowCount();
      if ($count3 > 0) {
        while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row3 as $supp3) {
            $past_total_inventory += ($supp3['quantity'] * $supp3['rate']);
          }
        }
      }






      $supplier = array(
        'id' => "3",
        'check' => "Inventories",
        'name' => "E£ " . number_format($past_total_inventory, 2, '.', ','),
        'type' => "E£ " . number_format($total_inventory, 2, '.', ','),
      );
      array_push($suppliers, $supplier);








      $past_total_curr_assets = $past_total_eq + $open_balance + $past_total_inventory + $past_total_debits;
      $total_curr_assets = $total_eq + $total_balance + $total_inventory + $total_debits;

      $supplier = array(
        'id' => "4",
        'check' => "Total Current Assets",
        'name' => "E£&nbsp;<span id='past_total_curr_assets'>" . number_format($past_total_curr_assets, 2, '.', ',') . "</span>",
        'type' => "E£&nbsp;<span id='total_curr_assets'>" . number_format($total_curr_assets, 2, '.', ',') . "</span>",
      );
      array_push($suppliers, $supplier);
    }
  }
}

echo json_encode($suppliers);
