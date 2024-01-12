<?php
require "../../../functions/connect.php"; // Connect to database file
require "../../../functions/general.php"; // Connect to database file
date_default_timezone_set("Africa/Cairo"); // Set Default timezone for Egypt Cairo
$date = strtotime(date("Y-m-d")); // Get timestamp for the date
$day = date('d', $date); // Get actual day
$m = date('m', $date); // Get actual month
$y = date('Y', $date); // Get actual year

global $con;
$errors = [
    "notes" => "",
];
if (isset($_POST['quicknotes']) && !empty($_POST['quicknotes'])) {
    $notes = "";
    $id = $_POST['id'];
    if (isset($_POST['quicknotes'])) {
        if (!empty($_POST['quicknotes'])) {
            $notes = trim(filter_var($_POST['quicknotes'], FILTER_SANITIZE_STRING));
            if (strlen($notes) > 300) {
                $errors["quicknotes"] = "Maximun characters are 300";
            }
        }
    }

    $type = $_POST['type'];
    if (empty(array_filter($errors))) {
        $stmt5 = $con->prepare("UPDATE `$type` SET `notes` = '$notes'  WHERE `id` = '$id'");
        $stmt5->execute(); // Update salary in salary_employee
        echo $notes;
    } else {
        echo $notes;
    }
}
