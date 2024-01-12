<?php
require "../../functions/connect.php"; // Connect to database file

if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
  date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
  $date = date("Y-m-d h:i A"); // Get timestamp for the date
  $id = $_POST['user_id'];
  $stmt = $con->prepare("UPDATE `users` SET  `online` = '$date' WHERE `id` = '$id'");
  $stmt->execute();
}
