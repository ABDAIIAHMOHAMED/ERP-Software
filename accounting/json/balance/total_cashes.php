<?php
$total_in = 0;
$total_out = 0;
$past_total_in = 0;
$past_total_out = 0;
$nextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($end_date)) . ' +1 month'));
$nextnextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($nextEndMonth)) . ' +1 month'));

// CASH IN
$stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $total_in += $supp['credit'];
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
$stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'cash'  AND `date` BETWEEN '$start_date' AND '$end_date'");
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
// CASH OUT

$stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $total_out += $supp['debit'];
    }
  }
}
$stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp2) {
      $total_out += $supp2['debit'];
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
// $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$end_date'");
// $stmt->execute();
// $count = $stmt->rowCount();
// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {
//       $total_out += $supp['debit'];
//     }
//   }
// }
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
$stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` <= '$nextnextEndMonth' ");
$stmt1->execute();
$count1 = $stmt1->rowCount();
if ($count1 > 0) {
  while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row1 as $supp) {
      $total_out += $supp['debit'];
    }
  }
}





// PAST CASH IN
$stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'cash'  AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}

$stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}

$stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['credit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['total'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['amount'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_in += $supp['total'];
    }
  }
}
// PAST CASH OUT

$stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
$stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt3->execute();
$count3 = $stmt3->rowCount();
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp2) {
      $past_total_out += $supp2['debit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['total'];
    }
  }
}
// $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
// $stmt->execute();
// $count = $stmt->rowCount();
// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {
//       $past_total_out += $supp['debit'];
//     }
//   }
// }
$stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}

$stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
$stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$new_end_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $past_total_out += $supp['init_price'];
    }
  }
}
$stmt1 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash' AND `date` BETWEEN '$start_date' AND '$nextEndMonth' ");
$stmt1->execute();
$count1 = $stmt1->rowCount();
if ($count1 > 0) {
  while ($row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row1 as $supp) {
      $past_total_out += $supp['debit'];
    }
  }
}
