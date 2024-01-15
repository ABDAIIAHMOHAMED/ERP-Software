<?php

require "connect.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year
$stmt999 = $con->prepare("DELETE FROM `av_items` WHERE `quantity` = '0' AND `supplier_id` LIKE 'M%'");
$stmt999->execute();





function check_employe() // Check id from em or session is exits in db and get the name and picture of the employee above the table
{
  global $con; // Make connection to database is global to function
  global $image_route;
  if (isset($_GET['em']) & !empty($_GET['em'])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check if the id from GET exist in database
    if ($count > 0) { // If GET is exist
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $employe) {
          echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
            <input type="text" class="prof-name" value="' . $employe["name"] . '">';
        }
      }
    } else { // If GET isn't exist
      // $_GET['em'] = $_SESSION['id']; // GET will change to SESSION
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $_GET['em'] = $urid_array[0];
      $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
      $stmt->execute();
      $count = $stmt->rowCount(); // Check if the id from SESSION exist in database
      if ($count > 0) {
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row as $employe) {
            echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
              <input type="text" class="prof-name" value="' . $employe["name"] . '">';
          }
        }
      } else { // If SESSION isn't exist so header to index.php
        header("location:index.php");
        exit();
      }
    }
  } else { // If there is no GET name 'em'
    // $_GET['em'] = $_SESSION['id']; // Get will change to SESSION
    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $_GET['em'] = $urid_array[0];
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check if the id from SESSION exist in database
    if ($count > 0) { // Loop for queries
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row as $employe) {
          echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
              <input type="text" class="prof-name" value="' . $employe["name"] . '">';
        }
      }
    } else { // If SESSION isn't exist so header to index.php
      header("location:../index.php");
      exit();
    }
  }
}

function check_employe_2() // Check id from em or session is exits in db and get the name and picture of the employee above the table
{
  global $con; // Make connection to database is global to function
  global $image_route;
  if (isset($_GET['em']) & !empty($_GET['em'])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check if the id from GET exist in database
    if ($count > 0) { // If GET is exist
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
        foreach ($row as $employe) {
          echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
            <div class="naming">' . $employe["name"] . '</div>';
        }
      }
    } else { // If GET isn't exist
      // $_GET['em'] = $_SESSION['id']; // GET will change to SESSION
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $_GET['em'] = $urid_array[0];
      $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
      $stmt->execute();
      $count = $stmt->rowCount(); // Check if the id from SESSION exist in database
      if ($count > 0) {
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row as $employe) {
            echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
            <div class="naming">' . $employe["name"] . '</div>';
          }
        }
      } else { // If SESSION isn't exist so header to index.php
        header("location:index.php");
        exit();
      }
    }
  } else { // If there is no GET name 'em'
    // $_GET['em'] = $_SESSION['id']; // Get will change to SESSION
    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $_GET['em'] = $urid_array[0];
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check if the id from SESSION exist in database
    if ($count > 0) { // Loop for queries
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row as $employe) {
          echo '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
            <div class="naming">' . $employe["name"] . '</div>';
        }
      }
    } else { // If SESSION isn't exist so header to index.php
      header("location:../index.php");
      exit();
    }
  }
}

function get_employe_id() // Get input hidden for id to filter date
{
  global $con; // Make connection to database is global to function
  if (isset($_GET['em']) & !empty($_GET['em'])) { // Check if there is GET and is not empty
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check if the id from GET exist in database
    if ($count > 0) { // If the id is exist print input with id hidden
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row as $employe) {
          echo '<input type="hidden" name="em" value="' . $employe["id"] . '">';
        }
      }
    } else { // If the id is not exist header to index
      header("Location:index.php");
      exit();
    }
  } else { // If there is no GET or empty GET header to index
    header("Location:index.php");
    exit();
  }
}

function push_attendance() // Create attendance function
{
  global $con;
  date_default_timezone_set("Africa/Cairo"); // Set timezone to Egypt Cairo
  if (isset($_POST['attend']) & !empty($_POST['attend']) & isset($_POST['em']) & !empty($_POST['em'])) { // Check if there is POST AND POST em with id
    if (is_numeric($_POST['em'])) { // Check if id is number
      $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_POST['em'] . "");
      $stmt->execute();
      $count = $stmt->rowCount(); // Check if id is exist in database
      if ($count > 0) {
        $stmt2 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND leave_out = '0000-00-00 00:00:00'");
        $stmt2->execute();
        $count2 = $stmt2->rowCount(); // Check if there is attendance without leave for the same id
        if ($count2 > 0) { // If there is an attendance without leave for the same id echo error message
          $error_log = "<div class='error-mg'><span>This employee hasn't left yet</span></div>";
          echo $error_log;
        } else { // If there is no attendance before without leave for the same id
          $nowdate = date("Y-m-d H:i:s");
          $id = $_POST['em']; // variable for POST em to id
          if (isset($_POST['enter_date']) && !empty($_POST['enter_date']) && isset($_POST['not_current']) && $_POST['not_current'] == "checked") {
            if (strtotime($_POST['enter_date']) == false) {
              $date = date("Y-m-d H:i");
            } else {
              $time = $_POST['enter_date'];
              $date = str_replace("T", " ", $time);
            }
          } else {
            $date = date("Y-m-d H:i"); // Get all now date 0000-00-00 00:00
          }
          $stmt3 = $con->prepare("INSERT INTO `attendance`(`id`, `enter_in`,`leave_out`,`duration`,`count`,`comment`) VALUES ('$id','$date','0000-00-00 00:00:00','0','0','')");
          $stmt3->execute(); // Insert attendance for id = POST em
          $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
          $stmt5->execute();
          $row4 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of the employee who make for him attendance
          $name = $row4['name']; // Variable name
          // $sessionid = $_SESSION['id']; // Variable id
          $urid = $_COOKIE['urid'];
          $urid_array = explode("-", $urid);
          $sessionid = $urid_array[0];
          $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Create new attend for $name','attendance','$nowdate')");
          $stmt4->execute(); // Insert to Logs
          header("location:attendance.php?em=$id"); // Header to attendance.php
          exit();
        }
      }
    }
  }
}
push_attendance(); // Run Create attendance function

function change_att()
{
  global $con;
  if (isset($_POST['change'])) {
    if (!empty($_POST['change']) & !empty($_POST['start']) & !empty($_POST['end']) & !empty($_POST['att_id']) & !empty($_POST['em'])) {
      $start = date_format(date_create($_POST['start']), "Y-m-d H:i:s");
      $att_id = $_POST['att_id'];
      $end = date_format(date_create($_POST['end']), "Y-m-d H:i:s");
      $id = $_POST['em'];
      $dur_ent = strtotime($start);
      $dur_leave = strtotime($end);
      $over = 90;
      $dur = @round(abs($dur_leave - $dur_ent) / 60, 2); // now date [leave] - attendance date to get duration in min






      $mandy = date("Y-m") . "-01"; // Variable 0000-00-01 to mandy
      $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE id = " . $_POST['em'] . " AND `date` = '$mandy'");
      $stmt4->execute();
      $count4 = $stmt4->rowCount();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month
      $stmt6 = $con->prepare("SELECT `value` FROM settings WHERE item = 'working_hours'");
      $stmt6->execute();
      $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Check working hours from settings
      $working_hours = $row6['value']; // Variable working hours

      // Change dur variable in order to if dur > num so dur = and if dur < so dur = //


      $stmt5 = $con->prepare("SELECT * FROM users WHERE id = " . $_POST['em'] . "");
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Check
      $salary = $row5['net_salary']; // Variable salary
      $name = $row5['name']; // Variable Name



      if ($count4 > 0) { // If there is employee_salary for this employee this month in line 121
        $old_dur = $row4['duration']; // Get old duration
        $old_actual = $row4['actual']; // Get old duration


        if ($dur > ($working_hours * 60)) {
          if ($dur == (($working_hours * 60) + $over)) {
            $j = 1.35;
            $dur = ($working_hours * 60);
            $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
            $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
            $actual = ($old_actual + (($salary / (30 * $working_hours) * $j) * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
          } elseif ($dur > (($working_hours * 60) + $over)) {
            $j = 1.7;
            $dur = ($working_hours * 60);
            $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
            $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
            $actual = ($old_actual + (($salary / (30 * $working_hours) * $j) * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
          } else {
            $dur = ($working_hours * 60);
            $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
            $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
            $actual = $old_actual + ($salary / (30 * $working_hours) * ($dur / 60)); // Get actual salary from salary / 30 days multipli to number of actual days
          }
        } elseif ($dur < ($working_hours * 60)) {
          if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 15) {
            $stmt23 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND late != '0' AND `enter_in` LIKE '" . date("Y-m") . "%'");
            $stmt23->execute();
            $count23 = $stmt23->rowCount(); // Check if there is many enters in the same day





            if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 90) {
              $dur_add = $dur; // Variable duration without old duration addition
              $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
              $actual = ($old_actual - (($salary / 30) * 4 / $working_hours) + ($salary / (30 * $working_hours) * ($dur / 60)));
            } else {
              if ($count23 == 0) {
                $dur = ($working_hours * 60);
                $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                $actual = ($old_actual - (($salary / 30) / $working_hours) + ($salary / (30 * $working_hours) * ($dur / 60)));
              } elseif ($count23 == 1) {
                $dur = ($working_hours * 60);
                $dur_add = $dur; // Variable duration without old duration addition
                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                $actual = ($old_actual - (($salary / 30) * 2 / $working_hours) + ($salary / (30 * $working_hours) * ($dur / 60)));
              } elseif ($count23 > 1) {
                $dur = ($working_hours * 60);
                $dur_add = $dur; // Variable duration without old duration addition
                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                $actual = ($old_actual - (($salary / 30) * 4 / $working_hours) + ($salary / (30 * $working_hours) * ($dur / 60)));
              }
            }
          } else {
            $dur = ($working_hours * 60);
            $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
            $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
            $actual = $old_actual + ($salary / (30 * $working_hours) * ($dur / 60)); // Get actual salary from salary / 30 days multipli to number of actual days
          }
        } else {
          $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
          $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
          $actual = $old_actual + ($salary / (30 * $working_hours) * ($dur / 60)); // Get actual salary from salary / 30 days multipli to number of actual days
        }
      }


      $stmt63 = $con->prepare("SELECT * FROM attendance WHERE att_id = " . $_POST['att_id'] . "");
      $stmt63->execute();
      $count63 = $stmt63->rowCount();
      $row63 = $stmt63->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month
      $oldy_enter = $row63['enter_in'];
      $oldy_leave = $row63['leave_out'];
      $oldy_duration = $row63['duration'];
      $oldy_overtime = $row63['overtime'];
      if ($oldy_overtime == $over) {
        $s = 1.35;
      } elseif ($oldy_overtime > $over) {
        $s = 1.7;
      } else {
        $s = 0;
      }
      $oldy_late = $row63['late'];

      $final_actual = $actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) + ($salary / (30 * $working_hours) * ($oldy_late / 60));






      $stmt7 = $con->prepare("UPDATE `employee_salary` SET  `actual` = '$final_actual'  , `duration` = '$dur', `days` = '$days' WHERE `date` LIKE '" . substr($oldy_enter, 0, 7) . "%' AND `id` = '" . $_POST['em'] . "'   ");
      $stmt7->execute(); // Update salary in salary_employee





      if ((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) >= $over) {
        $overtime = (@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60));
      } else {
        $overtime = 0;
      }

      if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 15) {
        $stmt23 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND late != '0'");
        $stmt23->execute();
        $count23 = $stmt23->rowCount(); // Check if there is many enters in the same day


        if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 90) {
          $lating = 240;
        } else {
          if ($count23 == 0) {
            $lating = 60;
          } elseif ($count23 == 1) {
            $lating = 120;
          } elseif ($count23 > 1) {
            $lating = 240;
          }
        }
      } else {
        $lating = 0;
      }

      $stmt5 = $con->prepare("UPDATE `attendance` SET  `enter_in` = '$start'  , `leave_out` = '$end', `duration` = '$dur', `overtime` = '$overtime' , `late` = '$lating' WHERE `att_id` = '$att_id'");
      $stmt5->execute(); // Update salary in salary_employee
      $stmt6 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
      $stmt6->execute();
      $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Get name of id leave
      $name = $row6['name']; // Variable name of id leave
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change attendance time for $name','attendance','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      header("location:attendance.php?em=$id");
    } else {
      echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
    }
  } elseif (isset($_POST['delete'])) {
    if (!empty($_POST['delete']) & !empty($_POST['att_id']) & !empty($_POST['em'])) {
      $att_id = $_POST['att_id'];
      $id = $_POST['em'];


      $over = 90;
      $stmt6 = $con->prepare("SELECT `value` FROM settings WHERE item = 'working_hours'");
      $stmt6->execute();
      $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Check working hours from settings
      $working_hours = $row6['value']; // Variable working hours
      $stmt5 = $con->prepare("SELECT * FROM users WHERE id = " . $_POST['em'] . "");
      $stmt5->execute();
      $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Check
      $salary = $row5['net_salary']; // Variable salary



      $stmt63 = $con->prepare("SELECT * FROM attendance WHERE att_id = " . $_POST['att_id'] . "");
      $stmt63->execute();
      $count63 = $stmt63->rowCount();
      $row63 = $stmt63->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month
      $oldy_enter = $row63['enter_in'];
      $oldy_leave = $row63['leave_out'];
      $oldy_duration = $row63['duration'];
      $oldy_overtime = $row63['overtime'];
      if ($oldy_overtime == $over) {
        $s = 1.35;
      } elseif ($oldy_overtime > $over) {
        $s = 1.7;
      } else {
        $s = 0;
      }
      $oldy_late = $row63['late'];

      $mandy = date("Y-m") . "-01"; // Variable 0000-00-01 to mandy
      $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE id = " . $_POST['em'] . " AND `date` = '$mandy'");
      $stmt4->execute();
      $count4 = $stmt4->rowCount();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month

      $old_actual = $row4['actual']; // Get old duration


      $final_actual = $old_actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) + ($salary / (30 * $working_hours) * ($oldy_late / 60));

      $stmt7 = $con->prepare("UPDATE `employee_salary` SET  `actual` = '$final_actual'  WHERE `date` LIKE '" . substr($oldy_enter, 0, 7) . "%' AND `id` = '" . $_POST['em'] . "'   ");
      $stmt7->execute(); // Update salary in salary_employee





      $stmt4 = $con->prepare("DELETE FROM `attendance` WHERE att_id = '$att_id'");
      $stmt4->execute();
      $stmt6 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
      $stmt6->execute();
      $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Get name of id leave
      $name = $row6['name']; // Variable name of id leave
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete attendance time for $name','attendance','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      header("location:attendance.php?em=$id");
    } else {
      echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
    }
  }
}


function check_attend() // Check attendance function to show leave btn or not
{
  global $con;
  if (isset($_GET['em']) & !empty($_GET['em']) & is_numeric($_GET['em'])) { // Check first if there is GET em with id
    $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check id from database in employee
    if ($count > 0) { // if id is exist
      $stmt2 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_GET['em'] . " AND leave_out = '0000-00-00 00:00:00'");
      $stmt2->execute();
      $count2 = $stmt2->rowCount(); // Check if there is attendance without leave with the same id
      if ($count2 > 0) { // if there is attendance without leave
        return 1;
      } else { // if there is no attendance without leave
        return 0;
      }
    }
  }
}

function login_check() // Check login email and password
{
  global $con; // Global connection with database
  if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) { // Check if there is POST email and password and login
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['login'])) { // Check if they are not empty
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Filter email
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); // Filter password
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // if email is valid email
        $stmt = $con->prepare("SELECT * FROM users WHERE email = '$email' AND `type` = 'user' ");
        $stmt->execute();
        $count = $stmt->rowCount(); // Get data where email = POST email
        if ($count > 0) { // If there is email exist
          $row = $stmt->fetch(PDO::FETCH_ASSOC); // Get queries
          $ck_password = $row['password']; // Variable password
          if (password_verify($password, $ck_password)) { // If password exist
            // $_SESSION['id'] = $row['id']; // Create SESSION id [logged in]
            $status = $row['status'];
            $email_type = $row['type'];
            if ($email_type == "user") {
              if ($status == 1) {
                $urid = $row['id'] . "-" . md5($email) . "-" . $ck_password;
                setcookie("urid", $urid, time() + (360400 * 30), "/");
                header("Location:index.php");
              } else {
                echo "This account is not active";
              }
            } else {
              echo "This account is for employee only";
            }
          } else { // If password is wrong
            echo "Password is not correct";
          }
        } else { // If there is no email exist
          echo "Email is not correct";
        }
      } else { // if email is not valid email
        echo "Email is not valid";
      }
    } else { // If there is field empty
      echo "All fields are required";
    }
  } elseif (isset($_GET['sc']) && $_GET['sc'] == 1) { // Changing password GET validation
    echo "<span class='success'>Password was changed you can log in now with new password</span>";
  } elseif (isset($_GET['su']) && $_GET['su'] == 1) {
    echo "<span class='success'>Account was created successfully</span>";
  }
}

function login_info() // GET array user info
{
  global $con; // Global connection with database
  // $id = $_SESSION['id']; // id = SESSION
  $urid = $_COOKIE['urid'];
  $urid_array = explode("-", $urid);
  $id = $urid_array[0];
  $stmt = $con->prepare("SELECT * FROM users WHERE id = '$id' ");
  $stmt->execute();
  $user_info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  return $user_info;
}

function email_check() // Email check to send mail to reset password
{
  global $con; // Global connection with database
  if (isset($_POST['forgot']) && isset($_POST['email'])) { // Check there is email POST and forgot POST
    if (!empty($_POST['forgot']) && !empty($_POST['email'])) { // Check email is not empty
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Filteration Email
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // If email is valid
        $stmt = $con->prepare("SELECT * FROM users WHERE email = '$email' ");
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Get queries where email = POST email
        $headers = 'From:abdallah@iiwi-eg.com'; // Mail Header
        if ($count > 0) { // If there is email exist
          $token = $row['validation']; // Validation Code
          mail($email, 'Reset Password', "Go to link to reset your passsword https://https://accounting.iiwi-eg.com/reset.php?email=" . $email . "&rtoken=" . $token, $headers); // Mail reset link to email
          $vali_code = md5(uniqid() . uniqid() . uniqid()); // Generate new validation code
          $stmt2 = $con->prepare("UPDATE `users` SET  `validation` = '$vali_code' WHERE `email` = '$email'");
          $stmt2->execute(); // Update validation code
          echo "<span class='success'>Validation link is sent to email </span>";
        } else { // if email is not exist
          echo "Email is not correct";
        }
      } else { // if email is not valid
        echo "Email is not valid";
      }
    } else { // if field is empty
      echo "Enter your email first";
    }
  }
}

function reset_check() // Reset page redirect if email or token is exist
{
  global $con; // Global connection with database
  if (isset($_GET['email']) && isset($_GET['rtoken']) && !empty($_GET['email']) && !empty($_GET['rtoken'])) { // Check if there is token and email in GET
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); // Filteration Email
    $token = filter_var($_GET['rtoken'], FILTER_SANITIZE_STRING); // Filteration Token
    $stmt = $con->prepare("SELECT * FROM users WHERE `email` = '$email' AND `validation` = '$token' ");
    $stmt->execute();
    $count = $stmt->rowCount(); // Check there is email and token exist in database
    if ($count > 0) { // if email and token is exist nothing happed
    } else { // if email and token is not exist header
      header('location:login.php'); // Header to login.php
      exit();
    }
  } else { // if there is no email and token in GET and not empty
    header('location:login.php'); //  Header to login.php
    exit();
  }
}

function reset_password() // Reset password function
{
  global $con; // Global connection to database
  if (isset($_POST['password']) && isset($_POST['rpassword']) && isset($_POST['reset'])) { // If there is POST reset and password and repassword
    if (!empty($_POST['password']) && !empty($_POST['rpassword']) && !empty($_POST['reset'])) { //  If POST reset and password and repassword is empty
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); // Filteration password
      $rpassword = filter_var($_POST['rpassword'], FILTER_SANITIZE_STRING); // Filteration repassword
      if ($password === $rpassword) { // If password equal repassword
        if (strlen($password) > 8) { // If new password is more than 8
          $hash_pass = password_hash($password, PASSWORD_DEFAULT); // Hash password
          $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); // fileration email
          $vali_code = md5(uniqid() . uniqid() . uniqid()); // Generate new validation code
          $stmt2 = $con->prepare("SELECT `password` FROM users WHERE `email` = '$email'");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          $row = $stmt2->fetch(PDO::FETCH_ASSOC); // Get queries from users where email = email POST
          if ($count2 > 0) { // if there is email exist
            $oldpassword = $row['password']; // Variable old password
            if (password_verify($password, $oldpassword)) { // If new password = old password
              echo "Password entered is the same of old password";
            } else { // If new password is not old passowrd
              $stmt = $con->prepare("UPDATE `users` SET `password` = '$hash_pass', `validation` = '$vali_code' WHERE `email` = '$email'");
              $stmt->execute();
              header("location:login.php?sc=1");
            }
          }
        } else { // If password is less than 8
          echo "Your Password must be more than 8 characters";
        }
      } else { // If password not equal repassword
        echo "Passwords did not match";
      }
    } else { // If not all fields are filled
      echo "All fields are required";
    }
  }
}

function signup_check()
{
  global $con;
  if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['signup']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['rpassword']) && isset($_POST['salary'])) {
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['signup']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username']) && !empty($_POST['rpassword']) && !empty($_POST['salary'])) {
      $username = htmlspecialchars($_POST['username']);
      $firstname = htmlspecialchars($_POST['fname']);
      $lastname = htmlspecialchars($_POST['lname']);
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $password = htmlspecialchars($_POST['password']);
      $rpassword = htmlspecialchars($_POST['rpassword']);
      $salary = $_POST['salary'];
      $stmt = $con->prepare("SELECT * FROM users WHERE `email` = '$email'");
      $stmt->execute();
      $count = $stmt->rowCount();
      $stmt2 = $con->prepare("SELECT * FROM users WHERE `username` = '$username'");
      $stmt2->execute();
      $count2 = $stmt2->rowCount();
      if ($_FILES['profile_pic']['error'] == 4) {
        $image_name = "profile3.png";
        if (strlen($username) < 3) {
          echo "Username is so small min. 4 char";
        } elseif (strlen($firstname) < 3) {
          echo "First name is so small min. 4 char";
        } elseif (strlen($lastname) < 3) {
          echo "Last name is so small min. 4 char";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
          echo "Email is not valid";
        } elseif ($count > 0) {
          echo "Email is already exists";
        } elseif ($count2 > 0) {
          echo "Username is already exists";
        } elseif ($password !== $rpassword) {
          echo "Passwords don't match";
        } elseif ($salary <= 0) {
          echo "Salary must be more than 0";
        } else {
          $stmt3 = $con->prepare("INSERT INTO `users`(`username`,`fname`,`lname`,`email`,`password`,`activate`,`picture`,`perm`) VALUES ('$username','$firstname','$lastname','$email','" . password_hash($password, PASSWORD_DEFAULT) . "','1','$image_name','admin')");
          $stmt3->execute();
          $stmt = $con->prepare("SELECT * FROM users WHERE `email` = '$email'");
          $stmt->execute();
          $count = $stmt->rowCount();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $id = $row['id'];
          $stmt9 = $con->prepare("INSERT INTO `employee_salary`(`id`,`salary`) VALUES ('$id','$salary')");
          $stmt9->execute();
          header("location:login.php?su=1");
        }
      } else {
        $image_type = $_FILES['profile_pic']['type'];
        $image_temp = $_FILES['profile_pic']['tmp_name'];
        $image_size = $_FILES['profile_pic']['size'];
        $image_extension = @strtolower(end(explode('.', $_FILES['profile_pic']['name'])));
        $image_name = rand(0, 100000000000000) . "." . $image_extension;
        $allowed_extensions = [
          "jpg",
          "jpeg",
          "png",
          "gif"
        ];
        if ($image_size > 5000000) {
          echo "Image must be less than 5MB";
        } elseif (!in_array($image_extension, $allowed_extensions)) {
          echo "File is not valid";
        } else {
          if (strlen($username) < 3) {
            echo "Username is so small min. 4 char";
          } elseif (strlen($firstname) < 3) {
            echo "First name is so small min. 4 char";
          } elseif (strlen($lastname) < 3) {
            echo "Last name is so small min. 4 char";
          } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            echo "Email is not valid";
          } elseif ($count > 0) {
            echo "Email is already exists";
          } elseif ($count2 > 0) {
            echo "Username is already exists";
          } elseif ($password !== $rpassword) {
            echo "Passwords don't match";
          } elseif (strlen($password) < 6) {
            echo "Passwords must be at least 6 characters";
          } elseif ($salary <= 0) {
            echo "Salary must be more than 0";
          } else {
            if (move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name)) {
              move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name);
              $stmt3 = $con->prepare("INSERT INTO `users`(`username`,`fname`,`lname`,`email`,`password`,`activate`,`picture`,`perm`) VALUES ('$username','$firstname','$lastname','$email','" . password_hash($password, PASSWORD_DEFAULT) . "','1','$image_name','admin')");
              $stmt3->execute();
              header("location:login.php?su=1");
            } else {
              echo "Upload image failed";
            }
          }
        }
      }
    } else {
      echo "All fields are required";
    }
  }
}

function login_redirect()
{
  global $con;
  if (isset($_COOKIE['urid'])) {
    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $id = $urid_array[0];
    $email = $urid_array[1];
    $password = $urid_array[2];
    $stmt = $con->prepare("SELECT * FROM users WHERE `id` = '$id'");
    $stmt->execute();
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);;
    if ($count > 0) {
      $exact_password = $row['password'];
      $exact_email = md5($row['email']);
      if ($email == $exact_email) {
        if ($password == $exact_password) {
          if ($row['type'] == "user") {
            if ($row['status'] == 1) {
              return 1;
            } else {
              return 0;
            }
          } else {
            return 0;
          }
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  } else {
    return 0;
  }
}

function request_vac()
{
  global $con;
  $user_info = login_info();
  if (isset($_POST["vacation"]) & isset($_POST["reason"]) & isset($_POST["start_vac"]) & isset($_POST["end_vac"]) & isset($_POST["em"])) {
    if (!empty($_POST["vacation"]) & !empty($_POST["reason"]) & !empty($_POST["start_vac"]) & !empty($_POST["end_vac"]) & !empty($_POST["em"])) {
      $id = $_POST['em'];
      $start_vac = $_POST["start_vac"];
      $end_vac = $_POST["end_vac"];
      $reason = filter_var($_POST["reason"], FILTER_SANITIZE_STRING);
      $user_id = $user_info["id"];
      if (strtotime($start_vac) & strtotime($end_vac)) {
        if ($start_vac <= $end_vac) {
          $ns = 0;
          $start_time = strtotime($start_vac);
          $end_time = strtotime($end_vac);
          $datediff = $end_time - $start_time;
          $diff = (round($datediff / (60 * 60 * 24)) + 1);
          $stmt47 = $con->prepare("SELECT `value` FROM settings WHERE item = 'holidays'");
          $stmt47->execute();
          $row47 = $stmt47->fetch(PDO::FETCH_ASSOC);
          $holidays = explode("-", $row47['value']);



          for ($t = 0; $t < $diff; $t++) {
            $daty = date_create($start_vac);
            date_add($daty, date_interval_create_from_date_string("$t days"));
            $comp = date_format($daty, "Y-m-d");


            $newDate = date('l', strtotime($comp));



            if (in_array($newDate, $holidays)) {
              $ns++;
            }
          }


          $final_diff = $diff - $ns;
          $stmt2 = $con->prepare("SELECT * FROM `users` WHERE id = '$id'");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $name = $row2['name'];
          if ($diff > 0) {
            $stmt3 = $con->prepare("INSERT INTO `holidays`(`res_id`, `id`,`name`,`comment`,`start_date`,`end_date`,`duration`,`approve`,`approved_by`,`reject_reason`,`created_date`) VALUES ('$user_id','$id','$name','$reason','$start_vac','$end_vac','$final_diff','0','','','" . date("Y-m-d H:i") . ":00')");
            $stmt3->execute();
            $stmt6 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Get name of id leave
            $name = $row6['name']; // Variable name of id leave
            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Request Vacation for $name','Vacation','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave

            header("location:attendance.php?em=$id"); // Header to attendance.php
            exit();
          } else {
            $error_log = "<div class='error-mg'><span>There is something wrong in duration</span></div>";
            echo $error_log;
          }
        } else {
          $error_log = "<div class='error-mg'><span>End vacation date must be after start vacation date</span></div>";
          echo $error_log;
        }
      } else {
        $error_log = "<div class='error-mg'><span>Date is not valid</span></div>";
        echo $error_log;
      }
    } else {
      $error_log = "<div class='error-mg'><span>All fields are required</span></div>";
      echo $error_log;
    }
  }
}

function check_new()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM holidays WHERE approve = '0'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    return 1;
  } else {
    return 0;
  }
}

function get_working_hours()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM settings WHERE item = 'working_hours'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $working_hours = $row["value"];
  echo $working_hours;
}

function get_weekly_holidays()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM settings WHERE item = 'holidays'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $holidays = $row["value"];
  $holidays_array = explode('-', $holidays);
  return $holidays_array;
}

function checked_if_holiday($day)
{
  $holidays_array = get_weekly_holidays();
  if (in_array($day, $holidays_array)) {
    echo "checked";
  }
}

function push_general_settings()
{
  global $con;
  if (isset($_POST['change-general-s']) && !empty($_POST['change-general-s'])) {
    if (isset($_POST['working_hours'])) {
      if (!empty($_POST['working_hours'])) {
        $working_hours = (int) $_POST['working_hours'];
        if (is_numeric($working_hours) && is_int($working_hours)) {
          $stmt2 = $con->prepare("UPDATE `settings` SET `value` = '$working_hours' WHERE `item` = 'working_hours'");
          $stmt2->execute();
          $urid = $_COOKIE['urid'];
          $urid_array = explode("-", $urid);
          $sessionid = $urid_array[0];
          $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change working hours to $working_hours hours','Settings','" . date('Y-m-d H:i:s') . "')");
          $stmt4->execute(); // Create log for leave


          header("location:settings.php"); // Header to settings.php
        } else {
          $error_log = "<div class='error-mg'><span>Working hours is not a number valid</span></div>";
          echo $error_log;
        }
      } else {
        $error_log = "<div class='error-mg'><span>You must enter a working hours</span></div>";
        echo $error_log;
      }
    }
    if (isset($_POST['holiday'])) {
      $holidays_array = $_POST["holiday"];
      $week_days = ["Friday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Saturday"];
      $holidays_intersect = array_intersect($week_days, $holidays_array);
      $holidays = implode("-", $holidays_intersect);
      $stmt = $con->prepare("UPDATE `settings` SET `value` = '$holidays' WHERE `item` = 'holidays'");
      $stmt->execute();
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change Weekly holidays to $holidays','Settings','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave


      header("location:settings.php"); // Header to settings.php
    } else {
      $holidays = "";
      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change Weekly holidays to $holidays','Settings','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      $stmt = $con->prepare("UPDATE `settings` SET `value` = '$holidays' WHERE `item` = 'holidays'");
      $stmt->execute();
      header("location:settings.php"); // Header to settings.php
    }
  }
}







function get_requests()
{
  global $con;
  global $image_route;
  $num_per_page = 10;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $approve = "('-1','0','1')";
    } elseif ($status == "approved") {
      $approve = "('1')";
    } elseif ($status == "pending") {
      $approve = "('0')";
    } elseif ($status == "rejected") {
      $approve = "('-1')";
    } else {
      $approve = "('-1','0','1')";
    }
  } else {
    $approve = "('-1','0','1')";
  }
  $stmt60 = $con->prepare("SELECT * FROM `holidays` WHERE approve in $approve");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `holidays` WHERE `name` LIKE '$name%' AND approve in $approve ORDER BY created_date DESC LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `holidays` WHERE approve in $approve ORDER BY created_date DESC LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $request) {
        echo "
      <div class='request-row ";
        if ($request['approve'] == 0) {
          echo "pending";
        }
        echo "'>
      <div>" . $request['request_id'] . "</div>";
        $stmt2 = $con->prepare("SELECT * FROM `users` WHERE id = '" . $request['id'] . "'");
        $stmt2->execute();
        $count2 = $stmt2->rowCount();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $profile_path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $profile_path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]) . "/../employee";
        echo "<div>
              <a href='$profile_path/view.php?uid=" . $row2['id'] . "'>
                <div class='img-frame'><img src='" . $image_route . "images/" . $row2['picture'] . "' alt=''></div>
                <div class='info'>
                  <div class='name'>" . $row2['fname'] . " " . $row2['mname'] . "</div>";
        $stmt44 = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $row2['role'] . "'");
        $stmt44->execute();
        $count44 = $stmt44->rowCount();
        $row44 = $stmt44->fetch(PDO::FETCH_ASSOC);
        echo "<div class='profission'>" . $row44['name'] . "</div>
                </div>
              </a>
            </div>";
        $stmt3 = $con->prepare("SELECT * FROM `users` WHERE id = '" . $request['res_id'] . "'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        echo "<div>
              <a href='$profile_path/view.php?uid=" . $row3['id'] . "'>
                <div class='img-frame'><img src='" . $image_route . "images/" . $row3['picture'] . "' alt=''></div>
                <div class='info'>
                  <div class='name'>" . $row2['fname'] . " " . $row2['mname'] . "</div>";
        $stmt43 = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $row3['role'] . "'");
        $stmt43->execute();
        $count43 = $stmt43->rowCount();
        $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);
        echo "<div class='profission'>" . $row43['name'] . "</div>
                </div>
              </a>
            </div>";
        echo "
      <div>" . $request['start_date'] . "</div>
      <div>" . date('Y-m-d', strtotime($request['start_date']) + (($request['duration'] - 1) * 24 * 60 * 60)) . "</div>
      <div>" . $request['duration'] . " days</div>
      <div class='reason'>" . $request['comment'] . "</div>";
        if ($request['approve'] == 0) {
          echo "<div class='pending'><span>Pending</span></div>";
        } elseif ($request['approve'] == 1) {
          echo "<div class='approved'><span>Approved</span></div>";
        } else {
          echo "<div class='rejected'><span>Rejected</span></div>";
        }
        echo "<div class='sm-menu'>
      <button><img src='" . $image_route . "images/menu.png' alt='menu'></button>
      <div class='sm-menu-drop'>
      <ul>
      <li><a href='view.php?r=" . $request['request_id'] . "'><img src='" . $image_route . "images/view.png'>View</a></li>
      </ul>
      </div>
  </div>
  </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no requests</div></tr>";
  }
}

