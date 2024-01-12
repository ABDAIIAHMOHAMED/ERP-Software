<?php
require "../../functions/connect.php"; // Connect to database file

$banks = array();
if (isset($_POST['bank_name']) && !empty($_POST['bank_name'])) {
  $bank_name = $_POST['bank_name'];

  $stmt = $con->prepare("SELECT * FROM `bank_account` WHERE `bank_name` = '$bank_name'");
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
      foreach ($row as $bank) {
        $name = $bank['account_number'];
        $bank_i = array(
          'bank_account' => $name,
        );
        array_push($banks, $bank_i);
      }
    }
  }
}

echo json_encode($banks);
