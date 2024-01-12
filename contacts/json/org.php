<?php
require "../../functions/connect.php"; // Connect to database file

$suppliers = array();
if (isset($_GET['type']) && !empty($_GET['type']) &&  isset($_GET['once']) && !empty($_GET['once'])) {
  $s = $_GET['type'];
  $m = $_GET['once'];
  $stmt = $con->prepare("SELECT * FROM `$s`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $i = 1;
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $name = ucfirst($supp['name']);
        $supp_id = $supp['id'];

        $stmt2 = $con->prepare("SELECT * FROM `users` WHERE `$m` = '$supp_id'");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $count2 = $stmt2->rowCount();


        if ($supp['status'] == 1) {
          $status = '<span class="paid">Active</span>';
          $check = '<input type="checkbox" class="delete-bx" name="delete[]" value="' . $supp_id . '">';
        } else {
          $status = '<span class="closed">Inactive</span>';
          $check = '';
        }
        if ($supp['def'] == '1') {
          $del_btn = '';
        } else {
          $del_btn = '<a class="delete_order" href="' . $m . '.php?uid=' . $supp_id . '&del=1"><i class="fa-solid fa-trash"></i></a>';
        }

        $supplier = array(
          'check' => $check,
          'no' => $i,
          'name' => $name,
          'count' => $count2,
          'status' => $status,
          'action' =>  $del_btn .  '<a href="' . $m . '_list.php?uid=' . $supp_id . '"><i class="fa-solid fa-users"></i></a><a href="' . $m . '_edit.php?uid=' . $supp_id . '"><i class="fa-solid fa-pen-to-square"></i></a><a href="' . $m . '.php?uid=' . $supp_id . '"><i class="fa-solid fa-eye"></i></a>',
        );

        $i++;

        array_push($suppliers, $supplier);
      }
    }
  }
}

echo json_encode($suppliers);