function check_request_id()
{
  global $con;
  if (isset($_GET['r']) && !empty($_GET['r'])) {
    if (is_numeric($_GET['r'])) {
      $rid = $_GET['r'];
      $stmt = $con->prepare("SELECT * FROM `holidays` WHERE request_id = '$rid' ");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count > 0) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  } else {
    return 0;
  }
}

// $employee['category']
function get_employees()
{
  global $con;
  global $functions_route;
  global $css_route;
  global $image_route;
  global $js_route;
  $num_per_page = 10;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $active = "('0','1')";
    } elseif ($status == "active") {
      $active = "('1')";
    } elseif ($status == "inactive") {
      $active = "('0')";
    } else {
      $active = "('0','1')";
    }
  } else {
    $active = "('0','1')";
  }
  $stmt60 = $con->prepare("SELECT * FROM `users` WHERE activate in $active");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `users` WHERE `name` LIKE '$name%' AND activate in $active ORDER BY `name` LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `users` WHERE activate in $active ORDER BY `name`  LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        echo "
      <a href='#' class='request-row'>
      <div><input type='checkbox' class='delete-bx' name='delete[]' value='" . $employee['id'] . "'></div>
      <div>" . $count . "</div>
          <div class='flex fx-start'>
            <div class='img-frame'><img src='" . $image_route . "images/profile3.png' alt=''></div>
            <div class='info'>
              <div class='name'>" . $employee['fname'] . " " . $employee['mname'] . " " . $employee['lname'] . "</div>
              <div class='profission'>Wonder eg</div>
            </div>
          </div>
        <div>Cairo, Ain Shams</div>
        <div>01094432940</div>
        <div>abdallah@wonder-eg.com</div>
        <div>E£ 0.00</div>
        <div><button>Create Invoice</button></div>
    </a>      <a href='#' class='request-row'>
      <div><input type='checkbox' class='delete-bx' name='delete[]' value='" . $employee['id'] . "'></div>
      <div>2</div>
          <div class='flex fx-start'>
            <div class='img-frame'><img src='" . $image_route . "images/profile3.png' alt=''></div>
            <div class='info'>
              <div class='name'>Ahmed Khaled Saleh</div>
              <div class='profission'>Wonder eg</div>
            </div>
          </div>
        <div>Cairo, Nasr City</div>
        <div>01005848901</div>
        <div>Ahmed@wonder-eg.com</div>
        <div>E£ 1,200.00</div>
        <div><button>Create Invoice</button></div>
    </a>
    </a>      <a href='#' class='request-row'>
    <div><input type='checkbox' class='delete-bx' name='delete[]' value='" . $employee['id'] . "'></div>
    <div>2</div>
        <div class='flex fx-start'>
          <div class='img-frame'><img src='" . $image_route . "images/company3.png' alt=''></div>
          <div class='info'>
            <div class='name'>Wonder eg</div>
          </div>
        </div>
      <div>Cairo, New Cairo</div>
      <div>44915918</div>
      <div>contact@wonder-eg.com</div>
      <div>E£ 0.00</div>
      <div><button>Create Invoice</button></div>
  </a>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}


function get_sum_employees()
{
  global $con;
  global $functions_route;
  global $css_route;
  global $image_route;
  global $js_route;
  $num_per_page = 10;
  $stmt = $con->prepare("SELECT * FROM `users` LIMIT 10");
  $stmt->execute();
  $count = $stmt->rowCount();

  if ($count > 0) {
    echo '<div class="body-section emo">';
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        $stmt54 = $con->prepare("SELECT * FROM `categories` WHERE id = '" . $employee['category'] . "'");
        $stmt54->execute();
        $count54 = $stmt54->rowCount();
        $row54 = $stmt54->fetch(PDO::FETCH_ASSOC);

        $stmt55 = $con->prepare("SELECT * FROM `job_titles` WHERE id = '" . $employee['job_title'] . "'");
        $stmt55->execute();
        $count55 = $stmt55->rowCount();
        $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);

        $stmt56 = $con->prepare("SELECT * FROM `career_level` WHERE id = '" . $employee['career_level'] . "'");
        $stmt56->execute();
        $count56 = $stmt56->rowCount();
        $row56 = $stmt56->fetch(PDO::FETCH_ASSOC);

        $stmt57 = $con->prepare("SELECT * FROM `job_types` WHERE id = '" . $employee['job_type'] . "'");
        $stmt57->execute();
        $count57 = $stmt57->rowCount();
        $row57 = $stmt57->fetch(PDO::FETCH_ASSOC);


        echo '  <ul class="emp-sum">
            <li>
              <a href="employee/view.php?uid=' . $employee['id'] . '">
                <div>
                  <div class="img-prof">
                    <img src="images/' . $employee['picture'] . '" alt="">
                  </div>
                  <div class="name">' . $employee['fname'] . ' ' . $employee['mname'] . '<span>#' . $employee['id'] . '</span></div>
                </div>
                <div>' . $row55['name'] . '</div>
                <div>' . $row54['name'] . '</div>
                <div>' . $employee['join_date'] . '</div>
              </a>
            </li>
          </ul>';
      }
    }
  } else {
    echo '
    <div class="body-section empty">
      <div class="em-cont">
        <p>There are no employees yet</p>
        <a href="employee/add.php">Add new employee</a>
      </div>';
  }
  echo '</div>';
}

function get_sum_requests()
{
  global $con;
  global $functions_route;
  global $css_route;
  global $image_route;
  global $js_route;
  $num_per_page = 10;
  $stmt = $con->prepare("SELECT * FROM `holidays` WHERE `approve` = '0' LIMIT 10");
  $stmt->execute();
  $count = $stmt->rowCount();

  if ($count > 0) {
    echo '<div class="body-section emo">';
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        $stmt20 = $con->prepare("SELECT * FROM `users` WHERE `id` = '" . $employee['id'] . "'");
        $stmt20->execute();
        $count20 = $stmt20->rowCount();
        $row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
        echo '  <ul class="emp-sum">
            <li>
              <a href="requests/view.php?r=' . $employee['request_id'] . '">
                <div>
                  <div class="img-prof">
                    <img src="images/' . $row20['picture'] . '" alt="">
                  </div>
                  <div class="name">' . $row20['fname'] . ' ' . $row20['mname'] . '<span>#' . $row20['id'] . '</span></div>
                </div>
                <div>' . $employee['start_date'] . '</div>
                <div>' . $employee['end_date'] . '</div>
                <div>' . $employee['duration'] . ' Months</div>
              </a>
            </li>
          </ul>';
      }
    }
  } else {
    echo '
    <div class="body-section empty">
      <div class="em-cont">
        <p>There are no pending requests yet</p>
      </div>';
  }
  echo '</div>';
}

function countries()
{
  $countries = array(
    'AF' => 'Afghanistan',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AG' => 'Antigua And Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia And Herzegovina',
    'BW' => 'Botswana',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'BN' => 'Brunei',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CO' => 'Colombia',
    'CG' => 'Congo',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D\'ivoire',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'CD' => 'Democratic Republic of the Congo',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FO' => 'Faroe Islands',
    'FM' => 'Federated States Of Micronesia',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GW' => 'Guinea Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Laos',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LY' => 'Libyan Arab Jamahiriya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'MX' => 'Mexico',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'ME' => 'Montenegro',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NF' => 'Norfolk Island',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'MD' => 'Republic Of Moldova',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russia',
    'RW' => 'Rwanda',
    'KN' => 'Saint Kitts And Nevis',
    'LC' => 'Saint Lucia',
    'VC' => 'Saint Vincent And The Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome And Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'RS' => 'Serbia',
    'SC' => 'Seychelles',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'ZA' => 'South Africa',
    'KR' => 'South Korea',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TO' => 'Tonga',
    'TT' => 'Trinidad And Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'US' => 'United States',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'VG' => 'Virgin Islands British',
    'VI' => 'Virgin Islands U.S.',
    'YE' => 'Yemen',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe'
  );

  return $countries;
}

function ip_info($ip = null, $purpose = "location", $deep_detect = true)
{
  $output = null;
  if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if ($deep_detect) {
      if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      }
    }
  }
  // $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), null, strtolower(trim($purpose)));
  $support = array("country", "countrycode", "state", "region", "city", "location", "address");
  $continents = array(
    "AF" => "Africa",
    "AN" => "Antarctica",
    "AS" => "Asia",
    "EU" => "Europe",
    "OC" => "Australia (Oceania)",
    "NA" => "North America",
    "SA" => "South America"
  );
  if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
      switch ($purpose) {
        case "location":
          $output = array(
            "city" => @$ipdat->geoplugin_city,
            "state" => @$ipdat->geoplugin_regionName,
            "country" => @$ipdat->geoplugin_countryName,
            "country_code" => @$ipdat->geoplugin_countryCode,
            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
            "continent_code" => @$ipdat->geoplugin_continentCode
          );
          break;
        case "address":
          $address = array($ipdat->geoplugin_countryName);
          if (@strlen($ipdat->geoplugin_regionName) >= 1) {
            $address[] = $ipdat->geoplugin_regionName;
          }
          if (@strlen($ipdat->geoplugin_city) >= 1) {
            $address[] = $ipdat->geoplugin_city;
          }
          $output = implode(", ", array_reverse($address));
          break;
        case "city":
          $output = @$ipdat->geoplugin_city;
          break;
        case "state":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "region":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "country":
          $output = @$ipdat->geoplugin_countryName;
          break;
        case "countrycode":
          $output = @$ipdat->geoplugin_countryCode;
          break;
      }
    }
  }
  return $output;
}

function get_categories()
{
  global $con;
  global $image_route;
  $num_per_page = 10;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $active = "('0','1')";
    } elseif ($status == "active") {
      $active = "('1')";
    } elseif ($status == "inactive") {
      $active = "('0')";
    } else {
      $active = "('0','1')";
    }
  } else {
    $active = "('0','1')";
  }
  $stmt60 = $con->prepare("SELECT * FROM `categories` WHERE `status` in $active");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `categories` WHERE `name` LIKE '$name%' AND `status` in $active ORDER BY `name` LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `categories` WHERE `status` in $active ORDER BY `name`  LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        echo "
      <div class='request-row'>
        <div>" . $employee['name'] . "</div>";
        $stmt3 = $con->prepare("SELECT * FROM `users` WHERE `category` = '" . $employee['id'] . "' ");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        echo "<div>" . $count3 . "</div>";
        if ($employee['status'] == 1) {
          echo "<div class='approved'><span>Active</span></div>";
        } else {
          echo "<div class='rejected'><span>Inactive</span></div>";
        }
        echo "<div class='sm-menu'>
                <button><img src='" . $image_route . "images/menu.png' alt='menu'></button>
                <div class='sm-menu-drop'>
                <ul>
                <li><a href='view.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/view.png'>View</a></li>
                <li><a href='edit.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/edit.png'>Edit</a></li>";

        if ($employee['def'] == 0) {
          echo "<li><a href='edit.php?cid=" . $employee['id'] . "&del=1'><img src='" . $image_route . "images/delete.png'>Delete</a></li>";
        }

        echo "</ul>
                </div>
            </div>
    </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function get_career_level()
{
  global $con;
  global $image_route;
  $num_per_page = 10;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $active = "('0','1')";
    } elseif ($status == "active") {
      $active = "('1')";
    } elseif ($status == "inactive") {
      $active = "('0')";
    } else {
      $active = "('0','1')";
    }
  } else {
    $active = "('0','1')";
  }
  $stmt60 = $con->prepare("SELECT * FROM `career_level` WHERE `status` in $active");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `career_level` WHERE `name` LIKE '$name%' AND `status` in $active ORDER BY `name` LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `career_level` WHERE `status` in $active ORDER BY `name`  LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        echo "
      <div class='request-row'>
        <div>" . $employee['name'] . "</div>";
        $stmt3 = $con->prepare("SELECT * FROM `users` WHERE `career_level` = '" . $employee['id'] . "' ");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        echo "<div>" . $count3 . "</div>";
        if ($employee['status'] == 1) {
          echo "<div class='approved'><span>Active</span></div>";
        } else {
          echo "<div class='rejected'><span>Inactive</span></div>";
        }
        echo "<div class='sm-menu'>
      <button><img src='" . $image_route . "images/menu.png' alt='menu'></button>
      <div class='sm-menu-drop'>
      <ul>
      <li><a href='view.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/view.png'>View</a></li>
      <li><a href='edit.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/edit.png'>Edit</a></li>";

        if ($employee['def'] == 0) {
          echo "<li><a href='edit.php?cid=" . $employee['id'] . "&del=1'><img src='" . $image_route . "images/delete.png'>Delete</a></li>";
        }

        echo "</ul>
      </div>
    </div>
  </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function get_job_types()
{
  global $con;
  global $image_route;
  $num_per_page = 10;
  if (isset($_GET['status']) & !empty($_GET['status'])) {
    $status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
    if ($status == "all") {
      $active = "('0','1')";
    } elseif ($status == "active") {
      $active = "('1')";
    } elseif ($status == "inactive") {
      $active = "('0')";
    } else {
      $active = "('0','1')";
    }
  } else {
    $active = "('0','1')";
  }
  $stmt60 = $con->prepare("SELECT * FROM `job_types` WHERE `status` in $active");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `job_types` WHERE `name` LIKE '$name%' AND `status` in $active ORDER BY `name` LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `job_types` WHERE `status` in $active ORDER BY `name`  LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        echo "
      <div class='request-row'>
        <div>" . $employee['name'] . "</div>";
        $stmt3 = $con->prepare("SELECT * FROM `users` WHERE `job_type` = '" . $employee['id'] . "' ");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        echo "<div>" . $count3 . "</div>";
        if ($employee['status'] == 1) {
          echo "<div class='approved'><span>Active</span></div>";
        } else {
          echo "<div class='rejected'><span>Inactive</span></div>";
        }
        echo "<div class='sm-menu'>
                <button><img src='" . $image_route . "images/menu.png' alt='menu'></button>
                <div class='sm-menu-drop'>
                <ul>
                <li><a href='view.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/view.png'>View</a></li>
                <li><a href='edit.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/edit.png'>Edit</a></li>";

        if ($employee['def'] == 0) {
          echo "<li><a href='edit.php?cid=" . $employee['id'] . "&del=1'><img src='" . $image_route . "images/delete.png'>Delete</a></li>";
        }

        echo "</ul>
                </div>
            </div>
    </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function profile_info($uid)
{
  global $con;
  global $image_route;
  if (isset($uid)) {
    if (!empty($uid)) {
      $stmt = $con->prepare("SELECT * FROM users WHERE id = '$uid' ");
      $stmt->execute();
      $count = $stmt->rowCount();
      $profile_info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
      return $profile_info;
    }
  }
}

function log_as()
{
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      if (isset($_POST['log-as'])) {
        $profile_info = profile_info($_GET['uid']);
        $urid = $_GET['uid'] . "-" . md5($profile_info['email']) . "-" . $profile_info['password'];
        setcookie("urid", $urid, time() + (360400 * 30), "/");
        header("location:" . $_SERVER['PHP_SELF'] . "?uid=" . $_GET['uid'] . "");
      }
    }
  }
}

function edit_employee()
{
  global $con;
  global $y;
  global $m;
  $errors = [
    "fname" => "",
    "mname" => "",
    "lname" => "",
    "profile-pic" => "",
    "notes" => "",
    "type" => "",
    "email" => "",
    "status" => "",
    "job_role" => "",
    "birthday" => "",
    "gender" => "",
    "country" => "",
    "phone_number" => "",
    "personal_email" => "",
    "curr_add1" => "",
    "curr_add2" => "",
    "curr_city" => "",
    "curr_gover" => "",
    "curr_postal" => "",
    "perm_add1" => "",
    "perm_add2" => "",
    "perm_city" => "",
    "perm_gover" => "",
    "perm_postal" => "",
    "job_title" => "",
    "category" => "",
    "type_job" => "",
    "career_level" => "",
    "net_salary" => "",
  ];
  if (isset($_POST['edit-user']) && !empty($_POST['edit-user'])) {
    $fname = "";
    $mname = "";
    $lname = "";
    $notes = "";
    $email = "";
    $status = "";
    $job_role = "";
    $gender = "";
    $bday = "";
    $country = "";
    $phone = "";
    $pemail = "";
    $curr_add1 = "";
    $curr_add2 = "";
    $curr_city = "";
    $curr_gover = "";
    $curr_postal = "";
    $perm_add1 = "";
    $perm_add2 = "";
    $perm_city = "";
    $perm_gover = "";
    $perm_postal = "";
    $job_title = "";
    $category = "";
    $type_job = "";
    $career_level = "";
    $n_salary = "";
    $type = "employee";

    if (isset($_POST['fname'])) {
      if (!empty($_POST['fname'])) {
        $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $fname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $fname)) {
          $errors["fname"] = "First name can't contain numbers or special character";
        } else {
          if ($fname == trim($fname) && strpos($fname, ' ') !== false) {
            $errors["fname"] = "First name can't contain any spaces";
          }
          if (strlen($fname) < 3) {
            $errors["fname"] = "First name is too small minimun 3 character";
          } elseif (strlen($fname) > 12) {
            $errors["fname"] = "First name is too long maximun 12 character";
          }
        }
      } else {
        $errors["fname"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['mname'])) {
      if (!empty($_POST['mname'])) {
        $mname = filter_var($_POST['mname'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $mname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $mname)) {
          $errors["mname"] = "Middle name can't contain numbers or special character";
        } else {
          if ($mname == trim($mname) && strpos($mname, ' ') !== false) {
            $errors["mname"] = "Middle name can't contain any spaces";
          }
          if (strlen($mname) < 3) {
            $errors["mname"] = "Middle name is too small minimun 3 character";
          } elseif (strlen($mname) > 12) {
            $errors["mname"] = "Middle name is too long maximun 12 character";
          }
        }
      } else {
        $errors["mname"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['lname'])) {
      if (!empty($_POST['lname'])) {
        $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $lname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lname)) {
          $errors["lname"] = "Last name can't contain numbers or special character";
        } else {
          if ($lname == trim($lname) && strpos($lname, ' ') !== false) {
            $errors["lname"] = "Last name can't contain any spaces";
          }
          if (strlen($lname) < 3) {
            $errors["lname"] = "Last name is too small minimun 3 character";
          } elseif (strlen($lname) > 12) {
            $errors["lname"] = "Last name is too long maximun 12 character";
          }
        }
      } else {
        $errors["lname"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['notes'])) {
      if (!empty($_POST['notes'])) {
        $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
        if (strlen($notes) > 200) {
          $errors["notes"] = "Maximun characters are 200";
        }
      }
    }
    if (isset($_POST['type'])) {
      if (!empty($_POST['type'])) {
        $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
        if ($type == "user" or $type == "employee") {
        } else {
          $errors["type"] = "This value is not valid";
        }
      } else {
        $errors["type"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['email'])) {
      if (!empty($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors["email"] = "Email is not valid";
        } else {
          $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = '$email'");
          $stmt->execute();
          $count = $stmt->rowCount();
          if ($count > 0) {
            $id = $_GET['uid'];
            $stmt2 = $con->prepare("SELECT * FROM `users` WHERE `id` = '$id'");
            $stmt2->execute();
            $count2 = $stmt2->rowCount();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($email == $row2['email']) {
            } else {
              $errors["email"] = "Email is already exist";
            }
          }
        }
      } else {
        if ($_POST['type'] == "user") {
          $errors["email"] = "This field is required and cannot be empty";
        }
      }
    }
    if ($_FILES['profile-pic']['error'] == 4) {
      $image_name = "profile3.png";
    } else {
      $image_type = $_FILES['profile-pic']['type'];
      $image_temp = $_FILES['profile-pic']['tmp_name'];
      $image_size = $_FILES['profile-pic']['size'];
      $image_extension = @strtolower(end(explode('.', $_FILES['profile-pic']['name'])));
      $image_name = rand(0, 100000000000000) . "." . $image_extension;
      $allowed_extensions = [
        "jpg",
        "jpeg",
        "png",
        "gif"
      ];
      if ($image_size > 10000000) {
        $errors["profile-pic"] = "Image must be less than 10MB";
      } elseif (!in_array($image_extension, $allowed_extensions)) {
        $errors["profile-pic"] = "File is not valid";
      }
      if (move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name)) {
      } else {
        $errors["profile-pic"] = "Upload image failed";
      }
    }

    if (isset($_POST['status'])) {
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
      if ($status == "1" or $status == "0") {
      } else {
        $errors["status"] = "This value is not valid";
      }
    }
    if (isset($_POST['job_role'])) {
      if (!empty($_POST['job_role'])) {
        $job_role = filter_var($_POST['job_role'], FILTER_SANITIZE_STRING);
        $stmt50 = $con->prepare("SELECT * FROM `user_roles`");
        $stmt50->execute();
        $count50 = $stmt50->rowCount();
        $user_roles = [];
        if ($count50 > 0) {
          while ($row50 = $stmt50->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row50 as $role) {
              $user_roles[] = $role['id'];
            }
          }
        }
        if (!in_array($job_role, $user_roles)) {
          $errors["job_role"] = "This value is not valid";
        }
      } else {
        if ($_POST['type'] == "user") {
          $errors["job_role"] = "This field is required and cannot be empty";
        }
      }
    }
    if (isset($_POST['gender'])) {
      if (!empty($_POST['gender'])) {
        $gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING);
        if ($gender == "male" or $gender == "female") {
        } else {
          $errors["gender"] = "This value is not valid";
        }
      } else {
        $errors["gender"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['bday'])) {
      if (!empty($_POST['bday'])) {
        $bday = filter_var($_POST['bday'], FILTER_SANITIZE_STRING);
        if ($bday < date("Y-m-d", strtotime('-10 years'))) {
        } else {
          $errors["birthday"] = "This date is less than 10 years old";
        }
      } else {
        $errors["birthday"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['country'])) {
      if (!empty($_POST['country'])) {
        $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $countries = countries();
        $values = array_values($countries);
        if (in_array($country, $values)) {
        } else {
          $errors["country"] = "This value is not valid";
        }
      } else {
        $errors["country"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['phone'])) {
      if (!empty($_POST['phone'])) {
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        if (is_numeric($phone)) {
          if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $phone)) {
            $errors["phone_number"] = "Phone number can't contain special character";
          } else {
            if ($phone == trim($phone) && strpos($phone, ' ') !== false) {
              $errors["phone_number"] = "Phone number can't contain any spaces";
            }
            if (strlen($phone) < 11) {
              $errors["phone_number"] = "Phone number is too small minimun 11 numbers";
            } elseif (strlen($phone) > 13) {
              $errors["phone_number"] = "Last name is too long maximun 13 numbers";
            }
          }
        } else {
          $errors["phone_number"] = "Phone number can't contain any characters";
        }
      } else {
        $errors["phone_number"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['personal-email'])) {
      if (!empty($_POST['personal-email'])) {
        $pemail = filter_var($_POST['personal-email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($pemail, FILTER_VALIDATE_EMAIL)) {
          $errors["personal_email"] = "Email is not valid";
        }
      } else {
        $errors["personal_email"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['curr-address1'])) {
      if (!empty($_POST['curr-address1'])) {
        $curr_add1 = filter_var($_POST['curr-address1'], FILTER_SANITIZE_STRING);
        if (strlen($curr_add1) > 200) {
          $errors["curr_add1"] = "Maximun characters are 200";
        }
      } else {
        $errors["curr_add1"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['curr-address2'])) {
      if (!empty($_POST['curr-address2'])) {
        $curr_add2 = filter_var($_POST['curr-address2'], FILTER_SANITIZE_STRING);
        if (strlen($curr_add2) > 200) {
          $errors["curr_add2"] = "Maximun characters are 200";
        }
      } else {
        $errors["curr_add2"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['curr-city'])) {
      if (!empty($_POST['curr-city'])) {
        $curr_city = filter_var($_POST['curr-city'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $curr_city) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $curr_city)) {
          $errors["curr_city"] = "City name can't contain numbers or special character";
        } else {
          if (strlen($curr_city) < 2) {
            $errors["curr_city"] = "City name is too small minimun 3 character";
          } elseif (strlen($curr_city) > 30) {
            $errors["curr_city"] = "City name is too long maximun 12 character";
          }
        }
      } else {
        $errors["curr_city"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['curr-gover'])) {
      if (!empty($_POST['curr-gover'])) {
        $curr_gover = filter_var($_POST['curr-gover'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $curr_gover) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $curr_gover)) {
          $errors["curr_gover"] = "Government name can't contain numbers or special character";
        } else {
          if (strlen($curr_gover) < 2) {
            $errors["curr_gover"] = "Government name is too small minimun 3 character";
          } elseif (strlen($curr_gover) > 30) {
            $errors["curr_gover"] = "Government name is too long maximun 12 character";
          }
        }
      } else {
        $errors["curr_gover"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['curr-postal'])) {
      if (!empty($_POST['curr-postal'])) {
        $curr_postal = filter_var($_POST['curr-postal'], FILTER_SANITIZE_STRING);
        if (is_numeric($curr_postal)) {
          if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $curr_postal)) {
            $errors["curr_postal"] = "Postal number can't contain special character";
          } else {
            if ($curr_postal == trim($curr_postal) && strpos($curr_postal, ' ') !== false) {
              $errors["curr_postal"] = "Postal number can't contain any spaces";
            }
            if (strlen($curr_postal) < 2) {
              $errors["curr_postal"] = "Postal number is too small minimun 11 numbers";
            } elseif (strlen($curr_postal) > 20) {
              $errors["curr_postal"] = "Postal number is too long maximun 13 numbers";
            }
          }
        } else {
          $errors["curr_postal"] = "Postal number can't contain any characters";
        }
      }
    }
    if (isset($_POST['perm-address1'])) {
      if (!empty($_POST['perm-address1'])) {
        $perm_add1 = filter_var($_POST['perm-address1'], FILTER_SANITIZE_STRING);
        if (strlen($perm_add1) > 200) {
          $errors["perm_add1"] = "Maximun characters are 200";
        }
      }
    }
    if (isset($_POST['perm-address2'])) {
      if (!empty($_POST['perm-address2'])) {
        $perm_add2 = filter_var($_POST['perm-address2'], FILTER_SANITIZE_STRING);
        if (strlen($perm_add2) > 200) {
          $errors["perm_add2"] = "Maximun characters are 200";
        }
      }
    }
    if (isset($_POST['perm-city'])) {
      if (!empty($_POST['perm-city'])) {
        $perm_city = filter_var($_POST['perm-city'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $perm_city) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $perm_city)) {
          $errors["perm_city"] = "City name can't contain numbers or special character";
        } else {
          if (strlen($perm_city) < 2) {
            $errors["perm_city"] = "City name is too small minimun 3 character";
          } elseif (strlen($perm_city) > 30) {
            $errors["perm_city"] = "City name is too long maximun 12 character";
          }
        }
      }
    }
    if (isset($_POST['perm-gover'])) {
      if (!empty($_POST['perm-gover'])) {
        $perm_gover = filter_var($_POST['perm-gover'], FILTER_SANITIZE_STRING);
        if (preg_match('~[0-9]+~', $perm_gover) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $perm_gover)) {
          $errors["perm_gover"] = "Government name can't contain numbers or special character";
        } else {
          if (strlen($perm_gover) < 2) {
            $errors["perm_gover"] = "Government name is too small minimun 3 character";
          } elseif (strlen($perm_gover) > 30) {
            $errors["perm_gover"] = "Government name is too long maximun 12 character";
          }
        }
      }
    }
    if (isset($_POST['perm-postal'])) {
      if (!empty($_POST['perm-postal'])) {
        $perm_postal = filter_var($_POST['perm-postal'], FILTER_SANITIZE_STRING);
        if (is_numeric($perm_postal)) {
          if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $perm_postal)) {
            $errors["perm_postal"] = "Postal number can't contain special character";
          } else {
            if ($perm_postal == trim($perm_postal) && strpos($perm_postal, ' ') !== false) {
              $errors["perm_postal"] = "Postal number can't contain any spaces";
            }
            if (strlen($perm_postal) < 2) {
              $errors["perm_postal"] = "Postal number is too small minimun 11 numbers";
            } elseif (strlen($perm_postal) > 20) {
              $errors["perm_postal"] = "Postal number is too long maximun 13 numbers";
            }
          }
        } else {
          $errors["perm_postal"] = "Postal number can't contain any characters";
        }
      }
    }
    if (isset($_POST['job_title'])) {
      if (!empty($_POST['job_title'])) {
        $job_title = filter_var($_POST['job_title'], FILTER_SANITIZE_STRING);
        $stmt50 = $con->prepare("SELECT * FROM `job_titles` WHERE `status` = '1'");
        $stmt50->execute();
        $count50 = $stmt50->rowCount();
        $job_titles = [];
        if ($count50 > 0) {
          while ($row50 = $stmt50->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row50 as $jobt) {
              $job_titles[] = $jobt['id'];
            }
          }
        }
        if (!in_array($job_title, $job_titles)) {
          $errors["job_title"] = "This value is not valid";
        }
      } else {
        $errors["job_title"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['category'])) {
      if (!empty($_POST['category'])) {
        $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
        $stmt50 = $con->prepare("SELECT * FROM `categories` WHERE `status` = '1'");
        $stmt50->execute();
        $count50 = $stmt50->rowCount();
        $categories = [];
        if ($count50 > 0) {
          while ($row50 = $stmt50->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row50 as $cate) {
              $categories[] = $cate['id'];
            }
          }
        }
        if (!in_array($category, $categories)) {
          $errors["category"] = "This value is not valid";
        }
      } else {
        $errors["category"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['type_job'])) {
      if (!empty($_POST['type_job'])) {
        $type_job = filter_var($_POST['type_job'], FILTER_SANITIZE_STRING);
        $stmt60 = $con->prepare("SELECT * FROM `job_types` WHERE `status` = '1'");
        $stmt60->execute();
        $count60 = $stmt60->rowCount();
        $type_jobs = [];
        if ($count60 > 0) {
          while ($row60 = $stmt60->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row60 as $types) {
              $type_jobs[] = $types['id'];
            }
          }
        }
        if (!in_array($type_job, $type_jobs)) {
          $errors["type_job"] = "This value is not valid";
        }
      } else {
        $errors["type_job"] = "This field is required and cannot be empty";
      }
    }
    if (isset($_POST['career_level'])) {
      if (!empty($_POST['career_level'])) {
        $career_level = filter_var($_POST['career_level'], FILTER_SANITIZE_STRING);
        $stmt50 = $con->prepare("SELECT * FROM `career_level` WHERE `status` = '1'");
        $stmt50->execute();
        $count50 = $stmt50->rowCount();
        $career_levels = [];
        if ($count50 > 0) {
          while ($row50 = $stmt50->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row50 as $career) {
              $career_levels[] = $career['id'];
            }
          }
        }
        if (!in_array($career_level, $career_levels)) {
          $errors["career_level"] = "This value is not valid";
        }
      } else {
        $errors["career_level"] = "This field is required and cannot be empty";
      }
    }

    if (isset($_POST['n_salary'])) {
      if (!empty($_POST['n_salary'])) {
        $n_salary = filter_var($_POST['n_salary'], FILTER_SANITIZE_STRING);
        if (is_numeric($n_salary)) {
          if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $n_salary)) {
            $errors["net_salary"] = "Salary can't contain special character";
          } else {
            if ($n_salary == trim($n_salary) && strpos($n_salary, ' ') !== false) {
              $errors["net_salary"] = "Salary can't contain any spaces";
            } else {
              if ($n_salary < 1400) {
                $errors["net_salary"] = "Minimum Salary is 1400 EGP";
              }
            }
          }
        } else {
          $errors["net_salary"] = "Salary can't contain any characters";
        }
      } else {
        $errors["net_salary"] = "This field is required and cannot be empty";
      }
    }
  }

  if (array_filter($errors)) {
    return $errors;
  } else {
    if (isset($_POST['edit-user'])) {
      $id = $_GET['uid'];



      if ($n_salary >= 4120) {
        $main = 2060;
        $main2 = ($n_salary * 0.7) - $main;
        if (($main2 + $main) > 9400) {
          $main2 = 7340;
        }
        if ($n_salary >= 10000) {
          $loc_allow = ($n_salary - ($main + $main2)) * 0.1;
          $acco_allow = ($n_salary - ($main + $main2)) * 0.2;
          $cloth_allow = ($n_salary - ($main + $main2)) * 0.3;
          $other_allow = ($n_salary - ($main + $main2)) * 0.4;
        } else {
          $loc_allow = ($n_salary - ($main + $main2)) * 0.3;
          $acco_allow = ($n_salary - ($main + $main2)) * 0.3;
          $cloth_allow = ($n_salary - ($main + $main2)) * 0.4;
          $other_allow = 0;
        }
      } else {
        $main = $n_salary * 0.5;
        $main2 = ($n_salary * 0.7) - $main;

        if (($main2 + $main) < 1400) {
          $main2 = 1400 - $main;
        }

        $loc_allow = ($n_salary - ($main + $main2)) * 0.3;
        $acco_allow = ($n_salary - ($main + $main2)) * 0.3;
        $cloth_allow = ($n_salary - ($main + $main2)) * 0.4;
        $other_allow = 0;
      }

      $insure = ($main + $main2) * 0.11;
      $fellow = 0;

      $tax_compare = ((($main + $main2 + $other_allow) - $insure) * 12) - 24000;

      if ($tax_compare > 0) {
        if ($tax_compare <= 6000) {
          $tax = ($tax_compare / 12) * 0.025;
        }

        if ($tax_compare > 6000 & $tax_compare <= 21000) {
          $tax = (500 * 0.025) + ((($tax_compare - 6000) / 12) * 0.1);
        }

        if ($tax_compare > 21000 & $tax_compare <= 36000) {
          $tax = (500 * 0.025) + (1250 * 0.1) + ((($tax_compare - 21000) / 12) * 0.15);
        }

        if ($tax_compare > 36000 & $tax_compare <= 176000) {
          $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + ((($tax_compare - 36000) / 12) * 0.20);
        }

        if ($tax_compare > 176000 & $tax_compare <= 200000) {
          $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + ((($tax_compare - 176000) / 12) * 0.225);
        }

        if ($tax_compare > 200000) {
          $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225) + ((($tax_compare - 200000) / 12) * 0.25);
        }
      } else {
        $tax = 0;
      }



      $yandm = $y . "-" . $m;
      $stmt55 = $con->prepare("SELECT * FROM employee_salary WHERE `date` LIKE '$yandm%' AND `id` = '$id' ");
      $stmt55->execute();
      $count55 = $stmt55->rowCount();
      $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);

      $stmt477 = $con->prepare("SELECT * FROM attendance WHERE  `enter_in` LIKE '$yandm%' AND `duration` = '480' AND `id` = '$id' ");
      $stmt477->execute();
      $count477 = $stmt477->rowCount();

      $holi_throw = $row55['holidays'];
      if ($row55['salary_vacation'] == 0) {
        $daying = 0;
      } else {
        $daying = $row55['salary_vacation'] * 30 / $n_salary;
      }
      $daysInMonth = cal_days_in_month(0, date('m'), date('Y'));
      $absence = ($daysInMonth - ($count477 + $holi_throw + $daying)) * ($n_salary / 30);

      $stmt43 = $con->prepare("SELECT * FROM `settings` WHERE `item` = 'working_hours'");
      $stmt43->execute();
      $count43 = $stmt43->rowCount();
      $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);
      $working_hours = $row43['value'];

      $stmt25 = $con->prepare("SELECT SUM(`overtime`) FROM `attendance` WHERE `id` = '$id' AND `enter_in` LIKE '$yandm%' ");
      $stmt25->execute();
      $count25 = $stmt25->rowCount();
      $row25 = $stmt25->fetch(PDO::FETCH_ASSOC);
      $overtime = (($n_salary / 30) / $working_hours) * ($row25['SUM(`overtime`)'] / 60);

      $stmt25 = $con->prepare("SELECT SUM(`late`) FROM `attendance` WHERE `id` = '$id' AND `enter_in` LIKE '$yandm%' ");
      $stmt25->execute();
      $count25 = $stmt25->rowCount();
      $row25 = $stmt25->fetch(PDO::FETCH_ASSOC);
      $late = (($n_salary / 30) / $working_hours) * ($row25['SUM(`late`)'] / 60);

      $y_m = date("Y-m");
      $stmt488 = $con->prepare("SELECT * FROM `salary` WHERE `id` = '$id' AND `date` = '$y_m'");
      $stmt488->execute();
      $row488 = $stmt488->fetch(PDO::FETCH_ASSOC);
      $main_holidays = $row488['main_holidays'];



      $total = $main + $main2 + $loc_allow + $acco_allow + $cloth_allow + $other_allow + $overtime - $tax - $fellow - $insure - $absence - $late + $main_holidays;


      if ($total < 0) {
        $total = 0;
      }


      $stmt70 = $con->prepare("SELECT * FROM `salary` WHERE `id` = '$id' AND `date` = '" . date('Y-m') . "'");
      $stmt70->execute();
      $count70 = $stmt70->rowCount();
      $row70 = $stmt70->fetch(PDO::FETCH_ASSOC);

      if ($_FILES['profile-pic']['error'] == 4) {
        $stmt = $con->prepare("UPDATE `users` SET `name`='" . $fname . " " . $mname . " " . $lname . "',`fname`='$fname',`mname`='$mname',`email`='$email',`activate`='$status',`role`='$job_role',`lname`='$lname',`notes`='$notes',`birthday`='$bday',`gender`='$gender',`country`='$country',`phone_number`='$phone',`personal_email`='$pemail',`curr_add1`='$curr_add1',`perm_add1`='$perm_add1',`curr_add2`='$curr_add2',`perm_add2`='$perm_add2',`curr_city`='$curr_city',`perm_city`='$perm_city',`curr_gover`='$curr_gover',`perm_gover`='$perm_gover',`curr_postal`='$curr_postal',`perm_postal`='$perm_postal',`job_title`='$job_title',`category`='$category',`job_type`='$type_job',`career_level`='$career_level',`net_salary`='$n_salary',`type`='$type' WHERE id = $id");
        $stmt->execute();

        $stmt78 = $con->prepare("SELECT * FROM `users` WHERE `email` = '$email'");
        $stmt78->execute();
        $count78 = $stmt78->rowCount();
        $row78 = $stmt78->fetch(PDO::FETCH_ASSOC);









        $stmt9 = $con->prepare("UPDATE `employee_salary` SET `salary` = '$n_salary' WHERE `id` = '" . $row78['id'] . "' AND `date` = '" . date('Y-m-') . "01'");
        $stmt9->execute();

        $stmt10 = $con->prepare("UPDATE `salary` SET  `name` = '" . $fname . " " . $mname . " " . $lname . "' , `category` = '$category' , `job_title` = '$job_title',`salary`='$n_salary',`main`='$main',`main2`='$main2',`loc_allow`='$loc_allow',`acco_allow`='$acco_allow',`cloth_allow`='$cloth_allow',`other_allow`='$other_allow',`overtime`='$overtime',`insure`='$insure',`tax`='$tax',`fellow`='$fellow',`penality`='0',`delay`='$late',`absence`='$absence',`total`='$total'  WHERE id = '" . $row78['id'] . "' AND `date` = '" . date('Y-m') . "'");
        $stmt10->execute();
      } else {
        $stmt = $con->prepare("UPDATE `users` SET `name`='" . $fname . " " . $mname . " " . $lname . "',`fname`='$fname',`mname`='$mname',`email`='$email',`activate`='$status',`picture`='$image_name',`role`='$job_role',`lname`='$lname',`notes`='$notes',`birthday`='$bday',`gender`='$gender',`country`='$country',`phone_number`='$phone',`personal_email`='$pemail',`curr_add1`='$curr_add1',`perm_add1`='$perm_add1',`curr_add2`='$curr_add2',`perm_add2`='$perm_add2',`curr_city`='$curr_city',`perm_city`='$perm_city',`curr_gover`='$curr_gover',`perm_gover`='$perm_gover',`curr_postal`='$curr_postal',`perm_postal`='$perm_postal',`job_title`='$job_title',`category`='$category',`job_type`='$type_job',`career_level`='$career_level',`net_salary`='$n_salary',`type`='$type' WHERE id = $id");
        $stmt->execute();
        $stmt78 = $con->prepare("SELECT * FROM `users` WHERE `email` = '$email'");
        $stmt78->execute();
        $count78 = $stmt78->rowCount();
        $row78 = $stmt78->fetch(PDO::FETCH_ASSOC);




        $stmt9 = $con->prepare("UPDATE `employee_salary` SET `salary` = '$n_salary' WHERE id = '" . $row78['id'] . "' `date` = '" . date('Y-m-') . "01'");
        $stmt9->execute();


        $stmt10 = $con->prepare("UPDATE `salary` SET  `name` = '" . $fname . " " . $mname . " " . $lname . "' , `category` = '$category' , `job_title` = '$job_title',`salary`='$n_salary',`main`='$main',`main2`='$main2',`loc_allow`='$loc_allow',`acco_allow`='$acco_allow',`cloth_allow`='$cloth_allow',`other_allow`='$other_allow',`overtime`='$overtime',`insure`='$insure',`tax`='$tax',`fellow`='$fellow',`penality`='0',`delay`='$late',`absence`='$absence',`total`='$total'  WHERE id = '" . $row78['id'] . "' AND `date` = '" . date('Y-m') . "'");
        $stmt10->execute();

        move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name);
      }







      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $id = $row78['id'];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Edit user #$id Info','Employee Edit','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      header("location:view.php?uid=$id");
      return $errors;
    } else {
      return $errors;
    }
  }
}

