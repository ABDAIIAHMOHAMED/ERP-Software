<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['item_id']) && !empty($_POST['item_id'])) {

  $item_id = $_POST['item_id'];
  $items = array();
  $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $it) {
        if ($it['is_composite'] == 1) {
          $subitems = $it['sub_items'];
          $exp_subitems = explode("-", $subitems);
          $subquantity = $it['sub_quantity'];
          $exp_subquantity = explode("-", $subquantity);
          $i = 0;
          foreach ($exp_subitems as $subitem) {
            $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
            $stmt2->execute();
            $count2 = $stmt2->rowCount();


            if ($count2 > 0) {
              while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {



                $item_id = $row2[0]['item_id'];

                $stmt10 = $con->prepare("SELECT SUM(`quantity`) as total_quantity FROM `av_items` WHERE `item_id` = '$item_id'");
                $stmt10->execute();
                $row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
                $total_quantity = $row10['total_quantity'];



                $quantity =  $row2[0]["quantity"];
                $rate =  $row2[0]["rate"];
                $name =  $row2[0]["name"];
                $unit =  $row2[0]["unit"];
                $curr_quantity = $exp_subquantity[$i];
              }
            }
            $total = ($curr_quantity * $rate);
            $item = array(
              'id' => $subitem,
              'item_name' => $name,
              'item_unit' => $unit,
              'item_quantity' => $total_quantity,
              'item_curr_quantity' => $curr_quantity,
              'item_total' => $total,
              'rate' => $rate,
            );
            array_push($items, $item);
            $i++;
          }
        }
      }
    }
  } else {
  }
}

echo json_encode($items);
