<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `assets_category`");
$stmt->execute();
$count = $stmt->rowCount();
$total_balance = 0;
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      $name = "<a href='fasset.php?uid=" . $supp['id'] . "' target='_blank'>" . $supp['name'] . "</a>";
      if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $stmt2 = $con->prepare("SELECT SUM(`init_price`) as `total_cost` FROM `assets` WHERE `category_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt3 = $con->prepare("SELECT SUM(`cost`) as `total_exclusions` FROM `asset_transactions` WHERE `category_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt4 = $con->prepare("SELECT SUM(`amount`) as `total_dep` FROM `dep_transactions` WHERE `category_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
        $stmt5 = $con->prepare("SELECT SUM(`amount`) as `total_dep_ex` FROM `dep_ex_transactions` WHERE `category_id` = '$supp_id' AND `date` BETWEEN '$start_date' AND '$end_date'");
      }

      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_cost = number_format($row2['total_cost'], 2, '.', ',');


      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $total_exclusions = number_format($row3['total_exclusions'], 2, '.', ',');

      $total_total_cost = $row2['total_cost'] - $row3['total_exclusions'];
      $total_total_cost_format = number_format($total_total_cost, 2, '.', ',');

      $stmt4->execute();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $total_dep = number_format($row4['total_dep'], 2, '.', ',');

      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
      $total_dep_ex = number_format($row5['total_dep_ex'], 2, '.', ',');

      $total_total_dep = $row4['total_dep'] - $row5['total_dep_ex'];
      $total_total_dep_format = number_format($total_total_dep, 2, '.', ',');

      $total = $total_total_cost - $total_total_dep;
      $total_format = number_format($total, 2, '.', ',');
      $supplier = array(
        'no' => $i,
        'name' => $name,
        'total_cost' => $total_cost,
        'total_exclusions' => "(" .  $total_exclusions . ")",
        'total_total_cost' => $total_total_cost_format,
        'total_dep' => $total_dep,
        'total_dep_ex' => $total_dep_ex,
        'total_total_dep' => "(" .  $total_total_dep_format . ")",
        'total' => $total_format,
      );
      $i++;
      array_push($suppliers, $supplier);
    }
  }
}



echo json_encode($suppliers);