function del_employee()
{
  global $con;
  if (isset($_GET['del']) && isset($_GET['uid'])) {
    if (!empty($_GET['del']) && !empty($_GET['uid'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("DELETE FROM `users` WHERE id = $uid");
      $stmt->execute();


      header("location:" . $_SERVER['PHP_SELF'] . "");
    }
  }
}

function dis_employee()
{
  global $con;
  if (isset($_GET['dis']) && isset($_GET['uid'])) {
    if (!empty($_GET['dis']) && !empty($_GET['uid'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("UPDATE `users` SET `status` = '0' WHERE id = $uid");
      $stmt->execute();



      header("location:" . $_SERVER['PHP_SELF'] . "?uid=$uid");
    }
  }
}
function act_employee()
{
  global $con;
  if (isset($_GET['act']) && isset($_GET['uid'])) {
    if (!empty($_GET['act']) && !empty($_GET['uid'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("UPDATE `users` SET `status` = '1'  WHERE id = $uid");
      $stmt->execute();


      header("location:" . $_SERVER['PHP_SELF'] . "?uid=$uid");
    }
  }
}

function reset_password_inside() // Reset password function
{
  global $con; // Global connection to database
  if (isset($_POST['password']) && isset($_POST['rpassword']) && isset($_POST['opassword']) && isset($_POST['reset'])) { // If there is POST reset and password and repassword
    if (!empty($_POST['password']) && !empty($_POST['rpassword']) && !empty($_POST['opassword']) && !empty($_POST['reset'])) { //  If POST reset and password and repassword is empty
      $opassword = filter_var($_POST['opassword'], FILTER_SANITIZE_STRING); // Filteration password
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); // Filteration password
      $rpassword = filter_var($_POST['rpassword'], FILTER_SANITIZE_STRING); // Filteration repassword
      if ($password === $rpassword) { // If password equal repassword
        if (strlen($password) > 8) { // If new password is more than 8
          $hash_pass = password_hash($password, PASSWORD_DEFAULT); // Hash password
          $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
          $stmt2 = $con->prepare("SELECT * FROM users WHERE `id` = '$uid'");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          $row = $stmt2->fetch(PDO::FETCH_ASSOC); // Get queries from users where email = email POST
          if ($count2 > 0) { // if there is email exist
            $oldpassword = $row['password']; // Variable old password
            $email = $row['email'];
            $name = $row['name'];
            if (password_verify($opassword, $oldpassword)) {
              if (password_verify($password, $oldpassword)) { // If new password = old password
                echo "Password entered is the same of old password";
              } else { // If new password is not old passowrd
                $stmt = $con->prepare("UPDATE `users` SET `password` = '$hash_pass' WHERE `email` = '$email'");
                $stmt->execute();
                $urid = $_GET['uid'] . "-" . md5($email) . "-" . $hash_pass;
                setcookie("urid", $urid, time() + (360400 * 30), "/");



                $urid = $_COOKIE['urid'];
                $urid_array = explode("-", $urid);
                $sessionid = $urid_array[0];
                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','$name reset his/her password','Password','" . date('Y-m-d H:i:s') . "')");
                $stmt4->execute(); // Create log for leave

                header("location:employeedetails?uid=$uid");
              }
            } else {
              echo "Your old password is in correct";
            }
          }
        } else { // If password is less than 8
          echo "Your password must be more than 8 characters";
        }
      } else { // If password not equal repassword
        echo "Passwords did not match";
      }
    } else { // If not all fields are filled
      echo "All fields are required";
    }
  }
}

function get_request_information()
{
  global $con;
  if (isset($_GET['r'])) {
    if (!empty($_GET['r'])) {
      $request_id = filter_var($_GET['r'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM holidays WHERE `request_id` = '$request_id'");
      $stmt->execute();
      $count = $stmt->rowCount();
      return $request_info = $stmt->fetch(PDO::FETCH_ASSOC);
    }
  }
}

function edit_req_status()
{
  global $con;
  $user_info = login_info();
  if (isset($_POST['approve'])) {
    $stmt = $con->prepare("UPDATE `holidays` SET `approve` = '1', `approved_by` = '" . $user_info['id'] . "' WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt->execute();

    $stmt3 = $con->prepare("SELECT * FROM holidays WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt3->execute();
    $count3 = $stmt3->rowCount();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);


    $stmt45 = $con->prepare("SELECT `value` FROM settings WHERE item = 'holidays'");
    $stmt45->execute();
    $row45 = $stmt45->fetch(PDO::FETCH_ASSOC);
    $holidays = explode("-", $row45['value']);

    $start_vac = $row3['start_date'];
    $end_vac = $row3['end_date'];
    $vac_dur = $row3['duration'];

    $start_time = strtotime($start_vac);
    $end_time = strtotime($end_vac);
    $datediff = $end_time - $start_time;
    $diff = (round($datediff / (60 * 60 * 24)) + 1);
    $ns = 0;

    for ($t = 0; $t < $diff; $t++) {
      $daty = date_create($start_vac);
      date_add($daty, date_interval_create_from_date_string("$t days"));
      $comp = date_format($daty, "Y-m-d");


      $newDate = date('l', strtotime($comp));



      if (in_array($newDate, $holidays)) {
        $ns++;
      }
    }

    $dura = $vac_dur + $ns;





    $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
    $stmt4->execute();
    $count4 = $stmt4->rowCount();
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

    $old_actual = $row4['actual'];
    $salary = $row4['salary'];
    $old_vacation = $row4['vacation'];
    $old_s_vacation = $row4['salary_vacation'];



    $new_vacation = $old_vacation + $vac_dur;

    $new_s_vacation = $old_s_vacation + ($salary / 30 * $vac_dur);

    $new_actual = $old_actual + $new_s_vacation;



    $annual_vac = 0;
    $stmt10 = $con->prepare("SELECT `duration` FROM holidays WHERE id = " . $row3['id'] . " AND `approve` = '1'  AND `start_date` LIKE '" . substr($row3['start_date'], 0, 4) . "%' ");
    $stmt10->execute(); // change 0 to 1
    while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row10 as $dura) {
        $annual_vac += $dura['duration'];
      }
    }

    if ($annual_vac > 21) {
      $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation' WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
      $stmt2->execute();
    } else {
      $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation', `salary_vacation` = '$new_s_vacation', `actual` = '$new_actual' WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
      $stmt2->execute();
    }

    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $sessionid = $urid_array[0];
    $id = $_GET['r'];
    $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Approve Vacation Request #$id','Vacation','" . date('Y-m-d H:i:s') . "')");
    $stmt4->execute(); // Create log for leave


    header("location:../employee/attendance.php?em=" . $row3['id'] . "&dt=" . substr($row3['start_date'], 0, 7) . "");
  } elseif (isset($_POST['reject'])) {
    if (isset($_POST['reason'])) {
      if (!empty($_POST['reason'])) {
        $reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
      } else {
        $reason = "";
      }
    }


    $stmt3 = $con->prepare("SELECT * FROM holidays WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt3->execute();
    $count3 = $stmt3->rowCount();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);



    $stmt45 = $con->prepare("SELECT `value` FROM settings WHERE item = 'holidays'");
    $stmt45->execute();
    $row45 = $stmt45->fetch(PDO::FETCH_ASSOC);
    $holidays = explode("-", $row45['value']);

    $start_vac = $row3['start_date'];
    $end_vac = $row3['end_date'];
    $vac_dur = $row3['duration'];

    $start_time = strtotime($start_vac);
    $end_time = strtotime($end_vac);
    $datediff = $end_time - $start_time;
    $diff = (round($datediff / (60 * 60 * 24)) + 1);
    $ns = 0;

    for ($t = 0; $t < $diff; $t++) {
      $daty = date_create($start_vac);
      date_add($daty, date_interval_create_from_date_string("$t days"));
      $comp = date_format($daty, "Y-m-d");


      $newDate = date('l', strtotime($comp));



      if (in_array($newDate, $holidays)) {
        $ns++;
      }
    }

    $dura = $vac_dur + $ns;


    $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
    $stmt4->execute();
    $count4 = $stmt4->rowCount();
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

    $old_actual = $row4['actual'];
    $salary = $row4['salary'];
    $old_vacation = $row4['vacation'];
    $old_s_vacation = $row4['salary_vacation'];



    $new_vacation = $old_vacation - $vac_dur;

    $new_s_vacation = $old_s_vacation - ($salary / 30 * $vac_dur);

    $new_actual = $old_actual - ($salary / 30 * $vac_dur);


    $annual_vac = 0;
    $stmt10 = $con->prepare("SELECT `duration` FROM holidays WHERE id = " . $row3['id'] . " AND `approve` = '1'  AND `start_date` LIKE '" . substr($row3['start_date'], 0, 4) . "%' ");
    $stmt10->execute(); // change 0 to 1
    while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row10 as $dura) {
        $annual_vac += $dura['duration'];
      }
    }


    $stmt68 = $con->prepare("SELECT * FROM holidays WHERE `request_id` = '" . $_GET['r'] . "' AND `approve` = 1");
    $stmt68->execute();
    $count68 = $stmt68->rowCount();

    if ($count68 > 0) {
      if ($annual_vac > 21) {
        $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation' WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
        $stmt2->execute();
      } else {
        $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation', `salary_vacation` = '$new_s_vacation', `actual` = '$new_actual' WHERE  `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' AND `id` = '" . $row3['id'] . "' ");
        $stmt2->execute();
      }
    }






    $stmt = $con->prepare("UPDATE `holidays` SET `approve` = '-1', `approved_by` = '" . $user_info['id'] . "', `reject_reason` = '$reason' WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt->execute();

    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $sessionid = $urid_array[0];
    $id = $_GET['r'];
    $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Reject Vacation Request #$id','Vacation','" . date('Y-m-d H:i:s') . "')");
    $stmt4->execute(); // Create log for leave


    header("location:../employee/attendance.php?em=" . $row3['id'] . "&dt=" . substr($row3['start_date'], 0, 7) . "");
  } elseif (isset($_POST['delete'])) {
    $stmt3 = $con->prepare("SELECT * FROM holidays WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt3->execute();
    $count3 = $stmt3->rowCount();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    $status = $row3['approve'];

    if ($status == 1) {
      $stmt45 = $con->prepare("SELECT `value` FROM settings WHERE item = 'holidays'");
      $stmt45->execute();
      $row45 = $stmt45->fetch(PDO::FETCH_ASSOC);
      $holidays = explode("-", $row45['value']);

      $start_vac = $row3['start_date'];
      $end_vac = $row3['end_date'];
      $vac_dur = $row3['duration'];

      $start_time = strtotime($start_vac);
      $end_time = strtotime($end_vac);
      $datediff = $end_time - $start_time;
      $diff = (round($datediff / (60 * 60 * 24)) + 1);
      $ns = 0;

      for ($t = 0; $t < $diff; $t++) {
        $daty = date_create($start_vac);
        date_add($daty, date_interval_create_from_date_string("$t days"));
        $comp = date_format($daty, "Y-m-d");


        $newDate = date('l', strtotime($comp));



        if (in_array($newDate, $holidays)) {
          $ns++;
        }
      }

      $dura = $vac_dur + $ns;




      $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
      $stmt4->execute();
      $count4 = $stmt4->rowCount();
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

      $old_actual = $row4['actual'];
      $salary = $row4['salary'];
      $old_vacation = $row4['vacation'];
      $old_s_vacation = $row4['salary_vacation'];



      $new_vacation = $old_vacation - $vac_dur;

      $new_s_vacation = $old_s_vacation - ($salary / 30 * $vac_dur);

      $new_actual = $old_actual - ($salary / 30 * $vac_dur);





      $annual_vac = 0;
      $stmt10 = $con->prepare("SELECT `duration` FROM holidays WHERE id = " . $row3['id'] . " AND `approve` = '1'  AND `start_date` LIKE '" . substr($row3['start_date'], 0, 4) . "%' ");
      $stmt10->execute(); // change 0 to 1
      while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row10 as $dura) {
          $annual_vac += $dura['duration'];
        }
      }
      if ($annual_vac > 21) {
        $new_s_vacation = ($salary / 30 * 21);

        $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation', `salary_vacation` = '$new_s_vacation' WHERE `id` = '" . $row3['id'] . "' AND `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' ");
        $stmt2->execute();
      } else {
        $stmt2 = $con->prepare("UPDATE `employee_salary` SET `vacation` = '$new_vacation', `salary_vacation` = '$new_s_vacation', `actual` = '$new_actual' WHERE  `date` LIKE '" . substr($row3['start_date'], 0, 7) . "%' AND `id` = '" . $row3['id'] . "' ");
        $stmt2->execute();
      }
    }


    $stmt = $con->prepare("DELETE FROM `holidays` WHERE `request_id` = '" . $_GET['r'] . "'");
    $stmt->execute();

    $urid = $_COOKIE['urid'];
    $urid_array = explode("-", $urid);
    $sessionid = $urid_array[0];
    $id = $_GET['r'];
    $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete Vacation Request #$id','Vacation','" . date('Y-m-d H:i:s') . "')");
    $stmt4->execute(); // Create log for leave


    header("location:../employee/attendance.php?em=" . $row3['id'] . "&dt=" . substr($row3['start_date'], 0, 7) . "");
  }
}

function check_org($r)
{
  global $con;
  if (isset($_GET['cid'])) {
    if (!empty($_GET['cid'])) {
      $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
      if (is_numeric($cid)) {
        $stmt = $con->prepare("SELECT * FROM `$r` WHERE `id` = '$cid'");
        $stmt->execute();
        $cid_check = $stmt->rowCount();
      } else {
        return 0;
      }
      if ($cid_check > 0) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }
}

function get_org_info($r)
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `$r` WHERE id = '$cid'");
      $stmt->execute();
      $count = $stmt->rowCount();
      $org_info = $stmt->fetch(PDO::FETCH_ASSOC);
      return $org_info;
    }
  }
}

function get_num_org($r)
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `users` WHERE `$r` = '$cid'");
      $stmt->execute();
      $count = $stmt->rowCount();
      return $count;
    }
  }
}

function update_org($r, $j)
{
  global $con;
  $org_info = get_org_info($r);
  if (isset($_POST['update'])) {
    if (!empty($_POST['update']) & !empty($_POST['name'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
      if (isset($_POST['des'])) {
        $des = filter_var($_POST['des'], FILTER_SANITIZE_STRING);
      } else {
        $des = "";
      }

      if (isset($_POST['default'])) {
        $def = 1;
      } else {
        $stmt60 = $con->prepare("SELECT * FROM `$r` WHERE id = '$cid'");
        $stmt60->execute();
        $count60 = $stmt60->rowCount();
        $curr_def = $stmt60->fetch(PDO::FETCH_ASSOC);
        if ($curr_def['def'] == 1) {
          $def = 1;
        } else {
          $def = 0;
        }
      }

      if ($status == 0 || $status == 1) {
        if (strlen($name) > 32) {
          echo "<div class='error'>Name is to long</div>";
        } else {
          if (strlen($des) > 200) {
            echo "<div class='error'>Description is to long</div>";
          } else {
            if ($name !== $org_info['name']) {
              $stmt = $con->prepare("SELECT `name` FROM `$r`");
              $stmt->execute();
              $count = $stmt->rowCount();
              $ns = $stmt->fetchAll(PDO::FETCH_ASSOC);
              $names = [];
              foreach ($ns as $n) {
                array_push($names, $n['name']);
              }
              if (in_array($name, $names)) {
                echo "<div class='error'>Name is already Exist</div>";
              } else {
                if ($def == 1) {
                  $stmt9 = $con->prepare("UPDATE `$r` SET `def` = '0' WHERE `id` != '" . $org_info['id'] . "' ");
                  $stmt9->execute();
                }

                $stmt10 = $con->prepare("UPDATE `$r` SET  `name` = '$name'  , `description` = '$des', `status` = '$status',`def` = '$def' WHERE `id` = '" . $org_info['id'] . "'");
                $stmt10->execute();





                header("Location:" . $j . "_edit.php?uid=" . $org_info['id'] . "");
                exit();
              }
            } else {
              if ($def == 1) {
                $stmt9 = $con->prepare("UPDATE `$r` SET `def` = '0' WHERE `id` != '" . $org_info['id'] . "' ");
                $stmt9->execute();
              }
              $stmt10 = $con->prepare("UPDATE `$r` SET  `name` = '$name'  , `description` = '$des', `status` = '$status',`def` = '$def' WHERE `id` = '" . $org_info['id'] . "'");
              $stmt10->execute();


              header("Location:" . $j . "_edit.php?uid=" . $org_info['id'] . "");
              exit();
            }
          }
        }
      } else {
        echo "<div class='error'>Status Value is not valid</div>";
      }
    } else {
      echo "<div class='error'>All required fields must be not empty</div>";
    }
  }
}

function delete_org($r, $y)
{
  global $con;
  if (isset($_GET['uid']) & isset($_GET['del'])) {
    if (!empty($_GET['uid']) & !empty($_GET['del'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `$r` WHERE `id` = '$cid' AND `def` = '1' ");
      $stmt->execute();
      $count = $stmt->rowCount();
      $stmt3 = $con->prepare("SELECT * FROM `$r` WHERE def = '1'");
      $stmt3->execute();
      $count3 = $stmt3->rowCount();
      $get_org_info = get_org_info($r);
      $def_r = $stmt3->fetch(PDO::FETCH_ASSOC);
      if ($count > 0) {
      } else {
        $stmt10 = $con->prepare("UPDATE `users` SET `$y` = '" . $def_r['id'] . "' WHERE `$y` = '" . $get_org_info['id'] . "'");
        $stmt10->execute();
        $stmt9 = $con->prepare("DELETE FROM `$r` WHERE `id` = '$cid'");
        $stmt9->execute();


        $urid = $_COOKIE['urid'];
        $urid_array = explode("-", $urid);
        $sessionid = $urid_array[0];
        $name = $get_org_info['name'];
        $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete $name from " . ucfirst(str_replace("_", " ", $r)) . "','Delete','" . date('Y-m-d H:i:s') . "')");
        $stmt4->execute(); // Create log for leave


        header("location:$r.php");
        exit();
      }
    }
  }
}

function get_org_list($r)
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM users WHERE `$r` = '$cid'");
      $stmt->execute();
      $count = $stmt->rowCount(); // Check if the id from GET exist in database
      if ($count > 0) { // If GET is exist
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row as $employe) {
            $stmt54 = $con->prepare("SELECT * FROM `categories` WHERE id = '" . $employe['category'] . "'");
            $stmt54->execute();
            $count54 = $stmt54->rowCount();
            $row54 = $stmt54->fetch(PDO::FETCH_ASSOC);


            $stmt55 = $con->prepare("SELECT * FROM `job_titles` WHERE id = '" . $employe['job_title'] . "'");
            $stmt55->execute();
            $count55 = $stmt55->rowCount();
            $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);

            $stmt56 = $con->prepare("SELECT * FROM `career_levels` WHERE id = '" . $employe['career_level'] . "'");
            $stmt56->execute();
            $count56 = $stmt56->rowCount();
            $row56 = $stmt56->fetch(PDO::FETCH_ASSOC);


            echo '<div class="card-contain">
            <div class="card">
              <div class="imgBx">
                <img src="../images/ur-img/' . $employe['picture'] . '" alt="">
              </div>
              <div class="content">
                <div class="details">
                  <h2>' . ucfirst($employe['fname']) . ' ' . ucfirst($employe['mname']) . '<span>#1</span></h2>
                  <div class="card-info">
                    <div class="l-info">Phone Number:</div>
                    <div class="r-info">+2 ' . $employe['mobile'] . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Department:</div>
                    <div class="r-info">' . ucfirst($row54['name']) . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Job Title:</div>
                    <div class="r-info">' . ucfirst($row55['name']) . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Career Level:</div>
                    <div class="r-info">' . ucfirst($row56['name']) . '</div>
                  </div>
                  <div class="actionBtn">
                    <a href="employeedetails.php?uid=' . $employe['id'] . '" target="_blank"><i class="fa-solid fa-eye"></i> View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>';
          }
        }
      } else {
        echo "<div class='no-res'>No Results</div>";
      }
    }
  }
}


function get_roles()
{
  global $con;
  global $image_route;
  $num_per_page = 10;

  $stmt60 = $con->prepare("SELECT * FROM `user_roles`");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `name` LIKE '$name%'  ORDER BY `id` LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `user_roles` ORDER BY `id`  LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $employee) {
        echo "
      <div class='request-row'>
        <div>" . $employee['id'] . "</div>
        <div>" . $employee['name'] . "</div>

                <div class='sm-menu-drop roling'>
                <ul>";
        if ($employee['def'] !== 1) {
          echo "<li><a href='edit.php?cid=" . $employee['id'] . "'><img src='" . $image_route . "images/edit.png'>Edit</a></li>";
        }

        if ($employee['def'] == 0) {
          echo "<li><a href='edit.php?cid=" . $employee['id'] . "&del=1'><img src='" . $image_route . "images/delete.png'>Delete</a></li>";
        }

        echo "</ul>
                </div>
            
    </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function role_info()
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE id = '$cid'");
      $stmt->execute();
      $count = $stmt->rowCount();
      $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
      return $role_info;
    }
  }
}

function add_role()
{
  global $con;
  if (isset($_POST['add'])) {
    if (!empty($_POST['add']) & !empty($_POST['name'])) {
      $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      if (isset($_POST['role'])) {
        $roly = $_POST['role'];
      } else {
        $roly = "";
      }
      $role_array = $roly;
      if (!empty($role_array)) {
        $role = implode(",", $role_array);
        if (strlen($name) > 128) {
          echo "<div class='error'>Name is to long</div>";
        } else {
          $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `name` = '$name'");
          $stmt->execute();
          $count = $stmt->rowCount();
          if ($count > 0) {
            echo "<div class='error'>Name is already Exist</div>";
          } else {
            $stmt9 = $con->prepare("INSERT INTO `user_roles`(`name`,`role`,`def`) VALUES ('$name','$role','0')");
            $stmt9->execute();
            header("Location:roles.php");
            exit();
          }
        }
      } else {
        echo "<div class='error'>At least one role must be chosen</div>";
      }
    } else {
      echo "<div class='error'>All required fields must be not empty</div>";
    }
  }
}

function edit_role()
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      if (isset($_POST['edit'])) {
        if (!empty($_POST['edit']) && !empty($_POST['name'])) {
          $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
          if (isset($_POST['role'])) {
            $roly = $_POST['role'];
          } else {
            $roly = "";
          }
          $role_array = $roly;
          if (!empty($role_array)) {
            $role = implode(",", $role_array);
            if (strlen($name) > 32) {
              echo "<div class='error'>Name is to long</div>";
            } else {
              $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `name` = '$name'");
              $stmt->execute();
              $count = $stmt->rowCount();
              if ($count > 0) {
                $stmt9 = $con->prepare("UPDATE `user_roles` SET `name` = '$name' , `role` = '$role' WHERE id = '$cid' ");
                $stmt9->execute();

                header("Location:edit_role.php?uid=$cid");
                exit();
              } else {
                $stmt2 = $con->prepare("SELECT `name` FROM `user_roles`");
                $stmt2->execute();
                $count2 = $stmt2->rowCount();
                $ns = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $names = [];
                foreach ($ns as $n) {
                  array_push($names, $n['name']);
                }
                if (in_array($name, $names)) {
                  echo "<div class='error'>Name is already Exist</div>";
                } else {
                  $stmt9 = $con->prepare("UPDATE `user_roles` SET `name` = '$name' , `role` = '$role' WHERE id = '$cid' ");
                  $stmt9->execute();



                  $urid = $_COOKIE['urid'];
                  $urid_array = explode("-", $urid);
                  $sessionid = $urid_array[0];
                  $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change role $name info ','Edit','" . date('Y-m-d H:i:s') . "')");
                  $stmt4->execute(); // Create log for leave

                  header("Location:edit_role.php?uid=$cid");
                  exit();
                }
              }
            }
          } else {
            echo "<div class='error'>At least one role must be chosen</div>";
          }
        } else {
          echo "<div class='error'>All required fields must be not empty</div>";
        }
      }
    }
  }
}

function check_role()
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE id = '$cid'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count > 0) {
        return 1;
      } else {
        return 0;
      }
    }
  }
}

function check_role_id($r)
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE id = '$cid' LIMIT 1");
      $stmt->execute();
      $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
      $role_array = explode(",", $role_info['role']);
      if (in_array($r, $role_array)) {
        return 1;
      } else {
        return 0;
      }
    }
  }
}

function del_role()
{
  global $con;
  if (isset($_GET['uid']) & isset($_GET['del'])) {
    if (!empty($_GET['uid']) & !empty($_GET['del'])) {
      $cid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `id` = '$cid' AND `def` = '1' ");
      $stmt->execute();
      $count = $stmt->rowCount();
      $stmt3 = $con->prepare("SELECT * FROM `user_roles` WHERE def = '1'");
      $stmt3->execute();
      $count3 = $stmt3->rowCount();
      $get_org_info = get_org_info("user_roles");
      $def_r = $stmt3->fetch(PDO::FETCH_ASSOC);
      if ($count > 0) {
      } else {
        $stmt4 = $con->prepare("SELECT * FROM `users` WHERE `role` = '$cid'");
        $stmt4->execute();
        $count4 = $stmt4->rowCount();
        if ($count4 > 0) {
        } else {
          $stmt10 = $con->prepare("UPDATE `users` SET `role` = '" . $def_r['id'] . "' WHERE `role` = '" . $get_org_info['id'] . "'");
          $stmt10->execute();
          $stmt9 = $con->prepare("DELETE FROM `user_roles` WHERE `id` = '$cid'");
          $stmt9->execute();
        }

        header("location:roles.php");
        exit();
      }
    }
  }
}

function check_user_role($n)
{
  global $con;
  $user_info = login_info();
  $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $user_info['role'] . "'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
  $role_array = explode(",", $role_info['role']);
  if (in_array($n, $role_array)) {
    return 1;
  } else {
    return 0;
  }
}

function get_overtime($year, $month)
{
  global $con;
  if (isset($_GET['em'])) {
    if (!empty($_GET['em'])) {
      $yandm = $year . "-" . $month;
      $over = [];
      $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      for ($i = 1; $i <= $d; $i++) {
        $over[] = 0;
      }

      $stmt = $con->prepare("SELECT * FROM `attendance` WHERE id = '" . $_GET['em'] . "' AND `enter_in` LIKE '$yandm%' AND `overtime` != '0'");
      $stmt->execute();
      $count = $stmt->rowCount();
      while ($overs = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($overs as $o) {
          $over[substr($o['enter_in'], 8, 2) - 1] = $o['overtime'];
        }
      }



      $over = implode(",", $over);
      return $over;
    }
  }
}


function get_delay($year, $month)
{
  global $con;
  if (isset($_GET['em'])) {
    if (!empty($_GET['em'])) {
      $yandm = $year . "-" . $month;
      $late = [];
      $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      for ($i = 1; $i <= $d; $i++) {
        $late[] = 0;
      }


      $stmt = $con->prepare("SELECT * FROM `attendance` WHERE id = '" . $_GET['em'] . "' AND `enter_in` LIKE '$yandm%' AND `late` != '0'");
      $stmt->execute();
      $count = $stmt->rowCount();
      while ($lates = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($lates as $l) {
          $late[substr($l['enter_in'], 8, 2) - 1] = -$l['late'];
        }
      }
      $late = implode(",", $late);
      return $late;
    }
  }
}


