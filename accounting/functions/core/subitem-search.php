<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

global $con;
if (isset($_POST["item_search"])) {
  if (!empty($_POST['item_search'])) {
    $item_search = $_POST['item_search'];
    $stmt = $con->prepare("SELECT DISTINCT `id`,`name`,`quantity`,`unit`,`item_id`,`img` FROM `av_items` WHERE `name` LIKE '%$item_search%' AND `supplier_id` NOT LIKE '%M%' GROUP BY `item_id` ");
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          $item_id = $item['item_id'];
          $stmt2 = $con->prepare("SELECT SUM(`quantity`) AS `total_quantity` FROM `av_items` WHERE `item_id` = '$item_id' ");
          $stmt2->execute();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $total_quantity = $row2['total_quantity'];

          echo '<li class="sug" data-id="' . $item['id'] . '" data-name="' . $item['name'] . '"><div class="img_cont_item"><img src="../assets/items/' . $item['img'] . '"></div><span>' . $item['name'] . '<span class="itemD">' . $item['item_id'] . '</span></span><span class="availablity_limit">' . $total_quantity . ' ' . $item["unit"] . ' Available</span></li>';
        }
      }
    } else {
      echo '<li class="nothing">No Results</li>';
    }
  } else {
    echo '<li class="nothing">No Results</li>';
  }
}
