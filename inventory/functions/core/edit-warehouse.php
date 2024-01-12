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
  "code" => "",
  "unit" => "",
  "rate" => "",
  "prefered_supplier" => "",
  "description" => "",
];
if (isset($_POST['edit']) && !empty($_POST['edit'])) {
  $name = ""; ///////
  $code = ""; ///////
  $phone = ""; ///////
  $street = ""; ///////
  $city = ""; ///////
  $state = ""; ///////
  $postal = ""; ///////
  $country = ""; ///////
  $notes = ""; ///////
  $cdate = date("Y-m-d h:i A");
  $id = $_POST['id'];

  if (isset($_POST['name'])) {
    if (!empty($_POST['name'])) {
      $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
      if (strlen($name) < 2) {
        $errors["name"] = "Name is too small minimun 2 character";
      } elseif (strlen($name) > 128) {
        $errors["name"] = "Name is too long maximun 128 character";
      }
    } else {
      $errors["name"] = "Name is required";
    }
  }


  if (isset($_POST['code'])) {
    if (!empty($_POST['code'])) {
      $code = trim(filter_var($_POST['code'], FILTER_SANITIZE_STRING));
      if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $code)) {
        $errors["code"] = "Name can't contain special character";
      } else {
        if (strlen($code) < 6) {
          $errors["code"] = "Code is not valid";
        } elseif (strlen($code) > 6) {
          $errors["code"] = "Code is not valid";
        }
        $stmt = $con->prepare("SELECT * FROM `warehouses` WHERE code = '$code'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
          $code = rand(100000, 999999);
        }
      }
    } else {
      $errors["code"] = "Code is required";
    }
  } else {
    $code = rand(100000, 999999);
  }

  if (isset($_POST['notes'])) {
    if (!empty($_POST['notes'])) {
      $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
      if (strlen($notes) > 300) {
        $errors["notes"] = "Maximun characters are 300";
      }
    }
  }

  if (isset($_POST['status'])) {
    if (!empty($_POST['status'])) {
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
      if ($status == 1) {
        $status = 1;
      } else {
        $status = 0;
      }
    } else {
      $status = 0;
    }
  } else {
    $status = 0;
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
          if (strlen($phone) < 6) {
            $errors["phone_number"] = "Phone number is too small minimun 6 numbers";
          } elseif (strlen($phone) > 15) {
            $errors["phone_number"] = "Last name is too long maximun 15 numbers";
          }
        }
      } else {
        $errors["phone_number"] = "Phone number can't contain any characters";
      }
    }
  }


  if (isset($_POST['street'])) {
    if (!empty($_POST['street'])) {
      $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
      if (strlen($street) > 250) {
        $errors["street"] = "Maximun characters are 250";
      }
    }
  }

  if (isset($_POST['city'])) {
    if (!empty($_POST['city'])) {
      $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
      if (strlen($city) > 25) {
        $errors["city"] = "Maximun characters are 25";
      }
    }
  }

  if (isset($_POST['state'])) {
    if (!empty($_POST['state'])) {
      $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
      if (strlen($state) > 25) {
        $errors["state"] = "Maximun characters are 25";
      }
    }
  }

  if (isset($_POST['postal'])) {
    if (!empty($_POST['postal'])) {
      $postal = filter_var($_POST['postal'], FILTER_SANITIZE_STRING);
      if (is_numeric($postal)) {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $postal)) {
          $errors["postal"] = "Postal number can't contain special character";
        } else {
          if ($postal == trim($postal) && strpos($postal, ' ') !== false) {
            $errors["postal"] = "Postal number can't contain any spaces";
          }
          if (strlen($postal) < 2) {
            $errors["postal"] = "Postal number is too small minimun 11 numbers";
          } elseif (strlen($postal) > 20) {
            $errors["postal"] = "Postal number is too long maximun 13 numbers";
          }
        }
      } else {
        $errors["curr_postal"] = "Postal number can't contain any characters";
      }
    }
  }

  if (empty(array_filter($errors))) {
    $stmt5 = $con->prepare("UPDATE `warehouses` SET  `name` =  '$name' ,`phone` = '$phone'  , `notes` = '$notes', `street` = '$street', `city` = '$city' ,`state` = '$state', `postal` = '$postal' , `country` = '$country' ,`status` = '$status' WHERE `id` = '$id'");
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
