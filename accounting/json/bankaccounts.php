<?php
require "../../functions/connect.php"; // Connect to database file
require "../../functions/general.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `bank_account`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      $account = $supp['account_number'];
      $bank_name = $supp['bank_name'];

      $total_balance = get_total_bank($bank_name, $account);
      $total_balance = number_format($total_balance, 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'account' => $account,
        'bank_name' => $bank_name,
        'balance' => $total_balance,
        'action' => '<a href="bankdetails.php?uid=' . $supp_id . '"><i class="fa-solid fa-eye"></i></a>',
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
