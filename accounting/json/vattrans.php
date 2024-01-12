<?php
require "../../functions/connect.php"; // Connect to database file

// Cash In LIST
$cashes = array();

$stmt3 = $con->prepare("SELECT * FROM `vat_transactions`");
$stmt3->execute();
$count3 = $stmt3->rowCount();
$i = 1;
if ($count3 > 0) {
  while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row3 as $supp) {
      $debit = number_format($supp['debit'], 2);
      $payment_method = $supp['payment_method'];
      if ($supp['payment_method'] == "cash") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-money-bill'></i> Treasury Cash</span>";
      } else if ($supp['payment_method'] == "bank") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-building-columns'></i> " . $supp['bank_number'] . " ( " . $supp['bank_name'] . " )</span>";
      }
      $date = $supp['date'];
      $cash = array(
        'no' => $i,
        'payment_method' => $payment,
        'date' => $date,
        'amount' => $debit,
      );
      array_push($cashes, $cash);
      $i++;
    }
  }
}

// VAT FROM Returns

// Cash Out LIST
echo json_encode($cashes);
