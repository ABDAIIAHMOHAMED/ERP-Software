<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

global $con;
if (isset($_POST["item_search"]) && isset($_POST['warehouse'])) {
  if (!empty($_POST['item_search']) && $_POST['warehouse'] !== "choose") {
    $item_search = filter_var(trim($_POST['item_search']), FILTER_SANITIZE_STRING);
    $warehouse_id = $_POST['warehouse'];
    $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `name` LIKE '%$item_search%'  AND `warehouse_id` = '$warehouse_id' AND `quantity` > '0' OR `item_id` = '$item_search' AND `warehouse_id` = '$warehouse_id' AND `quantity` > '0' ");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $item) {
          if (substr($item['supplier_id'], 0, 1) == "M") {
            $supp_id = $item['supplier_id'];
            $stmt = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id'");
            $stmt->execute();
            $count = $stmt->rowCount();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['is_company'] == "1") {
              $name = $row['company_name'];
            } else {
              $name = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
            }
          } else {
            $supp_id = $item['supplier_id'];
            $stmt = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
            $stmt->execute();
            $count = $stmt->rowCount();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['is_company'] == "1") {
              $name = $row['company_name'];
            } else {
              $name = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
            }
          }



          echo '<li class="sug" data-id="' . $item['sku'] . '" style="display: grid;grid-template-columns: 270px 270px repeat(4,1fr);">
                  <div style="justify-content:flex-start;">
                    <div class="img_cont_item">
                      <img src="../assets/items/' . $item['img'] . '">
                    </div>
                    <span>' . $item['name'] . '<span class="itemD">' . $item['item_id'] . '</span></span>
                  </div>
                  <span>
                  <span class="itemD">Supplier/Manufacturer</span>
                  <div>' . $name . '</div>
                  </span>
                  <span>
                  <span class="itemD">Available Quantity</span>
                  <div>' . $item['quantity'] . '</div>
                  </span>
                  <span>
                  <span class="itemD">Unit</span>
                  <div>' . $item['unit'] . ' E£</div>
                  </span>
                  <span>
                  <span class="itemD">Cost</span>
                  <div>' . number_format($item['rate'], 2, '.', ',') . ' E£</div>
                  </span>
                  <span>
                  <span class="itemD">Sell Rate</span>
                  <div>' . number_format($item['sell_rate'], 2, '.', ',') . ' E£</div>
                  </span>
                </li>';
        }
      }
    } else {
      echo '<li class="nothing">No Results</li>';
    }
  } else {
    echo '<li class="nothing">No Results</li>';
  }
}
