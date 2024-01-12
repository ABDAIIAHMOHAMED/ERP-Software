
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
  "fname" => "",
  "mname" => "",
  "lname" => "",
  "cname" => "",
  "type" => "",
  "phone" => "",
  "mobile" => "",
  "fax" => "",
  "email" => "",
  "website" => "",
  "other" => "",
  "notes" => "",
  "street" => "",
  "city" => "",
  "state" => "",
  "postal" => "",
  "country" => "",
  "tax_id" => "",
];
if (isset($_POST['add']) && !empty($_POST['add'])) {
  $fname = ""; ///////
  $is_company = "0"; ///////
  $mname = ""; ///////
  $lname = ""; ///////
  $cname = ""; ///////
  $type = ""; ///////
  $phone = ""; ///////
  $mobile = ""; ///////
  $fax = ""; ///////
  $email = ""; ///////
  $website = "";  ///////
  $other = "";   ///////
  $notes = ""; ///////
  $street = "";  ///////
  $city = "";  ///////
  $state = "";   ///////
  $postal = "";   ///////
  $country = "";  ///////
  $tax_id = "";   ///////
  $cdate = date("Y-m-d");
  $lmodification = date("Y-m-d");
  if (isset($_POST['type'])) {
    if (!empty($_POST['type'])) {
      $is_company = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
    }
    $type = "1";
  } else {
    $type = "0";
  }
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
        } elseif (strlen($fname) > 18) {
          $errors["fname"] = "First name is too long maximun 18 character";
        }
      }
    } else {
      if ($type == "1") {
      } else {
        $errors["fname"] = "First name is required";
      }
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
        } elseif (strlen($mname) > 18) {
          $errors["mname"] = "Middle name is too long maximun 18 character";
        }
      }
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
        } elseif (strlen($lname) > 18) {
          $errors["lname"] = "Last name is too long maximun 18 character";
        }
      }
    }
  }

  if (isset($_POST['cname'])) {
    if (!empty($_POST['cname'])) {
      $cname = filter_var($_POST['cname'], FILTER_SANITIZE_STRING);
      if (preg_match('~[0-9]+~', $cname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $cname)) {
        $errors["cname"] = "Company name can't contain numbers or special character";
      } else {
        if (strlen($cname) < 3) {
          $errors["cname"] = "Company name is too small minimun 3 character";
        } elseif (strlen($cname) > 18) {
          $errors["cname"] = "Company name is too long maximun 18 character";
        }
      }
    } else {
      if ($type == "0") {
      } else {
        $errors["cname"] = "Company name is required";
      }
    }
  }

  if (isset($_POST['notes'])) {
    if (!empty($_POST['notes'])) {
      $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
      if (strlen($notes) > 300) {
        $errors["notes"] = "Maximun characters are 300";
      }
    }
  }

  if (isset($_POST['type'])) {
    if (!empty($_POST['type'])) {
      $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
      if ($type == "1") {
      } else {
        $errors["type"] = "This value is not valid";
      }
    }
  }

  if (isset($_POST['email'])) {
    if (!empty($_POST['email'])) {
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
      }
    }
  }

  if (isset($_POST['website'])) {
    if (!empty($_POST['website'])) {
      $website = filter_var($_POST['website'], FILTER_SANITIZE_EMAIL);
      if (filter_var($website, FILTER_VALIDATE_URL)) {
        $errors["website"] = "Website is not valid";
      }
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

  if (isset($_POST['mobile'])) {
    if (!empty($_POST['mobile'])) {
      $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
      if (is_numeric($mobile)) {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $mobile)) {
          $errors["mobile"] = "Phone number can't contain special character";
        } else {
          if ($mobile == trim($mobile) && strpos($mobile, ' ') !== false) {
            $errors["mobile"] = "Phone number can't contain any spaces";
          }
          if (strlen($mobile) < 6) {
            $errors["mobile"] = "Phone number is too small minimun 6 numbers";
          } elseif (strlen($mobile) > 15) {
            $errors["mobile"] = "Last name is too long maximun 15 numbers";
          }
        }
      } else {
        $errors["mobile"] = "Phone number can't contain any characters";
      }
    }
  }

  if (isset($_POST['fax'])) {
    if (!empty($_POST['fax'])) {
      $fax = filter_var($_POST['fax'], FILTER_SANITIZE_STRING);
      if (is_numeric($fax)) {
        if (preg_match('/[\'^£$%&*()}{@#~?><div>,|=_+¬-]/', $fax)) {
          $errors["fax"] = "Phone number can't contain special character";
        } else {
          if ($fax == trim($fax) && strpos($fax, ' ') !== false) {
            $errors["fax"] = "Phone number can't contain any spaces";
          }
          if (strlen($fax) < 6) {
            $errors["fax"] = "Phone number is too small minimun 6 numbers";
          } elseif (strlen($fax) > 15) {
            $errors["fax"] = "Last name is too long maximun 15 numbers";
          }
        }
      } else {
        $errors["fax"] = "Phone number can't contain any characters";
      }
    }
  }

  if (isset($_POST['other'])) {
    if (!empty($_POST['other'])) {
      $other = filter_var($_POST['other'], FILTER_SANITIZE_STRING);
      if (strlen($other) > 150) {
        $errors["other"] = "Maximun characters are 150";
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


  if (isset($_POST['tax_id'])) {
    if (!empty($_POST['tax_id'])) {
      $tax_id = filter_var($_POST['tax_id'], FILTER_SANITIZE_STRING);
      if (
        strlen($tax_id) >
        20
      ) {
        $errors["tax_id"] = "Maximun characters are 20";
      }
    }
  }


  if (empty(array_filter($errors))) {
    $stmt4 = $con->prepare("INSERT INTO `customers`(`first_name`,`middle_name`,`last_name`,`company_name`,`is_company`,`phone`,`mobile`,`fax`,`email`,`website`,`other`,`notes`,`street`,`city`,`state`,`postal`,`country`,`tax_id`,`created_time`,`last_modification`) VALUES ('$fname','$mname','$lname','$cname','$type','$phone','$mobile','$fax','$email','$website','$other','$notes','$street','$city','$state','$postal','$country','$tax_id','$cdate','$lmodification')");
    $stmt4->execute();
    get_customers();
    echo "<div class='pop_box success_box'><div class='pop_title'>Customer was added successfully</div>";
    echo "</div><script>
        $(document).ready(function () {
          $('.pop_box').delay(2000).fadeOut(500);
        });
        </script>";
  } else {
    get_customers();
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