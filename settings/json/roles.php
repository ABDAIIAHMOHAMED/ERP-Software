<?php
require "../../functions/connect.php"; // Connect to database file

$suppliers = array();

$stmt = $con->prepare("SELECT * FROM `user_roles`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
    foreach ($row as $supp) {
      $name = ucfirst($supp['name']);
      $supp_id = $supp['id'];
      if ($supp['def'] == '1') {
        $del_btn = '';
        $edit_btn = '';
      } else {

        $stmt4 = $con->prepare("SELECT * FROM `users` WHERE `role` = '$supp_id'");
        $stmt4->execute();
        $count4 = $stmt4->rowCount();
        if ($count4 > 0) {
          $del_btn = '';
        } else {
          $del_btn = '<a class="delete_order" href="edit_role.php?uid=' . $supp_id . '&del=1"><i class="fa-solid fa-trash"></i></a>';
        }

        $edit_btn = '<a href="edit_role.php?uid=' . $supp_id . '"><i class="fa-solid fa-pen-to-square"></i></a>';
        $supplier = array(
          'no' => $i,
          'name' => $name,
          'action' =>  $del_btn .  $edit_btn,
        );

        $i++;

        array_push($suppliers, $supplier);
      }
    }
  }
}


echo json_encode($suppliers);
