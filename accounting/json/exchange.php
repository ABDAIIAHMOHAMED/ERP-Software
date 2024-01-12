<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `exchange_transactions`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $order = $supp['order_id'];
      $id = $supp['id'];
      if ($supp['payment_method'] == "cash") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-money-bill'></i> Treasury Cash</span>";
      } else if ($supp['payment_method'] == "bank") {
        $payment = "<span class='pay_method'> <i class='fa-solid fa-building-columns'></i> " . $supp['bank_number'] . " ( " . $supp['bank_name'] . " )</span>";
      } else {
        $payment = '<span class="pay_method"> <i class="fa-solid fa-circle-dollar-to-slot"></i> ' . ucwords($supp["payment_method"]) . '</span>';
      }
      $total_credit = number_format($supp['credit'], 2, '.', ',');
      $total_debit = number_format($supp['debit'], 2, '.', ',');
      $total_balance =  number_format($supp['balance'], 2, '.', ',');
      $supplier = array(
        'no' => $id,
        'name' => $order,
        'created_time' => $supp['date'],
        'order_id' => $payment,
        'debit' => $total_debit,
        'credit' => $total_credit,
        'balance' => $total_balance,
      );
      array_push($suppliers, $supplier);
    }
  }
}
// $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE `credit` = '0'");
// $stmt->execute();
// $count = $stmt->rowCount();
// $total_balance = 0;
// if ($count > 0) {
//   while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
//     foreach ($row as $supp) {
//       $order = "Order # " . $supp['order_id'];
//       $supp_id = $supp['supplier_id'];
//       $id = $supp['id'];
//       if (substr($supp_id, 0, 1) === 'M') {
//         $stmt5 = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id' LIMIT 1");
//         $stmt5->execute();
//         $count5 = $stmt5->rowCount();
//         if ($count5 > 0) {
//           $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
//           if ($row5['is_company'] == "1") {
//             $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/company3.png" alt=""></div>
//           <div class="info">
//             <div class="name">' . $row5['company_name'] . '</div>
//           </div></div>';
//           } else {
//             $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/profile3.png" alt=""></div>
//             <div class="info">
//               <div class="name">' . $row5['first_name'] . ' ' . $row5['middle_name'] . ' ' . $row5['last_name'] . '</div>
//               <div class="profission">' . $row5['company_name'] . '</div>
//             </div></div>';
//           }
//         }
//       } else {
//         $stmt5 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id' LIMIT 1");
//         $stmt5->execute();
//         $count5 = $stmt5->rowCount();
//         if ($count5 > 0) {
//           $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
//           if ($row5['is_company'] == "1") {
//             $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/company3.png" alt=""></div>
//           <div class="info">
//             <div class="name">' . $row5['company_name'] . '</div>
//           </div></div>';
//           } else {
//             $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/profile3.png" alt=""></div>
//             <div class="info">
//               <div class="name">' . $row5['first_name'] . ' ' . $row5['middle_name'] . ' ' . $row5['last_name'] . '</div>
//               <div class="profission">' . $row5['company_name'] . '</div>
//             </div></div>';
//           }
//         }
//       }
//       $stmt3 = $con->prepare("SELECT `debit` as `total_debit` FROM `exchange_transactions` WHERE `credit` = '0' AND `id` = '$id'");
//       $stmt3->execute();
//       $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
//       $total_debit = number_format($row3['total_debit'], 2, '.', ',');
//       $total_credit = number_format(0, 2, '.', ',');
//       $total_balance =  number_format($supp['balance'], 2, '.', ',');
//       $supplier = array(
//         'no' => $supp['id'],
//         'name' => $name,
//         'created_time' => $supp['date'],
//         'order_id' => $order,
//         'debit' => $total_debit,
//         'credit' => $total_credit,
//         'balance' => $total_balance,
//       );
//       array_push($suppliers, $supplier);
//     }
//   }
// }


echo json_encode($suppliers);
