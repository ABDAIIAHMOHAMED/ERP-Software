<?php
require "../../functions/connect.php"; // Connect to database file
$urid = $_COOKIE['urid'];
$urid_array = explode("-", $urid);
$id = $urid_array[0];
$stmt = $con->prepare("SELECT * FROM users WHERE id = '$id' ");
$stmt->execute();
$count = $stmt->rowCount();
$user_info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session

$suppliers = array();
$stmt = $con->prepare("SELECT * FROM `users`");
$stmt->execute();
$count = $stmt->rowCount();
if ($count > 0) {
  $i = 1;
  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries

    foreach ($row as $supp) {
      $supp_id = $supp['id'];
      $cat_id = $supp['category'];
      $job_title_id = $supp['job_title'];
      $job_type_id = $supp['job_type'];
      $career_level_id = $supp['career_level'];
      $role_id = $supp['role'];
      $type = $supp['type'];
      // Category
      $stmt = $con->prepare("SELECT * FROM `categories` WHERE `id` = '$cat_id' LIMIT 1");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $stmt->rowCount();
      if ($count > 0) {
        $category = $row['name'];
      } else {
        $category = '';
      }



      // Job Title
      $stmt = $con->prepare("SELECT * FROM `job_titles` WHERE `id` = '$job_title_id' LIMIT 1");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($count > 0) {
        $job_title = $row['name'];
      } else {
        $job_title = '';
      }

      // Job Type
      $stmt2 = $con->prepare("SELECT * FROM `job_types` WHERE `id` = '$job_type_id' LIMIT 1");
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if ($count > 0) {
        $job_type = $row2['name'];
      } else {
        $job_type = '';
      }

      // Career Level
      $stmt = $con->prepare("SELECT * FROM `career_levels` WHERE `id` = '$career_level_id' LIMIT 1");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($count > 0) {
        $career_level = $row['name'];
      } else {
        $career_level = '';
      }

      // Role Name
      if ($type == "employee") {
        $role = '';
      } else {
        $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `id` = '$role_id' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($count > 0) {
          $role = $row['name'];
        } else {
          $role = '';
        }
      }
      $type = ucfirst($supp['type']);


      $name = '<div class="flex fx-start"><div class="img-frame"><img src="../images/ur-img/' . $supp['picture'] . '" alt=""></div>
      <div class="info">
        <div class="name">' . $supp['name'] . '</div>
        <div class="profission">' . $role . '</div>
      </div></div>';
      if ($supp['status'] == 1) {
        $status = '<span class="paid">Active</span>';
        if ($supp['id'] == $user_info['id']) {
          $check = '';
        } else {
          $check = '<input type="checkbox" class="delete-bx" name="delete[]" value="' . $supp_id . '">';
        }
      } else {
        $status = '<span class="closed">Inactive</span>';
        $check = '';
      }

      $supplier = array(
        'check' => $check,
        'no' => $i,
        'name' => $name,
        'type' => $type,
        'category' => $category,
        'job_title' => $job_title,
        'job_type' => $job_type,
        'career_level' => $career_level,
        'status' => $status,
        'action' => '<a href="employeedetails.php?uid=' . $supp_id . '"><i class="fa-solid fa-eye"></i></a>',
      );

      $i++;

      array_push($suppliers, $supplier);
    }
  }
} else {
}


echo json_encode($suppliers);
