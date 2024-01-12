<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `share_account`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries

    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      $name = '<a href="accountdetails.php?uid=' . $supp_id . '" target="_blank"><div class="img-frame"><img src="../images/ur-img/profile3.png" alt=""></div>
            <div class="info">
              <div class="name">' . $supp['name'] . '</div>
            </div></a>';
      $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `share_transactions` WHERE `supplier_id` = '$supp_id'");
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = number_format($row2['total_debit'], 2, '.', ',');
      $stmt3 = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `share_transactions` WHERE  `supplier_id` = '$supp_id'");
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_credit = number_format($row3['total_credit'], 2, '.', ',');
      $total_balance = number_format(($row3['total_credit'] - $row2['total_debit']), 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'created_time' => $supp['created_time'],
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
