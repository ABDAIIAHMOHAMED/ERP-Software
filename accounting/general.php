<?php

require "connect.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

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
                    echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                        echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                    echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                    echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                        echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                    echo  '<div class="prof-img"><img src="' . $image_route . 'images/' . $employe["picture"] . '" alt=""></div>
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
                    echo  '<input type="hidden" name="em" value="' . $employe["id"] . '">';
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

function push_leave() // Create Leave function
{
    date_default_timezone_set("Africa/Cairo"); // Set timezone to Egypt Cairo
    global $n; // Global n = number of weekly holidays in the month
    global $nn; // Global nn = number of weekly holidays in the month last
    global $daysInMonth; // Global daysInMonth = number of days per month
    global $con;
    if (isset($_POST['leave']) & !empty($_POST['leave']) & isset($_POST['em']) & !empty($_POST['em'])) { // Check there is leave and em POST and not empty
        if (is_numeric($_POST['em'])) { // Check if id is number
            $stmt = $con->prepare("SELECT * FROM users WHERE id = " . $_POST['em'] . "");
            $stmt->execute();
            $count = $stmt->rowCount(); // Check the id is exist in employee
            if ($count > 0) { // If id exist in employee
                $stmt2 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND leave_out = '0000-00-00 00:00:00'");
                $stmt2->execute();
                $count2 = $stmt2->rowCount(); // Check if there is attendance without leave for the same id
                if ($count2 > 0) { // If there attendance without leave
                    $id = $_POST['em']; // Variable POST em to id


                    $nowdate = date("Y-m-d H:i:s");
                    if (isset($_POST['leave_date']) && !empty($_POST['leave_date']) && isset($_POST['not_current']) && $_POST['not_current'] == "checked") {
                        if (strtotime($_POST['leave_date']) == false) {
                            $date = date("Y-m-d H:i") . ":00";
                        } else {
                            $time = $_POST['leave_date'];
                            $date = str_replace("T", " ", $time) . ":00";
                        }
                        $daydate = substr($date, 0, 10);
                    } else {
                        $date = date("Y-m-d H:i") . ":00"; // Variable 0000-00-00 00:00:00 to date
                        $daydate = date("Y-m-d"); // Variable day date
                    }
                    $comment = substr(filter_var($_POST["comment"], FILTER_SANITIZE_STRING), 0, 250); // Variable filteration comment to comment
                    while ($row = $stmt2->fetch()) { // Get from stmt2 line 110 queries
                        $enter = $row[2]; // Variable attendance date to enter
                        if ($enter < $date) {
                            $dur_ent = strtotime($enter); // Convert attendance date to timestamp
                            $dur_leave = strtotime($date); // Convert now date to timestamp
                            $dur = @round(abs($dur_leave - $dur_ent) / 60, 2); // now date [leave] - attendance date to get duration in min
                            $mandy = date("Y-m") . "-01"; // Variable 0000-00-01 to mandy
                            $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE id = " . $_POST['em'] . " AND `date` = '$mandy'");
                            $stmt4->execute();
                            $count4 = $stmt4->rowCount();
                            $row4 = $stmt4->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month
                            $incholidays = $daysInMonth - $n; // Variable days of month - number of weekly holidays [Actual working days]
                            $stmt6 = $con->prepare("SELECT `value` FROM settings WHERE item = 'working_hours'");
                            $stmt6->execute();
                            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Check working hours from settings
                            $working_hours = $row6['value']; // Variable working hours

                            // Change dur variable in order to if dur > num so dur = and if dur < so dur = //


                            $over = 90;
                            $stmt5 = $con->prepare("SELECT * FROM users WHERE id = " . $_POST['em'] . "");
                            $stmt5->execute();
                            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Check
                            $salary = $row5['net_salary']; // Variable salary
                            $name = $row5['name']; // Variable Name



                            if ($count4 > 0) { // If there is employee_salary for this employee this month in line 121
                                $old_dur = $row4['duration']; // Get old duration
                                $old_actual = $row4['actual']; // Get old duration


                                if ($dur > ($working_hours * 60)) {
                                    if ($dur == (($working_hours * 60)  +  $over)) {
                                        $j = 1.35;
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
                                    } elseif ($dur > (($working_hours * 60)  +  $over)) {
                                        $j = 1.7;
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  *  (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
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




                                $d = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
                                $stmt55 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND duration = '" . (60 * $working_hours) . "' AND `enter_in` LIKE '" . date("Y-m") . "%'");
                                $stmt55->execute();
                                $count55 = $stmt55->rowCount(); // Check if there is many enters in the same day

                                if ($d == 31) {
                                    if ($count55 == (30 - $nn)) {
                                        if ($old_actual >= ($salary - ($nn * ($salary / 30)))) {
                                            $actual = $old_actual;
                                        } else {
                                            $actual = $old_actual - (($salary / 30) * ($count55 + $nn - 1)) + $salary;
                                        }
                                    }
                                } elseif ($d == 28) {
                                    if ($count55 == (27 - $nn)) {
                                        $actual = $old_actual - (($salary / 30) * 28) + $salary;
                                    }
                                }


                                $salary_holidays = (($salary / 30) * $nn);  // Get salary of holidays salary / 30 days multipli to number of weekly holidays last
                                $stmt5 = $con->prepare("UPDATE `employee_salary` SET  `duration` = '$dur_add'  , `actual` = '$actual', `days` = '$days', `holidays` = '$nn' , `salary_holidays` = '$salary_holidays' WHERE `id` = '$id'  AND `date` = '$mandy'");
                                $stmt5->execute(); // Update salary in salary_employee
                            } else { // If there is not employee_salary for this employee this month in line 121
                                if ($dur > ($working_hours * 60)) {
                                    if ($dur == (($working_hours * 60)  +  $over)) {
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur; // Variable duration without old duration addition
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $j = 1.35;
                                        $actual = ((($salary / 30)    *    $days) + (($salary / 30 * $j)  * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60) / $working_hours)));
                                    } elseif ($dur > (($working_hours * 60)  +  $over)) {
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur; // Add new + old duration to get total duration
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $j = 1.7;
                                        $actual = ((($salary / 30)    *    $days) + (($salary / 30 * $j)  * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60) / $working_hours)));
                                    } else {
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur; // Add new + old duration to get total duration
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $actual = (($salary / 30) * $days); // Get actual salary from salary / 30 days multipli to number of actual days
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
                                                $dur_add = $dur; // Variable duration without old duration addition
                                                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                                $actual = ((($salary / 30)    *    $days) - (($salary / 30) / $working_hours));
                                            } elseif ($count23 == 1) {
                                                $dur = ($working_hours * 60);
                                                $dur_add = $dur; // Variable duration without old duration addition
                                                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                                $actual = ((($salary / 30)    *    $days) - (($salary / 30) * 2 / $working_hours));
                                            } elseif ($count23 > 1) {
                                                $dur = ($working_hours * 60);
                                                $dur_add = $dur; // Variable duration without old duration addition
                                                $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                                $actual = ((($salary / 30)    *    $days) - (($salary / 30) * 4 / $working_hours));
                                            }
                                        }
                                    } else {
                                        $dur = ($working_hours * 60);
                                        $dur_add = $dur; // Add new + old duration to get total duration
                                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                        $actual = (($salary / 30) * $days); // Get actual salary from salary / 30 days multipli to number of actual days
                                    }
                                } else {
                                    $dur_add = $dur; // Add new + old duration to get total duration
                                    $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                                    $actual = (($salary / 30) * $days); // Get actual salary from salary / 30 days multipli to number of actual days
                                }




                                $salary_holidays = (($salary / 30) * $nn);  // Get salary of holidays salary / 30 days multipli to number of weekly holidays last
                                $stmt5 = $con->prepare("INSERT INTO `employee_salary`(`id`, `salary`,`actual`,`duration`,`days`,`date`,`paid`,`holidays`) VALUES ('$id','$salary','$actual','$dur_add','$days','$mandy','0','$nn')");
                                $stmt5->execute(); // Insert new salary in salary_employee for this id and this month and year
                            }
                            $stmt3 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_POST['em'] . " AND enter_in LIKE '" . $daydate . "%'");
                            $stmt3->execute();
                            $count3 = $stmt3->rowCount(); // Check if there is many enters in the same day

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



                            if ($count3 > 1) { // If there is many enters in the same day
                                $stmt2 = $con->prepare("UPDATE `attendance` SET `leave_out` = '$date' , `duration` = '$dur' , `count` = '0' , `comment` = '$comment' , `overtime` = '$overtime' ,`late` = '$lating' WHERE `id` = '$id' AND `enter_in` = '$enter' ");
                                $stmt2->execute(); // Create leave with count 0
                                $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
                                $stmt5->execute();
                                $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of id leave
                                $name = $row5['name']; // Variable name of id leave
                                // $sessionid = $_SESSION['id']; // Variable session id
                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Create new Leave for $name','attendance','$nowdate')"); // Create log for leave
                                header("location:attendance.php?em=$id"); // Header to attendance.php
                                exit();
                            } else { // If this is only enter in the day
                                $stmt2 = $con->prepare("UPDATE `attendance` SET `leave_out` = '$date' , `duration` = '$dur' , `count` = '1' , `comment` = '$comment', `overtime` = '$overtime' ,`late` = '$lating'  WHERE `id` = '$id' AND `enter_in` = '$enter' ");
                                $stmt2->execute(); // Create leave with count 1
                                $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_POST['em'] . "");
                                $stmt5->execute();
                                $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of id leave
                                $name = $row5['name']; // Variable name of id leave
                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Create new leave for $name','attendance','$nowdate')");
                                $stmt4->execute(); // Create log for leave
                                header("location:attendance.php?em=$id"); // Header to attendance.php
                                exit();
                            }
                        } else {
                            $error_log = "<div class='error-mg'><span>Attendance time is " . $enter . " , Leave time must be before it</span></div>";
                            echo $error_log;
                        }
                    }
                } else { // If there is no id enter yet
                    $error_log = "<div class='error-mg'><span>This employee hasn't enter yet</span></div>";
                    echo $error_log;
                }
            }
        }
    }
}


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
                    if ($dur == (($working_hours * 60)  +  $over)) {
                        $j = 1.35;
                        $dur = ($working_hours * 60);
                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
                    } elseif ($dur > (($working_hours * 60)  +  $over)) {
                        $j = 1.7;
                        $dur = ($working_hours * 60);
                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  *  (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
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

            $final_actual = $actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) +  ($salary / (30 * $working_hours) * ($oldy_late / 60));






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


            $final_actual = $old_actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) +  ($salary / (30 * $working_hours) * ($oldy_late / 60));

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
                        $status = $row['activate'];
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
    $count = $stmt->rowCount();
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
    if (isset($_POST['password']) && isset($_POST['rpassword'])  && isset($_POST['reset'])) { // If there is POST reset and password and repassword
        if (!empty($_POST['password']) && !empty($_POST['rpassword'])  && !empty($_POST['reset'])) { //  If POST reset and password and repassword is empty
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); // Filteration password
            $rpassword = filter_var($_POST['rpassword'], FILTER_SANITIZE_STRING); // Filteration repassword
            if ($password === $rpassword) { // If password equal repassword
                if (strlen($password) > 8) { // If new password is more than 8
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT); // Hash password
                    $email =  filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); // fileration email
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
                        if ($row['activate'] == 1) {
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


                    $final_diff =  $diff - $ns;
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
                $working_hours = (int)$_POST['working_hours'];
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
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), null, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
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
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
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

function add_employee()
{
    global $con;
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
        "join_date" => "",
        "net_salary" => "",
    ];
    if (isset($_POST['new-user']) && !empty($_POST['new-user'])) {
        $password = "123456789";
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
        $jdate = date("Y-m-d");
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
                        $errors["email"] = "Email is already exist";
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
        if (isset($_POST['jdate'])) {
            if (!empty($_POST['jdate'])) {
                $jdate = filter_var($_POST['jdate'], FILTER_SANITIZE_STRING);
            } else {
                $errors["join_date"] = "This field is required and cannot be empty";
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
        if (isset($_POST['new-user'])) {
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

            $tax_compare = ((($main + $main2 + $othera_allow) - $insure) * 12) - 24000;

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
                    $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225)  + ((($tax_compare - 200000) / 12) * 0.25);
                }
            } else {
                $tax = 0;
            }

            $total = $main + $main2 + $loc_allow + $acco_allow + $cloth_allow + $other_allow - $tax - $fellow - $insure - $n_salary;

            if ($total < 0) {
                $total = 0;
            }

            if ($_POST['type'] == "user") {
                $stmt = $con->prepare("INSERT INTO `users`(`type`,`name`,`fname`,`mname`,`lname`,`notes`,`email`,`activate`,`picture`,`role`,`gender`,`birthday`,`country`,`phone_number`,`personal_email`,`curr_add1`,`curr_add2`,`curr_city`,`curr_gover`,`curr_postal`,`perm_add1`,`perm_add2`,`perm_city`,`perm_gover`,`perm_postal`,`job_title`,`category`,`job_type`,`career_level`,`join_date`,`net_salary`,`password`,`last_login`) VALUES ('$type','" . $fname . " " . $mname . " " . $lname . "','$fname','$mname','$lname','$notes','$email','$status','$image_name','$job_role','$gender','$bday','$country','$phone','$pemail','$curr_add1','$curr_add2','$curr_city','$curr_gover','$curr_postal','$perm_add1','$perm_add2','$perm_city','$perm_gover','$perm_postal','$job_title','$category','$type_job','$career_level','$jdate','$n_salary','" . password_hash($password, PASSWORD_DEFAULT) . "','')");
                $stmt->execute();
                $stmt2 = $con->prepare("SELECT * FROM users WHERE `email` = '$email'");
                $stmt2->execute();
                $count2 = $stmt2->rowCount();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name);
                $id = $row2['id'];
                $stmt9 = $con->prepare("INSERT INTO `employee_salary`(`id`,`salary`) VALUES ('$id','$n_salary')");
                $stmt9->execute();
                $stmt10 = $con->prepare("INSERT INTO `salary` (`id`,`name`,`category`,`job_title`,`date`,`salary`,`main`,`main2`,`loc_allow`,`acco_allow`,`cloth_allow`,`other_allow`,`insure`,`tax`,`fellow`,`absence`,`total`) VALUES ('$id','" . $fname . " " . $mname . " " . $lname . "','$category','$job_title','" . date('Y-m') . "','$n_salary','$main','$main2','$loc_allow','$acco_allow','$cloth_allow','$other_allow','$insure','$tax','$fellow','$n_salary','$total')");
                $stmt10->execute();


                $urid = $_COOKIE['urid'];
                $urid_array = explode("-", $urid);
                $sessionid = $urid_array[0];
                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Create new user with id #$id','Employee','" . date('Y-m-d H:i:s') . "')");
                $stmt4->execute(); // Create log for leave

                header("location:index.php?u=1");
            } else {
                $stmt = $con->prepare("INSERT INTO `users`(`type`,`name`,`fname`,`mname`,`lname`,`notes`,`email`,`activate`,`picture`,`role`,`gender`,`birthday`,`country`,`phone_number`,`personal_email`,`curr_add1`,`curr_add2`,`curr_city`,`curr_gover`,`curr_postal`,`perm_add1`,`perm_add2`,`perm_city`,`perm_gover`,`perm_postal`,`job_title`,`category`,`job_type`,`career_level`,`join_date`,`net_salary`,`password`,`last_login`) VALUES ('$type','" . $fname . " " . $mname . " " . $lname . "','$fname','$mname','$lname','$notes','$email','$status','$image_name','$job_role','$gender','$bday','$country','$phone','$pemail','$curr_add1','$curr_add2','$curr_city','$curr_gover','$curr_postal','$perm_add1','$perm_add2','$perm_city','$perm_gover','$perm_postal','$job_title','$category','$type_job','$career_level','$jdate','$n_salary','" . password_hash($password, PASSWORD_DEFAULT) . "','')");
                $stmt->execute();
                $stmt2 = $con->prepare("SELECT * FROM users WHERE `email` = '$email'");
                $stmt2->execute();
                $count2 = $stmt2->rowCount();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                move_uploaded_file($image_temp, __DIR__ . "/../images/" . $image_name);
                $id = $row2['id'];
                $stmt9 = $con->prepare("INSERT INTO `employee_salary`(`id`,`salary`) VALUES ('$id','$n_salary')");
                $stmt9->execute();
                $stmt10 = $con->prepare("INSERT INTO `salary` (`id`,`name`,`category`,`job_title`,`date`,`salary`,`main`,`main2`,`loc_allow`,`acco_allow`,`cloth_allow`,`other_allow`,`insure`,`tax`,`fellow`,`absence`,`total`) VALUES ('$id','" . $fname . " " . $mname . " " . $lname . "','$category','$job_title','" . date('Y-m') . "','$n_salary','$main','$main2','$loc_allow','$acco_allow','$cloth_allow','$other_allow','$insure','$tax','$fellow','$n_salary','$total')");
                $stmt10->execute();


                $urid = $_COOKIE['urid'];
                $urid_array = explode("-", $urid);
                $sessionid = $urid_array[0];
                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Create new employee with id #$id','Employee','" . date('Y-m-d H:i:s') . "')");
                $stmt4->execute(); // Create log for leave

                header("location:index.php?e=1");
            }
            return $errors;
        } else {
            return $errors;
        }
    }
}

