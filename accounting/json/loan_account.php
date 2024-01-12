<?php
require "../../functions/connect.php"; // Connect to database file

// Cash In LIST
$cashes = array();
if (isset($_GET['uid']) && !empty($_GET['uid'])) {
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE `credit` != '0' AND `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $supp_id = $supp['supplier_id'];

        $statement = 'Open balance for loan <span class="sign in">+</span> ';

        $date = $supp['date'];
        $debit = number_format($supp['debit'], 2);
        $credit = number_format($supp['credit'], 2);
        $cash = array(
          'statement' => $statement,
          'date' => $date,
          'debit' => $debit,
          'credit' => $credit,
          'type' => '<div><span style="display:none;">repayment loan interest</span>' . ucfirst($supp['type']) . '</div>',
          'action' => '',
        );
        array_push($cashes, $cash);
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE `debit` != '0' AND `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $supp_id = $supp['supplier_id'];

        if ($supp['payment_method'] == "cash") {
          $statement = 'Payment through cash <span class="sign out">-</span> ';
        } else {
          $statement = 'Payment through Bank Account ' . $supp['bank_number'] . ' ( ' . $supp['bank_name'] . ' ) <span class="sign out">-</span> ';
        }
        $date = $supp['date'];
        $debit = number_format($supp['debit'], 2);
        $credit = number_format($supp['credit'], 2);
        $cash = array(
          'statement' => $statement,
          'date' => $date,
          'debit' => $debit,
          'credit' => $credit,
          'type' => ucfirst($supp['type']),
          'action' => '<button class="delete_order" btn-data="' . $supp['id'] . '"><i class="fa-solid fa-trash"></i></button>',
        );
        array_push($cashes, $cash);
      }
    }
  }
}
// Cash Out LIST
echo json_encode($cashes);
