<?php
require "../../functions/connect.php"; // Connect to database file


$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `suppliers`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries

    foreach ($row as $supp) {
      if ($supp['is_company'] == "1") {
        $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/company3.png" alt=""></div>
          <div class="info">
            <div class="name">' . $supp['company_name'] . '</div>
          </div></div>';
        $type = "company";
      } else {
        $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/profile3.png" alt=""></div>
            <div class="info">
              <div class="name">' . $supp['first_name'] . ' ' . $supp['middle_name'] . ' ' . $supp['last_name'] . '</div>
              <div class="profission">' . $supp['company_name'] . '</div>
            </div></div>';
        $type = "individual";
      }
      if (!empty($supp['mobile'])) {
        $phone = $supp['mobile'];
      } else {
        $phone = $supp['phone'];
      }



      $supp_id = $supp['id'];
      $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `supplier_orders` WHERE `supplier_id` = '$supp_id'");
      $stmt->execute();
      $count = $stmt->rowCount();
      $total_due = 0;
      if ($count > 0) {
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row as $due) {

            $total_due += $due['balance_due'];
          }
          $due_total = number_format($total_due, 2, '.', ',');
        }
      } else {
        $due_total = "0.00";
      }


      if ($supp['status'] == 1) {
        $status = '<span class="paid">Active</span>';
        $check = '<input type="checkbox" class="delete-bx" name="delete[]" value="' . $supp_id . '">';
      } else {
        $status = '<span class="closed">Inactive</span>';
        $check = '';
      }

      $supplier = array(
        'check' => $check,
        'no' => $i,
        'name' => $name,
        'type' => $type,
        'city' => $supp['city'],
        'phone' => $phone,
        'email' => $supp['email'],
        'due_balance' => $due_total,
        'status' => $status,
        'created_time' => $supp['created_time'],
        'action' => '<a href="supplierdetails.php?uid=' . $supp_id . '"><i class="fa-solid fa-eye"></i></a>',
      );

      $i++;

      array_push($suppliers, $supplier);
    }
  }
} else {
}


echo json_encode($suppliers);
