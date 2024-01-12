
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
  "name" => "",
];
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['account_id']) && !empty($_POST['account_id'])) {
  $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
  $id = $_POST['account_id'];

  if (empty(array_filter($errors))) {
    $stmt5 = $con->prepare("UPDATE `share_account` SET `name` = '$name' WHERE `id` = '$id'");
    $stmt5->execute(); // Update salary in salary_employee
    echo "<div class='pop_box success_box'><div class='pop_title'>Loading...</div>";
    echo "</div><script>
        $(document).ready(function () {
          $('.pop_box').delay(2000).fadeOut(500);
        });
        </script>";
  } else {
    echo "<div class='pop_box error_box'><div class='pop_title'>Some Errors in inputs:</div>";
    foreach ($errors as $e) {
      if (!empty($e)) {
        echo "
                  <div class='pop-message'>
                  " . $e . "
                  </div>";
      }
    }
    echo "</div>
        <script>
        $(document).ready(function () {
          $('.pop_box').delay(2000).fadeOut(500);
        });
        </script>";
  }
}

?>