function get_att_requests()
{
  global $con;
  global $image_route;
  $num_per_page = 10;

  $stmt60 = $con->prepare("SELECT * FROM `attendance_change`");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }
  $start_from = ($page - 1) * $num_per_page;
  if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $name = filter_var($_GET['search_name'], FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("SELECT * FROM `attendance_change` WHERE `name` LIKE '$name%' ORDER BY `id` DESC LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  } else {
    $stmt = $con->prepare("SELECT * FROM `attendance_change` ORDER BY `id` DESC LIMIT $start_from,$num_per_page");
    $stmt->execute();
    $count = $stmt->rowCount();
  }
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $request) {
        $stmt65 = $con->prepare("SELECT * FROM `attendance` WHERE att_id = '" . $request['att_id'] . "'");
        $stmt65->execute();
        $count65 = $stmt65->rowCount();
        $row65 = $stmt65->fetch(PDO::FETCH_ASSOC);
        $old_enter = date("Y-m-d h:i A", strtotime($row65['enter_in']));
        $old_leave = date("Y-m-d h:i A", strtotime($row65['leave_out']));


        $stmt66 = $con->prepare("SELECT * FROM `attendance_change` WHERE id = '" . $request['id'] . "'");
        $stmt66->execute();
        $count66 = $stmt66->rowCount();
        $row66 = $stmt66->fetch(PDO::FETCH_ASSOC);
        if ($row66['enter_in'] == 0 || $row66['leave_out'] == 0) {
          $new_enter = "<span> Delete </span> ";
          $new_leave = "<span> Delete </span>";
        } else {
          $new_enter = date("Y-m-d h:i A", strtotime($row66['enter_in']));
          $new_leave = date("Y-m-d h:i A", strtotime($row66['leave_out']));
        }



        echo "
      <div class='request-row'>
      <div>" . $request['id'] . "</div>";
        $stmt2 = $con->prepare("SELECT * FROM `users` WHERE id = '" . $request['requester'] . "'");
        $stmt2->execute();
        $count2 = $stmt2->rowCount();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $profile_path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $profile_path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]) . "/../employee";
        echo "<div>
              <a href='$profile_path/view.php?uid=" . $row2['id'] . "'>
                <div class='img-frame'><img src='" . $image_route . "images/" . $row2['picture'] . "' alt=''></div>
                <div class='info'>
                  <div class='name'>" . ucfirst($row2['fname']) . " " . ucfirst($row2['mname']) . "</div>";
        $stmt44 = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $row2['role'] . "'");
        $stmt44->execute();
        $count44 = $stmt44->rowCount();
        $row44 = $stmt44->fetch(PDO::FETCH_ASSOC);
        echo "<div class='profission'>" . $row44['name'] . "</div>
                </div>
              </a>
            </div>";
        echo "<div>
              <div class='time-cont'>
              <div class='f-time'>";
        echo $new_enter;
        echo "</div>
                <div class='s-time'>";
        echo $old_enter;
        echo "</div>
              </div>      
            </div>";
        echo "<div>
            <div class='time-cont'>
            <div class='f-time'>";
        echo $new_leave;
        echo "</div>
              <div class='s-time'>";
        echo $old_leave;
        echo "</div>
            </div>      
          </div>";
        echo "<div class='sm-menu'>
      <button><img src='" . $image_route . "images/menu.png' alt='menu'></button>
      <div class='sm-menu-drop'>
      <ul>
      <li><a href='?att_id=" . $request['att_id'] . "&";
        if ($row66['enter_in'] == 0 & $row66['leave_out'] == 0) {
          echo "dl";
        } else {
          echo "approve";
        }
        echo "=1&start=" . $request['enter_in'] . "&end=" . $request['leave_out'] . "&em=" . $request['requester'] . "'><img src='" . $image_route . "images/approve.png'>Approve</a></li>
      <li><a href='?att_id=" . $request['att_id'] . "&reject=1&start=" . $request['enter_in'] . "&end=" . $request['leave_out'] . "&em=" . $request['requester'] . "'><img src='" . $image_route . "images/reject.png'>Reject</a></li>
      </ul>
      </div>
  </div>
  </div>";
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no requests</div></tr>";
  }
}


function request_att()
{
  global $con;
  if (isset($_POST['change'])) {
    if (!empty($_POST['change']) & !empty($_POST['start']) & !empty($_POST['end']) & !empty($_POST['att_id']) & !empty($_POST['em'])) {
      $start = date_format(date_create($_POST['start']), "Y-m-d H:i:s");
      $att_id = $_POST['att_id'];
      $end = date_format(date_create($_POST['end']), "Y-m-d H:i:s");
      $id = $_POST['em'];
      $profile_info = profile_info($id);
      $name = $profile_info['name'];

      $stmt32 = $con->prepare("SELECT * FROM attendance_change WHERE att_id = '$att_id' ");
      $stmt32->execute(); // change 0 to 1
      $count32 = $stmt32->rowCount();
      if ($count32 > 0) {
        $stmt4 = $con->prepare("UPDATE `attendance_change` SET  `enter_in` = '$start'  , `leave_out` = '$end' WHERE `att_id` = '$att_id' ");
        $stmt4->execute(); // Update salary in salary_employee
        $stmt4->execute();
      } else {
        $stmt4 = $con->prepare("INSERT INTO `attendance_change` (`att_id`,`requester`,`name`,`enter_in`,`leave_out`) VALUES ('$att_id','$id','$name','$start','$end')");
        $stmt4->execute();
      }

      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Request to change attendance time','attendance','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      header("location:attendance.php?em=$id");
    } else {
      echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
    }
  } elseif (isset($_POST['delete'])) {
    if (!empty($_POST['delete']) & !empty($_POST['att_id']) & !empty($_POST['em'])) {
      $att_id = $_POST['att_id'];
      $id = $_POST['em'];
      $profile_info = profile_info($id);
      $name = $profile_info['name'];

      $stmt32 = $con->prepare("SELECT * FROM attendance_change WHERE att_id = '$att_id' ");
      $stmt32->execute(); // change 0 to 1
      $count32 = $stmt32->rowCount();
      if ($count32 > 0) {
        $stmt4 = $con->prepare("UPDATE `attendance_change` SET  `enter_in` = '0'  , `leave_out` = '0' WHERE `att_id` = '$att_id' ");
        $stmt4->execute(); // Update salary in salary_employee
        $stmt4->execute();
      } else {
        $stmt4 = $con->prepare("INSERT INTO `attendance_change` (`att_id`,`requester`,`name`,`enter_in`,`leave_out`) VALUES ('$att_id','$id','$name','0','0')");
        $stmt4->execute();
      }


      $urid = $_COOKIE['urid'];
      $urid_array = explode("-", $urid);
      $sessionid = $urid_array[0];
      $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Request to delete attendance time','attendance','" . date('Y-m-d H:i:s') . "')");
      $stmt4->execute(); // Create log for leave

      header("location:attendance.php?em=$id");
    } else {
      echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
    }
  }
}



function redirect_contract()
{
  global $con;
  global $day;
  global $m;
  global $y;

  if (isset($_GET['em'])) {
    if (!empty($_GET['em'])) {
      if (isset($_GET['dt'])) { // if there is date in GET
        $dt = $_GET['dt']; // Variable date on GET to dt
        $dt_array = explode("-", $dt); // Explode string to date array 0 year 1 month
        if (count($dt_array) == 2) { // if the array has two elements year and month
          $year = $dt_array[0]; // Variable year
          $month = $dt_array[1]; // Variable month
          if (!is_numeric($month) or !is_numeric($year)) { // if year and month are not numbers
            $month = $m; // Re Variable to now month m from general.php
            $year = $y; // Re Variable to now year y from general.php
          } else { // if year and month are numbers
            if ($month > 12 || $year > $y) { // Check if month more than 12 or year more than current year
              $month = $m; // Re Variable to now month m from general.php
              $year = $y; // Re Variable to now year y from general.php
            }
          }
        } else { // if the array has not two elements year and month
          $month = $m; // Re Variable to now month m from general.php
          $year = $y; // Re Variable to now year y from general.php
        }
      } else { // if there is not date in GET
        $month = $m; // Re Variable to now month m from general.php
        $year = $y; // Re Variable to now year y from general.php
      }

      $id = $_GET['em'];
      $yandm = $year . "-" . $month;
      $stmt55 = $con->prepare("SELECT * FROM employee_salary WHERE `date` LIKE '$yandm%' AND `id` = '$id' ");
      $stmt55->execute();
      $count55 = $stmt55->rowCount();
      $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);
      if ($count55 > 0) {
        $n_salary = $row55['salary'];

        if ($n_salary >= 4120) {
          $main = 2060;
          $main2 = ($n_salary * 0.7) - $main;
          if (($main2 + $main) > 9400) {
            $main2 = 7340;
          }
          if ($n_salary >= 10000) {
            $loc_allow = ($n_salary - ($main + $main2)) * 0.1;
            $acco_allow = ($n_salary - ($main + $main2)) * 0.2;
            $cloth_allow = ($n_salary - ($main + $main2)) * 0.3;
            $other_allow = ($n_salary - ($main + $main2)) * 0.4;
          } else {
            $loc_allow = ($n_salary - ($main + $main2)) * 0.3;
            $acco_allow = ($n_salary - ($main + $main2)) * 0.3;
            $cloth_allow = ($n_salary - ($main + $main2)) * 0.4;
            $other_allow = 0;
          }
        } else {
          $main = $n_salary * 0.5;
          $main2 = ($n_salary * 0.7) - $main;

          if (($main2 + $main) < 1400) {
            $main2 = 1400 - $main;
          }

          $loc_allow = ($n_salary - ($main + $main2)) * 0.3;
          $acco_allow = ($n_salary - ($main + $main2)) * 0.3;
          $cloth_allow = ($n_salary - ($main + $main2)) * 0.4;
          $other_allow = 0;
        }

        $insure = ($main + $main2) * 0.11;
        $fellow = 0;

        $tax_compare = ((($main + $main2 + $other_allow) - $insure) * 12) - 24000;

        if ($tax_compare > 0) {
          if ($tax_compare <= 6000) {
            $tax = ($tax_compare / 12) * 0.025;
          }

          if ($tax_compare > 6000 & $tax_compare <= 21000) {
            $tax = (500 * 0.025) + ((($tax_compare - 6000) / 12) * 0.1);
          }

          if ($tax_compare > 21000 & $tax_compare <= 36000) {
            $tax = (500 * 0.025) + (1250 * 0.1) + ((($tax_compare - 21000) / 12) * 0.15);
          }

          if ($tax_compare > 36000 & $tax_compare <= 176000) {
            $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + ((($tax_compare - 36000) / 12) * 0.20);
          }

          if ($tax_compare > 176000 & $tax_compare <= 200000) {
            $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + ((($tax_compare - 176000) / 12) * 0.225);
          }

          if ($tax_compare > 200000) {
            $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225) + ((($tax_compare - 200000) / 12) * 0.25);
          }
        } else {
          $tax = 0;
        }


        $stmt477 = $con->prepare("SELECT * FROM attendance WHERE  `enter_in` LIKE '$yandm%' AND `duration` = '480' AND `id` = '$id' ");
        $stmt477->execute();
        $count477 = $stmt477->rowCount();
        $d = cal_days_in_month(0, date("m"), date("Y"));
        $holi_throw = $row55['holidays'];
        if ($row55['salary_vacation'] == 0) {
          $daying = 0;
        } else {
          $daying = $row55['salary_vacation'] * 30 / $row55['salary'];
        }
        $daysInMonth = cal_days_in_month(0, date('m'), date('Y'));
        if ($d == 31) {
          if ($count477 == (31 - $holi_throw)) {
            $count477 = 30 - $holi_throw;
          }
        } elseif ($d == 28) {
          if ($count477 == (28 - $holi_throw)) {
            $count477 = 30 - $holi_throw;
          }
        }

        $absence = (30 - $count477 - $holi_throw - $daying) * ($row55['salary'] / 30);

        $stmt43 = $con->prepare("SELECT * FROM `settings` WHERE `item` = 'working_hours'");
        $stmt43->execute();
        $count43 = $stmt43->rowCount();
        $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);
        $working_hours = $row43['value'];

        $stmt25 = $con->prepare("SELECT SUM(`overtime`) FROM `attendance` WHERE `id` = '$id' AND `enter_in` LIKE '$yandm%' ");
        $stmt25->execute();
        $count25 = $stmt25->rowCount();
        $row25 = $stmt25->fetch(PDO::FETCH_ASSOC);
        $overtime = (($row55['salary'] / 30) / $working_hours) * ($row25['SUM(`overtime`)'] / 60);

        $stmt25 = $con->prepare("SELECT SUM(`late`) FROM `attendance` WHERE `id` = '$id' AND `enter_in` LIKE '$yandm%' ");
        $stmt25->execute();
        $count25 = $stmt25->rowCount();
        $row25 = $stmt25->fetch(PDO::FETCH_ASSOC);
        $late = (($row55['salary'] / 30) / $working_hours) * ($row25['SUM(`late`)'] / 60);
      }
      $stmt26 = $con->prepare("SELECT * FROM `salary` WHERE `id` = '$id' AND `date` LIKE '$yandm%' ");
      $stmt26->execute();
      $count26 = $stmt26->rowCount();
      $row26 = $stmt26->fetch(PDO::FETCH_ASSOC);


      if ($count26 > 0) {
        $old_overtime = $row26['overtime'];
        $old_late = $row26['delay'];
        $old_absence = $row26['absence'];
        $old_main = $row26['main'];
        $old_main2 = $row26['main2'];
        $old_loc = $row26['loc_allow'];
        $old_acco = $row26['acco_allow'];
        $old_cloth = $row26['cloth_allow'];
        $old_other = $row26['other_allow'];
        $old_tax = $row26['tax'];
        $old_insure = $row26['insure'];
        $old_fellow = $row26['fellow'];
        $old_cash_advance = $row26['cash_advance'];
        $old_advance = $row26['advance'];
        $main_holidays = $row26['main_holidays'];

        $total = $old_main + $old_main2 + $old_loc + $old_acco + $old_cloth + $old_other + $overtime - $old_tax - $old_fellow - $old_insure - $absence - $late - $old_cash_advance - $old_advance + $main_holidays;

        if ($total < 0) {
          $total = 0;
        }

        if (strcmp($overtime, $old_overtime) == 0) {
          if (strcmp($late, $old_late) == 0) {
            if (strcmp($absence, $old_absence) == 0) {
            } else {
              $stmt10 = $con->prepare("UPDATE `salary` SET `total` = '$total',`delay` = '$late',`overtime` = '$overtime',`absence` = '$absence' WHERE `id` = '$id' AND `date` = '" . date('Y-m') . "' ");
              $stmt10->execute();
              header("location:attendance.php?em=$id&dt=$yandm");
              exit();
            }
          } else {
            $stmt10 = $con->prepare("UPDATE `salary` SET `total` = '$total',`delay` = '$late',`overtime` = '$overtime',`absence` = '$absence' WHERE `id` = '$id' AND `date` = '" . date('Y-m') . "' ");
            $stmt10->execute();
            header("location:attendance.php?em=$id&dt=$yandm");
            exit();
          }
        } else {
          $stmt10 = $con->prepare("UPDATE `salary` SET `total` = '$total',`delay` = '$late',`overtime` = '$overtime',`absence` = '$absence' WHERE `id` = '$id' AND `date` = '" . date('Y-m') . "' ");
          $stmt10->execute();
          header("location:attendance.php?em=$id&dt=$yandm");
          exit();
        }
      }
    }
  }
}


function get_all_payroll()
{
  global $con;
  date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
  $date = strtotime(date("Y-m-d")); // Get timestamp for the date
  $day = date('d', $date); // Get actual day
  $m = date('m', $date); // Get actual month
  $y = date('Y', $date); // Get actual year
  if (isset($_POST['dt'])) { // if there is date in GET
    $dt = $_POST['dt']; // Variable date on GET to dt
    $dt_array = explode("-", $dt); // Explode string to date array 0 year 1 month
    if (count($dt_array) == 2) { // if the array has two elements year and month
      $year = $dt_array[0]; // Variable year
      $month = $dt_array[1]; // Variable month
      if (!is_numeric($month) or !is_numeric($year)) { // if year and month are not numbers
        $month = $m; // Re Variable to now month m from general.php
        $year = $y; // Re Variable to now year y from general.php
      } else { // if year and month are numbers
        if ($month > 12 || $year > $y) { // Check if month more than 12 or year more than current year
          $month = $m; // Re Variable to now month m from general.php
          $year = $y; // Re Variable to now year y from general.php
        }
      }
    } else { // if the array has not two elements year and month
      $month = $m; // Re Variable to now month m from general.php
      $year = $y; // Re Variable to now year y from general.php
    }
  } else { // if there is not date in GET
    $month = $m; // Re Variable to now month m from general.php
    $year = $y; // Re Variable to now year y from general.php
  }
  $date = $year . "-" . $month;

  $stmt2 = $con->prepare("SELECT * FROM `categories` ");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  $stmt3 = $con->prepare("SELECT * FROM `job_titles` ");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  $row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
  $job_t_array = [];
  $cat_t_array = [];
  foreach ($row3 as $jt) {
    $job_t_array[] = $jt['id'];
  }
  foreach ($row2 as $dp) {
    $cat_t_array[] = $dp['id'];
  }
  $job_title = implode(",", $job_t_array);
  $departement = implode(",", $cat_t_array);
  if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt24 = $con->prepare("SELECT id FROM `salary` WHERE  `name` LIKE  '$name%' AND category in ($departement) AND job_title in ($job_title) ");
    $stmt24->execute();
    $count24 = $stmt24->rowCount();
    $row24 = $stmt24->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $stmt24 = $con->prepare("SELECT id FROM `salary` WHERE  category in ('$departement') AND job_title in ('$job_title') ");
    $stmt24->execute();
    $count24 = $stmt24->rowCount();
    $row24 = $stmt24->fetchAll(PDO::FETCH_ASSOC);
  }

  if ($count24 > 0) {
    $ids = [];

    foreach ($row24 as $idi) {
      $ids[] = $idi['id'];
    }

    $ids_arr = implode(",", $ids);
    $stmt9 = $con->prepare("SELECT * FROM `salary` WHERE  `date` = '$date'  ");
    $stmt9->execute();
    $count9 = $stmt9->rowCount();
    echo '<div class="payroll-table-body">';
    if ($count9 > 0) {
      while ($row9 = $stmt9->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row9 as $res) {
          echo '<div class="payroll-row">
            
        <div>' . @$res['id'] . '</div>';
          @$stmt26 = $con->prepare("SELECT * FROM `categories` WHERE  `id` = '" . $res['category'] . "' ");
          $stmt26->execute();
          $count26 = $stmt26->rowCount();
          $row26 = $stmt26->fetch(PDO::FETCH_ASSOC);
          @$stmt27 = $con->prepare("SELECT * FROM `job_titles` WHERE  `id` = '" . $res['job_title'] . "' ");
          $stmt27->execute();
          $count27 = $stmt27->rowCount();
          $row27 = $stmt27->fetch(PDO::FETCH_ASSOC);
          @$stmt25 = $con->prepare("SELECT * FROM `users` WHERE  `id` = '" . $res['id'] . "' ");
          $stmt25->execute();
          $count25 = $stmt25->rowCount();
          if ($count25 > 0) {
            $del = '';
          } else {
            $del = 'deleted disable_a';
          }
          echo '<div><a class="' . $del . ' hv_under" href="../employee/contract.php?uid=' . $res["id"] . '&dt=' . $date . '">' . @$res['name'] . '</a></div>
        <div>' . @$row26['name'] . '</div>
        <div>' . @$row27['name'] . '</div>';
          echo '<div>' . number_format($res['salary'], 2) . '</div>
        <div>' . number_format($res['overtime'], 2) . '</div>

        <div>
          <div class="l-div">
          <div class="li-div">' . number_format($res['insure'], 2) . '</div>
            <div class="li-div">' . number_format($res['tax'], 2) . '</div>
            <div class="li-div">' . number_format($res['advance'] + $res['cash_advance'], 2) . '</div>
            <div class="li-div">' . number_format($res['absence'], 2) . '</div>
            <div class="li-div">' . number_format($res['delay'], 2) . '</div>

          </div>
        </div>
        <div>' . number_format($res['insure'] + $res['fellow'] + $res['tax'] + $res['advance'] + $res['cash_advance'] + $res['absence'] + $res['delay'] + $res['penality'], 2) . '</div>
        <div>' . number_format($res['total'], 2) . '</div>
      </div>';
        }
      }
    } else {
      echo '<div class="no-result">No results</div>';
    }
    echo '</div>';

    // AND `id` in ($ids_arr)
    $stmt55 = $con->prepare("SELECT SUM(salary) FROM `salary` WHERE  `date` = '$date' ");
    $stmt55->execute();
    $count55 = $stmt55->rowCount();
    $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);
    $stmt56 = $con->prepare("SELECT SUM(overtime) FROM `salary` WHERE  `date` = '$date' ");
    $stmt56->execute();
    $count56 = $stmt56->rowCount();
    $row56 = $stmt56->fetch(PDO::FETCH_ASSOC);
    $stmt57 = $con->prepare("SELECT SUM(insure) FROM `salary` WHERE  `date` = '$date' ");
    $stmt57->execute();
    $count57 = $stmt57->rowCount();
    $row57 = $stmt57->fetch(PDO::FETCH_ASSOC);
    $stmt58 = $con->prepare("SELECT SUM(tax) FROM `salary` WHERE  `date` = '$date' ");
    $stmt58->execute();
    $count58 = $stmt58->rowCount();
    $row58 = $stmt58->fetch(PDO::FETCH_ASSOC);
    $stmt59 = $con->prepare("SELECT SUM(advance) FROM `salary` WHERE  `date` = '$date' ");
    $stmt59->execute();
    $count59 = $stmt59->rowCount();
    $row59 = $stmt59->fetch(PDO::FETCH_ASSOC);
    $stmt60 = $con->prepare("SELECT SUM(cash_advance) FROM `salary` WHERE  `date` = '$date' ");
    $stmt60->execute();
    $count60 = $stmt60->rowCount();
    $row60 = $stmt60->fetch(PDO::FETCH_ASSOC);
    $stmt61 = $con->prepare("SELECT SUM(absence) FROM `salary` WHERE  `date` = '$date' ");
    $stmt61->execute();
    $count61 = $stmt61->rowCount();
    $row61 = $stmt61->fetch(PDO::FETCH_ASSOC);
    $stmt62 = $con->prepare("SELECT SUM(delay) FROM `salary` WHERE  `date` = '$date' ");
    $stmt62->execute();
    $count62 = $stmt62->rowCount();
    $row62 = $stmt62->fetch(PDO::FETCH_ASSOC);
    $stmt63 = $con->prepare("SELECT SUM(penality) FROM `salary` WHERE  `date` = '$date' ");
    $stmt63->execute();
    $count63 = $stmt63->rowCount();
    $row63 = $stmt63->fetch(PDO::FETCH_ASSOC);
    $stmt64 = $con->prepare("SELECT SUM(total) FROM `salary` WHERE  `date` = '$date' ");
    $stmt64->execute();
    $count64 = $stmt64->rowCount();
    $row64 = $stmt64->fetch(PDO::FETCH_ASSOC);
    $stmt65 = $con->prepare("SELECT SUM(fellow) FROM `salary` WHERE  `date` = '$date' ");
    $stmt65->execute();
    $count65 = $stmt65->rowCount();
    $row65 = $stmt65->fetch(PDO::FETCH_ASSOC);

    echo '<div class="payroll-table-foot">
  <div class="payroll-row">
    <div>Total</div>
    <div>' . number_format($row55['SUM(salary)'], 2) . '</div>
    <div>' . number_format($row56['SUM(overtime)'], 2) . '</div>
    <div>
      <div class="l-div">
        <div class="li-div">' . number_format($row57['SUM(insure)'], 2) . '</div>
        <div class="li-div">' . number_format($row58['SUM(tax)'], 2) . '</div>
        <div class="li-div">' . number_format($row59['SUM(advance)'] + $row60['SUM(cash_advance)'], 2) . '</div>
        <div class="li-div">' . number_format($row61['SUM(absence)'], 2) . '</div>
        <div class="li-div">' . number_format($row62['SUM(delay)'], 2) . '</div>

      </div>
    </div>
    <div>' . number_format($row57['SUM(insure)'] + $row58['SUM(tax)'] + $row59['SUM(advance)'] + $row60['SUM(cash_advance)'] + $row61['SUM(absence)'] + $row62['SUM(delay)'] + $row63['SUM(penality)'] + $row65['SUM(fellow)'], 2) . '</div>
    <div>' . number_format($row64['SUM(total)'], 2) . '</div>
  </div>
  
  </div>';
  } else {
    echo '<div class="no-result">No results</div>';
  }
}

function get_advance()
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $id = $_GET['uid'];
      $stmt20 = $con->prepare("SELECT * FROM `advance` WHERE `user_id` = '$id' ORDER BY id DESC");
      $stmt20->execute();
      $count20 = $stmt20->rowCount();
      if ($count20 > 0) {
        while ($row20 = $stmt20->fetchAll(PDO::FETCH_ASSOC)) {
          foreach ($row20 as $advance) {
            echo '<div class="advance-row ';
            if ($advance['approved'] == 1) {
              if ($advance['remain'] != 0) {
                echo "ongoing";
              }
            }
            echo '">
          <div>' . number_format($advance['amount']) . ' EGP</div>
          <div>' . number_format($advance['insta']) . ' EGP</div>
          <div>' . number_format($advance['paid']) . ' EGP</div>
          <div>' . number_format($advance['remain']) . ' EGP</div>

          <div>' . $advance['start_date'] . '</div>
          <div>' . $advance['end_date'] . '</div>
          <div>' . $advance['duration'] . ' Months</div>';
            if ($advance['approved'] == 1) {
              if ($advance['remain'] == 0) {
                $status = "Completed";
                $clr = "green";
                $i = '<i class="fa-solid fa-check"></i>';
              } elseif ($advance['remain'] != 0) {
                $status = "Ongoing";
                $clr = "";
                $i = '<i class="fa-solid fa-spinner"></i>';
              }
            } elseif ($advance['approved'] == -1) {
              $status = "Rejected";
              $clr = "red";
              $i = '<i class="fa-solid fa-xmark"></i>';
            } elseif ($advance['approved'] == 0) {
              $status = "Pending";
              $clr = "";
              $i = '<i class="fa-solid fa-grip-lines"></i>';
            }
            echo '<div class="' . $clr . '">
            ' . $i . '
            &nbsp;&nbsp;&nbsp;
            ' . $status . '
          </div>
          <div>';
            if (check_user_role(1) == 1 || check_user_role(18) == 1 || check_user_role(23) == 1) {
              if ($advance['approved'] == 0) {
                echo '<a href="index.php?uid=' . $_GET['uid'] . '&ad_id=' . $advance['id'] . '&status=1" class="agree"><i class="fa-solid fa-circle-check"></i></a>';
                echo '<a href="index.php?uid=' . $_GET['uid'] . '&ad_id=' . $advance['id'] . '&status=-1" class="reject"><i class="fa-solid fa-circle-xmark"></i></a>';
              }
            }
            echo '</div>
        </div>';
          }
        }
      } else {
        echo "<div class='no-result'>No Results</div>";
      }
    }
  }
}

function request_advance($id)
{
  global $con;

  $error_mg = "";
  if (isset($_POST['request'])) {
    if (!empty($_POST['request'])) {
      if (isset($_POST['amount']) && isset($_POST['duration'])) {
        if (!empty($_POST['amount']) && !empty($_POST['duration'])) {
          $amount = $_POST['amount'];
          $duration = $_POST['duration'];
          $insta = $amount / $duration;
          $start = date("Y-m");
          $end = date('Y-m', strtotime("+$duration months", strtotime($start)));


          $stmt2 = $con->prepare("SELECT SUM(insta) FROM `advance` WHERE  `user_id` = '$id' AND `remain` != '0' AND approved = '1' ");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $stmt3 = $con->prepare("SELECT * FROM `salary` WHERE  `id` = '$id' AND `date` = '$start'");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $salary = $row3['salary'];
          $insta_ongoing = $row2['SUM(insta)'];

          if (($insta_ongoing + $insta) < ($salary * 0.5)) {
            if ($duration >= 1) {
              if ($amount >= 1) {
                $stmt4 = $con->prepare("INSERT INTO `advance`(`user_id`, `amount`,`paid`,`remain`,`insta`,`duration`,`start_date`,`end_date`,`approved`,`created_date`) VALUES ('$id','$amount','0','$amount','$insta','$duration','$start','$end','0','$start')");
                $stmt4->execute(); // Insert attendance for id = POST em


                $urid = $_COOKIE['urid'];
                $urid_array = explode("-", $urid);
                $sessionid = $urid_array[0];
                $nowdate = date("Y-m-d H:i:s");
                $stmt255 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Request new Advance Payment','Advance','$nowdate')");
                $stmt255->execute(); // Insert to Logs

                header("location:index.php?uid=$id");
                exit();
              } else {
                $error_mg = "Min. amount is 1 EGP";
                return $error_mg;
              }
            } else {
              $error_mg = "Min. duration is 1 month";
              return $error_mg;
            }
          } else {
            $error_mg = "Current installment will be more than 50% of your salary";
            return $error_mg;
          }
        } else {
          $error_mg = "Fields can't be empty";
          return $error_mg;
        }
      }
    }
  }
}

function change_request_advance()
{
  global $con;

  if (isset($_GET['uid']) && isset($_GET['ad_id']) && isset($_GET['status'])) {
    $id = $_GET['uid'];
    $ad_id = $_GET['ad_id'];
    $status = $_GET['status'];
    $date = date("Y-m");
    $stmt2 = $con->prepare("SELECT * FROM `advance` WHERE `user_id` = '$id' AND `id` =  $ad_id AND `approved` = '0'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($count2 > 0) {
      if ($status == -1) {
        $stmt10 = $con->prepare("UPDATE `advance` SET `approved` = '-1' WHERE `user_id` = '$id' AND `id` =  $ad_id");
        $stmt10->execute();

        $urid = $_COOKIE['urid'];
        $urid_array = explode("-", $urid);
        $sessionid = $urid_array[0];
        $nowdate = date("Y-m-d H:i:s");
        $stmt255 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Reject Advance Payment for employee #$id','Advance','$nowdate')");
        $stmt255->execute(); // Insert to Logs


        header("location:index.php?uid=$id");
        exit();
      } elseif ($status == 1) {
        $stmt4 = $con->prepare("SELECT SUM(insta) FROM `advance` WHERE  `user_id` = '$id' AND `remain` != '0' AND approved = '1' ");
        $stmt4->execute();
        $count4 = $stmt4->rowCount();
        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
        $stmt3 = $con->prepare("SELECT * FROM `salary` WHERE  `id` = '$id' AND `date` = '$date'");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        $salary = $row3['salary'];
        $insta_ongoing = $row4['SUM(insta)'];
        $old_cash_advance = $row3['cash_advance'];
        $old_advance = $row3['advance'];
        $old_total = $row3['total'];

        if ($insta_ongoing + $row2['insta'] < ($salary * 0.5)) {
          if ($row2['duration'] == '1') {
            $insta = $old_cash_advance + $row2['insta'];
            $total = $old_total - $row2['insta'];
            if ($total < 0) {
              $error_mg = "Can't Approve for this advance,Net Salary will be in a negative value";
              return $error_mg;
            } else {
              $stmt10 = $con->prepare("UPDATE `advance` SET `approved` = '1', `remain` = '" . $row2['remain'] - $row2['insta'] . "', `paid` = '" . $row2['insta'] . "' WHERE `user_id` = '$id' AND `id` =  $ad_id");
              $stmt10->execute();
              $stmt11 = $con->prepare("UPDATE `salary` SET `cash_advance` = '$insta' , `total` = '$total' WHERE `id` = '$id' AND `date` =  '$date'");
              $stmt11->execute();
              $urid = $_COOKIE['urid'];
              $urid_array = explode("-", $urid);
              $sessionid = $urid_array[0];
              $nowdate = date("Y-m-d H:i:s");
              $stmt255 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Approved Advance Payment for employee #$id','Advance','$nowdate')");
              $stmt255->execute(); // Insert to Logs
            }
          } else {
            $insta = $old_advance + $row2['insta'];
            $total = $old_total - $row2['insta'];
            if ($total < 0) {
              $error_mg = "Can't Approve for this advance,Net Salary will be in a negative value";
              return $error_mg;
            } else {
              $stmt10 = $con->prepare("UPDATE `advance` SET `approved` = '1', `remain` = '" . $row2['remain'] - $row2['insta'] . "', `paid` = '" . $row2['insta'] . "' WHERE `user_id` = '$id' AND `id` =  $ad_id");
              $stmt10->execute();
              $stmt11 = $con->prepare("UPDATE `salary` SET `advance` = '$insta' , `total` = '$total' WHERE `id` = '$id' AND `date` =  '$date'");
              $stmt11->execute();
              $urid = $_COOKIE['urid'];
              $urid_array = explode("-", $urid);
              $sessionid = $urid_array[0];
              $nowdate = date("Y-m-d H:i:s");
              $stmt255 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Approved Advance Payment for employee #$id','Advance','$nowdate')");
              $stmt255->execute(); // Insert to Logs
            }
          }


          header("location:index.php?uid=$id");
          exit();
        } else {
          $error_mg = "Current installment will be more than 50% of your salary";
          return $error_mg;
        }
      }
    }
  }
}

function get_salary_summary()
{
  global $con;
  $total_net = 0;
  $total_gross = 0;
  $total_tax = 0;
  $total_insure = 0;
  $stmt20 = $con->prepare("SELECT SUM(total) FROM `salary` WHERE `date` = '" . date('Y-m') . "'");
  $stmt20->execute();
  $count20 = $stmt20->rowCount();
  $row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
  if ($count20 > 0) {
    $total_net = number_format(round($row20['SUM(total)'], 2), 2);
  }
  $stmt21 = $con->prepare("SELECT SUM(salary) FROM `salary` WHERE `date` = '" . date('Y-m') . "'");
  $stmt21->execute();
  $count21 = $stmt21->rowCount();
  $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
  if ($count21 > 0) {
    $total_gross = number_format(round($row21['SUM(salary)'], 2), 2);
  }
  $stmt22 = $con->prepare("SELECT SUM(insure) FROM `salary` WHERE `date` = '" . date('Y-m') . "'");
  $stmt22->execute();
  $count22 = $stmt22->rowCount();
  $row22 = $stmt22->fetch(PDO::FETCH_ASSOC);
  $stmt23 = $con->prepare("SELECT SUM(tax) FROM `salary` WHERE `date` = '" . date('Y-m') . "'");
  $stmt23->execute();
  $count23 = $stmt23->rowCount();
  $row23 = $stmt23->fetch(PDO::FETCH_ASSOC);
  $total_tax = number_format(round($row23['SUM(tax)'], 2), 2);
  $total_insure = number_format(round($row22['SUM(insure)'], 2), 2);

  echo '<div class="sum-salary">
          <h6 style="color:#36a592;">Total Gross Salary</h6>
          <span>' . $total_gross . '</span>
        </div>
        <div class="sum-salary">
          <h6 style="color:#e41970;">Total Insurances</h6>
          <span>' . $total_insure . '</span>
        </div>
        <div class="sum-salary">
          <h6 style="color:#f37434;">Total Tax</h6>
          <span>' . $total_tax . '</span>
        </div>
        <div class="sum-salary">
          <h6 style="color:#b900f6;">Total Net Salary</h6>
          <span>' . $total_net . '</span>
        </div>';
}

