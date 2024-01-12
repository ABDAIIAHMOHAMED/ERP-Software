<?php
require "../../../functions/connect.php"; // Connect to database file


$suppliers = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $past_end_date = date('Y-m-d', strtotime(date('Y-m-01', strtotime($end_date)) . ' -1 month'));
  $nextStartMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($start_date)) . ' +1 month'));

  $nextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($end_date)) . ' +1 month'));
  $nextnextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($nextEndMonth)) . ' +1 month'));
  $stmt = $con->prepare("SELECT * FROM `suppliers`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $new_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));





      $total_loan = 0;
      $last_total_loan = 0;
      $stmt10 = $con->prepare("SELECT * FROM `loan_orders` WHERE `duration` <= '12'");
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
        'check' => "Short-term Loans Payable",
        'name' => "E£ " . number_format($last_total_loan, 2, '.', ','),
        'type' => "E£ " . number_format($total_loan, 2, '.', ','),
      );

      array_push($suppliers, $supplier);
    }








    $total_supp_manu = 0;
    $last_total_supp_manu = 0;
    $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `supplier_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
    $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `supplier_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
    $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `supplier_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
    $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `supplier_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

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
    $open_balance = $prev_credit - $prev_debit;
    $total_balance = $row3['total_credit'] - $row2['total_debit'];

    $total_supp_manu += $total_balance;
    $last_total_supp_manu += $open_balance;



    $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
    $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
    $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
    $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

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
    $open_balance = $prev_credit - $prev_debit;
    $total_balance = $row3['total_credit'] - $row2['total_debit'];

    $total_supp_manu += $total_balance;
    $last_total_supp_manu += $open_balance;





    // VAT TAX - DISCOUNT TAX

    // $total_def_tax = 0;
    // $last_total_def_tax = 0;


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



    // $last_total_supp_manu = $last_total_supp_manu + $last_total_def_tax;
    // $total_supp_manu = $total_supp_manu + $total_def_tax;




    $supplier = array(
      'id' => "1",
      'check' => "Suppliers & Manufacturers",
      'name' => "E£ " .  number_format($last_total_supp_manu, 2, '.', ','),
      'type' => "E£ " . number_format($total_supp_manu, 2, '.', ','),
    );
    array_push($suppliers, $supplier);









    // Other Credit Balances
    $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `cbalance_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
    $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `cbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
    $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `cbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date' ");
    $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `cbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");

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
    $open_balance_debit = $prev_credit - $prev_debit;
    $total_balance_debit = $row3['total_credit'] - $row2['total_debit'];



    $total_credits = $total_balance_debit;
    $past_total_credits = $open_balance_debit;



    $supplier = array(
      'id' => "2",
      'check' => "Other Credit Balances",
      'name' => "E£ " . number_format($past_total_credits, 2, '.', ','),
      'type' => "E£ " . number_format($total_credits, 2, '.', ','),
    );
    array_push($suppliers, $supplier);

















    // $stmt2 = $con->prepare("SELECT SUM(`amount`) as `total_tax` FROM `income_tax` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
    // $stmt3 = $con->prepare("SELECT SUM(`amount`) as `total_tax` FROM `income_tax` WHERE `date` BETWEEN '$start_date' AND '$new_end_date'");
    // $stmt2->execute();
    // $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    // $stmt3->execute();
    // $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    // $total_tax = $row2['total_tax'];
    // $last_total_tax = $row3['total_tax'];




    // $supplier = array(
    //   'id' => "3",
    //   'check' => "Income Taxes Payable",
    //   'name' => "E£ " . number_format($last_total_tax, 2, '.', ','),
    //   'type' => "E£ " . number_format($total_tax, 2, '.', ','),
    // );
    // array_push($suppliers, $supplier);


    // VAT Tax.

    // $past_total_vat = 0;
    // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `sell_orders` WHERE `created_time` < '$start_date' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat += $supp['vat_amount'];
    //     }
    //   }
    // }
    // $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` < '$start_date' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat += $supp['vat_amount'];
    //     }
    //   }
    // }



    // $past_total_vat_out = 0;
    // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `supplier_orders` WHERE `created_time` < '$start_date' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat_out += $supp['vat_amount'];
    //     }
    //   }
    // }
    // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `manufacturer_orders` WHERE `created_time` < '$start_date' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat_out += $supp['vat_amount'];
    //     }
    //   }
    // }
    // $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` < '$start_date' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat_out += $supp['vat_amount'];
    //     }
    //   }
    // }
    // $stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` <= '$nextStartMonth' ");
    // $stmt1->execute();
    // $count1 = $stmt1->rowCount();
    // if ($count1 > 0) {
    //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    //     foreach ($row1 as $supp) {
    //       $past_total_vat_out += $supp['debit'];
    //     }
    //   }
    // }






    // $past_total_total_vat = $past_total_vat - $past_total_vat_out;

    // if ($past_total_total_vat <= 0) {
    //   $past_status = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $past_total_total_vat, 2, '.', ',');
    // } else {
    //   $past_status = "<span class='sti_cr_db db_sti'>Credit</span> " . number_format($past_total_total_vat, 2, '.', ',');
    // }













    // PAST

    $past_total_vat = 0;
    $past_total_vat_out = 0;
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$past_end_date'");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$past_end_date'");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat += $supp['vat_amount'];
        }
      }
    }
    $past_total_vat_out = 0;
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$past_end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$past_end_date'");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` BETWEEN '$start_date' AND '$past_end_date'");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` <= '$nextEndMonth' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $past_total_vat_out += $supp['debit'];
        }
      }
    }
    $past_total_total_vat = $past_total_vat - $past_total_vat_out;



    // LIVE

    $total_vat = 0;
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat += $supp['vat_amount'];
        }
      }
    }
    $total_vat_out = 0;
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat_out += $supp['vat_amount'];
        }
      }
    }
    $stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` < '$nextnextEndMonth' ");
    $stmt1->execute();
    $count1 = $stmt1->rowCount();
    if ($count1 > 0) {
      while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row1 as $supp) {
          $total_vat_out += $supp['debit'];
        }
      }
    }






    $total_total_vat =  ($total_vat - $total_vat_out);




    $supplier = array(
      'id' => "3",
      'check' => "VAT Tax.",
      'name' => "E£ " . number_format($past_total_total_vat, 2, '.', ','),
      'type' => "E£ " . number_format($total_total_vat, 2, '.', ','),
    );
    array_push($suppliers, $supplier);








    $total_curr_lia =  $total_credits + $total_supp_manu + $total_loan + $total_total_vat;
    $last_total_curr_lia = $past_total_credits + $last_total_supp_manu + $past_total_total_vat;
    $supplier = array(
      'id' => "4",
      'check' => "Total Current Liablilities",
      'name' => "E£&nbsp;<span id='last_total_curr_lia'>" . number_format($last_total_curr_lia, 2, '.', ',') . "</span>",
      'type' => "E£&nbsp;<span id='total_curr_lia'>" . number_format($total_curr_lia, 2, '.', ',') . "</span>",
    );
    array_push($suppliers, $supplier);


    $supplier = array(
      'id' => "5",
      'check' => "Total Liablilities",
      'name' => "E£&nbsp;<span id='last_total_lia'>Calculating...</span>",
      'type' => "E£&nbsp;<span id='total_lia'>Calculating...</span>",
    );

    array_push($suppliers, $supplier);
  }
}


echo json_encode($suppliers);
