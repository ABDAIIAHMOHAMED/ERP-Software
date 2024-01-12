<?php
require "../../functions/connect.php"; // Connect to database file


$warehouses = array();
$stmt = $con->prepare("SELECT * FROM `warehouses`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {

      $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/warehouse3.png" alt=""></div>
            <div class="info">
              <div class="name">' . $supp['name'] . '</div>
              <div class="profission">WH-' . $supp['code'] . '</div>
            </div></div>';

      $phone = $supp['phone'];
      $supp_id = $supp['id'];
      if ($supp['status'] == 1) {
        $status = '<span class="paid">Active</span>';
        $check = '<input type="checkbox" class="delete-bx" name="delete[]" value="' . $supp_id . '">';
      } else {
        $status = '<span class="closed">Inactive</span>';
        $check = '';
      }

      $warehouse = array(
        'check' => $check,
        'no' => $i,
        'name' => $name,
        'city' => $supp['city'],
        'phone' => $phone,
        'status' => $status,
        'created_time' => $supp['created_time'],
        'action' => '<a href="warehousedetails.php?uid=' . $supp_id . '" target="_blank"><i class="fa-solid fa-eye"></i></a>',
      );

      $i++;

      array_push($warehouses, $warehouse);
    }
  }
} else {
}


echo json_encode($warehouses);
