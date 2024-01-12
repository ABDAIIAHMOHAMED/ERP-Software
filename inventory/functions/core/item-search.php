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
    $stmt = $con->prepare("SELECT * FROM `items` WHERE `name` LIKE '%$item_search%'  ");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        echo '<li class="sug new_item_btn"><i class="fa-solid fa-plus"></i> Add New</li>';
        foreach ($row as $item) {
          echo '<li class="sug" data-id="' . $item['id'] . '" data-name="' . $item['name'] . '">' . $item['name'] . '</li>';
        }
      }
    } else {
      echo '<li class="sug new_item_btn"><i class="fa-solid fa-plus"></i> Add New</li>';
    }
  } else {
    echo '<li class="sug new_item_btn"><i class="fa-solid fa-plus"></i> Add New</li>';
  }
}
echo '
  <script>
  $(".suggestion").on("click", ".new_item_btn" ,function(){
    var exportHeight = $(".add_new_item").prop("scrollHeight") + 70;
    $(".add_new_item").css({
          height: exportHeight + "px",
          padding: "20px 25px",
          border: "1px solid #cfcfcf",
        });
        $(".black_screen").fadeIn(200);
          let randomNumber = Math.floor(Math.random() * 1000000000000);
          var barcodeNumber = String(randomNumber).padStart(12, "0");
        document.getElementById("code_input").value = barcodeNumber;
        $("#new_item input#code_input").prop("disabled", true);
      });
      $("button.close").click(function () {
        $(".black_screen").fadeOut(200);
        $(".add_new_item").css({
          height: "0px",
          padding: "0px",
          border: "0px solid #cfcfcf",
      });
  });  
  </script>';