function get_job_titles()
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
    $stmt60 = $con->prepare("SELECT * FROM `job_titles` WHERE `status` in $active");
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
        $stmt = $con->prepare("SELECT * FROM `job_titles` WHERE `name` LIKE '$name%' AND `status` in $active ORDER BY `name` LIMIT $start_from,$num_per_page");
        $stmt->execute();
        $count = $stmt->rowCount();
    } else {
        $stmt = $con->prepare("SELECT * FROM `job_titles` WHERE `status` in $active ORDER BY `name`  LIMIT $start_from,$num_per_page");
        $stmt->execute();
        $count = $stmt->rowCount();
    }
    if ($count > 0) {
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row as $employee) {
                echo "
      <div class='request-row'>
        <div>" . $employee['name'] . "</div>";
                $stmt3 = $con->prepare("SELECT * FROM `users` WHERE `job_title` = '" . $employee['id'] . "' ");
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

function check_id()
{
    global $con;
    if (isset($_GET['uid'])) {
        if (!empty($_GET['uid'])) {
            $uid = filter_var($_GET['uid'], FILTER_SANITIZE_STRING);
            if (is_numeric($uid)) {
                $stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = '$uid'");
                $stmt->execute();
                $id_check = $stmt->rowCount();
            } else {
                return 0;
            }
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
                    $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225)  + ((($tax_compare - 200000) / 12) * 0.25);
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
            $absence = ($daysInMonth - ($count477  +  $holi_throw + $daying)) * ($n_salary / 30);

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
            $stmt2 = $con->prepare("DELETE FROM `holidays` WHERE id = $uid");
            $stmt2->execute();

            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete user #$uid','Employee Delete','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave


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
            $stmt = $con->prepare("UPDATE `users` SET `activate` = '0' WHERE id = $uid");
            $stmt->execute();


            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Disable user #$uid','Employee Delete','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave

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
            $stmt = $con->prepare("UPDATE `users` SET `activate` = '1'  WHERE id = $uid");
            $stmt->execute();

            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Activate user #$uid','Employee Active','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave

            header("location:" . $_SERVER['PHP_SELF'] . "?uid=$uid");
        }
    }
}