function get_role_summary()
{
  global $con;
  $total_overtime = 0;
  $total_delay = 0;
  $overtime_days = 0;
  $delay_days = 0;
  $daty = date("Y-m");
  $stmt10 = $con->prepare("SELECT SUM(overtime) FROM `attendance` WHERE `enter_in` LIKE '$daty%'");
  $stmt10->execute();
  $count10 = $stmt10->rowCount();
  $row10 = $stmt10->fetch(PDO::FETCH_ASSOC);
  $stmt12 = $con->prepare("SELECT * FROM `attendance` WHERE `overtime` != '0' AND `enter_in` LIKE '$daty%'");
  $stmt12->execute();
  $count12 = $stmt12->rowCount();
  if ($count10 > 0) {
    $total_overtime = round($row10['SUM(overtime)']);
    $overtime_days = $count12;
  }
  $stmt11 = $con->prepare("SELECT SUM(late) FROM `attendance` WHERE `enter_in` LIKE '$daty%'");
  $stmt11->execute();
  $count11 = $stmt11->rowCount();
  $row11 = $stmt11->fetch(PDO::FETCH_ASSOC);
  $stmt13 = $con->prepare("SELECT * FROM `attendance` WHERE `late` != '0' AND `enter_in` LIKE '$daty%'");
  $stmt13->execute();
  $count13 = $stmt13->rowCount();
  if ($count11 > 0) {
    $total_delay = round($row11['SUM(late)']);
    $delay_days = $count13;
  }
  echo '<div class="sum-att-role">
      <h5>' . $total_overtime . ' <span>Minutes</span></h5>
      <p>Total Overtime</p>
      <span>' . $overtime_days . ' days</span>
      </div>
      <div class="sum-att-role">
      <h5>' . $total_delay . ' <span>Minutes</span></h5>
      <p>Total Delay Time</p>
      <span>' . $delay_days . ' days</span>
      </div>';
}

function get_main_holidays()
{
  global $con;
  $stmt10 = $con->prepare("SELECT * FROM `main_holidays`");
  $stmt10->execute();
  $count10 = $stmt10->rowCount();
  $slog = "";
  $colors = [
    "#36a592",
    "#e41970",
    "#C19A6B",
    "#b900f6",
    "#f37434",
    "#088F8F",
    "#0047AB",
    "#800020",
    "#988558",
    "#808000",
    "#483C32",
    "#7393B3",
    "#097969",
    "#5F8575",
    "#8B4000",
    "#CC7722",
    "#9F2B68",
    "#673147",
    "#301934",
    "#702963",
    "#722F37",
    "#C41E3A",
    "#E0115F",
    "#8B8000",
    "#CC5500",
    "#7F00FF",
    "#C04000",
    "#40826D",
    "#008080",
    "#2AAA8A",
    "#7C3030",
    "#722F37",
    "#966919",
    "#A95C68",
    "#A0522D",
    "#0818A8",
    "#0F52BA",
    "#00A36C",
    "#0096FF",
    "#023020",
    "#7393B3",
    "#0F52BA",
  ];

  if ($count10 > 0) {
    while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row10 as $main) {
        $rand_keys = array_rand($colors, 2);
        $slog .= "{title: '" . $main['title'] . "',description:'" . $main['des'] . "',start: '" . $main['start'] . "',end: '" . date('Y-m-d', strtotime($main['end'] . ' + 1 day')) . "',backgroundColor:'" . $colors[$rand_keys[0]] . "',borderColor:'transparent',display:'block',droppable: false,defaultAllDay:false},";
      }
    }
  }
  echo $slog;
}

function add_main_holidays()
{
  global $con;
  if (isset($_POST['create'])) {
    if (!empty($_POST['create'])) {
      if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end'])) {
        if (!empty($_POST['title']) && !empty($_POST['start']) && !empty($_POST['end'])) {
          $title = $_POST['title'];
          $start = $_POST['start'];
          $end = $_POST['end'];
          $comment = "";
          if (isset($_POST['des'])) {
            if (!empty($_POST['des'])) {
              $comment = $_POST['des'];
            }
          }

          $start_time = strtotime($start);
          $end_time = strtotime($end);
          $datediff = $end_time - $start_time;
          $diff = (round($datediff / (60 * 60 * 24)) + 1);
          $stmt47 = $con->prepare("SELECT `value` FROM settings WHERE item = 'holidays'");
          $stmt47->execute();
          $row47 = $stmt47->fetch(PDO::FETCH_ASSOC);
          $holidays = explode("-", $row47['value']);

          $ns = 0;

          for ($t = 0; $t < $diff; $t++) {
            $daty = date_create($start);
            date_add($daty, date_interval_create_from_date_string("$t days"));
            $comp = date_format($daty, "Y-m-d");


            $newDate = date('l', strtotime($comp));

            if (in_array($newDate, $holidays)) {
              $ns++;
            }
          }


          $final_diff = $diff - $ns;
          $stmt3 = $con->prepare("INSERT INTO `main_holidays` (`title`,`des`,`start`,`end`,`duration`,`passed`,`calc`) VALUES ('$title','$comment','$start','$end','$final_diff','0','0')");
          $stmt3->execute(); // Insert attendance for id = POST em
          header("location:calendar.php");
          exit();
        } else {
          $error_mg = "All Required fields must be filled";
          return $error_mg;
        }
      }
    }
  }
}

function redirect_main_holidays()
{
  global $con;
  $start_date = date("Y") . "-01-01";
  $end_date = date("Y-m-d");
  $stmt10 = $con->prepare("SELECT * FROM `main_holidays` WHERE `passed` = '0' AND `end` BETWEEN '$start_date' AND '$end_date'");
  $stmt10->execute();
  $count10 = $stmt10->rowCount();
  while ($row10 = $stmt10->fetchAll(PDO::FETCH_ASSOC)) {
    if ($count10 > 0) {
      foreach ($row10 as $holiday) {
        $end = substr($holiday['end'], 0, 7);
        $stmt11 = $con->prepare("SELECT * FROM `salary` WHERE `date` = '$end' ");
        $stmt11->execute();
        $count11 = $stmt11->rowCount();
        while ($row11 = $stmt11->fetchAll(PDO::FETCH_ASSOC)) {
          if ($count11 > 0) {
            foreach ($row11 as $user) {
              $holi_id = $holiday['id'];
              $user_id = $user['id'];
              $added = (($user['salary'] / 30) * $holiday['duration']);
              $old_total = $user['main_holidays'];
              $new_total = $added + $old_total;
              $stmt12 = $con->prepare("UPDATE `main_holidays` SET  `passed` = '1' WHERE `id` = '$holi_id' ");
              $stmt12->execute(); // Update salary in salary_employee
              $stmt13 = $con->prepare("UPDATE `salary` SET  `main_holidays` = '$new_total' WHERE `id` = '$user_id' AND `date` = '$end'");
              $stmt13->execute(); // Update salary in salary_employee
            }
          }
        }
      }
    }
  }
}



// New

function get_customers()
{
  global $con;
  global $functions_route;
  global $css_route;
  global $image_route;
  global $js_route;
  $num_per_page = 12;
  $stmt60 = $con->prepare("SELECT * FROM `customers`");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }

  $start_from = ($page - 1) * $num_per_page;
  $stmt = $con->prepare("SELECT * FROM `customers` LIMIT $start_from,$num_per_page");
  $stmt->execute();
  $count = $stmt->rowCount();
  $i = 1;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $customer) {
        if (empty($customer['mobile'])) {
          $phone = $customer['phone'];
        } else {
          $phone = $customer['mobile'];
        }
        echo "
      <a href='customerdetails.php?cust-id=" . $customer['id'] . "' class='request-row'>
      <div><input type='checkbox' class='delete-bx' name='delete[]' value='" . $customer['id'] . "'></div>
      <div>" . $i . "</div>
          <div class='flex fx-start'>";
        if ($customer['is_company'] == 0) {
          echo "<div class='img-frame'><img src='../images/ur-img/profile3.png' alt=''></div>
            <div class='info'>
              <div class='name'>" . $customer['first_name'] . " " . $customer['middle_name'] . " " . $customer['last_name'] . "</div>
              <div class='profission'>" . $customer['company_name'] . "</div>
            </div>";
        } else {
          echo "<div class='img-frame'><img src='../images/ur-img/company3.png' alt=''></div>
            <div class='info'>
              <div class='name'>" . $customer['company_name'] . "</div>
            </div>";
        }
        echo "</div>
        <div>" . $customer['city'] . ", " . $customer['country'] . "</div>
        <div>" . $phone . "</div>
        <div>" . $customer['email'] . "</div>
        <div>E£ " . $customer['open_balance'] . "</div>
        <div><button>Create Invoice</button></div>
    </a>";
        $i++;
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function get_suppliers()
{
  global $con;
  global $functions_route;
  global $css_route;
  global $image_route;
  global $js_route;
  $num_per_page = 12;
  $stmt60 = $con->prepare("SELECT * FROM `suppliers`");
  $stmt60->execute();
  $total_records = $stmt60->rowCount();
  $total_pages = ceil($total_records / $num_per_page);
  if (isset($_GET["page"]) & !empty($_GET['page'])) {
    if (is_numeric($_GET["page"])) {
      if ($_GET['page'] <= $total_pages & $_GET['page'] > 0) {
        $page = ceil($_GET['page']);
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
  } else {
    $page = 1;
  }

  $start_from = ($page - 1) * $num_per_page;
  $stmt = $con->prepare("SELECT * FROM `suppliers` LIMIT $start_from,$num_per_page");
  $stmt->execute();
  $count = $stmt->rowCount();
  $i = 1;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $customer) {
        if (empty($customer['mobile'])) {
          $phone = $customer['phone'];
        } else {
          $phone = $customer['mobile'];
        }
        echo "
      <a href='supplierdetails.php?uid=" . $customer['id'] . "' class='request-row'>
      <div><input type='checkbox' class='delete-bx' name='delete[]' value='" . $customer['id'] . "'></div>
      <div>" . $i . "</div>
          <div class='flex fx-start'>";
        if ($customer['is_company'] == 0) {
          echo "<div class='img-frame'><img src='../images/ur-img/profile3.png' alt=''></div>
            <div class='info'>
              <div class='name'>" . $customer['first_name'] . " " . $customer['middle_name'] . " " . $customer['last_name'] . "</div>
              <div class='profission'>" . $customer['company_name'] . "</div>
            </div>";
        } else {
          echo "<div class='img-frame'><img src='../images/ur-img/company3.png' alt=''></div>
            <div class='info'>
              <div class='name'>" . $customer['company_name'] . "</div>
            </div>";
        }
        echo "</div>
        <div>" . $customer['city'] . ", " . $customer['country'] . "</div>
        <div>" . $phone . "</div>
        <div>" . $customer['email'] . "</div>
        <div>E£ " . $customer['open_balance'] . "</div>
        <div><button>Purchase Order</button></div>
    </a>";
        $i++;
      }
    }
  } else {
    echo "<div class='request-row'><div class='empty-result'>There is no results</div></tr>";
  }
}

function check_id($r)
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `$r` WHERE `id` = '$uid'");
      $stmt->execute();
      $id_check = $stmt->rowCount();
      if ($id_check > 0) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }
}
function check_sku()
{
  global $con;
  if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$uid'");
      $stmt->execute();
      $id_check = $stmt->rowCount();
      if ($id_check > 0) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }
}
function info($r) // GET array user info
{
  global $con; // Global connection with database
  // $id = $_SESSION['id']; // id = SESSION
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT * FROM `$r` WHERE id = '$id' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  $info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  return $info;
}
function sku_info() // GET array user info
{
  global $con; // Global connection with database
  // $id = $_SESSION['id']; // id = SESSION
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$id' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  $info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  return $info;
}

function get_supplier_order_number()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT MAX(order_id) FROM `supplier_orders`");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  if (!empty($result['MAX(order_id)'])) {
    $result['MAX(order_id)'] += 1;
    return $result['MAX(order_id)'];
  } else {
    return 1;
  }
}
function get_sell_order_number()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT MAX(order_id) FROM `sell_orders`");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  if (!empty($result['MAX(order_id)'])) {
    $result['MAX(order_id)'] += 1;
    return $result['MAX(order_id)'];
  } else {
    return 1;
  }
}
function get_manufacturer_order_number()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT MAX(order_id) FROM `manufacturer_orders`");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  if (!empty($result['MAX(order_id)'])) {
    $result['MAX(order_id)'] += 1;
    return $result['MAX(order_id)'];
  } else {
    return 1;
  }
}


function import_supplier_purchase()
{
  global $con;
  if (
    isset($_POST["p"]) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['terms']) &&
    isset($_POST['payment_m']) &&
    isset($_POST['cdate']) &&
    isset($_POST['subtotal']) &&
    isset($_POST['due_balance']) &&
    isset($_POST['total']) &&
    isset($_POST['save_order_purchase']) &&
    isset($_POST['inv_number']) &&

    !empty($_POST["p"]) &&
    !empty($_POST["supplier_id"]) &&
    !empty($_POST["terms"]) &&
    !empty($_POST["payment_m"]) &&
    !empty($_POST["cdate"]) &&
    !empty($_POST["subtotal"]) &&
    !empty($_POST["total"]) &&
    !empty($_POST['inv_number'])
  ) {
    if (isset($_POST['withholding']) && !empty($_POST['withholding'])) {
      $withholding = $_POST['withholding'];
    } else {
      $withholding = 0;
    }

    $supplier_id = trim($_POST['supplier_id']);
    $terms = trim($_POST['terms']);
    $payment_m = $_POST['payment_m'];
    $dateString = $_POST['cdate'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $total = round($_POST['total'], 2);
    $due_balance = round($_POST['due_balance'], 2);
    $order_id = trim($_POST['inv_number']);
    $stmt88 = $con->prepare("SELECT * FROM `supplier_orders` WHERE `order_id` = '$order_id'");
    $stmt88->execute();
    $count88 = $stmt88->rowCount();
    if ($count88 <= 0) {

      if (isset($_POST['discount'])) {
        $discount = $_POST['discount'];
      } else {
        $discount = 0;
      }
      if ($payment_m == "cash") {
        $bank_name = "";
        $bank_number = "";
      } else {
        $bank_number = $_POST['bank_number'];
        $bank_name = $_POST['bank'];
      }
      if (isset($_POST['vat'])) {
        $vat_perc = $_POST['vat'];
      } else {
        $vat_perc = 0;
      }
      if (isset($_POST['vat_amount'])) {
        $vat_amount = round($_POST['vat_amount'], 2);
      } else {
        $vat_amount = 0;
      }
      $subtotal = $_POST['subtotal'];
      $type = "Purchase Order";
      $warehouse = "";
      $storable = 0;
      $received = 0;
      $due_to = "";
      $status = "";
      if (isset($_POST["received"])) {
        $received = 1;
        if (isset($_POST['statement']) && !empty($_POST['statement'])) {
          $statement = trim($_POST['statement']);
        } else {
          $statement = "";
        }
        if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
          $paid = $_POST['paid'];
          $stmt3 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $balance = $sum + $total;
            $new_balance = $balance - $paid;
          } else {
            $balance = $total;
            $new_balance = $balance - $paid;
          }
          $stmt2 = $con->prepare("INSERT INTO supplier_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$total','$balance','$created_time','','','$statement','')");
          $stmt2->execute();
          $cash_statement = "اذن صرف دفعه مقدمه";
          $stmt3 = $con->prepare("INSERT INTO supplier_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$paid','0','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
          $stmt3->execute();
        } else {
          $paid = 0;
          $stmt3 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $balance = $sum + $total;
            $new_balance = $balance - $paid;
          } else {
            $balance = $total;
            $new_balance = $balance - $paid;
          }
          $stmt2 = $con->prepare("INSERT INTO supplier_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$total','$balance','$created_time','','','$statement','')");
          $stmt2->execute();
        }
      } else {
        $received = 0;
        if (isset($_POST['statement']) && !empty($_POST['statement'])) {
          $statement = trim($_POST['statement']);
        } else {
          $statement = "";
        }
        if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
          $paid = $_POST['paid'];
          $stmt3 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $balance = $sum;
            $new_balance = $balance - $paid;
          } else {
            $new_balance = -1 * $paid;
          }
          $cash_statement = "اذن صرف دفعه مقدمه";
          $stmt3 = $con->prepare("INSERT INTO supplier_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$paid','0','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
          $stmt3->execute();
        } else {
          $paid = 0;
        }
      }

      if ($paid == $total) {
        $status = "paid";
      } else {
        $status = "overdue";
      }
      if ($terms == "dueonreceipt") {
        if (isset($_POST["received"])) {
          if ($paid == $total) {
            $status = "paid";
          } else {
            $status = "overdue";
          }
        } else {
          if ($paid == $total) {
            $status = "paid";
          } else {
            $status = "due";
          }
        }
        $due_to = $created_time;
      } else {
        $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
        if ($paid == $total) {
          $status = "paid";
        } else {
          $status = "due";
        }
      }

      if (isset($_POST['storable'])) {
        if (isset($_POST['warehouse'])) {
          $storable = 1;
          $warehouse = $_POST['warehouse'];
        } else {
          $storable = 0;
          $warehouse = "";
        }
      } else {
        $storable = 0;
        $warehouse = "";
      }


      if ($_FILES['hardcopy']['error'] == 4) {
        $pdf_name = "";
      } else {
        $pdf_type = $_FILES['hardcopy']['type'];
        $pdf_temp = $_FILES['hardcopy']['tmp_name'];
        $pdf_size = $_FILES['hardcopy']['size'];
        $pdf_extension = @strtolower(end(explode('.', $_FILES['hardcopy']['name'])));
        $pdf_name = rand(0, 100000000000000) . "." . $pdf_extension;
        $allowed_extensions_pdf = [
          "pdf",
          "jpg",
          "jpeg",
          "png",
          "gif"
        ];

        if ($pdf_size > 10000000) {
          echo "pdf must be less than 10MB";
        } else if (!in_array($pdf_extension, $allowed_extensions_pdf)) {
          echo "File is not valid";
        } else {

          if (move_uploaded_file($pdf_temp, __DIR__ . "/../assets/order_purchases/" . $pdf_name)) {
            move_uploaded_file($pdf_temp, __DIR__ . "/../assets/order_purchases/" . $pdf_name);
          } else {
            echo "Upload image failed";
          }
        }
      }

      $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
        return
          !empty($row["id"]);
      }));

      $stmt = $con->prepare("INSERT INTO supplier_orders (`supplier_id`, `item_id`, `quantity`, `amount`, `total`, `order_id`, `created_time`, `status`, `due_to`, `description`, `balance_due`, `paid`, `storable`, `warehouse_id`, `order_total`, `type`, `received`, `hardcopy`,`vat_perc`,`vat_amount`,`subtotal`,`discount`,`withholding`,`payment_m`,`bank_name`,`bank_number`) VALUES (:supplier_id, :item_id, :item_quantity, :item_amount, :item_total, :order_id, :created_time, :status, :due_to, :item_desc, :due_balance, :paid, :storable, :warehouse, :total, :type, :received, :pdf_name,:vat_perc,:vat_amount,:subtotal,:discount,:withholding,:payment_m,:bank,:bank_number)");
      foreach ($filteredArray as $fa) {
        $item_id = $fa['id'];
        $item_quantity = $fa['quantity'];
        if ($item_quantity < 0) {
          $type = 'Return Order';
        }
        $item_amount = $fa['amount'];
        $item_total = $fa['total'];
        $item_desc = $fa['description'];
        $count_of_items = count($filteredArray);
        $item_total_vat_inc = $item_amount - ((($item_total / $subtotal) * $discount) / $item_quantity);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':item_quantity', $item_quantity);
        $stmt->bindParam(':item_amount', $item_amount);
        $stmt->bindParam(':item_total', $item_total);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':created_time', $created_time);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':due_to', $due_to);
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->bindParam(':due_balance', $due_balance);
        $stmt->bindParam(':paid', $paid);
        $stmt->bindParam(':storable', $storable);
        $stmt->bindParam(':warehouse', $warehouse);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':received', $received);
        $stmt->bindParam(':pdf_name', $pdf_name);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':vat_amount', $vat_amount);
        $stmt->bindParam(':vat_perc', $vat_perc);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':withholding', $withholding);
        $stmt->bindParam(':payment_m', $payment_m);
        $stmt->bindParam(':bank', $bank_name);
        $stmt->bindParam(':bank_number', $bank_number);
        $stmt->execute();

        if (isset($_POST["received"])) {
          $stmt3 = $con->prepare("SELECT * FROM `items` WHERE `code` = '$item_id'");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row3 as $item_info) {
                $item_name = $item_info['name'];
                $item_sku = "622" . substr($item_info['code'], 3, 4) . rand(10000, 99999);
                $item_unit = $item_info['unit'];
                $item_img = $item_info['img'];



                $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id'");
                $stmt4->execute();
                $count4 = $stmt4->rowCount();
                if ($count4 > 0) {
                  $hosted_quantity = 0;
                  while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                    foreach ($row4 as $avitem_info) {
                      $hosted_quantity += $avitem_info['quantity'];
                      $avitem_info_rate = $avitem_info['rate'];
                    }
                  }
                  $new_average_rate = (($hosted_quantity * $avitem_info_rate) + ($item_quantity * $item_total_vat_inc)) / ($hosted_quantity + $item_quantity);
                  $stmt5 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse'");
                  $stmt5->execute();
                  $count5 = $stmt5->rowCount();
                  if ($count5 > 0) {
                    // HERE
                    while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                      foreach ($row5 as $avitem_info_warehouse) {
                        $new_quantity =  $avitem_info_warehouse['quantity'] + $item_quantity;
                        $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                        $stmt6->execute();
                        $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse' ");
                        $stmt5->execute();
                      }
                    }
                  } else {
                    // HERE

                    $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                    $stmt6->execute();
                    $stmt77 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$new_average_rate','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                    $stmt77->execute();
                  }
                } else {
                  $stmt2 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_total_vat_inc','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                  $stmt2->execute();
                }
              }
            }
          }
        }
      }
    }
    header("location:supplierdetails.php?uid=$supplier_id");
    exit();
  }
}


function get_purchase_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT SUM(`credit` - `debit`) as `total_due` FROM `supplier_transactions` WHERE `supplier_id`='$id' LIMIT 1");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $due) {
        $total_due += $due['total_due'];
        echo number_format($total_due, 2, '.', ',');
      }
    }
  } else {
    echo "0.00";
  }
}
function get_sell_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT SUM(`credit` - `debit`) as `total_due` FROM `sell_transactions` WHERE `supplier_id`='$id' LIMIT 1");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $due) {
        $total_due += $due['total_due'];
        echo number_format($total_due, 2, '.', ',');
      }
    }
  } else {
    echo "0.00";
  }
}


function get_manufacturing_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT SUM(`credit` - `debit`) as `total_due` FROM `manufacturer_transactions` WHERE `supplier_id`='$id' LIMIT 1");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $due) {
        $total_due += $due['total_due'];
        echo number_format($total_due, 2, '.', ',');
      }
    }
  } else {
    echo "0.00";
  }
}
function get_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `supplier_orders` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        $total_due += $due['balance_due'];
      }
      echo number_format($total_due, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_selling_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `sell_orders` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        $total_due += $due['balance_due'];
      }
      echo number_format($total_due, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_manu_due()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `manufacturer_orders` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_due = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        $total_due += $due['balance_due'];
      }
      echo number_format($total_due, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_purchase_paid()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid` FROM `supplier_orders` WHERE `supplier_id` ='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_paid = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_paid += $paid['paid'];
      }
      echo number_format($total_paid, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_selling_paid()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid` FROM `sell_orders` WHERE `supplier_id` ='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_paid = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_paid += $paid['paid'];
      }
      echo number_format($total_paid, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}


function get_manufacturing_paid()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid` FROM `manufacturer_orders` WHERE `supplier_id` ='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_paid = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_paid += $paid['paid'];
      }
      echo number_format($total_paid, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_purchase_total()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid`,`order_total` FROM `supplier_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_total = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_total += $paid['order_total'];
      }
      echo number_format($total_total, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_sell_total()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid`,`order_total` FROM `sell_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_total = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_total += $paid['order_total'];
      }
      echo number_format($total_total, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_manufacturer_total()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status`,`paid`,`order_total` FROM `manufacturer_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_total = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $paid) {
        $total_total += $paid['order_total'];
      }
      echo number_format($total_total, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_purchase_overdue()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `supplier_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_overdue = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        if ($due['status'] == "overdue") {
          $total_overdue += $due['balance_due'];
        }
      }
      echo number_format($total_overdue, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_sell_overdue()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `sell_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_overdue = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        if ($due['status'] == "overdue") {
          $total_overdue += $due['balance_due'];
        }
      }
      echo number_format($total_overdue, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function get_manufacturing_overdue()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id`,`balance_due`,`status` FROM `manufacturer_orders` WHERE `supplier_id`='$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_overdue = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

      foreach ($row as $due) {
        if ($due['status'] == "overdue") {
          $total_overdue += $due['balance_due'];
        }
      }
      echo number_format($total_overdue, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}
function edit_supplier_purchase()
{
  global $con;
  if (isset($_POST['order_id']) && isset($_POST['curr_total']) && isset($_POST['curr_due']) && isset($_POST['edit_order_purchase']) && isset($_POST['supplier_id']) && isset($_POST['due_to'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $created_time = date("Y-m-d h:i A");
    $order_id = trim($_POST['order_id']);
    if (isset($_POST['old_paid']) && !empty($_POST['old_paid'])) {
      $old_paid = floatval(str_replace(',', '', $$_POST['old_paid']));
    } else {
      $old_paid = 0;
    }
    if (isset($_POST['paid']) && !empty($_POST['paid']) && $_POST['paid'] !== 0) {
      $curr_paid = floatval(str_replace(',', '', $_POST['paid']));
    } else {
      $curr_paid = 0;
    }
    $due_to = floatval(str_replace(',', '', $_POST['due_to']));
    $curr_total = floatval(str_replace(',', '', $_POST['curr_total']));
    $curr_due = floatval(str_replace(',', '', $_POST['curr_due']));


    $total_paid = $old_paid + $curr_paid;

    if ($curr_due == 0) {
      $status = "paid";
      if (isset($_POST['received'])) {
        $received = 1;
      } else {
        $received = 0;
      }
    } else {
      if (isset($_POST['received'])) {
        $received = 1;
        $givenTimestamp = strtotime($due_to);
        $currentTimestamp = time();
        if ($currentTimestamp > $givenTimestamp) {
          $status = "overdue";
        } else {
          $status = "due";
        }
      } else {
        $received = 0;
        $status = "due";
      }
    }


    if (isset($_POST['received'])) {
      $stmt8 = $con->prepare("SELECT * FROM `supplier_orders` WHERE `order_id` = '$order_id'");
      $stmt8->execute();
      $count8 = $stmt8->rowCount();
      if ($count8 > 0) {
        while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row8 as $ord) {
            $prev_rec = $ord['received'];
            if ($prev_rec == 0) {
              $payment_m = $ord['payment_m'];
              $bank_name = $ord['bank_name'];
              $statement = "استلام توريدات";
              $stmt3 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
              $stmt3->execute();
              $count3 = $stmt3->rowCount();
              if ($count3 > 0) {
                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                $sum = $row3['balance'];
                $balance = $sum + $curr_total;
              } else {
                $balance = $curr_total;
              }
              $item_id = $ord['item_id'];
              $item_quantity = $ord['quantity'];
              $item_amount = $ord['amount'];
              $item_desc = $ord['description'];
              $storable = $ord['storable'];
              $discount = $ord['discount'];
              $subtotal = $ord['subtotal'];
              $item_total = $ord['total'];
              $warehouse = $ord['warehouse_id'];
              $vat_perc = $ord['vat_perc'];
              $item_total_vat_inc = $item_amount - ((($item_total / $subtotal) * $discount) / $item_quantity);
              $stmt3 = $con->prepare("SELECT * FROM `items` WHERE `code` = '$item_id'");
              $stmt3->execute();
              $count3 = $stmt3->rowCount();
              if ($count3 > 0) {
                while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                  foreach ($row3 as $item_info) {
                    $item_name = $item_info['name'];
                    $item_sku = "622" . substr($item_info['code'], 3, 4) . rand(10000, 99999);
                    $item_unit = $item_info['unit'];
                    $item_img = $item_info['img'];




                    $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id'");
                    $stmt4->execute();
                    $count4 = $stmt4->rowCount();
                    if ($count4 > 0) {
                      $hosted_quantity = 0;
                      while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                        foreach ($row4 as $avitem_info) {
                          $hosted_quantity += $avitem_info['quantity'];
                          $avitem_info_rate = $avitem_info['rate'];
                        }
                      }
                      $new_average_rate = (($hosted_quantity * $avitem_info_rate) + ($item_quantity * $item_total_vat_inc)) / ($hosted_quantity + $item_quantity);


                      $stmt5 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse'");
                      $stmt5->execute();
                      $count5 = $stmt5->rowCount();
                      if ($count5 > 0) {
                        // HERE
                        while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                          foreach ($row5 as $avitem_info_warehouse) {
                            $new_quantity =  $avitem_info_warehouse['quantity'] + $item_quantity;
                            $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                            $stmt6->execute();
                            $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse' ");
                            $stmt5->execute();
                          }
                        }
                      } else {
                        // HERE

                        $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                        $stmt6->execute();
                        $stmt77 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$new_average_rate','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                        $stmt77->execute();
                      }
                    } else {
                      $stmt2 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_total_vat_inc','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                      $stmt2->execute();
                    }
                  }
                }
              }
            }
          }
          $stmt2 = $con->prepare("INSERT INTO supplier_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$curr_total','$balance','$created_time','','','$statement','')");
          $stmt2->execute();
        }
      }
    }


    $stmt5 = $con->prepare("UPDATE `supplier_orders` SET `received`='$received',`status`='$status' WHERE `order_id`='$order_id'");
    $stmt5->execute();
    header("location:supplierdetails.php?uid=$supplier_id");
    exit();
  }
}

function inactive_list($j)
{
  global $con;
  if (isset($_POST['inactive-submit'])) {
    $stmt = $con->prepare("UPDATE `$j` SET `status` = '0' WHERE `id` = :uid");
    foreach ($_POST['delete'] as $inac) {
      $uid = $inac;
      $stmt->execute(array(':uid' => $uid));
      if ($j == "users") {
        header("location:employees.php");
        exit();
      } else {
        header("location:$j.php");
        exit();
      }
    }
  }
}

function get_supplier_transactions()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_overdue = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $due) {
        $total_overdue += $due['debit'];
      }
      echo number_format($total_overdue, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}

function get_manufacturer_transactions()
{
  global $con;
  $id = $_GET['uid'];
  $stmt = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  $total_overdue = 0;
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $due) {
        $total_overdue += $due['amount'];
      }
      echo number_format($total_overdue, 2, '.', ',');
    }
  } else {
    echo "0.00";
  }
}

function get_orders_option()
{
  global $con;
  $supplier_id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id` FROM `supplier_orders` WHERE `balance_due` > 0 AND `supplier_id` = '$supplier_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['order_id'] . '">Order #' . $opt['order_id'] . '</option>';
      }
    }
  }
}
function get_sell_orders_option()
{
  global $con;
  $supplier_id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id` FROM `sell_orders` WHERE `balance_due` > 0 AND `supplier_id` = '$supplier_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['order_id'] . '">Order #' . $opt['order_id'] . '</option>';
      }
    }
  }
}
function get_manu_orders_option()
{
  global $con;
  $supplier_id = $_GET['uid'];
  $stmt = $con->prepare("SELECT DISTINCT `order_id` FROM `manufacturer_orders` WHERE `balance_due` > 0 AND `supplier_id` = '$supplier_id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['order_id'] . '">Order #' . $opt['order_id'] . '</option>';
      }
    }
  }
}
function import_quick_payment()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_bank_name']) &&
    isset($_POST['amount_payment_method']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['supplier_id']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_bank_name']) &&
    !empty($_POST['amount_payment_method'])
  ) {
    $supplier_id = $_POST['supplier_id'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_account = "";
    } else {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_account = trim($_POST['amount_bank_number']);
    }
    if (isset($_POST['amount_statement']) && !empty($_POST['amount_statement'])) {
      $statement = trim($_POST['amount_statement']);
    } else {
      $statement = "";
    }
    if (isset($_POST['order_id']) && isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];
        $stmt3 = $con->prepare("SELECT * FROM `supplier_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $amount;
        } else {
          $balance = -1 * $amount;
        }
        if ($_POST['order_id'] == "custom") {
          $stmt = $con->prepare("INSERT INTO `supplier_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','','$amount','0','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_account')");
          $stmt->execute();
          header("location:supplierdetails.php?uid=$supplier_id");
          exit();
        } else {
          $order_id = $_POST['order_id'];
          $stmt2 = $con->prepare("SELECT * FROM `supplier_orders` WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id' LIMIT 1");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          if ($count2 > 0) {
            while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row2 as $ord) {
                $old_balance_due = $ord['balance_due'];
                $old_received = $ord['received'];
                $old_due_to = $ord['due_to'];
                $old_paid = $ord['paid'];
              }
            }
            $balance_due = $old_balance_due - $amount;
            $paid = $old_paid + $amount;

            if ($old_received == '1') {
              $givenTimestamp = strtotime($old_due_to);
              $currentTimestamp = time();

              if ($balance_due == "0") {
                $status = "paid";
              } else {
                if ($currentTimestamp > $givenTimestamp) {
                  $status = "overdue";
                } else {
                  $status = "due";
                }
              }
            } else {
              if ($balance_due == "0") {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $stmt3 = $con->prepare("UPDATE `supplier_orders` SET  `balance_due` = '$balance_due' , `status` = '$status', `paid` = '$paid' WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id'");
            $stmt3->execute(); // Update salary in salary_employee
            $stmt = $con->prepare("INSERT INTO `supplier_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$amount','0','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_account')");
            $stmt->execute();
            header("location:supplierdetails.php?uid=$supplier_id");
          }
        }
      }
    }
  }
}

