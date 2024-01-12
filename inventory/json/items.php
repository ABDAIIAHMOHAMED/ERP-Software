<?php
require "../../functions/connect.php"; // Connect to database file


$inventorys = array();
$i = 1;
$stmt = $con->prepare("SELECT * FROM `items`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {

  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $id = $supp['code'];
      $name = '<div class="flex fx-start">
                <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $supp["img"] . '" alt=""></div>
                <div class="info">
                  <div class="name">' . $supp["name"] . '</div><div class="sku">#' . $supp['code'] . '</div>
                </div>
              </div>';


      $stmt10 = $con->prepare("SELECT SUM(`quantity`) as `total_quantity` FROM `av_items` WHERE `item_id` = '$id'");
      $stmt10->execute();
      $row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
      $quantity = number_format($row10['total_quantity'], 2, '.', ',');

      $unit = $supp['unit'];
      $amount = number_format($supp['amount'], 2, '.', ',');

      $stmt15 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$id'");
      $stmt15->execute();
      $count15 = $stmt15->rowCount();
      if ($count15 > 0) {
        $row15 = $stmt15->fetchAll(PDO::FETCH_ASSOC);
        $code = $row15[0]['sku'];
        $view_btn = '<a href="itemdetails.php?uid=' . $code . '" target="_blank"><i class="fa-solid fa-eye"></i></a>';
        $del_btn = '';
      } else {
        $view_btn = '';
        $del_btn = '<a class="delete_order" href="productreg.php?uid=' . $id . '&type=m&del=1"><i class="fa-solid fa-trash"></i></a>';
      }

      $inventory = array(
        'no' => $i,
        'name' => $name,
        'type' => 'material',
        'quantity' => $quantity,
        'unit' => $unit,
        'amount' => $amount,
        'action' => $del_btn . '<a href="productreg.php?uid=' . $supp['code'] . '&type=m" target="_blank"><i class="fa-solid fa-pen-to-square"></i></a>' . $view_btn,
      );

      $i++;

      array_push($inventorys, $inventory);
    }
  }
}

$stmt = $con->prepare("SELECT * FROM `final_items`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $id = $supp['code'];
      $name = '<div class="flex fx-start">
                <div class="img-frame" style="width: 90px;height: 90px;border-radius: 0;"><img src="../assets/items/' . $supp["img"] . '" alt=""></div>
                <div class="info">
                  <div class="name">' . $supp["name"] . '</div><div class="sku">#' . $supp['code'] . '</div>
                </div>
              </div>';


      $stmt10 = $con->prepare("SELECT SUM(`quantity`) as `total_quantity` FROM `av_items` WHERE `item_id` = '$id'");
      $stmt10->execute();
      $row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
      $quantity = number_format($row10['total_quantity'], 2, '.', ',');

      $unit = $supp['unit'];








      if ($supp['is_composite'] == '1') {

        $sub_items_array = explode("-", $supp['sub_items']);
        $sub_quantity_array = explode("-", $supp['sub_quantity']);
        $i = 0;
        $total = 0;
        for ($i = 0; $i < count($sub_items_array); $i++) {
          $curr_id = $sub_items_array[$i];
          $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$curr_id'");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $item_id = $row['item_id'];

          $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' ORDER BY `created_time` ASC LIMIT 1");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $odd_amount = $row['rate'];
          $odd_quantity = $sub_quantity_array[$i];
          $total += ($odd_quantity * $odd_amount);
        }
      } else {
        $total = $supp['amount'];
      }












      $stmt15 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$id'");
      $stmt15->execute();
      $count15 = $stmt15->rowCount();
      if ($count15 > 0) {
        $row15 = $stmt15->fetchAll(PDO::FETCH_ASSOC);
        $code = $row15[0]['sku'];
        $view_btn = '<a href="itemdetails.php?uid=' . $code . '" target="_blank"><i class="fa-solid fa-eye"></i></a>';
        $del_btn = '';
      } else {
        $view_btn = '';
        $del_btn = '<a class="delete_order" href="productreg.php?uid=' . $id . '&type=f&del=1"><i class="fa-solid fa-trash"></i></a>';
      }
      $inventory = array(
        'no' => $i,
        'name' => $name,
        'type' => 'Final Product',
        'quantity' => $quantity,
        'unit' => $unit,
        'amount' => number_format($total, 2, '.', ','),
        'action' => $del_btn . '<a href="productreg.php?uid=' . $supp['code'] . '&type=f" target="_blank"><i class="fa-solid fa-pen-to-square"></i></a>' . $view_btn,
      );
      $i++;
      array_push($inventorys, $inventory);
    }
  }
}

echo json_encode($inventorys);
