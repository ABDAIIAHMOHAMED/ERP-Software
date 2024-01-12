<?php
require "../../functions/connect.php"; // Connect to database file


$purchases = array();
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $stmt2 = $con->prepare("SELECT * FROM `transfer_orders` WHERE `date` BETWEEN '$start_date' AND '$end_date' ");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $i = 1;
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row2 as $tra) {
        $transfer_id = $tra['id'];
        $transfer = "Transfer #" . $transfer_id;
        $resp_id = $tra['resp'];
        $stmt14 = $con->prepare("SELECT * FROM `transfers` WHERE `transfer_id` = '$transfer_id' LIMIT 1");
        $stmt14->execute();
        $count14 = $stmt14->rowCount();
        if ($count14 > 0) {
          $row14 = $stmt14->fetch(PDO::FETCH_ASSOC);
          $warehouse_from = $row14['transfer_from'];
          $warehouse_to = $row14['transfer_to'];
        }
        $stmt13 = $con->prepare("SELECT * FROM `users` WHERE `id` = '$resp_id' LIMIT 1");
        $stmt13->execute();
        $count13 = $stmt13->rowCount();
        if ($count13 > 0) {
          $row13 = $stmt13->fetch(PDO::FETCH_ASSOC);
          $resp = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/' . $row13['picture'] . '" alt=""></div>
          <div class="info">
            <div class="name" style="font-size: 13px;font-weight:400;">' . ucfirst($row13['name']) . '</div>
            <div class="profission" style="font-size: 10px;"></div>
          </div></div>';
        }

        $created_time = $tra['date'];


        $stmt15 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$warehouse_from' LIMIT 1");
        $stmt15->execute();
        $count15 = $stmt15->rowCount();
        if ($count15 > 0) {
          $row15 = $stmt15->fetch(PDO::FETCH_ASSOC);
          $warehouse_name = $row15['name'];
        }
        $warehouse_from_name = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $warehouse_from . '">' . $warehouse_name . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';


        $stmt16 = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$warehouse_to' LIMIT 1");
        $stmt16->execute();
        $count16 = $stmt16->rowCount();
        if ($count16 > 0) {
          $row16 = $stmt16->fetch(PDO::FETCH_ASSOC);
          $warehouse_name_to = $row16['name'];
        }
        $warehouse_to_name = '<a class="go_inv" href="../inventory/warehousedetails.php?uid=' . $warehouse_to . '">' . $warehouse_name_to . '  &nbsp;  <i class="fa-solid fa-arrow-up-right-from-square"></i></a>';



        $purchase = array(
          'no' => $i,
          'transfer' => $transfer,
          'resp' => $resp,
          'from' => $warehouse_from_name,
          'to' => $warehouse_to_name,
          'date' => $created_time,
          'action' => '<button class="view_purchase" btn-data="' . $tra['id'] . '"><i class="fa-solid fa-eye"></i></button>',
        );
        $i++;
        array_push($purchases, $purchase);
      }
    }
  }
}
echo json_encode($purchases);
