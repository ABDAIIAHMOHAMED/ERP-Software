<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `expenses` ORDER BY `date`");
$stmt->execute();
$count = $stmt->rowCount();
$i = 1;
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $amount = number_format($supp['amount'], 2, '.', ',');
      $total = number_format($supp['total'], 2, '.', ',');
      if ($supp['payment_method'] == "cash") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-money-bill'></i> Treasury Cash</span>";
      } else if ($supp['payment_method'] == "bank") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-building-columns'></i> " . $supp['bank_number'] . " ( " . $supp['bank_name'] . " )</span>";
      } else {
        $payment = '<span class="pay_method"> <i class="fa-solid fa-circle-dollar-to-slot"></i> ' . ucwords($supp["payment_method"]) . '</span>';
      }
      $supplier = array(
        'no' => $i,
        'name' => $supp['name'],
        'type' => $supp['type'],
        'payment_method' => $payment,
        'created_time' => $supp['date'],
        'amount' => $amount,
        'quantity' => $supp['quantity'],
        'total_amount' => $total,
        'action' => '<button class="delete_order" btn-data="' . $supp['id'] . '"><i class="fa-solid fa-trash"></i></button>',
      );
      array_push($suppliers, $supplier);
      $i++;
    }
  }
}


echo json_encode($suppliers);