function reset_password_inside() // Reset password function
{
    global $con; // Global connection to database
    if (isset($_POST['password']) && isset($_POST['rpassword'])  && isset($_POST['opassword']) && isset($_POST['reset'])) { // If there is POST reset and password and repassword
        if (!empty($_POST['password']) && !empty($_POST['rpassword'])  && !empty($_POST['opassword']) && !empty($_POST['reset'])) { //  If POST reset and password and repassword is empty
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
                                $stmt = $con->prepare("UPDATE `users` SET `password` = '$hash_pass', `validation` = '$vali_code' WHERE `email` = '$email'");
                                $stmt->execute();
                                $urid = $_GET['uid'] . "-" . md5($email) . "-" . $hash_pass;
                                setcookie("urid", $urid, time() + (360400 * 30), "/");



                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','$name reset his/her password','Password','" . date('Y-m-d H:i:s') . "')");
                                $stmt4->execute(); // Create log for leave

                                header("location:" . $_SERVER['PHP_SELF'] . "/../view.php?uid=$uid");
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
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
            $stmt = $con->prepare("SELECT * FROM `users` WHERE `$r` = '$cid'");
            $stmt->execute();
            $count = $stmt->rowCount();
            return $count;
        }
    }
}

function update_org($r)
{
    global $con;
    $org_info = get_org_info($r);
    if (isset($_POST['update'])) {
        if (!empty($_POST['update']) & !empty($_POST['name'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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
                                $stmt9 = $con->prepare("UPDATE `$r` SET `def` = '0' ");
                                $stmt9->execute();
                                $stmt10 = $con->prepare("UPDATE `$r` SET  `name` = '$name'  , `description` = '$des', `status` = '$status',`def` = '$def' WHERE `id` = '" . $org_info['id'] . "'");
                                $stmt10->execute();


                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $name = $org_info['name'];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change $name Information from" . ucfirst(str_replace("_", " ", $r)) . " ','Edit','" . date('Y-m-d H:i:s') . "')");
                                $stmt4->execute(); // Create log for leave

                                header("Location:edit.php?cid=" . $org_info['id'] . "");
                                exit();
                            }
                        } else {
                            $stmt9 = $con->prepare("UPDATE `$r` SET `def` = '0' ");
                            $stmt9->execute();
                            $stmt10 = $con->prepare("UPDATE `$r` SET  `name` = '$name'  , `description` = '$des', `status` = '$status',`def` = '$def' WHERE `id` = '" . $org_info['id'] . "'");
                            $stmt10->execute();

                            $urid = $_COOKIE['urid'];
                            $urid_array = explode("-", $urid);
                            $sessionid = $urid_array[0];
                            $name = $org_info['name'];
                            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change $name Information form " . ucfirst(str_replace("_", " ", $r)) . " ','Edit','" . date('Y-m-d H:i:s') . "')");
                            $stmt4->execute(); // Create log for leave


                            header("Location:edit.php?cid=" . $org_info['id'] . "");
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
    if (isset($_GET['cid']) & isset($_GET['del'])) {
        if (!empty($_GET['cid']) & !empty($_GET['del'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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


                header("location:index.php");
                exit();
            }
        }
    }
}

function get_org_list($r)
{
    global $con;
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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

                        $stmt56 = $con->prepare("SELECT * FROM `career_level` WHERE id = '" . $employe['career_level'] . "'");
                        $stmt56->execute();
                        $count56 = $stmt56->rowCount();
                        $row56 = $stmt56->fetch(PDO::FETCH_ASSOC);


                        echo '<div class="card-contain">
            <div class="card">
              <div class="imgBx">
                <img src="../images/' . $employe['picture'] . '" alt="">
              </div>
              <div class="content">
                <div class="details">
                  <h2>' . ucfirst($employe['fname']) . ' ' . ucfirst($employe['mname']) . '<span>#1</span></h2>
                  <div class="card-info">
                    <div class="l-info">Phone Number:</div>
                    <div class="r-info">+2 ' . $employe['phone_number'] . '</div>
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
                    <a href="../employee/view.php?uid=' . $employe['id'] . '">View</a>
                    <a href="../employee/edit.php?uid=' . $employe['id'] . '">Edit</a>
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

function add_org($r)
{
    global $con;
    if (isset($_POST['add'])) {
        if (!empty($_POST['add']) & !empty($_POST['name'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
            if (isset($_POST['des'])) {
                $des = filter_var($_POST['des'], FILTER_SANITIZE_STRING);
            } else {
                $des = "";
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
                                $stmt9 = $con->prepare("INSERT INTO `$r`(`name`,`description`,`status`,`def`) VALUES ('$name','$des','$status','0')");
                                $stmt9->execute();


                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Add $name as a new " . ucfirst(str_replace("_", " ", $r)) . " ','Add','" . date('Y-m-d H:i:s') . "')");
                                $stmt4->execute(); // Create log for leave

                                header("Location:index.php");
                                exit();
                            }
                        } else {
                            $stmt9 = $con->prepare("INSERT INTO `$r`(`name`,`description`,`status`,`def`) VALUES ('$name','$des','$status','0')");
                            $stmt9->execute();

                            $urid = $_COOKIE['urid'];
                            $urid_array = explode("-", $urid);
                            $sessionid = $urid_array[0];
                            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Add $name as a new " . ucfirst(str_replace("_", " ", $r)) . " ','Add','" . date('Y-m-d H:i:s') . "')");
                            $stmt4->execute(); // Create log for leave

                            header("Location:index.php");
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
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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
                if (strlen($name) > 32) {
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


                        $urid = $_COOKIE['urid'];
                        $urid_array = explode("-", $urid);
                        $sessionid = $urid_array[0];
                        $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Add $name as a new role ','Add','" . date('Y-m-d H:i:s') . "')");
                        $stmt4->execute(); // Create log for leave

                        header("Location:index.php");
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
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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


                                $urid = $_COOKIE['urid'];
                                $urid_array = explode("-", $urid);
                                $sessionid = $urid_array[0];
                                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Change role $name info ','Edit','" . date('Y-m-d H:i:s') . "')");
                                $stmt4->execute(); // Create log for leave


                                header("Location:edit.php?cid=$cid");
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

                                    header("Location:edit.php?cid=$cid");
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

function check_role($r)
{
    global $con;
    if (isset($_GET['cid'])) {
        if (!empty($_GET['cid'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
            $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE id = '$cid'");
            $stmt->execute();
            $count = $stmt->rowCount();
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
    if (isset($_GET['cid']) & isset($_GET['del'])) {
        if (!empty($_GET['cid']) & !empty($_GET['del'])) {
            $cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
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
                $stmt10 = $con->prepare("UPDATE `users` SET `role` = '" . $def_r['id'] . "' WHERE `role` = '" . $get_org_info['id'] . "'");
                $stmt10->execute();
                $stmt9 = $con->prepare("DELETE FROM `user_roles` WHERE `id` = '$cid'");
                $stmt9->execute();


                $urid = $_COOKIE['urid'];
                $urid_array = explode("-", $urid);
                $sessionid = $urid_array[0];
                $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete role #$cid','Delete','" . date('Y-m-d H:i:s') . "')");
                $stmt4->execute(); // Create log for leave



                header("location:index.php");
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


function change_att_request()
{
    global $con;
    if (isset($_GET['approve'])) {
        if (!empty($_GET['approve']) & !empty($_GET['start']) & !empty($_GET['end']) & !empty($_GET['att_id']) & !empty($_GET['em'])) {
            $start = date_format(date_create($_GET['start']), "Y-m-d H:i:s");
            $att_id = $_GET['att_id'];
            $end = date_format(date_create($_GET['end']), "Y-m-d H:i:s");
            $id = $_GET['em'];
            $dur_ent = strtotime($start);
            $dur_leave = strtotime($end);
            $over = 90;
            $dur = @round(abs($dur_leave - $dur_ent) / 60, 2); // now date [leave] - attendance date to get duration in min





            $yandm = date("Y-m");
            $mandy = date("Y-m") . "-01"; // Variable 0000-00-01 to mandy
            $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE id = " . $_GET['em'] . " AND `date` = '$mandy'");
            $stmt4->execute();
            $count4 = $stmt4->rowCount();
            $row4 = $stmt4->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month
            $stmt6 = $con->prepare("SELECT `value` FROM settings WHERE item = 'working_hours'");
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Check working hours from settings
            $working_hours = $row6['value']; // Variable working hours

            // Change dur variable in order to if dur > num so dur = and if dur < so dur = //


            $stmt5 = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
            $stmt5->execute();
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Check
            $salary = $row5['net_salary']; // Variable salary
            $name = $row5['name']; // Variable Name



            if ($count4 > 0) { // If there is employee_salary for this employee this month in line 121
                $old_dur = $row4['duration']; // Get old duration
                $old_actual = $row4['actual']; // Get old duration


                if ($dur > ($working_hours * 60)) {
                    if ($dur == (($working_hours * 60)  +  $over)) {
                        $j = 1.35;
                        $dur = ($working_hours * 60);
                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  * (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
                    } elseif ($dur > (($working_hours * 60)  +  $over)) {
                        $j = 1.7;
                        $dur = ($working_hours * 60);
                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                        $actual = ($old_actual + (($salary / (30 * $working_hours) * $j)  *  (((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) / 60))) + ($salary / (30 * $working_hours) * ($dur / 60)));
                    } else {
                        $dur = ($working_hours * 60);
                        $dur_add = $dur + $old_dur; // Add new + old duration to get total duration
                        $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                        $actual = $old_actual + ($salary / (30 * $working_hours) * ($dur / 60)); // Get actual salary from salary / 30 days multipli to number of actual days
                    }
                } elseif ($dur < ($working_hours * 60)) {
                    if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 15) {
                        $stmt23 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_GET['em'] . " AND late != '0' AND `enter_in` LIKE '" . date("Y-m") . "%'");
                        $stmt23->execute();
                        $count23 = $stmt23->rowCount(); // Check if there is many enters in the same day



                        if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 90) {
                            $dur_add = $dur; // Variable duration without old duration addition
                            $days = ($dur_add / 60) / $working_hours; // Get actual days depend on total duration / 60 mins to get hours / working hours from settings
                            $actual = ($old_actual - (($salary / 30) * 1 / $working_hours) + ($salary / (30 * $working_hours) * ($dur / 60)));
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


            $stmt63 = $con->prepare("SELECT * FROM attendance WHERE att_id = " . $_GET['att_id'] . "");
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

            $final_actual = $actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) +  ($salary / (30 * $working_hours) * ($oldy_late / 60));

            $stmt7 = $con->prepare("UPDATE `employee_salary` SET  `actual` = '$final_actual'  , `duration` = '$dur', `days` = '$days' WHERE `date` LIKE '" . substr($oldy_enter, 0, 7) . "%' AND `id` = '" . $_GET['em'] . "'   ");
            $stmt7->execute(); // Update salary in salary_employee





            if ((@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60)) >= $over) {
                $overtime = (@round(abs($dur_leave - $dur_ent) / 60, 2) - ($working_hours * 60));
            } else {
                $overtime = 0;
            }

            if ((($working_hours * 60) - @round(abs($dur_leave - $dur_ent) / 60, 2)) >= 15) {
                $stmt23 = $con->prepare("SELECT * FROM attendance WHERE id = " . $_GET['em'] . " AND late != '0'");
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
            $stmt70 = $con->prepare("DELETE FROM `attendance_change` WHERE att_id = '$att_id'");
            $stmt70->execute();



            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_GET['em'] . "");
            $stmt5->execute();
            $row4 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of the employee who make for him attendance
            $name = $row4['name']; // Variable name
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Approve to change attendance for $name','attendance','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave


            header("location:../employee/attendance.php?em=$id&dt=$yandm");
        } else {
            echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
        }
    } elseif (isset($_GET['dl'])) {
        if (!empty($_GET['dl']) & !empty($_GET['att_id']) & !empty($_GET['em'])) {
            $att_id = $_GET['att_id'];
            $id = $_GET['em'];


            $over = 90;
            $stmt6 = $con->prepare("SELECT `value` FROM settings WHERE item = 'working_hours'");
            $stmt6->execute();
            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC); // Check working hours from settings
            $working_hours = $row6['value']; // Variable working hours
            $stmt5 = $con->prepare("SELECT * FROM users WHERE id = " . $_GET['em'] . "");
            $stmt5->execute();
            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC); // Check
            $salary = $row5['net_salary']; // Variable salary



            $stmt63 = $con->prepare("SELECT * FROM attendance WHERE att_id = " . $_GET['att_id'] . "");
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
            $stmt4 = $con->prepare("SELECT * FROM employee_salary WHERE id = " . $_GET['em'] . " AND `date` = '$mandy'");
            $stmt4->execute();
            $count4 = $stmt4->rowCount();
            $row4 = $stmt4->fetch(PDO::FETCH_ASSOC); // Check if there is employee_salary for this employee this month

            $old_actual = $row4['actual']; // Get old duration


            $final_actual = $old_actual - ($salary / (30 * $working_hours) * ($oldy_duration / 60)) - ($salary / (30 * $working_hours) * $s * ($oldy_overtime / 60)) +  ($salary / (30 * $working_hours) * ($oldy_late / 60));

            $stmt7 = $con->prepare("UPDATE `employee_salary` SET  `actual` = '$final_actual'  WHERE `date` LIKE '" . substr($oldy_enter, 0, 7) . "%' AND `id` = '" . $_GET['em'] . "'   ");
            $stmt7->execute(); // Update salary in salary_employee





            $stmt4 = $con->prepare("DELETE FROM `attendance` WHERE att_id = '$att_id'");
            $stmt4->execute();
            $stmt70 = $con->prepare("DELETE FROM `attendance_change` WHERE att_id = '$att_id'");
            $stmt70->execute();



            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_GET['em'] . "");
            $stmt5->execute();
            $row4 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of the employee who make for him attendance
            $name = $row4['name']; // Variable name
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete request to change attendance for $name','attendance','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave

            header("location:../employee/attendance.php?em=$id&dt=$yandm");
        } else {
            echo "<div class='eror'><div class='er_red'>Date can't be empty</div></div>";
        }
    } elseif (isset($_GET['reject'])) {
        if (!empty($_GET['reject']) & !empty($_GET['att_id']) & !empty($_GET['em'])) {
            $att_id = $_GET['att_id'];
            $id = $_GET['em'];

            $stmt70 = $con->prepare("DELETE FROM `attendance_change` WHERE att_id = '$att_id'");


            $urid = $_COOKIE['urid'];
            $urid_array = explode("-", $urid);
            $sessionid = $urid_array[0];
            $stmt5 = $con->prepare("SELECT `name` FROM users WHERE id = " . $_GET['em'] . "");
            $stmt5->execute();
            $row4 = $stmt5->fetch(PDO::FETCH_ASSOC); // Get name of the employee who make for him attendance
            $name = $row4['name']; // Variable name
            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Reject to change attendance for $name','attendance','" . date('Y-m-d H:i:s') . "')");
            $stmt4->execute(); // Create log for leave

            $stmt70->execute();
            header("location:../employee/attendance.php?em=$id&dt=$yandm");
        }
    }
}

function get_logs($id = "")
{
    global $con;
    $logs_date = [];
    if (empty($id)) {
        $stmt41 = $con->prepare("SELECT * FROM `logs` ORDER BY `creation` DESC");
        $stmt41->execute();
        $count41 = $stmt41->rowCount();
    } else {
        $stmt41 = $con->prepare("SELECT * FROM `logs` WHERE `id` = '$id' ORDER BY `creation` DESC");
        $stmt41->execute();
        $count41 = $stmt41->rowCount();
    }
    if ($count41 > 0) {
        while ($row41 = $stmt41->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
            foreach ($row41 as $dati) {
                $logs_date[] = substr($dati['creation'], 0, 10);
            }
        }
        $logs_date = array_unique($logs_date);
        foreach ($logs_date as $day) {
            if (empty($id)) {
                $stmt42 = $con->prepare("SELECT * FROM `logs` WHERE `creation` LIKE '$day%' ORDER BY `creation` DESC");
                $stmt42->execute();
                $count42 = $stmt42->rowCount();
            } else {
                $stmt42 = $con->prepare("SELECT * FROM `logs` WHERE `creation` LIKE '$day%' AND `id` = '$id' ORDER BY `creation` DESC");
                $stmt42->execute();
                $count42 = $stmt42->rowCount();
            }
            echo '<div class="date">' . date("Y M , d", strtotime($day)) . '</div>';
            if ($count42 > 0) {
                while ($row42 = $stmt42->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                    foreach ($row42 as $log) {
                        echo '<ul>
            <li>';
                        if ($log['section'] == 'attendance') {
                            echo '<i class="fa-solid fa-table"></i>';
                        } elseif ($log['section'] == 'Vacation') {
                            echo '<i class="fa-solid fa-house-circle-exclamation"></i>';
                        } elseif ($log['section'] == 'Settings') {
                            echo '<i class="fa-solid fa-gear"></i>';
                        } elseif ($log['section'] == 'Employee') {
                            echo '<i class="fa-solid fa-user-plus"></i>';
                        } elseif ($log['section'] == 'Employee Edit') {
                            echo '<i class="fa-solid fa-user-pen"></i>';
                        } elseif ($log['section'] == 'Employee Delete') {
                            echo '<i class="fa-solid fa-user-xmark"></i>';
                        } elseif ($log['section'] == 'Employee Active') {
                            echo '<i class="fa-solid fa-user-check"></i>';
                        } elseif ($log['section'] == 'Password') {
                            echo '<i class="fa-solid fa-lock"></i>';
                        } elseif ($log['section'] == 'Edit') {
                            echo '<i class="fa-solid fa-file-pen"></i>';
                        } elseif ($log['section'] == 'Delete') {
                            echo '<i class="fa-solid fa-trash"></i>';
                        } elseif ($log['section'] == 'Add') {
                            echo '<i class="fa-solid fa-plus"></i>';
                        } elseif ($log['section'] == 'salary') {
                            echo '<i class="fa-solid fa-money-bill"></i>';
                        } elseif ($log['section'] == 'Advance') {
                            echo '<i class="fa-solid fa-hand-holding-dollar"></i>';
                        }
                        echo '<div class="logs-contain">
              <div class="upper-log">' . $log['comment'] . '</div>
              <div class="lower-log">';

                        $stmt43 = $con->prepare("SELECT * FROM `users` WHERE `id` = '" . $log['id'] . "'");
                        $stmt43->execute();
                        $count43 = $stmt43->rowCount();
                        $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);

                        echo '<span><i class="fa-regular fa-clock"></i> ' . date("Y-m-d h:i A", strtotime($log['creation'])) . ' - <i class="fa-regular fa-user"></i> ' . $row43['name'] . '</span>
              </div>
            </div>
            </li>
          </ul>';
                    }
                }
            }
        }
    } else {
        echo "<div class='logs-no'>No logs yet</div>";
    }
}

function clear_logs()
{
    global $con;
    if (isset($_POST['clear_logs']) && !empty($_POST['clear_logs'])) {
        $stmt2 = $con->prepare("DELETE FROM `logs`");
        $stmt2->execute();
        $urid = $_COOKIE['urid'];
        $urid_array = explode("-", $urid);
        $sessionid = $urid_array[0];
        $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Delete all logs','Settings','" . date('Y-m-d H:i:s') . "')");
        $stmt4->execute(); // Create log for leave


        header("location:settings.php"); // Header to settings.php
    }
}

function get_contract()
{
    global $con;
    global $day;
    global $m;
    global $y;
    if (isset($_GET['uid'])) {
        if (!empty($_GET['uid'])) {
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

            $id = $_GET['uid'];

            $date = $year . "-" . $month;
            $stmt9 = $con->prepare("SELECT * FROM `salary` WHERE `id` = '$id' AND `date` = '$date' ");
            $stmt9->execute();
            $count9 = $stmt9->rowCount();
            $row9 = $stmt9->fetch(PDO::FETCH_ASSOC);

            if ($count9 > 0) {
                $total_ded = $row9['insure'] + $row9['tax'] + $row9['fellow'] + $row9['cash_advance'] + $row9['advance'] + $row9['penality'] + $row9['absence'];



                echo '<div class="payroll-row">
      <div>' . $row9['salary'] . '</div>
      <div>
        <div class="l-div">
          <div class="li-div"><input type="number" value="' . round($row9['main'], 1) . '" name="main" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['main2'], 1) . '" name="main2" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['loc_allow'], 1) . '" name="loc_allow" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['acco_allow'], 1) . '" name="acco_allow" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['cloth_allow'], 1) . '" name="cloth_allow" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['other_allow'], 1) . '" name="other_allow" step="0.1"></div>
          <div class="li-div">' . round($row9['overtime'], 1) . '</div>
        </div>
      </div>
      <div>
        <div class="l-div">
          <div class="li-div"><input type="number" value="' . round($row9['insure'], 1) . '" name="insure" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['tax'], 1) . '" name="tax" step="0.1"></div>
          <div class="li-div"><input type="number" value="' . round($row9['fellow'], 1) . '" name="fellow" step="0.1"></div>
          <div class="li-div">' . round($row9['cash_advance'], 1) . '</div>  
          <div class="li-div">' . round($row9['advance'], 1) . '</div>  
          <div class="li-div"><input type="number" value="' . round($row9['penality'], 1) . '" name="penality" step="0.1"></div>
          <div class="li-div">' . round($row9['delay'], 1) . '</div>          
          <div class="li-div">' . round($row9['absence'], 1) . '</div>
        </div>
      </div>
      <div>' . round($total_ded, 1) . '</div>
      <div>' . round($row9['total'], 1) . '</div>
    </div>';
                echo '<input type="hidden" name="salary" value="' . $row9['salary'] . '">';
                echo '<input type="hidden" name="uid" value="' . $id . '">';
                echo '<input type="hidden" name="dt" value="' . $date . '">';
            } else {
                echo "<div class='no-result'>No results for this date</div>";
            }
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
                        $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225)  + ((($tax_compare - 200000) / 12) * 0.25);
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
                $old_main =  $row26['main'];
                $old_main2 =  $row26['main2'];
                $old_loc =  $row26['loc_allow'];
                $old_acco =  $row26['acco_allow'];
                $old_cloth =  $row26['cloth_allow'];
                $old_other =  $row26['other_allow'];
                $old_tax =  $row26['tax'];
                $old_insure =  $row26['insure'];
                $old_fellow =  $row26['fellow'];
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

// payroll in check_all_contract() , add_employee() , edit_employee()
function edit_payroll()
{
    global $con;
    if (isset($_POST['uid']) && isset($_POST['dt'])) {
        $id = $_POST['uid'];
        $date = $_POST['dt'];
        if (isset($_POST['save']) && isset($_POST['salary']) && isset($_POST['main']) && isset($_POST['main2']) && isset($_POST['loc_allow']) && isset($_POST['acco_allow']) && isset($_POST['cloth_allow']) && isset($_POST['other_allow']) && isset($_POST['insure']) && isset($_POST['tax']) && isset($_POST['fellow']) && isset($_POST['penality'])) {
            $salary = $_POST['salary'];
            $main = $_POST['main'];
            $main2 = $_POST['main2'];
            $loc_allow = $_POST['loc_allow'];
            $acco_allow = $_POST['acco_allow'];
            $cloth_allow = $_POST['cloth_allow'];
            $other_allow = $_POST['other_allow'];
            $insure = $_POST['insure'];
            $tax = $_POST['tax'];
            $fellow = $_POST['fellow'];
            $penality = $_POST['penality'];





            if (is_numeric($salary) && is_numeric($main) && is_numeric($main2) && is_numeric($loc_allow) && is_numeric($acco_allow) && is_numeric($cloth_allow) && is_numeric($other_allow) && is_numeric($insure) && is_numeric($tax) && is_numeric($fellow) && is_numeric($penality)) {
                $total_benefits = $main + $main2 + $loc_allow + $acco_allow + $cloth_allow + $other_allow;

                if ($total_benefits == $salary) {
                    $taxn_compare = ((($main + $main2 + $other_allow) - $insure) * 12) - 24000;


                    if ($main + $main2 <= ($salary * 0.7) or $taxn_compare <= 0) {
                        $stmt26 = $con->prepare("SELECT * FROM `salary` WHERE `id` = '$id' AND `date` LIKE '$date%' ");
                        $stmt26->execute();
                        $count26 = $stmt26->rowCount();
                        $row26 = $stmt26->fetch(PDO::FETCH_ASSOC);


                        if ($count26 > 0) {
                            $absence = $row26['absence'];
                            $overtime = $row26['overtime'];
                            $late = $row26['delay'];
                            $old_tax = $row26['tax'];
                            $old_insure = $row26['insure'];
                            $old_main = $row26['main'];
                            $old_main2 = $row26['main2'];
                            $old_other_allow = $row26['other_allow'];
                            $main_holidays = $row26['main_holidays'];

                            if ($old_main != $main || $old_main2 != $main2) {
                                $insure = ($main + $main2) * 0.11;
                            }


                            if ($old_main != $main || $old_main2 != $main2 || $old_other_allow != $other_allow) {
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
                                        $tax = (500 * 0.025) + (1250 * 0.1) + (1250 * 0.15) + (11667 * 0.20) + (16667 * 0.225)  + ((($tax_compare - 200000) / 12) * 0.25);
                                    }
                                } else {
                                    $tax = 0;
                                }
                            }













                            $total = $total_benefits + $overtime - $absence - $late - $insure - $tax - $fellow - $cash_advance - $advance - $penality + $main_holidays;

                            if ($total < 0) {
                                $total = 0;
                            }

                            $stmt10 = $con->prepare("UPDATE `salary` SET `total` = '$total',`main` = '$main' ,`main2` = '$main2' , `loc_allow` = '$loc_allow' , `acco_allow` = '$acco_allow' , `cloth_allow` = '$cloth_allow',`other_allow` = '$other_allow',`delay` = '$late',`overtime` = '$overtime',`insure` = '$insure',`tax` = '$tax',`fellow` = '$fellow' ,`absence` = '$absence' , `penality` = '$penality' WHERE `id` = '$id' AND `date` = '$date' ");
                            $stmt10->execute();



                            $urid = $_COOKIE['urid'];
                            $urid_array = explode("-", $urid);
                            $sessionid = $urid_array[0];
                            $stmt4 = $con->prepare("INSERT INTO `logs`(`id`, `comment`,`section`,`creation`) VALUES ('$sessionid','Edit salary contract for employee #$id','salary','" . date('Y-m-d H:i:s') . "')");
                            $stmt4->execute(); // Create log for leave


                            header("location:contract.php?uid=$id&dt=$date");
                            exit();
                        }
                    } else {
                        echo "<div class='error_mg'>SUM of Insurance 1 & 2 shouldn't exceed " . $salary * 0.7 . " [ 70% ] " . $taxn_compare . "of gross salary</div>";
                    }
                } else {
                    echo "<div class='error_mg'>SUM of total benefits must be equal to gross salary</div>";
                }
            } else {
                echo "<div class='error_mg'>Not a numeric value</div>";
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
            } elseif ($status  == 1) {
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


                    $final_diff =  $diff - $ns;
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
      <a href='supplierdetails.php?cust-id=" . $customer['id'] . "' class='request-row'>
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
