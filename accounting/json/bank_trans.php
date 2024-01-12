<?php
require "../../functions/connect.php"; // Connect to database file

// Cash In LIST
$cashes = array();
if (isset($_GET['bank_id'])) {
  $bank_id = $_GET['bank_id'];
  $stmt3 = $con->prepare("SELECT * FROM `bank_account` WHERE id = '$bank_id'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $bank_name = $row3['bank_name'];
    $bank_number = $row3['account_number'];
    $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number' ");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $stmt2 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
          $stmt2->execute();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          if ($row2['is_company'] == "1") {
            $name = $row2['company_name'];
          } else {
            $name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
          }
          $statement = 'Cash out to <a href="../contacts/supplierdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (SUPPLIER) <span class="sign out">-</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );

          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $stmt = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id'");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($row['is_company'] == "1") {
            $name = $row['company_name'];
          } else {
            $name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
          }
          $statement = 'Cash out to <a href="../contacts/manufacturerdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (MANUFACTURER) <span class="sign out">-</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );

          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $stmt = $con->prepare("SELECT * FROM `customers` WHERE `id` = '$supp_id'");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($row['is_company'] == "1") {
            $name = $row['company_name'];
          } else {
            $name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
          }
          $statement = 'Cash in from <a href="../contacts/customerdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (CUSTOMER) <span class="sign in">+</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $stmt = $con->prepare("SELECT * FROM `share_account` WHERE `id` = '$supp_id'");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $name = $row['name'];
          $statement = 'Funding from <a href="accountdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (PARTNERSHIP) <span class="sign in">+</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $stmt = $con->prepare("SELECT * FROM `share_account` WHERE `id` = '$supp_id'");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $name = $row['name'];
          $statement = 'Withdrawal to <a href="accountdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (PARTNERSHIP) <span class="sign out">-</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $statement = 'Exchange Difference <span class="sign out">-</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $supp_id = $supp['supplier_id'];
          $statement = 'Exchange Difference <span class="sign in">+</span> ';
          $date = $supp['date'];
          $debit = number_format($supp['debit'], 2);
          $credit = number_format($supp['credit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $statement = '<a href="expenses.php" target="_blank">Expenses for ' . $supp['type'] . '</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['total'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $statement = '<a href="revenues.php" target="_blank">Revenues for ' . $supp['type'] . '</a> <span class="sign in">+</span> ';
          $date = $supp['date'];
          $credit = number_format($supp['total'], 2);
          $debit = number_format(0, 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $statement = '<a href="vtax.php" target="_blank">Payment to TAX Vat</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['debit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['supplier_id'];
          $stmt4 = $con->prepare("SELECT * FROM `cbalances` WHERE `id` = '$id'");
          $stmt4->execute();
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          $name = $row4['name'];
          $statement = 'Credit Balance for <a href="cbalance.php?uid=' . $id . '" target="_blank"> ' . $name . '</a> <span class="sign in">+</span> ';
          $date = $supp['date'];
          $credit = number_format($supp['credit'], 2);
          $debit = number_format(0, 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['supplier_id'];
          $stmt4 = $con->prepare("SELECT * FROM `dbalances` WHERE `id` = '$id'");
          $stmt4->execute();
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          $name = $row4['name'];
          $statement = 'Debit Balance for <a href="dbalance.php?uid=' . $id . '" target="_blank"> ' . $name . '</a> <span class="sign in">+</span> ';
          $date = $supp['date'];
          $credit = number_format($supp['credit'], 2);
          $debit = number_format(0, 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['supplier_id'];
          $stmt4 = $con->prepare("SELECT * FROM `cbalances` WHERE `id` = '$id'");
          $stmt4->execute();
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          $name = $row4['name'];
          $statement = 'Credit Balance for <a href="cbalance.php?uid=' . $id . '" target="_blank"> ' . $name . '</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['debit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }
    $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['supplier_id'];
          $stmt4 = $con->prepare("SELECT * FROM `dbalances` WHERE `id` = '$id'");
          $stmt4->execute();
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          $name = $row4['name'];
          $statement = 'Debit Balance for <a href="dbalance.php?uid=' . $id . '" target="_blank"> ' . $name . '</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['debit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $statement = '<a href="loan.php?uid=' . $supp['supplier_id'] . '" target="_blank">Payment for Loan</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['debit'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $statement = '<a href="loan.php?uid=' . $supp['supplier_id'] . '" target="_blank">Loan</a> <span class="sign in">+</span> ';
          $date = $supp['date'];
          $credit = number_format($supp['credit'], 2);
          $debit = number_format(0, 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_account` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['id'];
          $cat_id = $supp['category_id'];
          $name = $supp['name'];
          $statement = 'Cash out to <a href="fasset.php?uid=' . $cat_id . '" target="_blank">' . $name . ' (FIXED ASSET)</a> <span class="sign out">-</span> ';
          $date = $supp['date'];
          $credit = number_format(0, 2);
          $debit = number_format($supp['init_price'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }

    $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          $id = $supp['item_id'];
          $stmt2 = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
          $stmt2->execute();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $name = $row2['name'];
          $statement = 'Cash in from selling <a href="fassets_sell.php" target="_blank">' . $name . ' (FIXED ASSET)</a> <span class="sign in">+</span> ';
          $date = $supp['date'];
          $debit = number_format(0, 2);
          $credit = number_format($supp['total'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }


    $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'bank' AND `to_bank_name` = '$bank_name' AND `to_bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          if ($supp['from_payment_method'] == 'cash') {
            $from_bank_name = '';
            $from_bank_number = '';
            $from_bank_id = '';
            $statement = 'Transfered Money From <a href="cash.php" target="_blank">Cash</a> <span class="sign in">+</span> ';
          } else {
            $from_bank_name = $supp['from_bank_name'];
            $from_bank_number = $supp['from_bank_number'];
            $stmt2 = $con->prepare("SELECT * FROM `bank_account` WHERE `bank_name` = '$from_bank_name' AND `account_number` = '$from_bank_number'");
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $from_bank_id = $row2['id'];
            $statement = 'Transfered Money From <a href="bankdetails.php?uid=' . $from_bank_id . '" target="_blank">' . $from_bank_number  . ' (' . $from_bank_name . ')</a> <span class="sign in">+</span> ';
          }

          $date = $supp['date'];
          $debit = number_format(0, 2);
          $credit = number_format($supp['amount'], 2);
          $cash = array(
            'statement' => $statement,
            'date' => $date,
            'debit' => $debit,
            'credit' => $credit,
          );
          array_push($cashes, $cash);
        }
      }
    }


    $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `from_payment_method` = 'bank' AND `from_bank_name` = '$bank_name' AND `from_bank_number` = '$bank_number'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $supp) {
          if ($supp['to_payment_method'] == "bank") {
            $from_bank_name = $supp['to_bank_name'];
            $from_bank_number = $supp['to_bank_number'];
            $stmt2 = $con->prepare("SELECT * FROM `bank_account` WHERE `bank_name` = '$from_bank_name' AND `account_number` = '$from_bank_number'");
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $from_bank_id = $row2['id'];
            $statement = 'Transfer Money to <a href="bankdetails.php?uid=' . $from_bank_id . '" target="_blank">' . $from_bank_number  . ' (' . $from_bank_name . ')</a> <span class="sign out">-</span> ';
            $date = $supp['date'];
            $debit = number_format($supp['amount'], 2);
            $credit = number_format(0, 2);
            $cash = array(
              'statement' => $statement,
              'date' => $date,
              'debit' => $debit,
              'credit' => $credit,
            );
            array_push($cashes, $cash);
          } else if ($supp['to_payment_method'] == "cash") {
            $statement = 'Transfer Money to <a href="cash.php" target="_blank">Treasury Cash</a> <span class="sign out">-</span> ';
            $date = $supp['date'];
            $debit = number_format($supp['amount'], 2);
            $credit = number_format(0, 2);
            $cash = array(
              'statement' => $statement,
              'date' => $date,
              'debit' => $debit,
              'credit' => $credit,
            );
            array_push($cashes, $cash);
          }
        }
      }
    }
  }
}

// Cash Out LIST
echo json_encode($cashes);
