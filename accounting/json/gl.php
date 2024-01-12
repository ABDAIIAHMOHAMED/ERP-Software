<?php
require "../../functions/connect.php"; // Connect to database file
include "../../functions/general.php";

$suppliers = array();
$i = 1;
$total_balance = 0;


// Customers
$stmt = $con->prepare("SELECT * FROM `suppliers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $nextStartMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($start_date)) . ' +1 month'));

        $nextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($end_date)) . ' +1 month'));
        $nextnextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($nextEndMonth)) . ' +1 month'));


        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `sell_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `sell_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `sell_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `sell_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `sell_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `sell_transactions`");
      }
      $name = "<a href='customers.php' target='_blank'>Customers</a>";
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
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
      // $stmt1->execute();
      // $count1 = $stmt1->rowCount();
      // if ($count1 > 0) {
      //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row1 as $supp) {
      //       $total_vat_out -= $supp['vat_amount'];
      //       $total_vat_out += $supp['withholding'];
      //       $total_debit -= $supp['vat_amount'];
      //       $total_debit += $supp['withholding'];
      //       $total_credit -= $supp['vat_amount'];
      //       $total_credit += $supp['withholding'];
      //     }
      //   }
      // }


      // $past_total_vat_out = 0;
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `sell_orders` WHERE `created_time` < '$start_date' ");
      // $stmt1->execute();
      // $count1 = $stmt1->rowCount();
      // if ($count1 > 0) {
      //   while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      //     foreach ($row1 as $supp) {
      //       $past_total_vat_out -= $supp['vat_amount'];
      //       $past_total_vat_out += $supp['withholding'];
      //       $prev_debit -= $supp['vat_amount'];
      //       $prev_debit += $supp['withholding'];
      //       $prev_credit -= $supp['vat_amount'];
      //       $prev_credit += $supp['withholding'];
      //     }
      //   }
      // }





      $open_balance = ($prev_credit - $prev_debit);
      $total_balance = ($open_balance + ($total_credit - $total_debit));















      $open_balance_number = str_replace(',', '', $open_balance); // Remove commas from the formatted number
      $open_balance_number = floatval($open_balance_number); // Convert the string to a float

      if ($open_balance_number < 0) {
        $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * ($prev_credit - $prev_debit), 2, '.', ',');
      } else {
        $open_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($open_balance, 2, '.', ',');
      }




      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number < 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * (($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($total_balance, 2, '.', ',');
      }








      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => number_format($total_debit, 2, '.', ','),
        'credit' => number_format($total_credit, 2, '.', ','),
        'balance' => $total_balance,
      );
      if ($total_debit || $total_credit || $open_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Suppliers
$stmt = $con->prepare("SELECT * FROM `suppliers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `supplier_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `supplier_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `supplier_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `supplier_transactions` WHERE `date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `supplier_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `supplier_transactions`");
      }
      $name = "<a href='suppliers.php' target='_blank'>Suppliers</a>";
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
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
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
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `supplier_orders` WHERE `created_time` < '$start_date' ");
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
      $total_balance = ($open_balance + ($total_credit - $total_debit));















      $open_balance_number = str_replace(',', '', $open_balance); // Remove commas from the formatted number
      $open_balance_number = floatval($open_balance_number); // Convert the string to a float

      if ($open_balance_number < 0) {
        $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $open_balance, 2, '.', ',');
      } else {
        $open_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($open_balance, 2, '.', ',');
      }




      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number < 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $total_balance, 2, '.', ',');
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($total_balance, 2, '.', ',');
      }








      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => number_format($total_debit, 2, '.', ','),
        'credit' => number_format($total_credit, 2, '.', ','),
        'balance' => $total_balance,
      );
      if ($total_debit || $total_credit || $open_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}




// Manufacturers
$stmt = $con->prepare("SELECT * FROM `manufacturers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `manufacturer_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `manufacturer_transactions`");
      }
      $name = "<a href='manufacturers.php' target='_blank'>Manufacturers</a>";
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
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
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
      // $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount`,`withholding` FROM `manufacturer_orders` WHERE `created_time` < '$start_date' ");
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
      $total_balance = ($open_balance + ($total_credit - $total_debit));















      $open_balance_number = str_replace(',', '', $open_balance); // Remove commas from the formatted number
      $open_balance_number = floatval($open_balance_number); // Convert the string to a float

      if ($open_balance_number < 0) {
        $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $open_balance, 2, '.', ',');
      } else {
        $open_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($open_balance, 2, '.', ',');
      }




      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number < 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $total_balance, 2, '.', ',');
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . number_format($total_balance, 2, '.', ',');
      }








      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => number_format($total_debit, 2, '.', ','),
        'credit' => number_format($total_credit, 2, '.', ','),
        'balance' => $total_balance,
      );
      if ($total_debit || $total_credit || $open_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Expenses
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`total`) as `total_debit` FROM `expenses` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
      }
      $name = "<a href='expenses.php' target='_blank'>Expenses</a>";
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');

      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => $total_debit,
        'credit' => number_format(0, 2, '.', ','),
        'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . $total_debit,
      );
      if ($row2['total_debit'] != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Revenues
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`total`) as `total_debit` FROM `revenues` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
      }
      $name = "<a href='revenues.php' target='_blank'>Other Revenues</a>";
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');

      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format(0, 2, '.', ','),
        'credit' => $total_debit,
        'balance' => "<span class='sti_cr_db'>Credit</span> " . $total_debit,
      );
      if ($row2['total_debit'] != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Purchases
// $stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
// $stmt->execute();
// $count = $stmt->rowCount();

// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {

//       $total_purchases = 0;
//       $stmt1 = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`paid`,`order_id` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_purchases += $supp['subtotal'] - $supp['discount'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`paid`,`order_id` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_purchases += $supp['subtotal'] - $supp['discount'];
//           }
//         }
//       }


//       $name = "<a href='purchases.php' target='_blank'>Purchases & Manufacturing</a>";
//       $supplier = array(
//         'no' => $i,
//         'name' => $name,
//         'open_balance' => number_format(0, 2, '.', ','),
//         'debit' => number_format($total_purchases, 2, '.', ','),
//         'credit' => number_format(0, 2, '.', ','),
//         'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_purchases, 2, '.', ','),
//       );
//       if ($total_purchases != 0) {
//         $i++;
//         array_push($suppliers, $supplier);
//       }
//     }
//   }
// }
// Purchases Withholding
// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {

//       $total_vat = 0;
//       $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_vat += $supp['vat_amount'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_vat += $supp['vat_amount'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_vat += $supp['vat_amount'];
//           }
//         }
//       }
//       $name = "<a href='vtax.php' target='_blank'>VAT Tax for purchases</a>";
//       $supplier = array(
//         'no' => $i,
//         'name' => $name,
//         'open_balance' => number_format(0, 2, '.', ','),
//         'debit' => number_format($total_vat, 2, '.', ','),
//         'credit' => number_format(0, 2, '.', ','),
//         'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_vat, 2, '.', ','),
//       );
//       if ($total_vat != 0) {
//         $i++;
//         array_push($suppliers, $supplier);
//       }
//     }
//   }
// }

// Purchases Withholding
// $stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
// $stmt->execute();
// $count = $stmt->rowCount();

// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {

//       $total_with = 0;
//       $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`withholding` FROM `supplier_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_with += $supp['withholding'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`withholding` FROM `manufacturer_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_with += $supp['withholding'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_with += $supp['witholding'];
//           }
//         }
//       }
//       $name = "<a href='sales.php' target='_blank'>Withholding Tax for purchases</a>";
//       $supplier = array(
//         'no' => $i,
//         'name' => $name,
//         'open_balance' => number_format(0, 2, '.', ','),
//         'debit' => number_format(0, 2, '.', ','),
//         'credit' => number_format($total_with, 2, '.', ','),
//         'balance' => "<span class='sti_cr_db'>Credit</span> " . number_format($total_with, 2, '.', ','),
//       );
//       if ($total_with != 0) {
//         $i++;
//         array_push($suppliers, $supplier);
//       }
//     }
//   }
// }




// Sales
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $total_sales = 0;
      $stmt1 = $con->prepare("SELECT DISTINCT `discount`,`subtotal`,`order_id` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_sales += $supp['subtotal'] - $supp['discount'];
          }
        }
      }

      $name = "<a href='sales.php' target='_blank'>Sales</a>";
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format(0, 2, '.', ','),
        'credit' => number_format($total_sales, 2, '.', ','),
        'balance' => "<span class='sti_cr_db'>Credit</span> " . number_format($total_sales, 2, '.', ','),
      );
      if ($total_sales != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Sales Costs
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $total_sales = 0;
      $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`paid`,`order_id` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_sales += $supp['sell_cost'];
          }
        }
      }
      $name = "<a href='sales.php' target='_blank'>Sales Costs</a>";
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format($total_sales, 2, '.', ','),
        'credit' => number_format(0, 2, '.', ','),
        'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_sales, 2, '.', ','),
      );
      if ($total_sales != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Sales Withholding
// $stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
// $stmt->execute();
// $count = $stmt->rowCount();

// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {

//       $total_with = 0;
//       $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`withholding` FROM `sell_orders` WHERE `created_time` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_with += $supp['withholding'];
//           }
//         }
//       }
//       $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
//       $stmt1->execute();
//       $count1 = $stmt1->rowCount();
//       if ($count1 > 0) {
//         while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//           foreach ($row1 as $supp) {
//             $total_with += $supp['withholding'];
//           }
//         }
//       }
//       $name = "<a href='sales.php' target='_blank'>Withholding Tax for sales</a>";
//       $supplier = array(
//         'no' => $i,
//         'name' => $name,
//         'open_balance' => number_format(0, 2, '.', ','),
//         'debit' => number_format($total_with, 2, '.', ','),
//         'credit' =>  number_format(0, 2, '.', ','),
//         'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_with, 2, '.', ','),
//       );
//       if ($total_with != 0) {
//         $i++;
//         array_push($suppliers, $supplier);
//       }
//     }
//   }
// }

// VAT
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      // PAST

      $past_total_vat = 0;
      $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `sell_orders` WHERE `created_time` < '$start_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $past_total_vat += $supp['vat_amount'];
          }
        }
      }
      $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` < '$start_date' ");
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
      $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `supplier_orders` WHERE `created_time` < '$start_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $past_total_vat_out += $supp['vat_amount'];
          }
        }
      }
      $stmt1 = $con->prepare("SELECT DISTINCT `order_total`,`paid`,`order_id`,`vat_amount` FROM `manufacturer_orders` WHERE `created_time` < '$start_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $past_total_vat_out += $supp['vat_amount'];
          }
        }
      }
      $stmt1 = $con->prepare("SELECT * FROM `assets` WHERE `date` < '$start_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $past_total_vat_out += $supp['vat_amount'];
          }
        }
      }
      $stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` <= '$nextStartMonth' ");
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

      if ($past_total_total_vat <= 0) {
        $past_status = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $past_total_total_vat, 2, '.', ',');
      } else {
        $past_status = "<span class='sti_cr_db db_sti'>Credit</span> " . number_format($past_total_total_vat, 2, '.', ',');
      }


















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
      $stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` BETWEEN '$nextEndMonth' AND '$nextnextEndMonth' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_vat_out += $supp['debit'];
          }
        }
      }






      $total_total_vat = $past_total_total_vat + ($total_vat - $total_vat_out);

      if ($total_total_vat <= 0) {
        $status = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * $total_total_vat, 2, '.', ',');
      } else {
        $status = "<span class='sti_cr_db db_sti'>Credit</span> " . number_format($total_total_vat, 2, '.', ',');
      }
      $name = "<a href='vtax.php' target='_blank'>VAT Tax.</a>";
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $past_status,
        'debit' => number_format($total_vat_out, 2, '.', ','),
        'credit' => number_format($total_vat, 2, '.', ','),
        'balance' => $status,
      );
      if ($total_total_vat != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}
// Inventory
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();
$total_debit = 0;
$total_old_balance = 0;
$balance = 0;
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];


        // OLD Inventory

        // OLD Output
        $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`discount`,`paid`,`order_id` FROM `sell_orders` WHERE `received` = '1' AND `subtotal` > '0' AND `created_time` <= '$start_date'");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance -= $supp['sell_cost'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`total`) as `total` FROM `manufacturer_orders` WHERE `started` = '1' AND `subtotal` > '0' AND `created_time` <= '$start_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance -= $supp['total'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`subtotal`) as `subtotal` FROM `supplier_orders` WHERE `received` = '1' AND `subtotal` < '0' AND `created_time` <= '$start_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance += $supp['subtotal'] - $supp['discount'];
            }
          }
        }
        // OLD Input
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`subtotal`) as `subtotal` FROM `supplier_orders` WHERE `received` = '1' AND `subtotal` > '0' AND `created_time` <= '$start_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance += $supp['subtotal'] - $supp['discount'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT DISTINCT `total`,`subtotal`,`order_id`,`discount` FROM `manufacturer_orders` WHERE `received` = '1' AND `created_time` <= '$start_date'");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance += ($supp['subtotal'] + $supp['total'] - $supp['discount']);
            }
          }
        }
        $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`discount`,`paid`,`order_id` FROM `sell_orders` WHERE `received` = '1' AND `subtotal` < '0' AND `created_time` <= '$start_date'");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_old_balance -= $supp['sell_cost'] - $supp['discount'];
            }
          }
        }

        // End OLD Inventory

        // LIVE Output
        $total_sales = 0;
        $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`discount`,`paid`,`order_id` FROM `sell_orders` WHERE `received` = '1' AND `subtotal` > '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_sales += $supp['sell_cost'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`total`) as `total` FROM `manufacturer_orders` WHERE `started` = '1' AND `subtotal` > '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_sales += $supp['total'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`subtotal`) as `subtotal` FROM `supplier_orders` WHERE `received` = '1' AND `subtotal` < '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_sales -= $supp['subtotal'] - $supp['discount'];
            }
          }
        }
        // LIVE Input
        $stmt1 = $con->prepare("SELECT `order_id`,`discount`, MAX(`subtotal`) as `subtotal` FROM `supplier_orders` WHERE `received` = '1' AND `subtotal` > '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' GROUP BY `order_id`,`discount`");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_debit += $supp['subtotal'] - $supp['discount'];
            }
          }
        }
        $stmt1 = $con->prepare("SELECT DISTINCT `total`,`subtotal`,`order_id`,`discount` FROM `manufacturer_orders` WHERE `received` = '1' AND `created_time`  BETWEEN '$start_date' AND '$end_date' ");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_debit += ($supp['subtotal'] + $supp['total'] - $supp['discount']);
            }
          }
        }
        $stmt1 = $con->prepare("SELECT DISTINCT `sell_cost`,`discount`,`paid`,`order_id` FROM `sell_orders` WHERE `received` = '1' AND `subtotal` < '0' AND `created_time` BETWEEN '$start_date' AND '$end_date' ");
        $stmt1->execute();
        $count1 = $stmt1->rowCount();
        if ($count1 > 0) {
          while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row1 as $supp) {
              $total_debit -= $supp['sell_cost'] - $supp['discount'];
            }
          }
        }







        $balance = ($total_debit + $total_old_balance - $total_sales);
        $statue = "";
        if ($balance >= 0) {
          $status = "<span class='sti_cr_db db_sti'>Debit</span> ";
        } else {
          $status = "<span class='sti_cr_db'>Credit</span> ";
        }
        $name = "<a href='../inventory/inventory.php' target='_blank'>Inventory</a>";

        $supplier = array(
          'no' => $i,
          'name' => $name,
          'open_balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_old_balance, 2, '.', ','),
          'debit' => number_format($total_debit, 2, '.', ','),
          'credit' => number_format($total_sales, 2, '.', ','),
          'balance' => $status . number_format($balance, 2, '.', ','),
        );

        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Credit balances
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `cbalance_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `cbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `cbalance_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `cbalance_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `cbalance_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `cbalance_transactions`");
      }
      $name = "<a href='cbalances.php' target='_blank'>Other Credit Balances</a>";
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
      $open_balance = number_format(($prev_credit - $prev_debit), 2, '.', ',');
      $total_balance = number_format((($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');


      $open_balance_number = str_replace(',', '', $open_balance); // Remove commas from the formatted number
      $open_balance_number = floatval($open_balance_number); // Convert the string to a float

      if ($open_balance_number < 0) {
        $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * ($prev_credit - $prev_debit), 2, '.', ',');
      } else {
        $open_balance = "<span class='sti_cr_db'>Credit</span> " . $open_balance;
      }

      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number >= 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . $total_balance;
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . $total_balance;
      }
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      if ($total_debit != '0.00' || $total_credit != '0.00' || $open_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Debit balances
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `dbalance_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `dbalance_transactions`");
      }
      $name = "<a href='dbalances.php' target='_blank'>Other Debit Balances</a>";
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
      $open_balance = number_format(($prev_credit - $prev_debit), 2, '.', ',');
      $total_balance = number_format((($prev_debit - $prev_credit) + ($row2['total_debit'] - $row3['total_credit'])), 2, '.', ',');
      $open_balance_number = str_replace(',', '', $open_balance); // Remove commas from the formatted number
      $open_balance_number = floatval($open_balance_number); // Convert the string to a float

      if ($open_balance_number < 0) {
        $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * ($prev_credit - $prev_debit), 2, '.', ',');
      } else {
        $open_balance = "<span class='sti_cr_db'>Credit</span> " . $open_balance;
      }

      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number >= 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . $total_balance;
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . $total_balance;
      }
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      if ($total_debit != '0.00' || $total_credit != '0.00' || $open_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Fixed Assets NOT_WORKING
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`init_price`) as `total_debit` FROM `assets` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`init_price`) as `total_debit` FROM `assets` WHERE `date` < '$start_date' ");
      }
      $name = "<a href='fassets.php' target='_blank'>Fixed Assets</a>";
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $prev_debit = $row4['total_debit'];
      $open_balance = number_format(($prev_debit), 2, '.', ',');
      $total_balance = number_format(-1 * ((0 - $prev_debit) + (0 - $row2['total_debit'])), 2, '.', ',');


      $open_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . $open_balance;




      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number >= 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . $total_balance;
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . $total_balance;
      }
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => number_format(0, 2, '.', ','),
        'balance' => $total_balance,
      );
      if ($total_debit != '0.00' || $total_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Fixed Assets Depreciation NOT_WORKING
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`amount`) as `total_credit` FROM `dep_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_credit` FROM `dep_transactions` WHERE `date` < '$start_date' ");
      }
      $name = "<a href='fassets.php' target='_blank'>Fixed Assets Depreciation</a>";
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_credit = number_format($row2['total_credit'], 2, '.', ',');
      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $prev_credit = $row4['total_credit'];
      $open_balance = number_format(($prev_credit - 0), 2, '.', ',');
      $total_balance = number_format((($prev_credit - 0) + ($row2['total_credit'] - 0)), 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => "<span class='sti_cr_db'>Credit</span> " . $open_balance,
        'debit' => number_format(0, 2, '.', ','),
        'credit' => $total_credit,
        'balance' => "<span class='sti_cr_db'>Credit</span> " . $total_balance,
      );
      if ($total_credit != 0 || $open_balance != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}
// Fixed Assets Sales
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $total_sales = 0;
      $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_sales += $supp['total'];
          }
        }
      }

      $name = "<a href='sales.php' target='_blank'>Fixed Assets Sales</a>";
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format(0, 2, '.', ','),
        'credit' => number_format($total_sales, 2, '.', ','),
        'balance' => "<span class='sti_cr_db'>Credit</span> " . number_format($total_sales, 2, '.', ','),
      );
      if ($total_sales != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}
// Sales Costs
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $total_sales = 0;
      $stmt1 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
      $stmt1->execute();
      $count1 = $stmt1->rowCount();
      if ($count1 > 0) {
        while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row1 as $supp) {
            $total_sales += $supp['cost'];
          }
        }
      }

      $name = "<a href='sales.php' target='_blank'>Fixed Assets Sales Costs</a>";
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => number_format($total_sales, 2, '.', ','),
        'credit' => number_format(0, 2, '.', ','),
        'balance' => "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_sales, 2, '.', ','),
      );
      if ($total_sales != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}
// Loans
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `loan_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `loan_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `loan_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `loan_transactions`");
      }
      $name = "<a href='loans.php' target='_blank'>Loans</a>";
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
      $open_balance = number_format(($prev_credit - $prev_debit), 2, '.', ',');
      $total_balance = number_format((($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');

      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number <= 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " .  number_format(-1 * (($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');;
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . $total_balance;
      }

      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      if ($total_balance != "<span class='sti_cr_db db_sti'>Debit</span> 0.00") {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}



// Cash 
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];


        // Curr Cash in
        $total_in = 0;
        $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['credit'] > 0) {
                $total_in += $supp['credit'];
              } else {
                $total_out -= $supp['credit'];
              }
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['credit'];
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['amount'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in += $supp['total'];
            }
          }
        }
        // Curr Cash in

        // Past Cash in
        $past_total_in = 0;
        $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['credit'] > 0) {
                $past_total_in += $supp['credit'];
              } else {
                $past_total_out -= $supp['credit'];
              }
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['credit'];
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['amount'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in += $supp['total'];
            }
          }
        }
        // Past Cash in

        // Curr Cash out
        $total_out = 0;
        $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $total_out += $supp['debit'];
              } else {
                $total_in -= $supp['debit'];
              }
            }
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row3 as $supp2) {
              if ($supp2['debit'] > 0) {
                $total_out += $supp2['debit'];
              } else {
                $total_in -= $supp2['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $total_out += $supp['debit'];
              } else {
                $total_in -= $supp['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['init_price'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `from_payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out += $supp['amount'];
            }
          }
        }
        // Curr Cash out

        // Past Cash out
        $past_total_out = 0;
        $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $past_total_out += $supp['debit'];
              } else {
                $past_total_in -= $supp['debit'];
              }
            }
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row3 as $supp2) {
              if ($supp2['debit'] > 0) {
                $past_total_out += $supp2['debit'];
              } else {
                $past_total_in -= $supp2['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $past_total_out += $supp['debit'];
              } else {
                $past_total_in -= $supp['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['init_price'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `from_payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out += $supp['amount'];
            }
          }
        }
        // Past Cash out

        // Total Curr Cash
        $open_balance = $past_total_in - $past_total_out;
        $total_cash = $total_in - $total_out;
        $total_balance = $open_balance + $total_cash;
        // Total Curr Cash
      }
      if ($total_balance >= 0) {
        $status = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_balance, 2, '.', ',');
      } else {
        $status = "<span class='sti_cr_db'>Credit</span> " . number_format(-1 * $total_balance, 2, '.', ',');
      }
      $name = "<a href='cash.php' target='_blank'>Cash</a>";
      $total_debit = $total_in;
      $total_credit = $total_out;
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format($open_balance, 2, '.', ','),
        'debit' => number_format($total_debit, 2, '.', ','),
        'credit' => number_format($total_credit, 2, '.', ','),
        'balance' => $status,
      );
      if ($total_credit != 0 && $total_debit != 0 || $open_balance != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


// Bank Accounts 
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        // Curr Bank in
        $total_in_bank = 0;
        $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date' ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['credit'] > 0) {
                $total_in_bank += $supp['credit'];
              } else {
                $total_out_bank -= $supp['credit'];
              }
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['credit'];
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_in_bank += $supp['amount'];
            }
          }
        }
        // Curr Bank in
        // Past Bank in
        $past_total_in_bank = 0;
        $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date' ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['credit'] > 0) {
                $past_total_in_bank += $supp['credit'];
              } else {
                $past_total_out_bank -= $supp['credit'];
              }
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['credit'];
            }
          }
        }

        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['credit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'bank' AND  `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'bank' AND  `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_in_bank += $supp['amount'];
            }
          }
        }

        // Past Bank in
        // Curr Bank out
        $total_out_bank = 0;
        $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $total_out_bank += $supp['debit'];
              } else {
                $total_in_bank -= $supp['debit'];
              }
            }
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row3 as $supp2) {
              if ($supp2['debit'] > 0) {
                $total_out_bank += $supp2['debit'];
              } else {
                $total_in_bank -= $supp2['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date' ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $total_out_bank += $supp['debit'];
              } else {
                $total_in_bank -= $supp['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'bank' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['init_price'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $total_out_bank += $supp['amount'];
            }
          }
        }
        // Curr Bank out
        // Past Bank out
        $past_total_out_bank = 0;
        $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row3 as $supp2) {
              $past_total_out_bank += $supp2['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['total'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              if ($supp['debit'] > 0) {
                $past_total_out_bank += $supp['debit'];
              } else {
                $past_total_in_bank -= $supp['debit'];
              }
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['debit'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'bank' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['init_price'];
            }
          }
        }
        $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash' AND `date` < '$start_date'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $supp) {
              $past_total_out_bank += $supp['amount'];
            }
          }
        }
        // Total Curr Cash
        $open_balance_bank = $past_total_in_bank - $past_total_out_bank;
        $total_cash_bank = $total_in_bank - $total_out_bank;
        $total_balance_bank = $open_balance_bank + $total_cash_bank;
        // Total Curr Cash
      }
      if ($total_balance_bank >= 0) {
        $status = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format($total_balance_bank, 2, '.', ',');
      } else {
        $status = "<span class='sti_cr_db'>Credit</span> " . number_format(-1 * $total_balance_bank, 2, '.', ',');
      }


      $name = "<a href='banks.php' target='_blank'>Bank Accounts</a>";
      $total_debit_bank = $total_in_bank;
      $total_credit_bank = $total_out_bank;
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format($open_balance_bank, 2, '.', ','),
        'debit' => number_format($total_debit_bank, 2, '.', ','),
        'credit' => number_format($total_credit_bank, 2, '.', ','),
        'balance' => $status,
      );
      if ($total_credit_bank != 0 && $total_debit_bank != 0 || $open_balance_bank != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Capital Share
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions` WHERE `date` < '$start_date' ");
        $stmt5 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions` WHERE`date` < '$start_date'");
      } else {
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions`");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions`");
      }
      $name = "<a href='capital.php' target='_blank'>Share Capital</a>";
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
      $open_balance = number_format(($prev_credit - $prev_debit), 2, '.', ',');
      $total_balance = number_format((($prev_credit - $prev_debit) + ($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');





      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number < 0) {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . $total_balance;
      } else {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . $total_balance;
      }
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => $open_balance,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      if ($total_credit != 0 || $open_balance != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}

// Exchange Difference
$stmt = $con->prepare("SELECT * FROM `customers` LIMIT 1");
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `exchange_transactions` WHERE`date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `exchange_transactions` WHERE `date` BETWEEN '$start_date' AND '$end_date'");
      }
      $name = "<a href='exchange.php' target='_blank'>Currency Exchange Difference</a>";
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_credit = number_format($row3['total_credit'], 2, '.', ',');

      $total_balance = number_format((($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');


      $total_balance_number = str_replace(',', '', $total_balance); // Remove commas from the formatted number
      $total_balance_number = floatval($total_balance_number); // Convert the string to a float

      if ($total_balance_number >= 0) {
        $total_balance = "<span class='sti_cr_db'>Credit</span> " . number_format((($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');
      } else {
        $total_balance = "<span class='sti_cr_db db_sti'>Debit</span> " . number_format(-1 * (($row3['total_credit'] - $row2['total_debit'])), 2, '.', ',');
      }

      $supplier = array(
        'no' => $i,
        'name' => $name,
        'open_balance' => number_format(0, 2, '.', ','),
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      if ($total_balance_number != 0) {
        $i++;
        array_push($suppliers, $supplier);
      }
    }
  }
}


echo json_encode($suppliers);