function get_warehouses_option()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `warehouses` WHERE `id` != '314' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['id'] . '">' . $opt['name'] . '</option>';
      }
    }
  }
}

function get_warehouses_option_name()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `warehouses` WHERE `id` != '314' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['name'] . '">' . $opt['name'] . '</option>';
      }
    }
  }
}


function import_manufacure()
{
  global $con;
  if (
    isset($_POST["p"]) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['terms']) &&
    isset($_POST['payment_m']) &&
    isset($_POST['cdate']) &&
    isset($_POST['subtotal']) &&
    isset($_POST['due_balance']) &&
    isset($_POST['total']) &&
    isset($_POST['save_order_purchase']) &&
    isset($_POST['inv_number']) &&

    !empty($_POST["p"]) &&
    !empty($_POST["supplier_id"]) &&
    !empty($_POST["terms"]) &&
    !empty($_POST["payment_m"]) &&
    !empty($_POST["cdate"]) &&
    !empty($_POST['inv_number'])
  ) {

    if (isset($_POST['withholding']) && !empty($_POST['withholding'])) {
      $withholding = $_POST['withholding'];
    } else {
      $withholding = 0;
    }
    $transfer_id = get_transfer_order_number();
    $user_info = login_info();
    $resp_id = $user_info['id'];

    $supplier_id = trim($_POST['supplier_id']);
    $terms = trim($_POST['terms']);
    $payment_m = $_POST['payment_m'];
    $dateString = $_POST['cdate'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $total = round($_POST['total'], 2);
    $items_total = $_POST['subtotal_purchase'];
    $due_balance = round($_POST['due_balance'], 2);
    $order_id = trim($_POST['inv_number']);
    $orderI = $supplier_id;
    if (isset($_POST['discount'])) {
      $discount = $_POST['discount'];
    } else {
      $discount = 0;
    }
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else {
      $bank_name = $_POST['bank'];
      $bank_number = $_POST['bank_number'];
    }

    if (isset($_POST['vat'])) {
      $vat_perc = $_POST['vat'];
    } else {
      $vat_perc = 0;
    }
    if (isset($_POST['vat_amount'])) {
      $vat_amount = round($_POST['vat_amount'], 2);
    } else {
      $vat_amount = 0;
    }

    $subtotal = $_POST['subtotal'];
    $type = "Manufacturing Order";
    $warehouse = "";
    $storable = 0;
    $received = 0;
    $due_to = "";
    $status = "";

    if (isset($_POST['statement']) && !empty($_POST['statement'])) {
      $statement = trim($_POST['statement']);
    } else {
      $statement = "";
    }
    $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
      return
        !empty($row["id"]);
    }));
    if ($_FILES['hardcopy']['error'] == 4) {
      $pdf_name = "";
    } else {
      $pdf_type = $_FILES['hardcopy']['type'];
      $pdf_temp = $_FILES['hardcopy']['tmp_name'];
      $pdf_size = $_FILES['hardcopy']['size'];
      $pdf_extension = @strtolower(end(explode('.', $_FILES['hardcopy']['name'])));
      $pdf_name = rand(0, 100000000000000) . "." . $pdf_extension;
      $allowed_extensions_pdf = [
        "pdf",
        "jpg",
        "jpeg",
        "png",
        "gif"
      ];

      if ($pdf_size > 10000000) {
        echo "pdf must be less than 10MB";
      } else if (!in_array($pdf_extension, $allowed_extensions_pdf)) {
        echo "File is not valid";
      } else {

        if (move_uploaded_file($pdf_temp, __DIR__ . "/../assets/order_purchases/" . $pdf_name)) {
          move_uploaded_file($pdf_temp, __DIR__ . "/../assets/order_purchases/" . $pdf_name);
        } else {
          echo "Upload image failed";
        }
      }
    }
    if (isset($_POST['storable'])) {
      if (isset($_POST['warehouse'])) {
        $storable = 1;
        $warehouse = $_POST['warehouse'];
      } else {
        $storable = 0;
        $warehouse = "";
      }
    } else {
      $storable = 0;
      $warehouse = "";
    }
    if (isset($_POST["received"])) {
      // Started - Received
      $received = 1;
      $started = 1;
      if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
        $paid = $_POST['paid'];
        if ($paid == $total) {
          $status = "paid";
        } else {
          $status = "overdue";
        }
        if ($terms == "dueonreceipt") {
          if (isset($_POST["received"])) {
            if ($paid == $total) {
              $status = "paid";
            } else {
              $status = "overdue";
            }
          } else {
            if ($paid == $total) {
              $status = "paid";
            } else {
              $status = "due";
            }
          }
          $due_to = $created_time;
        } else {
          $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
          if ($paid == $total || $paid > $total) {
            $status = "paid";
          } else {
            $status = "due";
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $items_total;
          $new_balance = $balance - $paid;
          $credit = $items_total + $total;
          $last_balance =  $new_balance + $credit;
        } else {
          $balance = -1 * $items_total;
          $new_balance =  $balance - $paid;
          $credit = $items_total + $total;
          $last_balance = $new_balance + $credit;
        }
        $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
        $stmt33->execute();
        $cash_statement = "اذن صرف دفعه مقدمه";
        $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$paid','0','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
        $stmt3->execute();
        $last_statement = "استلام منتج تام";
        $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$credit','$last_balance','$created_time','','','$last_statement','')");
        $stmt3->execute();
      } else {
        $paid = 0;
        if ($paid == $total) {
          $status = "paid";
        } else {
          $status = "overdue";
        }
        if ($terms == "dueonreceipt") {
          if (isset($_POST["received"])) {
            if ($paid == $total) {
              $status = "paid";
            } else {
              $status = "overdue";
            }
          } else {
            if ($paid == $total) {
              $status = "paid";
            } else {
              $status = "due";
            }
          }
          $due_to = $created_time;
        } else {
          $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
          if ($paid == $total || $paid > $total) {
            $status = "paid";
          } else {
            $status = "due";
          }
        }
        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $items_total;
          $credit = $items_total + $total;
          $last_balance =  $balance + $credit;
        } else {
          $balance = -1 * $items_total;
          $credit = $items_total + $total;
          $last_balance = $balance + $credit;
        }
        $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
        $stmt33->execute();
        $last_statement = "استلام منتج تام";
        $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$credit','$last_balance','$created_time','','','$last_statement','')");
        $stmt3->execute();
      }
      $stmt = $con->prepare("INSERT INTO manufacturer_orders (`supplier_id`, `item_id`, `quantity`, `amount`, `total`, `order_id`, `created_time`, `status`, `due_to`, `description`, `balance_due`, `paid`, `storable`, `warehouse_id`, `order_total`, `type`, `received`, `hardcopy`,`vat_perc`,`vat_amount`,`subtotal`,`discount`,`withholding`,`payment_m`,`bank_name`,`started`,`bank_number`) VALUES (:supplier_id, :item_id, :item_quantity, :item_amount, :item_total, :order_id, :created_time, :status, :due_to, :item_desc, :due_balance, :paid, :storable, :warehouse, :total, :type, :received, :pdf_name,:vat_perc,:vat_amount,:subtotal,:discount,:withholding,:payment_m,:bank,:started,:bank_number)");
      foreach ($filteredArray as $fa) {
        $item_id = $fa['id'];
        $item_quantity = $fa['quantity'];
        $item_amount = $fa['amount'];
        $item_total = $fa['total'];
        $item_desc = $fa['description'];
        $count_of_items = count($filteredArray);
        $item_total_vat_inc = (($item_total + $subtotal - $discount) / $item_quantity);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':item_quantity', $item_quantity);
        $stmt->bindParam(':item_amount', $item_amount);
        $stmt->bindParam(':item_total', $item_total);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':created_time', $created_time);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':due_to', $due_to);
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->bindParam(':due_balance', $due_balance);
        $stmt->bindParam(':paid', $paid);
        $stmt->bindParam(':storable', $storable);
        $stmt->bindParam(':warehouse', $warehouse);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':received', $received);
        $stmt->bindParam(':pdf_name', $pdf_name);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':vat_amount', $vat_amount);
        $stmt->bindParam(':vat_perc', $vat_perc);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':withholding', $withholding);
        $stmt->bindParam(':payment_m', $payment_m);
        $stmt->bindParam(':bank', $bank_name);
        $stmt->bindParam(':started', $started);
        $stmt->bindParam(':bank_number', $bank_number);
        $stmt->execute();
      }
      $pid = $_POST["p"]["1"]["id"];
      $item_name = $_POST["p"]["1"]["name"];
      $item_desc = $_POST["p"]["1"]["description"];
      $item_unit = $_POST["p"]["1"]["unit"];
      $item_quantity = $_POST["p"]["1"]["quantity"];
      $item_amount = $_POST["p"]["1"]["amount"];
      $item_total = $_POST["p"]["1"]["total"];
      $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);
      $item_sku = "622" . substr($pid, 3, 4) . rand(10000, 99999);
      $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$pid'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count > 0) {
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
          foreach ($row as $ite) {
            $item_img = $ite['img'];
            if ($ite['is_composite'] == 1) {
              $subitems = $ite['sub_items'];
              $exp_subitems = explode("-", $subitems);
              $subquantity = $ite['sub_quantity'];
              $exp_subquantity = explode("-", $subquantity);
              $i = 0;
              foreach ($exp_subitems as $subitem) {
                // echo $subitem . "->" . $exp_subquantity[$i] . "<br>";
                $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
                $stmt77->execute();
                $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
                $real_item_id = $row77['item_id'];
                $assm_quantity = ($exp_subquantity[$i] * $item_quantity);
                $assm_quantity_2 = ($exp_subquantity[$i] * $item_quantity);
                $available_quantities = array();
                $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314' ORDER BY `created_time` ASC");
                $stmt2->execute();
                $count2 = $stmt2->rowCount();
                if ($count2 > 0) {
                  while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                    foreach ($row2 as $one) {
                      array_push($available_quantities, $one);
                    }
                  }
                }
                foreach ($available_quantities as $quan) {
                  $old_quantity =  $quan["quantity"];
                  $old_rate =  $quan["rate"];
                  $tmp_id =  $quan["id"];
                  $name =  $quan["name"];
                  $unit =  $quan["unit"];
                  $img =  $quan["img"];
                  $unit =  $quan["unit"];
                  $item_sku = "622" . substr($quan['item_id'], 3, 4) . rand(10000, 99999);
                  $item_warehouse = $quan['warehouse_id'];
                  $total_quantity = ($exp_subquantity[$i] * $item_quantity);
                  $new_quantity = $old_quantity - $total_quantity;
                  $newtotal = $quan['quantity'] - $assm_quantity;
                  if ($newtotal < 0) {
                    $new_quantity = 0;
                    $trans_quantity = $quan['quantity'];
                  } else {
                    $new_quantity = $newtotal;
                    $trans_quantity = $assm_quantity;
                  }
                  $total_rate = $old_rate * $trans_quantity;
                  $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                  $stmt88->execute();
                  $stmt99 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$real_item_id','$item_warehouse','314','$created_time','$old_rate','$trans_quantity','$total_rate','$unit','$transfer_id')");
                  $stmt99->execute();
                  if ($newtotal < 0) {
                    $assm_quantity = -1 * $newtotal;
                    $new_quantity = 0;
                  } else {
                    break;
                  }
                }
                $i++;
              }
            }




            // New Code Here
            $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$pid'");
            $stmt4->execute();
            $count4 = $stmt4->rowCount();
            if ($count4 > 0) {
              $hosted_quantity = 0;
              while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                foreach ($row4 as $avitem_info) {
                  $hosted_quantity += $avitem_info['quantity'];
                  $avitem_info_rate = $avitem_info['rate'];
                }
              }
              $new_average_rate = (($hosted_quantity * $avitem_info_rate) + ($item_quantity * $item_total_vat_inc)) / ($hosted_quantity + $item_quantity);


              $stmt5 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse'");
              $stmt5->execute();
              $count5 = $stmt5->rowCount();
              if ($count5 > 0) {
                // HERE
                while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                  foreach ($row5 as $avitem_info_warehouse) {
                    $new_quantity =  $avitem_info_warehouse['quantity'] + $item_quantity;
                    $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                    $stmt6->execute();
                    $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse' ");
                    $stmt5->execute();
                  }
                }
              } else {
                // HERE

                $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                $stmt6->execute();
                $stmt77 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$pid','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$new_average_rate','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                $stmt77->execute();
              }
            } else {
              $stmt2 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$pid','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_total_vat_inc','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
              $stmt2->execute();
            }
            // End New Code Here



          }
          $stmt102 = $con->prepare("INSERT INTO `transfer_orders` (`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
          $stmt102->execute();
        }
      }
    } else {
      if (isset($_POST['started'])) {
        // Started - Not Received
        $received = 0;
        $started = 1;
        if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
          $paid = $_POST['paid'];
          if ($paid == $total) {
            $status = "paid";
          } else {
            $status = "overdue";
          }
          if ($terms == "dueonreceipt") {
            if (isset($_POST["received"])) {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "overdue";
              }
            } else {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $due_to = $created_time;
          } else {
            $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
            if ($paid == $total || $paid > $total) {
              $status = "paid";
            } else {
              $status = "due";
            }
          }
          $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $balance = $sum - $items_total;
            $new_balance = $balance - $paid;
          } else {
            $balance = -1 * $items_total;
            $new_balance =  $balance - $paid;
          }
          $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
          $stmt33->execute();
          $cash_statement = "اذن صرف دفعه مقدمه";
          $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$paid','0','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
          $stmt3->execute();
        } else {
          $paid = 0;
          if ($paid == $total) {
            $status = "paid";
          } else {
            $status = "overdue";
          }
          if ($terms == "dueonreceipt") {
            if (isset($_POST["received"])) {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "overdue";
              }
            } else {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $due_to = $created_time;
          } else {
            $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
            if ($paid == $total || $paid > $total) {
              $status = "paid";
            } else {
              $status = "due";
            }
          }
          $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $balance = $sum - $items_total;
          } else {
            $balance = -1 * $items_total;
          }
          $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
          $stmt33->execute();
        }
        $stmt = $con->prepare("INSERT INTO manufacturer_orders (`supplier_id`, `item_id`, `quantity`, `amount`, `total`, `order_id`, `created_time`, `status`, `due_to`, `description`, `balance_due`, `paid`, `storable`, `warehouse_id`, `order_total`, `type`, `received`, `hardcopy`,`vat_perc`,`vat_amount`,`subtotal`,`discount`,`withholding`,`payment_m`,`bank_name`,`started`,`bank_number`) VALUES (:supplier_id, :item_id, :item_quantity, :item_amount, :item_total, :order_id, :created_time, :status, :due_to, :item_desc, :due_balance, :paid, :storable, :warehouse, :total, :type, :received, :pdf_name,:vat_perc,:vat_amount,:subtotal,:discount,:withholding,:payment_m,:bank,:started,:bank_number)");
        foreach ($filteredArray as $fa) {
          $item_id = $fa['id'];
          $item_quantity = $fa['quantity'];
          $item_amount = $fa['amount'];
          $item_total = $fa['total'];
          $item_desc = $fa['description'];
          $count_of_items = count($filteredArray);
          $item_total_vat_inc = $item_amount - (($discount / $count_of_items) / $item_quantity);
          $stmt->bindParam(':supplier_id', $supplier_id);
          $stmt->bindParam(':item_id', $item_id);
          $stmt->bindParam(':item_quantity', $item_quantity);
          $stmt->bindParam(':item_amount', $item_amount);
          $stmt->bindParam(':item_total', $item_total);
          $stmt->bindParam(':order_id', $order_id);
          $stmt->bindParam(':created_time', $created_time);
          $stmt->bindParam(':status', $status);
          $stmt->bindParam(':due_to', $due_to);
          $stmt->bindParam(':item_desc', $item_desc);
          $stmt->bindParam(':due_balance', $due_balance);
          $stmt->bindParam(':paid', $paid);
          $stmt->bindParam(':storable', $storable);
          $stmt->bindParam(':warehouse', $warehouse);
          $stmt->bindParam(':total', $total);
          $stmt->bindParam(':type', $type);
          $stmt->bindParam(':received', $received);
          $stmt->bindParam(':pdf_name', $pdf_name);
          $stmt->bindParam(':subtotal', $subtotal);
          $stmt->bindParam(':vat_amount', $vat_amount);
          $stmt->bindParam(':vat_perc', $vat_perc);
          $stmt->bindParam(':discount', $discount);
          $stmt->bindParam(':withholding', $withholding);
          $stmt->bindParam(':payment_m', $payment_m);
          $stmt->bindParam(':bank', $bank_name);
          $stmt->bindParam(':started', $started);
          $stmt->bindParam(':bank_number', $bank_number);
          $stmt->execute();
        }
        $pid = $_POST["p"]["1"]["id"];
        $item_name = $_POST["p"]["1"]["name"];
        $item_desc = $_POST["p"]["1"]["description"];
        $item_unit = $_POST["p"]["1"]["unit"];
        $item_quantity = $_POST["p"]["1"]["quantity"];
        $item_amount = $_POST["p"]["1"]["amount"];
        $item_total = $_POST["p"]["1"]["total"];
        $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);
        $item_sku = "622" . substr($pid, 3, 4) . rand(10000, 99999);
        $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$pid'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row as $ite) {
              $img = $ite['img'];
              if ($ite['is_composite'] == 1) {
                $subitems = $ite['sub_items'];
                $exp_subitems = explode("-", $subitems);
                $subquantity = $ite['sub_quantity'];
                $exp_subquantity = explode("-", $subquantity);
                $i = 0;
                foreach ($exp_subitems as $subitem) {
                  // echo $subitem . "->" . $exp_subquantity[$i] . "<br>";
                  $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
                  $stmt77->execute();
                  $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
                  $real_item_id = $row77['item_id'];
                  $assm_quantity = ($exp_subquantity[$i] * $item_quantity);
                  $assm_quantity_2 = ($exp_subquantity[$i] * $item_quantity);
                  $available_quantities = array();
                  $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314' ORDER BY `created_time` ASC");
                  $stmt2->execute();
                  $count2 = $stmt2->rowCount();
                  if ($count2 > 0) {
                    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                      foreach ($row2 as $one) {
                        array_push($available_quantities, $one);
                      }
                    }
                  }
                  foreach ($available_quantities as $quan) {
                    $old_quantity =  $quan["quantity"];
                    $old_rate =  $quan["rate"];
                    $tmp_id =  $quan["id"];
                    $name =  $quan["name"];
                    $unit =  $quan["unit"];
                    $img =  $quan["img"];
                    $unit =  $quan["unit"];
                    $item_sku = "622" . substr($quan['item_id'], 3, 4) . rand(10000, 99999);
                    $item_warehouse = $quan['warehouse_id'];
                    $total_quantity = ($exp_subquantity[$i] * $item_quantity);
                    $new_quantity = $old_quantity - $total_quantity;
                    $newtotal = $quan['quantity'] - $assm_quantity;
                    if ($newtotal < 0) {
                      $new_quantity = 0;
                      $trans_quantity = $quan['quantity'];
                    } else {
                      $new_quantity = $newtotal;
                      $trans_quantity = $assm_quantity;
                    }
                    $total_rate = $old_rate * $trans_quantity;
                    $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                    $stmt88->execute();
                    $stmt99 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$real_item_id','$item_warehouse','314','$created_time','$old_rate','$trans_quantity','$total_rate','$unit','$transfer_id')");
                    $stmt99->execute();

                    if ($newtotal < 0) {
                      $assm_quantity = -1 * $newtotal;
                      $new_quantity = 0;
                    } else {
                      $stmt75 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                      $stmt75->execute();
                      $count75 = $stmt75->rowCount();
                      if ($count75 > 0) {
                        while ($row75 = $stmt75->fetchAll(PDO::FETCH_ASSOC)) {
                          $old_quantity_2 =  $row75[0]["quantity"];
                          $new_quantity_2 = $old_quantity_2 + $assm_quantity_2;
                          $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity_2' WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                          $stmt88->execute();
                        }
                      } else {
                        $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`)  VALUES ('$orderI','$name','$item_sku','','$unit','$assm_quantity_2','$old_rate','1','314','$created_time','$real_item_id','$img','0','0','$order_id')");
                        $stmt99->execute();
                      }
                      break;
                    }
                  }
                  $i++;
                }
              }
            }
            $stmt102 = $con->prepare("INSERT INTO `transfer_orders` (`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
            $stmt102->execute();
          }
        }
      } else {
        // Not Started - Not Received
        $received = 0;
        $started = 0;
        if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
          $paid = $_POST['paid'];
          if ($paid == $total) {
            $status = "paid";
          } else {
            $status = "overdue";
          }
          if ($terms == "dueonreceipt") {
            if (isset($_POST["received"])) {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "overdue";
              }
            } else {
              if ($paid == $total) {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $due_to = $created_time;
          } else {
            $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
            if ($paid == $total || $paid > $total) {
              $status = "paid";
            } else {
              $status = "due";
            }
          }
          $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
          $stmt3->execute();
          $count3 = $stmt3->rowCount();
          if ($count3 > 0) {
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $sum = $row3['balance'];
            $new_balance = $sum - $paid;
          } else {
            $new_balance = -1 * $paid;
          }
          $cash_statement = "اذن صرف دفعه مقدمه";
          $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$paid','0','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
          $stmt3->execute();
        } else {
          $paid = 0;
        }

        $stmt = $con->prepare("INSERT INTO manufacturer_orders (`supplier_id`, `item_id`, `quantity`, `amount`, `total`, `order_id`, `created_time`, `status`, `due_to`, `description`, `balance_due`, `paid`, `storable`, `warehouse_id`, `order_total`, `type`, `received`, `hardcopy`,`vat_perc`,`vat_amount`,`subtotal`,`discount`,`withholding`,`payment_m`,`bank_name`,`started`,`bank_number`) VALUES (:supplier_id, :item_id, :item_quantity, :item_amount, :item_total, :order_id, :created_time, :status, :due_to, :item_desc, :due_balance, :paid, :storable, :warehouse, :total, :type, :received, :pdf_name,:vat_perc,:vat_amount,:subtotal,:discount,:withholding,:payment_m,:bank,:started,:bank_number)");
        foreach ($filteredArray as $fa) {
          $item_id = $fa['id'];
          $item_quantity = $fa['quantity'];
          $item_amount = $fa['amount'];
          $item_total = $fa['total'];
          $item_desc = $fa['description'];
          $count_of_items = count($filteredArray);
          $item_total_vat_inc = $item_amount - (($discount / $count_of_items) / $item_quantity);
          $stmt->bindParam(':supplier_id', $supplier_id);
          $stmt->bindParam(':item_id', $item_id);
          $stmt->bindParam(':item_quantity', $item_quantity);
          $stmt->bindParam(':item_amount', $item_amount);
          $stmt->bindParam(':item_total', $item_total);
          $stmt->bindParam(':order_id', $order_id);
          $stmt->bindParam(':created_time', $created_time);
          $stmt->bindParam(':status', $status);
          $stmt->bindParam(':due_to', $due_to);
          $stmt->bindParam(':item_desc', $item_desc);
          $stmt->bindParam(':due_balance', $due_balance);
          $stmt->bindParam(':paid', $paid);
          $stmt->bindParam(':storable', $storable);
          $stmt->bindParam(':warehouse', $warehouse);
          $stmt->bindParam(':total', $total);
          $stmt->bindParam(':type', $type);
          $stmt->bindParam(':received', $received);
          $stmt->bindParam(':pdf_name', $pdf_name);
          $stmt->bindParam(':subtotal', $subtotal);
          $stmt->bindParam(':vat_amount', $vat_amount);
          $stmt->bindParam(':vat_perc', $vat_perc);
          $stmt->bindParam(':discount', $discount);
          $stmt->bindParam(':withholding', $withholding);
          $stmt->bindParam(':payment_m', $payment_m);
          $stmt->bindParam(':bank', $bank_name);
          $stmt->bindParam(':started', $started);
          $stmt->bindParam(':bank_number', $bank_number);
          $stmt->execute();
        }
      }
    }
    header("location:manufacturerdetails.php?uid=$supplier_id");
    exit();
  }
}



function import_quick_manufacturer_payment()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_bank_name']) &&
    isset($_POST['amount_payment_method']) &&
    !empty($_POST['pay']) &&
    !empty($_POST['supplier_id']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_bank_name']) &&
    !empty($_POST['amount_payment_method'])
  ) {
    $supplier_id = $_POST['supplier_id'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_number = trim($_POST['amount_bank_number']);
    }
    if (isset($_POST['amount_statement']) && !empty($_POST['amount_statement'])) {
      $statement = trim($_POST['amount_statement']);
    } else {
      $statement = "";
    }
    if (isset($_POST['order_id']) && isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];

        $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $amount;
        } else {
          $balance = -1 * $amount;
        }




        if ($_POST['order_id'] == "custom") {
          $stmt = $con->prepare("INSERT INTO `manufacturer_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','','$amount','0','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_number')");
          $stmt->execute();
          header("location:manufacturerdetails.php?uid=$supplier_id");
          exit();
        } else {
          $order_id = $_POST['order_id'];
          $stmt2 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id' LIMIT 1");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          if ($count2 > 0) {
            while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row2 as $ord) {
                $old_balance_due = $ord['balance_due'];
                $old_received = $ord['received'];
                $old_due_to = $ord['due_to'];
                $old_paid = $ord['paid'];
              }
            }
            $balance_due = $old_balance_due - $amount;
            $paid = $old_paid + $amount;

            if ($old_received == '1') {
              $givenTimestamp = strtotime($old_due_to);
              $currentTimestamp = time();

              if ($balance_due == "0") {
                $status = "paid";
              } else {
                if ($currentTimestamp > $givenTimestamp) {
                  $status = "overdue";
                } else {
                  $status = "due";
                }
              }
            } else {
              if ($balance_due == "0") {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $stmt3 = $con->prepare("UPDATE `manufacturer_orders` SET  `balance_due` = '$balance_due' , `status` = '$status', `paid` = '$paid' WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id'");
            $stmt3->execute(); // Update salary in salary_employee
            $stmt = $con->prepare("INSERT INTO `manufacturer_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$amount','0','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_number')");
            $stmt->execute();
            header("location:manufacturerdetails.php?uid=$supplier_id");
          }
        }
      }
    }
  }
}

function edit_manufacturer_purchase()
{
  global $con;
  if (isset($_POST['order_id']) && isset($_POST['curr_total']) && isset($_POST['curr_due']) && isset($_POST['edit_order_purchase']) && isset($_POST['supplier_id']) && isset($_POST['due_to'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $created_time = date("Y-m-d h:i A");
    $order_id = trim($_POST['order_id']);
    $orderI = $supplier_id;
    $transfer_id = get_transfer_order_number();
    $user_info = login_info();
    $resp_id = $user_info['id'];
    if (isset($_POST['old_paid']) && !empty($_POST['old_paid'])) {
      $old_paid = floatval(str_replace(',', '', $_POST['old_paid']));
    } else {
      $old_paid = 0;
    }
    if (isset($_POST['paid']) && !empty($_POST['paid']) && $_POST['paid'] !== 0) {
      $curr_paid = floatval(str_replace(',', '', $_POST['paid']));
    } else {
      $curr_paid = 0;
    }
    $due_to = floatval(str_replace(',', '', $_POST['due_to']));
    $curr_total = floatval(str_replace(',', '', $_POST['curr_total']));
    $curr_due = floatval(str_replace(',', '', $_POST['curr_due']));


    $total_paid = $old_paid + $curr_paid;
    if ($curr_due < 0) {
    } else {
      if ($curr_due == 0) {
        $status = "paid";
        if (isset($_POST['received'])) {
          $received = 1;
        } else {
          $received = 0;
        }
      } else {
        if (isset($_POST['received'])) {
          $received = 1;
          $givenTimestamp = strtotime($due_to);
          $currentTimestamp = time();
          if ($currentTimestamp > $givenTimestamp) {
            $status = "overdue";
          } else {
            $status = "due";
          }
        } else {
          $received = 0;
          $status = "due";
        }
      }


      if (isset($_POST['received'])) {
        $received = 1;
        $started = 1;
        $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
        $stmt8->execute();
        $count8 = $stmt8->rowCount();
        if ($count8 > 0) {
          while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row8 as $ord) {
              $prev_rec = $ord['received'];
              $payment_m = $ord['payment_m'];
              $bank_name = $ord['bank_name'];
              $bank_number = $ord['bank_number'];
              $items_total = $ord['total'];
              $total = $ord['order_total'];
              $item_id = $ord['item_id'];
              $item_quantity = $ord['quantity'];
              $item_amount = $ord['amount'];
              $item_desc = $ord['description'];
              $storable = $ord['storable'];
              $warehouse = $ord['warehouse_id'];
              $vat_perc = $ord['vat_perc'];
              $discount = $ord['discount'];
              $subtotal = $ord['subtotal'];
              $item_total = $ord['total'];
              $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);

              $item_total_vat_inc = (($item_total + $subtotal - $discount) / $item_quantity);

              $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);


              $stmt98 = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
              $stmt98->execute();
              $row98 = $stmt98->fetch(PDO::FETCH_ASSOC);
              $item_name = $row98['name'];
              $item_unit = $row98['unit'];
              $item_img = $row98['img'];



              if ($prev_rec == 0) {

                $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                $stmt3->execute();
                $count3 = $stmt3->rowCount();
                if ($count3 > 0) {
                  $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                  $sum = $row3['balance'];
                  $balance = $sum - $items_total;
                  $credit = $items_total + $total;
                  $last_balance =  $sum + $credit;
                } else {
                  $balance = -1 * $items_total;
                  $credit = $items_total + $total;
                  $last_balance = $balance + $credit;
                }

                $last_statement = "استلام منتج تام";
                $stmt3 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$credit','$last_balance','$created_time','','','$last_statement','')");
                $stmt3->execute();



                $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                  while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    foreach ($row as $ite) {
                      $img = $ite['img'];

                      // New Code Here
                      $stmt4 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id'");
                      $stmt4->execute();
                      $count4 = $stmt4->rowCount();
                      if ($count4 > 0) {
                        $hosted_quantity = 0;
                        while ($row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                          foreach ($row4 as $avitem_info) {
                            $hosted_quantity += $avitem_info['quantity'];
                            $avitem_info_rate = $avitem_info['rate'];
                          }
                        }

                        $new_average_rate = (($hosted_quantity * $avitem_info_rate) + ($item_quantity * $item_total_vat_inc)) / ($hosted_quantity + $item_quantity);

                        $stmt5 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse'");
                        $stmt5->execute();
                        $count5 = $stmt5->rowCount();
                        if ($count5 > 0) {
                          // HERE
                          while ($row5 = $stmt5->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                            foreach ($row5 as $avitem_info_warehouse) {
                              $new_quantity =  $avitem_info_warehouse['quantity'] + $item_quantity;
                              $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                              $stmt6->execute();
                              $stmt5 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `item_id` = '$item_id' AND `warehouse_id` = '$warehouse' ");
                              $stmt5->execute();
                            }
                          }
                        } else {
                          // HERE
                          $stmt6 = $con->prepare("UPDATE `av_items` SET `rate`='$new_average_rate' WHERE `item_id` = '$item_id'");
                          $stmt6->execute();
                          $stmt77 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$new_average_rate','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                          $stmt77->execute();
                        }
                      } else {
                        $stmt2 = $con->prepare("INSERT INTO av_items (`item_id`,`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_id','$supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$item_quantity','$item_total_vat_inc','$storable','$warehouse','$created_time','$item_img','0','0','$order_id')");
                        $stmt2->execute();
                      }
                      // End New Code Here






                      $stmt96 = $con->prepare("DELETE FROM `av_items` WHERE `supplier_id` = '$orderI' AND `warehouse_id` = '314' AND `order_id` = '$order_id'");
                      $stmt96->execute();
                    }
                  }
                }
              }
            }
          }
        }
      } else {
        if (isset($_POST['started'])) {
          $received = 0;
          $started = 1;
          $stmt8 = $con->prepare("SELECT * FROM `manufacturer_orders` WHERE `order_id` = '$order_id'");
          $stmt8->execute();
          $count8 = $stmt8->rowCount();
          if ($count8 > 0) {
            while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row8 as $ord) {
                $prev_start = $ord['started'];
                $prev_rec = $ord['received'];
                $payment_m = $ord['payment_m'];
                $bank_name = $ord['bank_name'];
                $items_total = $ord['total'];
                $total = $ord['order_total'];
                $item_id = $ord['item_id'];
                $item_quantity = $ord['quantity'];
                $item_amount = $ord['amount'];
                $item_desc = $ord['description'];
                $storable = $ord['storable'];
                $warehouse = $ord['warehouse_id'];
                $vat_perc = $ord['vat_perc'];
                $subtotal = $ord['subtotal'];
                $discount = $ord['discount'];
                $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                $item_total_vat_inc = (($vat_perc / 100) * $item_amount) + $item_amount;
                $item_rate =  $item_amount + (($subtotal - $discount) / $item_quantity);
                if ($prev_start == 0) {
                  $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                  $stmt3->execute();
                  $count3 = $stmt3->rowCount();
                  if ($count3 > 0) {
                    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                    $sum = $row3['balance'];
                    $balance = $sum - $items_total;
                  } else {
                    $balance = -1 * $items_total;
                  }
                  $statement = "تسليم خامات التصنيع";
                  $stmt33 = $con->prepare("INSERT INTO manufacturer_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$items_total','0','$balance','$created_time','','','$statement','')");
                  $stmt33->execute();

                  $item_rate =  $item_amount + (($total) / $item_quantity);
                  $item_sku = "622" . substr($item_id, 3, 4) . rand(10000, 99999);
                  $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$item_id'");
                  $stmt->execute();
                  $count = $stmt->rowCount();
                  if ($count > 0) {
                    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                      foreach ($row as $ite) {
                        $img = $ite['img'];
                        if ($ite['is_composite'] == 1) {
                          $subitems = $ite['sub_items'];
                          $exp_subitems = explode("-", $subitems);
                          $subquantity = $ite['sub_quantity'];
                          $exp_subquantity = explode("-", $subquantity);
                          $i = 0;
                          foreach ($exp_subitems as $subitem) {
                            // echo $subitem . "->" . $exp_subquantity[$i] . "<br>";
                            $stmt77 = $con->prepare("SELECT * FROM `av_items` WHERE `id` = '$subitem'");
                            $stmt77->execute();
                            $row77 = $stmt77->fetch(PDO::FETCH_ASSOC);
                            $real_item_id = $row77['item_id'];
                            $assm_quantity = ($exp_subquantity[$i] * $item_quantity);
                            $assm_quantity_2 = ($exp_subquantity[$i] * $item_quantity);
                            $available_quantities = array();
                            $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` != '314' ORDER BY `created_time` ASC");
                            $stmt2->execute();
                            $count2 = $stmt2->rowCount();
                            if ($count2 > 0) {
                              while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($row2 as $one) {
                                  array_push($available_quantities, $one);
                                }
                              }
                            }
                            foreach ($available_quantities as $quan) {
                              $old_quantity =  $quan["quantity"];
                              $old_rate =  $quan["rate"];
                              $tmp_id =  $quan["id"];
                              $name =  $quan["name"];
                              $unit =  $quan["unit"];
                              $img =  $quan["img"];
                              $unit =  $quan["unit"];
                              $item_sku = "622" . substr($quan['item_id'], 3, 4) . rand(10000, 99999);
                              $item_warehouse = $quan['warehouse_id'];
                              $total_quantity = ($exp_subquantity[$i] * $item_quantity);
                              $new_quantity = $old_quantity - $total_quantity;
                              $newtotal = $quan['quantity'] - $assm_quantity;
                              if ($newtotal < 0) {
                                $new_quantity = 0;
                                $trans_quantity = $quan['quantity'];
                              } else {
                                $new_quantity = $newtotal;
                                $trans_quantity = $assm_quantity;
                              }
                              $total_rate = $old_rate * $trans_quantity;
                              $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                              $stmt88->execute();
                              $stmt99 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$real_item_id','$item_warehouse','314','$created_time','$old_rate','$trans_quantity','$total_rate','$unit','$transfer_id')");
                              $stmt99->execute();

                              if ($newtotal < 0) {
                                $assm_quantity = -1 * $newtotal;
                                $new_quantity = 0;
                              } else {
                                $stmt75 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                $stmt75->execute();
                                $count75 = $stmt75->rowCount();
                                if ($count75 > 0) {
                                  while ($row75 = $stmt75->fetchAll(PDO::FETCH_ASSOC)) {
                                    $old_quantity_2 =  $row75[0]["quantity"];
                                    $new_quantity_2 = $old_quantity_2 + $assm_quantity_2;
                                    $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity_2' WHERE `item_id` = '$real_item_id' AND `warehouse_id` = '314' AND `supplier_id` = '$supplier_id' AND `rate` = '$old_rate' ");
                                    $stmt88->execute();
                                  }
                                } else {
                                  $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`)  VALUES ('$orderI','$name','$item_sku','','$unit','$assm_quantity_2','$old_rate','1','314','$created_time','$real_item_id','$img','0','0','$order_id')");
                                  $stmt99->execute();
                                }
                                break;
                              }
                            }
                            $i++;
                          }
                        }
                      }
                      $stmt102 = $con->prepare("INSERT INTO `transfer_orders` (`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
                      $stmt102->execute();
                    }
                  }
                }
              }
            }
          }
        }
      }
      $stmt5 = $con->prepare("UPDATE `manufacturer_orders` SET `received`='$received',`started`='$started',`status`='$status' WHERE `order_id`='$order_id'");
      $stmt5->execute();
      header("location:manufacturerdetails.php?uid=$supplier_id");
      exit();
    }
  }
}


