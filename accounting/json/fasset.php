<?php
require "../../functions/connect.php"; // Connect to database file

$transacs = array();
if (isset($_GET['uid']) && !empty($_GET['uid'])) {

  $id = $_GET['uid'];
  if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $stmt2 = $con->prepare("SELECT * FROM `assets` WHERE `category_id` = '$id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    $i = 1;
    if ($count2 > 0) {
      while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row2 as $tra) {
          $cost = number_format($tra['amount'], 2, '.', ',');
          $init_price = number_format($tra['init_price'], 2, '.', ',');
          $total = number_format($tra['total'], 2, '.', ',');
          $item_id = $tra['id'];

          $stmt3 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_transactions` WHERE `category_id` = '$id' AND `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
          $stmt3->execute();
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $total_dep = number_format($row3['total_dep'], 2, '.', ',');

          $stmt7 = $con->prepare("SELECT * FROM `dep_transactions` WHERE `category_id` = '$id' AND `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
          $stmt7->execute();
          $count7 = $stmt7->rowCount();

          $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_ex` FROM `dep_ex_transactions` WHERE `category_id` = '$id' AND `item_id` = '$item_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
          $stmt4->execute();
          $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
          $total_ex = number_format($row4['total_ex'], 2, '.', ',');


          $stmt5 = $con->prepare("SELECT SUM(`cost`) as `total_sell` FROM `asset_transactions` WHERE `item_id` = '$item_id'");
          $stmt5->execute();
          $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
          $total_sell = number_format($row5['total_sell'], 2, '.', ',');
          $gross_cost = $tra['init_price'] - $row5['total_sell'];

          $total_total_dep = $row3['total_dep'] - $row4['total_ex'];
          $total_total_dep_format = number_format($total_total_dep, 2, '.', ',');


          $total_carry = $gross_cost - $total_total_dep;
          $total_carry_format = number_format($total_carry, 2, '.', ',');


          $action = '<button class="delete_order" btn-data="' . $tra["id"] . '"><i class="fa-solid fa-trash"></i></button><button class="view_purchase" btn-carry="' . $total_carry . '" btn-data="' . $tra["id"] . '"><i class="fa-solid fa-eye"></i></button><button class="sell_asset" btn-carry="' . $total_carry . '" btn-data="' . $tra["id"] . '"><i class="fa-solid fa-cart-shopping"></i></button>';

          $transac = array(
            'number' => $i,
            'name' => $tra['name'],
            'created_time' => $tra['date'],
            'quantity' => $tra['quantity'],
            'cost' => $cost,
            'total' => number_format($gross_cost, 2, '.', ','),
            'dep_perc' => $tra['dep_perc'] . " % (" . $count7 . ")",
            'total_dep' =>  $total_dep,
            'total_ex' => $total_ex,
            'total_total_dep' => "(" . $total_total_dep_format . ")",
            'total_carry' => $total_carry_format,
            'Action' => $action,
          );
          array_push($transacs, $transac);
          $i++;
        }
      }
    } else {
    }
  }
}

echo json_encode($transacs);
