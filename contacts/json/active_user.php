<?php
require "../../functions/connect.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$current_date = date('Y-m-d H:i:s');
$previous_date = date('Y-m-d H:i:s', strtotime('-20 seconds'));
$users = array();
$stmt = $con->prepare("SELECT * FROM `users` WHERE `online` BETWEEN '$previous_date' AND '$current_date'");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $it) {
      $name = ucfirst($it['fname']) . " " . ucfirst($it['mname']) . " " . ucfirst($it['lname']);
      $role_id = $it['role'];
      $stmt2 = $con->prepare("SELECT * FROM `user_roles` WHERE `id` = '$role_id'");
      $stmt2->execute();
      $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      $role_name = $row2[0]['name'];
      $img = $it['picture'];
      $user = array(
        'count' => $count,
        'img' => $img,
        'id' => $it['id'],
        'name' => $name,
        'role' => $role_name,
      );
      array_push($users, $user);
    }
  }
} else {
}


echo json_encode($users);