function get_supplierinfo_by_id($id)
{
  global $con; // Global connection with database
  if (substr($id, 0, 1) == "M") {
    $m = "manufacturers";
  } else {
    $m = "suppliers";
  }
  $stmt = $con->prepare("SELECT * FROM `$m` WHERE `id` = '$id' ");
  $stmt->execute();
  $supp_info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  return $supp_info;
}

function get_warehouseinfo_by_id($id)
{
  global $con; // Global connection with database
  $stmt = $con->prepare("SELECT * FROM `warehouses` WHERE `id` = '$id' ");
  $stmt->execute();
  $count = $stmt->rowCount(); // Check if the id from GET exist in database
  $ware_info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  return $ware_info;
}
function get_number($section)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `$section`");
  $stmt->execute();
  $count =  $stmt->rowCount();
  echo $count;
}

function get_number_unique($section)
{
  global $con;
  $stmt = $con->prepare("SELECT DISTINCT `item_id` FROM `$section` WHERE `warehouse_id` != '314'");
  $stmt->execute();
  $count =  $stmt->rowCount();
  echo $count;
}
function chart_customers()
{
  global $con;
  date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
  $date = strtotime(date("Y-m-d")); // Get timestamp for the date
  $day = date('d', $date); // Get actual day
  $m = date('m', $date); // Get actual month
  $y = date('Y', $date); // Get actual year
  $start_date = $y . '-01-01';
  $counts = array();

  for ($x = 1; $x <= $day; $x++) {
    if ($x < 10) {
      $x = "0" . $x;
    }
    $end_date  = $y . '-' . $m . '-' . $x;
    $stmt = $con->prepare("SELECT * FROM `customers` WHERE created_time BETWEEN '$start_date' AND '$end_date'");
    $stmt->execute();
    $count = $stmt->rowCount();
    array_push($counts, $count);
  }
  echo json_encode($counts);
}
function last_10_customers()
{
  global $con;
  global $path;
  $stmt = $con->prepare("SELECT * FROM `customers` ORDER BY `created_time` DESC LIMIT 10");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $customer) {
        if (empty($customer['mobile'])) {
          $phone = $customer['phone'];
        } else {
          $phone = $customer['mobile'];
        }
        if ($customer['is_company'] == "1") {
          $name = ucfirst($customer['company_name']);
          $company_name = "";
          $img = "company3.png";
        } else {
          $name = ucfirst($customer['first_name']) . " " . ucfirst($customer['middle_name']) . " " . ucfirst($customer['last_name']);
          $company_name = ucfirst($customer['company_name']);
          $img = "profile3.png";
        }
        echo '<li>
        <a href="' . $path . '/customerdetails.php?uid=' . $customer["id"] . '" target="_blank">
          <div>
            <div class="img-prof">
              <img src="../images/ur-img/' . $img . '" alt="" />
            </div>
            <div class="name">' . $name . '<span>' . $company_name . '</span></div>
          </div>
          <div>' . $phone . '</div>
          <div>' . $customer["city"] . '</div>
          <div>' . $customer["email"] . '</div>
          <div>' . $customer["created_time"] . '</div>
        </a>
      </li>';
      }
    }
  }
}
function chart_manufacturing_orders()
{
  global $con;
  date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
  $date = strtotime(date("Y-m-d")); // Get timestamp for the date
  $day = date('d', $date); // Get actual day
  $m = date('m', $date); // Get actual month
  $y = date('Y', $date); // Get actual year
  $start_date = $y . '-01-01';
  $counts = array();

  for ($x = 1; $x <= $m; $x++) {
    if ($x < 10) {
      $x = "0" . $x;
    }
    $end_date  = $y . '-' . $x . '-31';
    $stmt = $con->prepare("SELECT DISTINCT `order_id` FROM `manufacturer_orders` WHERE created_time BETWEEN '$start_date' AND '$end_date'");
    $stmt->execute();
    $count = $stmt->rowCount();
    array_push($counts, $count);
  }
  echo json_encode($counts);
}

function chart_purchase_orders()
{
  global $con;
  date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
  $date = strtotime(date("Y-m-d")); // Get timestamp for the date
  $day = date('d', $date); // Get actual day
  $m = date('m', $date); // Get actual month
  $y = date('Y', $date); // Get actual year
  $start_date = $y . '-01-01';
  $counts = array();

  for ($x = 1; $x <= $m; $x++) {
    if ($x < 10) {
      $x = "0" . $x;
    }
    $end_date  = $y . '-' . $x . '-31';
    $stmt = $con->prepare("SELECT DISTINCT `order_id` FROM `supplier_orders` WHERE created_time BETWEEN '$start_date' AND '$end_date'");
    $stmt->execute();
    $count = $stmt->rowCount();
    array_push($counts, $count);
  }
  echo json_encode($counts);
}

function active_users()
{
  global $con;
  global $path;
  $stmt = $con->prepare("SELECT * FROM `users` WHERE `online` = '1'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $customer) {
        $name = ucfirst($customer['fname']) . " " . ucfirst($customer['mname']) . " " . ucfirst($customer['lname']);
        $role_id = $customer['role'];
        $stmt2 = $con->prepare("SELECT * FROM `user_roles` WHERE `id` = '$role_id'");
        $stmt2->execute();
        $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); // Loop for queries
        $role_name = $row2[0]['name'];
        echo '<li>
        <a href="' . $path . '/employeedetails.php?uid=' . $customer["id"] . '" target="_blank">
          <div>
            <div class="img-prof">
              <img src="../images/ur-img/profile3.png" alt="">
            </div>
            <div class="name">' . $name . '<span>' . $role_name . '</span></div>
          </div>
          <div> <span class="circle_gn"></span> Online</div>
        </a>
        </li>';
      }
    }
  }
}
function users_count()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `users` WHERE `type` = 'user'");
  $stmt->execute();
  $count = $stmt->rowCount();
  return $count;
}
function get_banks()
{
  global $con;
  $stmt = $con->prepare("SELECT DISTINCT bank_name FROM `bank_account`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $bank) {
        $name = $bank['bank_name'];
        echo '<option value="' . $name . '">' . $name . '</option>';
      }
    }
  }
}

function get_in_cashes()
{
  global $con;
  $total = 0;
  $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['amount'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }

  return $total;
}

function get_out_cashes()
{
  global $con;
  $cashes = array();
  $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $supp_id = $supp['supplier_id'];
        $stmt2 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($row2['is_company'] == "1") {
          $name = $row2['company_name'];
        } else {
          $name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
        }
        $statement = 'Cash out to <a href="../contacts/supplierdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (SUPPLIER)';
        $date = $supp['date'];
        $debit = number_format($supp['debit'], 2);
        $credit = number_format($supp['credit'], 2);
        $cash = array(
          'statement' => $statement,
          'date' => $date,
          'debit' => $debit,
          'credit' => $credit,
        );
        $total += $supp['debit'];
        array_push($cashes, $cash);
      }
    }
  }
  $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp2) {
        $supp_id2 = $supp2['supplier_id'];
        $stmt4 = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id2'");
        $stmt4->execute();
        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
        if ($row4['is_company'] == "1") {
          $name2 = $row4['company_name'];
        } else {
          $name2 = $row4['first_name'] . ' ' . $row4['middle_name'] . ' ' . $row4['last_name'];
        }
        $statement2 = 'Cash out to <a href="../contacts/manufacturerdetails.php?uid=' . $supp_id2 . '" target="_blank">' . $name2 . '</a> (MANUFACTURER)';
        $date2 = $supp2['date'];
        $debit2 = number_format($supp2['debit'], 2);
        $credit2 = number_format($supp2['credit'], 2);
        $cash2 = array(
          'statement' => $statement2,
          'date' => $date2,
          'debit' => $debit2,
          'credit' => $credit2,
        );
        $total += $supp2['debit'];
        array_push($cashes, $cash2);
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['init_price'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `from_payment_method` = 'cash'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['amount'];
      }
    }
  }
  return $total;
}


function get_total_cashes()
{
  $cash_in = get_in_cashes();
  $cash_out = get_out_cashes();
  $total = round(($cash_in - $cash_out), 2);
  return $total;
}

function import_customer_purchase()
{
  global $con;
  if (
    isset($_POST["p"]) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['terms']) &&
    isset($_POST['payment_m']) &&
    isset($_POST['cdate']) &&
    isset($_POST['subtotal']) &&
    isset($_POST['due_balance']) &&
    isset($_POST['total']) &&
    isset($_POST['save_order_purchase']) &&
    isset($_POST['inv_number']) &&
    !empty($_POST["p"]) &&
    !empty($_POST["supplier_id"]) &&
    !empty($_POST["terms"]) &&
    !empty($_POST["payment_m"]) &&
    !empty($_POST["cdate"]) &&
    !empty($_POST["subtotal"]) &&
    !empty($_POST["total"]) &&
    !empty($_POST['inv_number'])
  ) {
    $total_cost = 0;

    foreach ($_POST['p'] as $array) {
      $array['total'] = floatval($array['quantity']) * floatval($array['idy']);
      $total_cost += $array['total'];
    }

    if (isset($_POST['withholding']) && !empty($_POST['withholding'])) {
      $withholding = $_POST['withholding'];
    } else {
      $withholding = 0;
    }
    if (isset($_POST['notes']) && !empty($_POST['notes'])) {
      $notes = $_POST['notes'];
    } else {
      $notes = "";
    }
    $supplier_id = trim($_POST['supplier_id']);
    $terms = trim($_POST['terms']);
    $payment_m = $_POST['payment_m'];
    $dateString = $_POST['cdate'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $total = round($_POST['total'], 2);
    $due_balance = round($_POST['due_balance'], 2);
    $order_id = trim($_POST['inv_number']);
    if (isset($_POST['discount'])) {
      $discount = $_POST['discount'];
    } else {
      $discount = 0;
    }
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else {
      $bank_number = $_POST['bank_number'];
      $bank_name = $_POST['bank'];
    }

    if (isset($_POST['vat'])) {
      $vat_perc = $_POST['vat'];
    } else {
      $vat_perc = 0;
    }
    if (isset($_POST['vat_amount'])) {
      $vat_amount = round($_POST['vat_amount'], 2);
    } else {
      $vat_amount = 0;
    }
    $subtotal = $_POST['subtotal'];
    $type = "Sale Invoice";
    $received = 0;
    $due_to = "";
    $status = "";


    if (isset($_POST["received"])) {
      $received = 1;
      if (isset($_POST['statement']) && !empty($_POST['statement'])) {
        $statement = trim($_POST['statement']);
      } else {
        $statement = "";
      }
      if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
        $paid = $_POST['paid'];
        $stmt3 = $con->prepare("SELECT * FROM `sell_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $total;
          $new_balance = $balance + $paid;
        } else {
          $balance = -1 * $total;
          $new_balance = $balance + $paid;
        }
        $stmt2 = $con->prepare("INSERT INTO sell_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$total','0','$balance','$created_time','','','$statement','')");
        $stmt2->execute();
        $cash_statement = "استلام دفعه نقديه مقدم";
        $stmt3 = $con->prepare("INSERT INTO sell_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$paid','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
        $stmt3->execute();
      } else {
        $paid = 0;
        $stmt3 = $con->prepare("SELECT * FROM `sell_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum - $total;
          $new_balance = $balance + $paid;
        } else {
          $balance = -1 * $total;
          $new_balance = $balance + $paid;
        }
        $stmt2 = $con->prepare("INSERT INTO sell_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$total','0','$balance','$created_time','','','$statement','')");
        $stmt2->execute();
      }
    } else {
      $received = 0;
      if (isset($_POST['statement']) && !empty($_POST['statement'])) {
        $statement = trim($_POST['statement']);
      } else {
        $statement = "";
      }
      if (isset($_POST['paid']) && $_POST['paid'] !== 0 && !empty($_POST['paid'])) {
        $paid = $_POST['paid'];
        $stmt3 = $con->prepare("SELECT * FROM `sell_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum;
          $new_balance = $balance + $paid;
        } else {
          $new_balance = $paid;
        }
        $cash_statement = "استلام دفعه نقديه مقدم";
        $stmt3 = $con->prepare("INSERT INTO sell_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$paid','$new_balance','$created_time','$payment_m','$bank_name','$cash_statement','$bank_number')");
        $stmt3->execute();
      } else {
        $paid = 0;
      }
    }

    if ($paid == $total || $paid > $total) {
      $status = "paid";
    } else {
      $status = "overdue";
    }
    if ($terms == "dueonreceipt") {
      if (isset($_POST["received"])) {
        if ($paid == $total || $paid > $total) {
          $status = "paid";
        } else {
          $status = "overdue";
        }
      } else {
        if ($paid == $total || $paid > $total) {
          $status = "paid";
        } else {
          $status = "due";
        }
      }
      $due_to = $created_time;
    } else {
      $due_to = date("Y-m-d h:i A", strtotime("+" . $terms . "days", strtotime($created_time)));
      if ($paid == $total || $paid > $total) {
        $status = "paid";
      } else {
        $status = "due";
      }
    }



    $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
      return
        !empty($row["id"]);
    }));

    $stmt = $con->prepare("INSERT INTO sell_orders (`supplier_id`, `item_id`, `quantity`, `amount`, `total`, `order_id`, `created_time`, `status`, `due_to`, `description`, `balance_due`, `paid`, `order_total`, `type`, `received`, `notes`,`vat_perc`,`vat_amount`,`subtotal`,`discount`,`withholding`,`payment_m`,`bank_name`,`bank_number`,`sell_cost`) VALUES (:supplier_id, :item_id, :item_quantity, :item_amount, :item_total, :order_id, :created_time, :status, :due_to, :item_desc, :due_balance, :paid, :total, :type, :received, :notes,:vat_perc,:vat_amount,:subtotal,:discount,:withholding,:payment_m,:bank,:bank_number,:total_cost)");
    foreach ($filteredArray as $fa) {
      $item_id = $fa['id'];
      $item_quantity = $fa['quantity'];
      $item_amount = $fa['amount'];
      $item_total = $fa['total'];
      $item_desc = $fa['description'];
      $count_of_items = count($filteredArray);
      if ($item_quantity < 0) {
        $type = 'Return Invoice';
      }
      $item_total_vat_inc = $item_amount - ((($item_total / $subtotal) * $discount) / $item_quantity);
      $stmt->bindParam(':supplier_id', $supplier_id);
      $stmt->bindParam(':item_id', $item_id);
      $stmt->bindParam(':item_quantity', $item_quantity);
      $stmt->bindParam(':item_amount', $item_amount);
      $stmt->bindParam(':item_total', $item_total);
      $stmt->bindParam(':order_id', $order_id);
      $stmt->bindParam(':created_time', $created_time);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':due_to', $due_to);
      $stmt->bindParam(':item_desc', $item_desc);
      $stmt->bindParam(':due_balance', $due_balance);
      $stmt->bindParam(':paid', $paid);
      $stmt->bindParam(':total', $total);
      $stmt->bindParam(':type', $type);
      $stmt->bindParam(':received', $received);
      $stmt->bindParam(':notes', $notes);
      $stmt->bindParam(':subtotal', $subtotal);
      $stmt->bindParam(':vat_amount', $vat_amount);
      $stmt->bindParam(':vat_perc', $vat_perc);
      $stmt->bindParam(':discount', $discount);
      $stmt->bindParam(':withholding', $withholding);
      $stmt->bindParam(':payment_m', $payment_m);
      $stmt->bindParam(':bank', $bank_name);
      $stmt->bindParam(':bank_number', $bank_number);
      $stmt->bindParam(':total_cost', $total_cost);
      $stmt->execute();


      if (isset($_POST["received"])) {
        $available_quantities = array();
        $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' ORDER BY `created_time` ASC");
        $stmt2->execute();
        $count2 = $stmt2->rowCount();
        if ($count2 > 0) {
          while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($row2 as $one) {
              array_push($available_quantities, $one);
            }
          }
        }
        $assm_quantity = $item_quantity;
        foreach ($available_quantities as $quan) {
          $old_quantity =  $quan["quantity"];
          $tmp_id =  $quan["id"];
          $new_quantity = $old_quantity - $assm_quantity;
          $newtotal = $quan['quantity'] - $assm_quantity;
          if ($newtotal < 0) {
            $new_quantity = 0;
          } else {
            $new_quantity = $newtotal;
          }
          $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
          $stmt88->execute();
          if ($newtotal < 0) {
            $assm_quantity = -1 * $newtotal;
            $new_quantity = 0;
          } else {
            break;
          }
        }
      }
    }
    header("location:customerdetails.php?uid=$supplier_id");
    exit();
  }
}


function import_quick_sell_payment()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_bank_name']) &&
    isset($_POST['amount_payment_method']) &&
    !empty($_POST['pay']) &&
    !empty($_POST['supplier_id']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_bank_name']) &&
    !empty($_POST['amount_payment_method'])
  ) {
    $supplier_id = $_POST['supplier_id'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_account = "";
    } else {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_account = trim($_POST['amount_bank_number']);
    }
    if (isset($_POST['amount_statement']) && !empty($_POST['amount_statement'])) {
      $statement = trim($_POST['amount_statement']);
    } else {
      $statement = "";
    }
    if (isset($_POST['order_id']) && isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];

        $stmt3 = $con->prepare("SELECT * FROM `sell_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
          $balance = $sum + $amount;
        } else {
          $balance = $amount;
        }




        if ($_POST['order_id'] == "custom") {
          $stmt = $con->prepare("INSERT INTO `sell_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','','0','$amount','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_account')");
          $stmt->execute();
          header("location:customerdetails.php?uid=$supplier_id");
          exit();
        } else {
          $order_id = $_POST['order_id'];
          $stmt2 = $con->prepare("SELECT * FROM `sell_orders` WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id' LIMIT 1");
          $stmt2->execute();
          $count2 = $stmt2->rowCount();
          if ($count2 > 0) {
            while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
              foreach ($row2 as $ord) {
                $old_balance_due = $ord['balance_due'];
                $old_received = $ord['received'];
                $old_due_to = $ord['due_to'];
                $old_paid = $ord['paid'];
              }
            }
            $balance_due = $old_balance_due - $amount;
            $paid = $old_paid + $amount;

            if ($old_received == '1') {
              $givenTimestamp = strtotime($old_due_to);
              $currentTimestamp = time();

              if ($balance_due == "0") {
                $status = "paid";
              } else {
                if ($currentTimestamp > $givenTimestamp) {
                  $status = "overdue";
                } else {
                  $status = "due";
                }
              }
            } else {
              if ($balance_due == "0") {
                $status = "paid";
              } else {
                $status = "due";
              }
            }
            $stmt3 = $con->prepare("UPDATE `sell_orders` SET  `balance_due` = '$balance_due' , `status` = '$status', `paid` = '$paid' WHERE `order_id` = '$order_id' AND `supplier_id` = '$supplier_id'");
            $stmt3->execute(); // Update salary in salary_employee
            $stmt = $con->prepare("INSERT INTO `sell_transactions`(`supplier_id`, `refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','0','$amount','$balance','$created_time','$payment_m','$bank_name','$statement','$bank_account')");
            $stmt->execute();
            header("location:customerdetails.php?uid=$supplier_id");
          }
        }
      }
    }
  }
}


function edit_customer_purchase()
{
  global $con;
  if (isset($_POST['order_id']) && isset($_POST['curr_total']) && isset($_POST['curr_due']) && isset($_POST['edit_order_purchase']) && isset($_POST['supplier_id']) && isset($_POST['due_to'])) {
    $supplier_id = trim($_POST['supplier_id']);
    $created_time = date("Y-m-d h:i A");
    $order_id = trim($_POST['order_id']);
    if (isset($_POST['old_paid']) && !empty($_POST['old_paid'])) {
      $old_paid = floatval(str_replace(',', '', $$_POST['old_paid']));
    } else {
      $old_paid = 0;
    }
    if (isset($_POST['paid']) && !empty($_POST['paid']) && $_POST['paid'] !== 0) {
      $curr_paid = floatval(str_replace(',', '', $_POST['paid']));
    } else {
      $curr_paid = 0;
    }
    $due_to = floatval(str_replace(',', '', $_POST['due_to']));
    $curr_total = floatval(str_replace(',', '', $_POST['curr_total']));
    $curr_due = floatval(str_replace(',', '', $_POST['curr_due']));


    $total_paid = $old_paid + $curr_paid;
    if ($curr_due < 0) {
    } else {
      if ($curr_due == 0) {
        $status = "paid";
        if (isset($_POST['received'])) {
          $received = 1;
        } else {
          $received = 0;
        }
      } else {
        if (isset($_POST['received'])) {
          $received = 1;
          $givenTimestamp = strtotime($due_to);
          $currentTimestamp = time();
          if ($currentTimestamp > $givenTimestamp) {
            $status = "overdue";
          } else {
            $status = "due";
          }
        } else {
          $received = 0;
          $status = "due";
        }
      }


      if (isset($_POST['received'])) {


        $stmt8 = $con->prepare("SELECT * FROM `sell_orders` WHERE `order_id` = '$order_id'");
        $stmt8->execute();
        $count8 = $stmt8->rowCount();
        if ($count8 > 0) {
          while ($row8 = $stmt8->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row8 as $ord) {
              $prev_rec = $ord['received'];
              if ($prev_rec == 0) {
                $payment_m = $ord['payment_m'];
                $bank_name = $ord['bank_name'];
                $statement = "فاتوره مبيعات";
                $stmt3 = $con->prepare("SELECT * FROM `sell_transactions` WHERE `supplier_id` = '$supplier_id' ORDER BY id DESC LIMIT 1");
                $stmt3->execute();
                $count3 = $stmt3->rowCount();
                if ($count3 > 0) {
                  $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                  $sum = $row3['balance'];
                  $balance = $sum - $curr_total;
                } else {
                  $balance = -1 * $curr_total;
                }





                $item_id = $ord['item_id'];
                $item_quantity = $ord['quantity'];
                $available_quantities = array();
                $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' ORDER BY `created_time` ASC");
                $stmt2->execute();
                $count2 = $stmt2->rowCount();
                if ($count2 > 0) {
                  while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
                    foreach ($row2 as $one) {
                      array_push($available_quantities, $one);
                    }
                  }
                }
                $assm_quantity = $item_quantity;
                foreach ($available_quantities as $quan) {
                  $old_quantity =  $quan["quantity"];
                  $tmp_id =  $quan["id"];
                  $new_quantity = $old_quantity - $assm_quantity;
                  $newtotal = $quan['quantity'] - $assm_quantity;
                  if ($newtotal < 0) {
                    $new_quantity = 0;
                  } else {
                    $new_quantity = $newtotal;
                  }
                  $stmt88 = $con->prepare("UPDATE `av_items` SET `quantity`='$new_quantity' WHERE `id` = '$tmp_id'");
                  $stmt88->execute();
                  if ($newtotal < 0) {
                    $assm_quantity = -1 * $newtotal;
                    $new_quantity = 0;
                  } else {
                    break;
                  }
                }
              }
            }
            $stmt2 = $con->prepare("INSERT INTO sell_transactions (`supplier_id`,`refere_order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`note`,`bank_number`) VALUES ('$supplier_id','$order_id','$curr_total','0','$balance','$created_time','','','$statement','')");
            $stmt2->execute();
          }
        }
      }
      $stmt5 = $con->prepare("UPDATE `sell_orders` SET `received`='$received',`status`='$status' WHERE `order_id`='$order_id'");
      $stmt5->execute();
      header("location:customerdetails.php?uid=$supplier_id");
      exit();
    }
  }
}
function delete_order($s)
{
  global $con;
  if (isset($_POST['id']) && isset($_POST['confirm_id'])) {
    $supp_id = $_POST['id'];
    $order_id = $_POST['confirm_id'];
    $stmt2 = $con->prepare("SELECT * FROM `$s` WHERE `supplier_id` = '$supp_id' AND `order_id` = '$order_id' LIMIT 1");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($count2 > 0) {
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if (isset($row2['started'])) {
        $status = $row2['started'];
      } else {
        $status = $row2['received'];
      }
      if ($status == "0") {
        $stmt998 = $con->prepare("DELETE FROM `$s` WHERE `supplier_id` = '$supp_id' AND `order_id` = '$order_id'");
        $stmt998->execute();
        if ($s == "supplier_orders") {
          header("location:supplierdetails.php?uid=$supp_id");
        } else if ($s == "manufacturer_orders") {
          header("location:manufacturerdetails.php?uid=$supp_id");
        } else if ($s == "sell_orders") {
          header("location:customerdetails.php?uid=$supp_id");
        }
        exit();
      }
    }
  }
}
function delete_expense()
{
  global $con;
  if (isset($_POST['confirm_id'])) {
    $order_id = $_POST['confirm_id'];
    $stmt998 = $con->prepare("DELETE FROM `expenses` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:expenses.php");
    exit();
  }
}
function get_in_share($s = "")
{
  global $con;
  $total = 0;
  $cashes = array();
  if (empty($s)) {
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0'");
  } else {
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `supplier_id` = '$s'");
  }
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  return $total;
}
function get_out_share($s = "")
{
  global $con;
  $total = 0;
  $cashes = array();
  if (empty($s)) {
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0'");
  } else {
    $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `supplier_id` = '$s'");
  }
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  return $total;
}


function get_total_share($s = "")
{
  $cash_in = get_in_share($s);
  $cash_out = get_out_share($s);
  $total = round(($cash_in - $cash_out), 2);
  return $total;
}
function import_share()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['type']) &&


    !empty($_POST['pay']) &&
    !empty($_POST['type']) &&
    !empty($_POST['supplier_id']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment_method'])
  ) {
    $supplier_id = $_POST['supplier_id'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_account = "";
    } else {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_account = trim($_POST['amount_bank_number']);
    }
    if (isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];
        if ($_POST['type'] == "1") {
          $sum = get_total_share($supplier_id);
          $balance = $sum + $amount;
          $stmt = $con->prepare("INSERT INTO `share_transactions`(`supplier_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('$supplier_id','0','$amount','$balance','$created_time','$payment_m','$bank_name','$bank_account')");
          $stmt->execute();
          header("location:accountdetails.php?uid=$supplier_id");
          exit();
        } else if ($_POST['type'] == "2") {
          $sum = get_total_share($supplier_id);
          $balance = $sum - $amount;
          $stmt = $con->prepare("INSERT INTO `share_transactions`(`supplier_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('$supplier_id','$amount','0','$balance','$created_time','$payment_m','$bank_name','$bank_account')");
          $stmt->execute();
          header("location:accountdetails.php?uid=$supplier_id");
          exit();
        }
      }
    }
  }
}


function get_in_bank($bank_name, $bank_number)
{
  global $con;
  $total = 0;
  $cashes = array();
  $stmt = $con->prepare("SELECT * FROM `sell_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number' ");
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }

  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `asset_transactions` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `to_payment_method` = 'bank' AND `to_bank_name` = '$bank_name' AND `to_bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['amount'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `revenues` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }
  return $total;
}

function get_out_bank($bank_name, $bank_number)
{
  global $con;
  $cashes = array();
  $stmt = $con->prepare("SELECT * FROM `supplier_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $supp_id = $supp['supplier_id'];
        $stmt2 = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$supp_id'");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($row2['is_company'] == "1") {
          $name = $row2['company_name'];
        } else {
          $name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
        }
        $statement = 'Cash out to <a href="../contacts/supplierdetails.php?uid=' . $supp_id . '" target="_blank">' . $name . '</a> (SUPPLIER)';
        $date = $supp['date'];
        $debit = number_format($supp['debit'], 2);
        $credit = number_format($supp['credit'], 2);
        $cash = array(
          'statement' => $statement,
          'date' => $date,
          'debit' => $debit,
          'credit' => $credit,
        );
        $total += $supp['debit'];
        array_push($cashes, $cash);
      }
    }
  }
  $stmt3 = $con->prepare("SELECT * FROM `manufacturer_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt3->execute();
  $count3 = $stmt3->rowCount();
  if ($count3 > 0) {
    while ($row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row3 as $supp2) {
        $supp_id2 = $supp2['supplier_id'];
        $stmt4 = $con->prepare("SELECT * FROM `manufacturers` WHERE `id` = '$supp_id2'");
        $stmt4->execute();
        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
        if ($row4['is_company'] == "1") {
          $name2 = $row4['company_name'];
        } else {
          $name2 = $row4['first_name'] . ' ' . $row4['middle_name'] . ' ' . $row4['last_name'];
        }
        $statement2 = 'Cash out to <a href="../contacts/manufacturerdetails.php?uid=' . $supp_id2 . '" target="_blank">' . $name2 . '</a> (MANUFACTURER)';
        $date2 = $supp2['date'];
        $debit2 = number_format($supp2['debit'], 2);
        $credit2 = number_format($supp2['credit'], 2);
        $cash2 = array(
          'statement' => $statement2,
          'date' => $date2,
          'debit' => $debit2,
          'credit' => $credit2,
        );
        $total += $supp2['debit'];
        array_push($cashes, $cash2);
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `share_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `exchange_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `expenses` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['total'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `vat_transactions` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `cbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `dbalance_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `assets` WHERE `payment_method` = 'bank' AND `bank_name` = '$bank_name' AND `bank_account` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['init_price'];
      }
    }
  }
  $stmt = $con->prepare("SELECT * FROM `transfer_money` WHERE `from_payment_method` = 'bank' AND `from_bank_name` = '$bank_name' AND `from_bank_number` = '$bank_number'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['amount'];
      }
    }
  }
  return $total;
}


function get_total_bank($bank_name, $bank_number)
{
  $cash_in = get_in_bank($bank_name, $bank_number);
  $cash_out = get_out_bank($bank_name, $bank_number);
  $total = round(($cash_in - $cash_out), 2);
  return $total;
}

function get_suppliers_option()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `suppliers`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      echo '<optgroup label="Suppliers">';
      foreach ($row as $opt) {
        if ($opt['is_company'] == "1") {
          echo '<option value="' . $opt['id'] . '">' . $opt['company_name'] . '</option>';
        } else {
          echo '<option value="' . $opt['id'] . '">' . $opt['first_name'] . ' ' . $opt['middle_name'] . ' ' . $opt['last_name'] . '</option>';
        }
      }
      echo '</optgroup>';
    }
  }
}

function get_manufacturers_option()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `manufacturers`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      echo '<optgroup label="Manufacturers">';
      foreach ($row as $opt) {
        if ($opt['is_company'] == "1") {
          echo '<option value="' . $opt['id'] . '">' . $opt['company_name'] . '</option>';
        } else {
          echo '<option value="' . $opt['id'] . '">' . $opt['first_name'] . ' ' . $opt['middle_name'] . ' ' . $opt['last_name'] . '</option>';
        }
      }
      echo '</optgroup>';
    }
  }
}

function import_exchange()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['type']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_bank_name']) &&
    isset($_POST['amount_bank_number']) &&
    isset($_POST['description']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['type']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_bank_name']) &&
    !empty($_POST['amount_bank_number']) &&
    isset($_POST['description']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment'])
  ) {

    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $description = trim($_POST['description']);
    $payment_method = $_POST['amount_payment_method'];
    $bank_name = $_POST['amount_bank_name'];
    $bank_number = $_POST['amount_bank_number'];

    if (isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];
        $stmt3 = $con->prepare("SELECT * FROM `exchange_transactions` ORDER BY id DESC LIMIT 1");
        $stmt3->execute();
        $count3 = $stmt3->rowCount();
        if ($count3 > 0) {
          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $sum = $row3['balance'];
        } else {
          $sum = 0;
        }
        if ($_POST['type'] == "1") {
          $balance = $sum + $amount;
          $stmt = $con->prepare("INSERT INTO `exchange_transactions`(`supplier_id`,`order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('0','$description','0','$amount','$balance','$created_time','$payment_method','$bank_name','$bank_number')");
          $stmt->execute();
          header("location:exchange.php");
          exit();
        } else if ($_POST['type'] == "2") {
          $balance = $sum - $amount;
          $stmt = $con->prepare("INSERT INTO `exchange_transactions`(`supplier_id`,`order_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('0','$description','$amount','0','$balance','$created_time','$payment_method','$bank_name','$bank_number')");
          $stmt->execute();
          header("location:exchange.php");
          exit();
        }
      }
    }
  }
}

