<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['start_date']) && !empty($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['end_date'])) {

  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $nextEndMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($end_date)) . ' +1 month'));
  $nextStartMonth = date('Y-m-d', strtotime(date('Y-m-01', strtotime($start_date)) . ' +1 month'));
  $total_trans = 0;
  $result = array(
    "def" => 0,
    "due" => 0,
    "with" => 0,
  );
  $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `supplier_orders` WHERE `vat_amount` != '0' AND `created_time` < '$start_date'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp) {
        $amount = round($supp['vat_amount'], 2);
        $withholding = round($supp['withholding'], 2);
        $result['def'] -= $amount;
        $result['def'] += $withholding;
      }
    }
  }

  $stmt3 = $con->prepare("SELECT DISTINCT `order_id`,`created_time`,`withholding` FROM `supplier_orders` WHERE `withholding` != '0' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp) {
        $withholding = round($supp['withholding'], 2);
        $result['with'] += $withholding;
      }
    }
  }









  $stmt3 = $con->prepare("SELECT * FROM `assets` WHERE `vat_amount` != '0' AND `date` < '$start_date'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp) {
        $amount = round($supp['vat_amount'], 2);
        $withholding = round($supp['witholding'], 2);
        $result['def'] -= $amount;
        $result['def'] += $withholding;
      }
    }
  }

  $stmt3 = $con->prepare("SELECT * FROM `assets` WHERE `witholding` != '0' AND `date` BETWEEN '$start_date' AND '$end_date'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp) {
        $withholding = round($supp['witholding'], 2);
        $result['with'] += $withholding;
      }
    }
  }














  $stmt4 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `manufacturer_orders` WHERE `vat_amount` != '0' AND `created_time` < '$start_date'");
  $stmt4->execute();
  $count4 = $stmt4->rowCount();
  if ($count4 > 0) {
    while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row4 as $supp) {
        $amount = round($supp['vat_amount'], 2);
        $withholding = round($supp['withholding'], 2);
        $result['def'] -= $amount;
        $result['def'] += $withholding;
      }
    }
  }
  $stmt4 = $con->prepare("SELECT DISTINCT `order_id`,`created_time`,`withholding` FROM `manufacturer_orders` WHERE `withholding` != '0' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
  $stmt4->execute();
  $count4 = $stmt4->rowCount();
  if ($count4 > 0) {
    while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row4 as $supp) {
        $withholding = round($supp['withholding'], 2);
        $result['with'] += $withholding;
      }
    }
  }




  $stmt6 = $con->prepare("SELECT DISTINCT `order_id`,`vat_amount`,`created_time`,`withholding` FROM `sell_orders` WHERE `vat_amount` != '0' AND `created_time` < '$start_date'");
  $stmt6->execute();
  $count6 = $stmt6->rowCount();
  if ($count6 > 0) {
    while ($row6 = $stmt6->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row6 as $supp) {
        $withholding = round($supp['withholding'], 2);
        $amount = round($supp['vat_amount'], 2);
        $result['def'] -= $withholding;
        $result['def'] += $amount;
      }
    }
  }
  // $stmt6 = $con->prepare("SELECT DISTINCT `order_id`,`created_time`,`withholding` FROM `sell_orders` WHERE `withholding` != '0' AND `created_time` BETWEEN '$start_date' AND '$end_date'");
  // $stmt6->execute();
  // $count6 = $stmt6->rowCount();
  // if ($count6 > 0) {
  //   while ($row6 = $stmt6->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
  //     foreach ($row6 as $supp) {
  //       $withholding = round($supp['withholding'], 2);
  //       $result['with'] -= $withholding;
  //     }
  //   }
  // }



  $stmt6 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `vat_amount` != '0' AND `date` < '$start_date'");
  $stmt6->execute();
  $count6 = $stmt6->rowCount();
  if ($count6 > 0) {
    while ($row6 = $stmt6->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row6 as $supp) {
        $withholding = round($supp['withholding'], 2);
        $amount = round($supp['vat_amount'], 2);
        $result['def'] -= $withholding;
        $result['def'] += $amount;
      }
    }
  }
  // $stmt6 = $con->prepare("SELECT * FROM `asset_transactions` WHERE `withholding` != '0' AND `date` BETWEEN '$start_date' AND '$end_date'");
  // $stmt6->execute();
  // $count6 = $stmt6->rowCount();
  // if ($count6 > 0) {
  //   while ($row6 = $stmt6->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
  //     foreach ($row6 as $supp) {
  //       $withholding = round($supp['withholding'], 2);
  //       $result['with'] -= $withholding;
  //     }
  //   }
  // }







  $stmt5 = $con->prepare("SELECT * FROM `vat_transactions` WHERE `date` <= '$nextStartMonth'");
  $stmt5->execute();
  $count5 = $stmt5->rowCount();
  if ($count5 > 0) {
    while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row5 as $supp) {
        $amount = round($supp['debit'], 2);
        $total_trans += $amount;
      }
    }
  }
}
$result['due'] = $result['def'] - $total_trans;
echo json_encode($result);
