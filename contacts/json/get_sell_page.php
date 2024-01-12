<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {

  $order_id = $_POST['order_id'];
  $stmt = $con->prepare("SELECT * FROM `sell_orders` WHERE `order_id` = '$order_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      $stmt2 = $con->prepare("SELECT * FROM `customers` WHERE `id` = '" . $row[0]['supplier_id'] . "'");
      $stmt2->execute();
      while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        if ($row2[0]['is_company'] == "1") {
          $supplier_name = $row2[0]['company_name'];
        } else {

          $supplier_name = $row2[0]['first_name'] . " " . $row2[0]['middle_name']  . " " . $row2[0]['last_name'];
        }
      }
      if ($row[0]['status'] == "paid") {
        $row[0]['status'] = '<span class="paid"><i class="fa-solid fa-check"></i> Paid</span>';
      } else if ($row[0]['status'] == "due") {
        $row[0]['status'] = '<span class="open"><i class="fa-solid fa-play"></i> Due</span>';
      } else {
        $row[0]['status'] = '<span class="closed"><i class="fa-solid fa-circle"></i> Overdue</span>';
      }
      if (empty($row[0]['hardcopy'])) {
        $row[0]['hardcopy'] = "<span class='no-hardcopy'>No hardcopy available</span>";
      } else {
        $row[0]['hardcopy'] = "<a class='hardcopy-go' href='../assets/order_purchases/" . $row[0]['hardcopy'] . "' target='_blank'>Show hardcopy</a>";
      }
      if (!empty($row[0]['withholding'])) {
        $withholding_perc = intval(($row[0]['withholding'] / ($row[0]['subtotal'] - $row[0]['discount'])) * 100);
        $row[0]['withholding_perc'] = $withholding_perc . ".00";
      } else {
        $row[0]['withholding_perc'] = "0.00";
      }
      $row[0]['supplier_name'] = $supplier_name;
      $row[0]['old_balance'] = $row[0]['balance_due'];
      $row[0]['balance_due'] = number_format($row[0]['balance_due'], 2, '.', ',');
      $row[0]['discount'] = number_format($row[0]['discount'], 2, '.', ',');
      $row[0]['withholding'] = number_format($row[0]['withholding'], 2, '.', ',');
      $row[0]['vat_amount'] = number_format($row[0]['vat_amount'], 2, '.', ',');
      $row[0]['vat_perc'] = number_format($row[0]['vat_perc'], 2, '.', ',');
      $row[0]['subtotal'] = number_format($row[0]['subtotal'], 2, '.', ',');
      $row[0]['order_total'] = number_format($row[0]['order_total'], 2, '.', ',');
      $result = $row[0];
    }
  } else {
  }
}

echo json_encode($result);