function import_expense()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['type']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['name']) &&
    isset($_POST['quantity']) &&
    isset($_POST['amount']) &&
    isset($_POST['total']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['type']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['name']) &&
    !empty($_POST['quantity']) &&
    !empty($_POST['amount']) &&
    !empty($_POST['total'])
  ) {
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $type = $_POST['type'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $payment_method = $_POST['amount_payment_method'];
    if ($payment_method == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else if ($payment_method == "bank") {
      $bank_name = $_POST['bank_name'];
      $bank_number = $_POST['bank_number'];
    }
    $stmt = $con->prepare("INSERT INTO `expenses`(`type`,`name`,`quantity`,`amount`,`total`,`payment_method`,`date`,`bank_name`,`bank_number`) VALUES ('$type','$name','$quantity','$amount','$total','$payment_method','$created_time','$bank_name','$bank_number')");
    $stmt->execute();
    header("location:expenses.php");
    exit();
  }
}

function import_vat_payment()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_payment']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_payment'])
  ) {
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_method = $_POST['amount_payment_method'];
    $amount = $_POST['amount_payment'];
    if ($payment_method == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else if ($payment_method == "bank") {
      $bank_name = $_POST['bank_name'];
      $bank_number = $_POST['bank_number'];
    }
    $stmt = $con->prepare("INSERT INTO `vat_transactions`(`debit`,`credit`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('$amount','0','$created_time','$payment_method','$bank_name','$bank_number')");
    $stmt->execute();
    header("location:vtax.php");
    exit();
  }
}
function delete_balance($s)
{
  global $con;
  if (isset($_POST['confirm_id'])) {
    $order_id = $_POST['confirm_id'];
    $stmt998 = $con->prepare("DELETE FROM `$s` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:cbalances.php");
    exit();
  }
}
function check_balance($s, $id)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `$s` WHERE `supplier_id` = '$id' ");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    return 1;
  } else {
    return 0;
  }
}


function import_trans($s)
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['supplier_id']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['type']) &&
    isset($_POST['statement']) &&


    !empty($_POST['pay']) &&
    !empty($_POST['type']) &&
    !empty($_POST['supplier_id']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['statement'])
  ) {
    $supplier_id = $_POST['supplier_id'];
    $input_date = $_POST['amount_cdate'];
    $notes = $_POST['statement'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "bank") {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_account = trim($_POST['amount_bank_number']);
    } else {
      $bank_name = "";
      $bank_account = "";
    }
    $stmt = $con->prepare("SELECT SUM(`credit`) as `total_credit` FROM `$s` WHERE `debit` = '0' AND `supplier_id` = '$supplier_id'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $total_credit = $row['total_credit'];
    } else {
      $total_credit = 0;
    }

    $stmt2 = $con->prepare("SELECT SUM(`debit`) as `total_debit` FROM `$s` WHERE `credit` = '0' AND `supplier_id` = '$supplier_id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($count2 > 0) {
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $total_debit = $row2['total_debit'];
    } else {
      $total_debit = 0;
    }
    $sum = $total_credit - $total_debit;
    if (isset($_POST['amount_payment'])) {
      if ($_POST['amount_payment'] !== "0" || !empty($_POST['amount_payment'])) {
        $amount = $_POST['amount_payment'];
        if ($_POST['type'] == "1") {
          $balance = $sum + $amount;
          $stmt = $con->prepare("INSERT INTO `$s`(`note`,`supplier_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('$notes','$supplier_id','0','$amount','$balance','$created_time','$payment_m','$bank_name','$bank_account')");
          $stmt->execute();
          if ($s == "cbalance_transactions") {
            header("location:cbalance.php?uid=$supplier_id");
          } else if ($s == "dbalance_transactions") {
            header("location:dbalance.php?uid=$supplier_id");
          }
          exit();
        } else if ($_POST['type'] == "2") {
          $balance = $sum - $amount;
          $stmt = $con->prepare("INSERT INTO `$s`(`note`,`supplier_id`,`debit`,`credit`,`balance`,`date`,`payment_method`,`bank_name`,`bank_number`) VALUES ('$notes','$supplier_id','$amount','0','$balance','$created_time','$payment_m','$bank_name','$bank_account')");
          $stmt->execute();
          if ($s == "cbalance_transactions") {
            header("location:cbalance.php?uid=$supplier_id");
          } else if ($s == "dbalance_transactions") {
            header("location:dbalance.php?uid=$supplier_id");
          }
          exit();
        }
      }
    }
  }
}



function delete_trans($s)
{
  global $con;
  if (isset($_POST['trans_id'])) {
    $order_id = $_POST['trans_id'];
    $order_date = $_POST['trans_date'];
    $order_amount = $_POST['trans_amount'];
    $stmt = $con->prepare("SELECT * FROM `$s` WHERE `id` = '$order_id'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $supp_id = $row['supplier_id'];

    $stmt2 = $con->prepare("SELECT * FROM `$s` WHERE `supplier_id` = '$supp_id' AND `id` > '$order_id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($count2 > 0) {
      while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row2 as $opt) {
          $prev_balance = $opt['balance'];
          $new_balance = $prev_balance + $order_amount;
          $id = $opt['id'];
          $stmt5 = $con->prepare("UPDATE `$s` SET `balance`='$new_balance' WHERE `id`='$id'");
          $stmt5->execute();
        }
      }
    }
    $stmt998 = $con->prepare("DELETE FROM `$s` WHERE `id` = '$order_id'");
    $stmt998->execute();
    if ($s == "cbalance_transactions") {
      header("location:cbalances.php");
    } else if ($s == "dbalance_transactions") {
      header("location:dbalances.php");
    }
  }
}
function get_expenses_option()
{
  global $con;
  $stmt = $con->prepare("SELECT DISTINCT `type` FROM `expenses`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['type'] . '">' . $opt['type'] . '</option>';
      }
    }
  }
}

function check_asset_category($id)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `assets` WHERE `category_id` = '$id'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    return 1;
  } else {
    return 0;
  }
}
function delete_category()
{
  global $con;
  if (isset($_POST['confirm_id'])) {
    $order_id = $_POST['confirm_id'];
    $stmt998 = $con->prepare("DELETE FROM `assets_category` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:fassets.php");
    exit();
  }
}

function delete_asset()
{
  global $con;
  if (isset($_POST['trans_id'])) {
    $order_id = $_POST['trans_id'];
    $stmt2 = $con->prepare("SELECT * FROM `assets` WHERE  `id` = '$order_id'");
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $cat_id = $row2['category_id'];
    $stmt998 = $con->prepare("DELETE FROM `assets` WHERE `id` = '$order_id'");
    $stmt998->execute();
    $stmt995 = $con->prepare("DELETE FROM `dep_transactions` WHERE `item_id` = '$order_id'");
    $stmt995->execute();
    header("location:fasset.php?uid=$cat_id");
  }
}

function import_asset($cat_id)
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_pdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['name']) &&
    isset($_POST['quantity']) &&
    isset($_POST['amount']) &&
    isset($_POST['total']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_pdate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['name']) &&
    !empty($_POST['quantity']) &&
    !empty($_POST['amount']) &&
    !empty($_POST['total'])
  ) {
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $start_date = $date->format('Y-m-d');

    $input_date2 = $_POST['amount_pdate'];
    $date2 = new DateTime($input_date2);
    $purchase_date = $date2->format('Y-m-d');
    $dep_rate = $_POST['dep_rate'];

    if (isset($_POST['vat_amount'])) {
      $vat_amount = $_POST['vat_amount'];
    } else {
      $vat_amount = 0;
    }
    if (isset($_POST['withholding'])) {
      $withholding = $_POST['withholding'];
    } else {
      $withholding = 0;
    }

    if ($dep_rate == 0) {
      $num_dep = 0;
    } else {
      $num_dep = floor(100 / $dep_rate) * 12;
    }
    $freq_dep = 1;
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $payment_method = $_POST['amount_payment_method'];
    if ($payment_method == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else if ($payment_method == "bank") {
      $bank_name = $_POST['bank_name'];
      $bank_number = $_POST['bank_number'];
    }
    $total_tax_inc = $total + $vat_amount - $withholding;
    $stmt = $con->prepare("INSERT INTO `assets`(`name`,`quantity`,`amount`,`total`,`init_price`,`final_price`,`dep_perc`,`dep_count`,`category_id`,`dep_numbers`,`dep_freq`,`payment_method`,`start_time`,`date`,`bank_name`,`bank_account`,`witholding`,`vat_amount`,`total_tax_inc`) VALUES ('$name','$quantity','$amount','$total','$total','$total','$dep_rate','0','$cat_id','$num_dep','$freq_dep','$payment_method','$start_date','$purchase_date','$bank_name','$bank_number','$withholding','$vat_amount','$total_tax_inc')");
    $stmt->execute();
    header("location:fasset.php?uid=$cat_id");
    exit();
  }
}

function check_dep()
{
  global $con;
  $current_date = date("Y-m-d");
  $stmt2 = $con->prepare("SELECT * FROM `assets` WHERE `dep_perc` != '0' AND `dep_numbers` != '0' AND `final_price` != '0'");
  $stmt2->execute();
  $count2 = $stmt2->rowCount();
  if ($count2 > 0) {
    while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row2 as $opt) {
        if ($opt['dep_count'] < $opt['dep_numbers']) {
          $date1 = new DateTime($current_date);
          $date2 = new DateTime($opt['start_time']);
          $interval = $date1->diff($date2);
          $months = ($interval->y * 12) + $interval->m;
          $check_num = floor($months / $opt['dep_freq']);
          if ($check_num > $opt['dep_count']) {
            if ($opt['quantity'] > 0) {
              $dep_amount = $opt['total'] * ($opt['dep_perc'] / 12 / 100);
              $id = $opt['id'];
              $category_id = $opt['category_id'];
              $check_diff = $check_num - $opt['dep_count'];
              for ($i = 1; $i <= $check_diff; $i++) {
                $stmt5 = $con->prepare("UPDATE `assets` SET dep_count = dep_count + 1 , final_price = final_price - $dep_amount  WHERE `id` = '$id'");
                $stmt5->execute();
                $stmt7 = $con->prepare("SELECT * FROM `dep_transactions` WHERE `item_id` = '$id' ORDER BY `date` DESC LIMIT 1");
                $stmt7->execute();
                $count7 = $stmt7->rowCount();
                if ($count7 > 0) {
                  $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
                  $old_date = $row7['date'];
                  $new_date = date("Y-m-d", strtotime($old_date . " +" . $opt['dep_freq'] . " months"));
                } else {
                  $new_date = date("Y-m-d", strtotime($opt['start_time'] . " +" . $opt['dep_freq'] . " months"));
                }
                $stmt6 = $con->prepare("INSERT INTO `dep_transactions`(`item_id`,`category_id`,`amount`,`date`) VALUES ('$id','$category_id','$dep_amount','$new_date')");
                $stmt6->execute();
              }
            }
          }
        }
      }
    }
  }
}

function import_sell_asset()
{
  global $con;
  if (
    isset($_POST['sell']) &&
    isset($_POST['cdate']) &&
    isset($_POST['carr_amount']) &&
    isset($_POST['id']) &&
    isset($_POST['name']) &&
    isset($_POST['quantity']) &&
    isset($_POST['amount']) &&
    isset($_POST['total']) &&

    !empty($_POST['sell']) &&
    !empty($_POST['cdate']) &&
    !empty($_POST['carr_amount']) &&
    !empty($_POST['id']) &&
    !empty($_POST['name']) &&
    !empty($_POST['quantity']) &&
    !empty($_POST['amount']) &&
    !empty($_POST['total'])
  ) {
    $dateString = $_POST['cdate'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $carr_amount = $_POST['carr_amount'];
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $amount = $_POST['amount'];
    $total = $_POST['total'];

    $stmt2 = $con->prepare("SELECT * FROM `assets` WHERE `id` = '$id' LIMIT 1");
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $cat_id = $row2['category_id'];
    $stmt3 = $con->prepare("SELECT * FROM `dep_transactions` WHERE `item_id` = '$id'");
    $stmt3->execute();
    $count3 = $stmt3->rowCount();
    if (isset($_POST['vat_amount'])) {
      $vat_amount = $_POST['vat_amount'];
    } else {
      $vat_amount = 0;
    }
    if (isset($_POST['withholding'])) {
      $withholding = $_POST['withholding'];
    } else {
      $withholding = 0;
    }

    $cost = $quantity * $row2['amount'];
    $dep_amount = $cost * $count3 * ($row2['dep_perc'] / 12 / 100);
    $stmt5 = $con->prepare("INSERT INTO `asset_transactions`(`item_id`,`category_id`,`quantity`,`amount`,`total`,`cost`,`date`,`payment_method`,`bank_name`,`bank_number`,`vat_amount`,`withholding`) VALUES ('$id','$cat_id','$quantity','$amount','$total','$cost','$created_time','cash','','','$vat_amount','$withholding')");
    $stmt5->execute();
    if ($count3 > 0) {
      $stmt8 = $con->prepare("INSERT INTO `dep_ex_transactions`(`item_id`,`category_id`,`amount`,`date`) VALUES ('$id','$cat_id','$dep_amount','$created_time')");
      $stmt8->execute();
    }
    $stmt9 = $con->prepare("UPDATE `assets` SET quantity = quantity - $quantity , total = amount * quantity  WHERE `id` = '$id'");
    $stmt9->execute();
    header("location:fasset.php?uid=$cat_id");
    exit();
  }
}



function get_org_option($s, $id = "")
{
  global $con;
  if ($s == 'user_roles') {
    $stmt = $con->prepare("SELECT * FROM `$s` WHERE `def` != '1'");
  } else {

    $stmt = $con->prepare("SELECT * FROM `$s`");
  }
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        if ($id !== '' && $id == $opt['id']) {
          echo '<option value="' . $opt['id'] . '" selected>' . ucfirst($opt['name']) . '</option>';
        } else {
          echo '<option value="' . $opt['id'] . '">' . ucfirst($opt['name']) . '</option>';
        }
      }
    }
  }
}

function get_type_name($s, $j)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `$s` WHERE `id` = '$j' LIMIT 1");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['name'];
  } else {
    return '';
  }
}


function get_org_option_name($s, $id = "")
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `$s`");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        if ($id !== '' && $id == $opt['id']) {
          echo '<option value="' . $opt['name'] . '" selected>' . ucfirst($opt['name']) . '</option>';
        } else {
          echo '<option value="' . $opt['name'] . '">' . ucfirst($opt['name']) . '</option>';
        }
      }
    }
  }
}
function check_item_id()
{
  global $con;
  if (isset($_GET['uid']) && isset($_GET['type'])) {
    if (!empty($_GET['uid']) && !empty($_GET['type'])) {
      $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
      $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
      if ($type == "m") {
        $stmt = $con->prepare("SELECT * FROM `items` WHERE `code` = '$uid'");
        $stmt->execute();
        $id_check = $stmt->rowCount();
        if ($id_check > 0) {
          return 1;
        } else {
          return 0;
        }
      } else if ($type == "f") {
        $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$uid'");
        $stmt->execute();
        $id_check = $stmt->rowCount();
        if ($id_check > 0) {
          return 1;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }
}

function item_id_info() // GET array user info
{
  global $con; // Global connection with database
  // $id = $_SESSION['id']; // id = SESSION
  $id = $_GET['uid'];
  $type = $_GET['type'];
  if ($type == "m") {
    $stmt = $con->prepare("SELECT * FROM `items` WHERE `code` = '$id' ");
    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
    return $info;
  } else if ($type == "f") {
    $stmt = $con->prepare("SELECT * FROM `final_items` WHERE `code` = '$id' ");
    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
    return $info;
  }
}

function get_total_amount($sub_items, $sub_quantity)
{
  global $con;

  $sub_items_array = explode("-", $sub_items);
  $sub_quantity_array = explode("-", $sub_quantity);
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
    $amount = $row['rate'];
    $quantity = $sub_quantity_array[$i];
    $total += ($quantity * $amount);
  }

  return $total;
}

function delete_item($r, $y, $n = '')
{
  global $con;
  if (isset($r) && isset($y) && isset($n)) {
    if (!empty($r) && !empty($y) && !empty($n)) {
      $cid = filter_var($y, FILTER_SANITIZE_STRING);
      if ($r == 'f') {
        $type = 'final_items';
      } else if ($r = 'm') {
        $type = 'items';
      }
      $stmt = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$cid'");
      $stmt->execute();
      $id_check = $stmt->rowCount();
      if ($id_check == 0) {
        $stmt9 = $con->prepare("DELETE FROM `$type` WHERE `code` = '$cid'");
        $stmt9->execute();
      }


      header("location:productsreg.php");
      exit();
    }
  }
}
function change_rate()
{
  global $con;
  if (isset($_POST['change_rate']) && !empty($_POST['change_rate']) && isset($_POST['type']) && isset($_POST['code'])) {
    $type = $_POST['type'];
    $item_id = $_POST['id'];
    $code = $_POST['code'];
    $stmt2 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($type == 'margin') {
      $margin = $_POST['margin'];
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
          foreach ($row2 as $opt) {
            $curr_rate = $opt['rate'];
            $id = $opt['id'];
            $new_rate = $curr_rate / (1 - ($margin / 100));
            $stmt9 = $con->prepare("UPDATE `av_items` SET `margin` = '$margin' , `sell_rate` = '$new_rate'  WHERE `id` = '$id'");
            $stmt9->execute();
          }
        }
      }
    } else if ($type == 'rate') {
      $rate = $_POST['rate'];
      if ($count2 > 0) {
        while ($row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
          foreach ($row2 as $opt) {
            $curr_rate = $opt['rate'];
            $id = $opt['id'];
            $new_margin = (1 - ($curr_rate / $rate)) * 100;
            $stmt9 = $con->prepare("UPDATE `av_items` SET `margin` = '$new_margin' , `sell_rate` = '$rate'  WHERE `id` = '$id'");
            $stmt9->execute();
          }
        }
      }
    }
    header("location:itemdetails.php?uid=$code");
    exit();
  }
}
function get_transfer_order_number()
{
  global $con;
  $stmt = $con->prepare("SELECT MAX(id) FROM `transfer_orders`");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC); // Select Queries from users where id = session
  if (!empty($result['MAX(id)'])) {
    $result['MAX(id)'] += 1;
    return $result['MAX(id)'];
  } else {
    return 1;
  }
}

function delete_share()
{
  global $con;
  if (isset($_POST['confirm_id']) && isset($_POST['account_id'])) {
    $order_id = $_POST['confirm_id'];
    $id = $_POST['account_id'];
    $stmt998 = $con->prepare("DELETE FROM `share_transactions` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:accountdetails.php?uid=$id");
    exit();
  }
}





function import_transfer()
{
  global $con;
  if (
    isset($_POST["p"]) &&
    isset($_POST['trans_id']) &&
    isset($_POST['resp']) &&
    isset($_POST['created_date']) &&
    isset($_POST['from_wh']) &&
    isset($_POST['to_wh']) &&

    !empty($_POST["p"]) &&
    !empty($_POST["trans_id"]) &&
    !empty($_POST["resp"]) &&
    !empty($_POST["created_date"]) &&
    !empty($_POST["from_wh"]) &&
    !empty($_POST["to_wh"])

  ) {
    $transfer_id = trim($_POST['trans_id']);
    $resp_id = trim($_POST['resp']);
    $dateString = $_POST['created_date'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $from_wh = $_POST['from_wh'];
    $to_wh = $_POST['to_wh'];


    $stmt2 = $con->prepare("SELECT * FROM `transfer_orders` WHERE `id` = '$transfer_id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($count2 <= 0) {
      if ($to_wh !== $from_wh && $to_wh !== 'choose' && $from_wh !== 'choose') {
        $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
          return
            !empty($row["quantity"]);
        }));

        if (!empty($filteredArray)) {
          print_r($filteredArray);
        }

        $stmt5 = $con->prepare("INSERT INTO `transfer_orders`(`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
        $stmt5->execute();


        foreach ($filteredArray as $fa) {

          $sku = $fa['id'];
          $quantity = $fa['quantity'];

          $stmt7 = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$sku'");
          $stmt7->execute();
          $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
          $item_id = $row7['item_id'];
          $item_amount = $row7['rate'];
          $item_supplier_id = $row7['supplier_id'];
          $item_name = $row7['name'];
          $item_desc = $row7['description'];
          $item_unit = $row7['unit'];
          $item_img = $row7['img'];
          $item_sell = $row7['sell_rate'];
          $item_total = $row7['rate'] * $quantity;
          $item_margin = $row7['margin'];
          $order_id = $row7['order_id'];
          $item_sku = "622" . substr($row7['item_id'], 3, 4) . rand(10000, 99999);


          $stmt8 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `rate` = '$item_amount' AND `supplier_id` = '$item_supplier_id' AND `warehouse_id` = '$to_wh' AND `sku` != '$sku'");
          $stmt8->execute();
          $count8 = $stmt8->rowCount();
          if ($count8 > 0) {
            $stmt99 = $con->prepare("UPDATE `av_items` SET quantity = quantity + $quantity  WHERE `item_id` = '$item_id' AND `rate` = '$item_amount' AND `supplier_id` = '$item_supplier_id' AND `warehouse_id` = '$to_wh' AND `sku` != '$sku'");
            $stmt99->execute();
          } else {
            $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$quantity','$item_amount','1','$to_wh','$created_time','$item_id','$item_img','$item_margin','$item_sell','$order_id')");
            $stmt99->execute();
          }

          $stmt8 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$item_id','$from_wh','$to_wh','$created_time','$item_amount','$quantity','$item_total','$item_unit','$transfer_id')");
          $stmt8->execute();
          $stmt9 = $con->prepare("UPDATE `av_items` SET `quantity` = quantity - $quantity  WHERE `sku` = '$sku'");
          $stmt9->execute();
        }
        header("location:inventory.php");
        exit();
      }
    }
  }
}


function import_transfer_warehouse($s)
{
  global $con;
  if (
    isset($_POST["p"]) &&
    isset($_POST['trans_id']) &&
    isset($_POST['resp']) &&
    isset($_POST['created_date']) &&
    isset($_POST['from_wh']) &&
    isset($_POST['to_wh']) &&

    !empty($_POST["p"]) &&
    !empty($_POST["trans_id"]) &&
    !empty($_POST["resp"]) &&
    !empty($_POST["created_date"]) &&
    !empty($_POST["from_wh"]) &&
    !empty($_POST["to_wh"])

  ) {
    $transfer_id = trim($_POST['trans_id']);
    $resp_id = trim($_POST['resp']);
    $dateString = $_POST['created_date'];
    $date = new DateTime($dateString);
    $created_time =  $date->format("Y-m-d h:i A");
    $from_wh = $_POST['from_wh'];
    $to_wh = $_POST['to_wh'];


    $stmt2 = $con->prepare("SELECT * FROM `transfer_orders` WHERE `id` = '$transfer_id'");
    $stmt2->execute();
    $count2 = $stmt2->rowCount();
    if ($count2 <= 0) {
      if ($to_wh !== $from_wh && $to_wh !== 'choose' && $from_wh !== 'choose') {
        $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
          return
            !empty($row["quantity"]);
        }));

        if (!empty($filteredArray)) {
          print_r($filteredArray);
        }

        $stmt5 = $con->prepare("INSERT INTO `transfer_orders`(`id`,`date`,`resp`) VALUES ('$transfer_id','$created_time','$resp_id')");
        $stmt5->execute();


        foreach ($filteredArray as $fa) {

          $sku = $fa['id'];
          $quantity = $fa['quantity'];

          $stmt7 = $con->prepare("SELECT * FROM `av_items` WHERE `sku` = '$sku'");
          $stmt7->execute();
          $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
          $item_id = $row7['item_id'];
          $item_amount = $row7['rate'];
          $item_supplier_id = $row7['supplier_id'];
          $item_name = $row7['name'];
          $item_desc = $row7['description'];
          $item_unit = $row7['unit'];
          $item_img = $row7['img'];
          $item_sell = $row7['sell_rate'];
          $item_total = $row7['rate'] * $quantity;
          $item_margin = $row7['margin'];
          $order_id = $row7['order_id'];
          $item_sku = "622" . substr($row7['item_id'], 3, 4) . rand(10000, 99999);


          $stmt8 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$item_id' AND `rate` = '$item_amount' AND `supplier_id` = '$item_supplier_id' AND `warehouse_id` = '$to_wh' AND `sku` != '$sku'");
          $stmt8->execute();
          $count8 = $stmt8->rowCount();
          if ($count8 > 0) {
            $stmt99 = $con->prepare("UPDATE `av_items` SET quantity = quantity + $quantity  WHERE `item_id` = '$item_id' AND `rate` = '$item_amount' AND `supplier_id` = '$item_supplier_id' AND `warehouse_id` = '$to_wh' AND `sku` != '$sku'");
            $stmt99->execute();
          } else {
            $stmt99 = $con->prepare("INSERT INTO `av_items` (`supplier_id`,`name`,`sku`,`description`,`unit`,`quantity`,`rate`,`storable`,`warehouse_id`,`created_time`,`item_id`,`img`,`margin`,`sell_rate`,`order_id`) VALUES ('$item_supplier_id','$item_name','$item_sku','$item_desc','$item_unit','$quantity','$item_amount','1','$to_wh','$created_time','$item_id','$item_img','$item_margin','$item_sell','$order_id')");
            $stmt99->execute();
          }

          $stmt8 = $con->prepare("INSERT INTO `transfers` (`item_id`,`transfer_from`,`transfer_to`,`date`,`amount`,`quantity`,`total`,`unit`,`transfer_id`) VALUES ('$item_id','$from_wh','$to_wh','$created_time','$item_amount','$quantity','$item_total','$item_unit','$transfer_id')");
          $stmt8->execute();
          $stmt9 = $con->prepare("UPDATE `av_items` SET `quantity` = quantity - $quantity  WHERE `sku` = '$sku'");
          $stmt9->execute();
        }
        header("location:warehousedetails.php?uid=$s");
        exit();
      }
    }
  }
}
function delete_loan()
{
  global $con;
  if (isset($_POST['confirm_id'])) {
    $order_id = $_POST['confirm_id'];
    $stmt998 = $con->prepare("DELETE FROM `loan_orders` WHERE `id` = '$order_id'");
    $stmt998->execute();
    $stmt998 = $con->prepare("DELETE FROM `loan_transactions` WHERE `supplier_id` = '$order_id'");
    $stmt998->execute();
    header("location:loans.php");
    exit();
  }
}



function import_loan()
{
  global $con;
  if (
    isset($_POST['add']) &&
    isset($_POST['main_bank']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_edate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_loan']) &&

    !empty($_POST['add']) &&
    !empty($_POST['main_bank']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_edate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_loan'])
  ) {

    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d');


    $input_date2 = $_POST['amount_edate'];
    $date2 = new DateTime($input_date2);
    $end_time = $date2->format('Y-m-d');


    $bank_from = $_POST['main_bank'];




    $interval = $date->diff($date2);

    $months = ($interval->format('%y') * 12) + $interval->format('%m');


    $amount = $_POST['amount_loan'];
    $payment_method = $_POST['amount_payment_method'];
    if ($payment_method == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else if ($payment_method == "bank") {
      $bank_name = $_POST['bank_name'];
      $bank_number = $_POST['bank_number'];
    }
    $id = sprintf("%09d", rand(0, 999999999));
    $stmt = $con->prepare("INSERT INTO `loan_orders`(`id`,`bank`,`amount`,`duration`,`created_time`,`due_to`,`payment_m`,`bank_name`,`bank_number`) VALUES ('$id','$bank_from','$amount','$months','$created_time','$end_time','$payment_method','$bank_name','$bank_number')");
    $stmt->execute();
    $stmt2 = $con->prepare("INSERT INTO `loan_transactions`(`supplier_id`,`debit`,`credit`,`date`,`payment_method`,`bank_name`,`bank_number`,`type`) VALUES ('$id','0','$amount','$created_time','$payment_method','$bank_name','$bank_number','receiving amount')");
    $stmt2->execute();
    header("location:loans.php");
    exit();
  }
}


function get_in_loan($s = "")
{
  global $con;
  $total = 0;
  $cashes = array();
  if (empty($s)) {
    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0'");
  } else {
    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE debit = '0' AND `supplier_id` = '$s'");
  }
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['credit'];
      }
    }
  }
  return $total;
}
function get_out_loan($s = "")
{
  global $con;
  $total = 0;
  $cashes = array();
  if (empty($s)) {
    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0'");
  } else {
    $stmt = $con->prepare("SELECT * FROM `loan_transactions` WHERE credit = '0' AND `supplier_id` = '$s'");
  }
  $stmt->execute();
  $total = 0;
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $supp) {
        $total += $supp['debit'];
      }
    }
  }
  return $total;
}


function get_total_loan($s = "")
{
  $cash_in = get_in_loan($s);
  $cash_out = get_out_loan($s);
  $total = round(($cash_in - $cash_out), 2);
  return $total;
}


function delete_loan_trans($s)
{
  global $con;
  if (isset($_POST['trans_id'])) {
    $order_id = $_POST['trans_id'];
    $stmt998 = $con->prepare("DELETE FROM `loan_transactions` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:loan.php?uid=$s");
    exit();
  }
}


function import_loan_trans($s)
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['amount_payment']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_type']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['amount_payment']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_type'])
  ) {
    $amount = $_POST['amount_payment'];
    $input_date = $_POST['amount_cdate'];
    $type = $_POST['amount_type'];
    $date = new DateTime($input_date);
    $order_id  = $s;
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $bank_name = "";
      $bank_account = "";
    } else {
      $bank_name = trim($_POST['amount_bank_name']);
      $bank_account = trim($_POST['amount_bank_number']);
    }

    $stmt = $con->prepare("INSERT INTO `loan_transactions`(`supplier_id`,`debit`,`credit`,`date`,`payment_method`,`bank_name`,`bank_number`,`type`) VALUES ('$order_id','$amount','0','$created_time','$payment_m','$bank_name','$bank_account','$type')");
    $stmt->execute();
    header("location:loan.php?uid=$order_id");
    exit();
  }
}



function import_transfer_money($bank_name, $bank_number)
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['amount_payment']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_cdate']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['amount_payment']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_cdate'])
  ) {
    $amount = $_POST['amount_payment'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $curr_bank_name = $bank_name;
    $curr_bank_number = $bank_number;
    $bank_id = $_POST['supplier_id'];
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    if ($payment_m == "cash") {
      $go_bank_name = "";
      $go_bank_account = "";
    } else {
      $go_bank_name = trim($_POST['amount_bank_name']);
      $go_bank_account = trim($_POST['amount_bank_number']);
    }
    if ($curr_bank_name === $go_bank_name && $curr_bank_number === $go_bank_account) {
    } else {
      $stmt = $con->prepare("INSERT INTO `transfer_money`(`from_payment_method`,`from_bank_name`,`from_bank_number`,`to_payment_method`,`to_bank_name`,`to_bank_number`,`amount`,`date`) VALUES ('bank','$curr_bank_name','$curr_bank_number','$payment_m','$go_bank_name','$go_bank_account','$amount','$created_time')");
      $stmt->execute();
      header("location:bankdetails.php?uid=$bank_id");
      exit();
    }
  }
}


function get_warehouses_option_location()
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM `warehouses` WHERE `id` != '314' AND `city` != ''");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
      foreach ($row as $opt) {
        echo '<option value="' . $opt['city'] . '">' . $opt['city'] . '</option>';
      }
    }
  }
}


function import_revenue()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['type']) &&
    isset($_POST['amount_cdate']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['name']) &&
    isset($_POST['quantity']) &&
    isset($_POST['amount']) &&
    isset($_POST['total']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['type']) &&
    !empty($_POST['amount_cdate']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['name']) &&
    !empty($_POST['quantity']) &&
    !empty($_POST['amount']) &&
    !empty($_POST['total'])
  ) {
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $type = $_POST['type'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $payment_method = $_POST['amount_payment_method'];
    if ($payment_method == "cash") {
      $bank_name = "";
      $bank_number = "";
    } else if ($payment_method == "bank") {
      $bank_name = $_POST['bank_name'];
      $bank_number = $_POST['bank_number'];
    } else {
      $bank_name = "";
      $bank_number = "";
    }
    $stmt = $con->prepare("INSERT INTO `revenues`(`type`,`name`,`quantity`,`amount`,`total`,`payment_method`,`date`,`bank_name`,`bank_number`) VALUES ('$type','$name','$quantity','$amount','$total','$payment_method','$created_time','$bank_name','$bank_number')");
    $stmt->execute();
    header("location:revenues.php");
    exit();
  }
}


function delete_revenue()
{
  global $con;
  if (isset($_POST['confirm_id'])) {
    $order_id = $_POST['confirm_id'];
    $stmt998 = $con->prepare("DELETE FROM `revenues` WHERE `id` = '$order_id'");
    $stmt998->execute();
    header("location:revenues.php");
    exit();
  }
}


function transfer_from_cash()
{
  global $con;
  if (
    isset($_POST['pay']) &&
    isset($_POST['amount_payment']) &&
    isset($_POST['amount_payment_method']) &&
    isset($_POST['amount_cdate']) &&

    !empty($_POST['pay']) &&
    !empty($_POST['amount_payment']) &&
    !empty($_POST['amount_payment_method']) &&
    !empty($_POST['amount_cdate'])
  ) {
    $amount = $_POST['amount_payment'];
    $input_date = $_POST['amount_cdate'];
    $date = new DateTime($input_date);
    $created_time = $date->format('Y-m-d h:i A');
    $payment_m = $_POST['amount_payment_method'];
    $go_bank_name = trim($_POST['amount_bank_name']);
    $go_bank_account = trim($_POST['amount_bank_number']);
    $stmt = $con->prepare("INSERT INTO `transfer_money`(`from_payment_method`,`from_bank_name`,`from_bank_number`,`to_payment_method`,`to_bank_name`,`to_bank_number`,`amount`,`date`) VALUES ('cash','','','$payment_m','$go_bank_name','$go_bank_account','$amount','$created_time')");
    $stmt->execute();
    header("location:cash.php");
    exit();
  }
}
