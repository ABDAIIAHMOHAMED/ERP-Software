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
  "mobile" => "",
  "gender" => "",
  "personal_email" => "",
  "job_title" => "",
  "job_type" => "",
  "category" => "",
  "career_level" => "",
  "notes" => "",
  "street" => "",
  "city" => "",
  "state" => "",
  "postal" => "",
  "role" => "",
  "email" => "",
  "country" => "",
  "net_salary" => "",
];
if (isset($_POST['edit']) && !empty($_POST['edit'])) {
  $id = $_POST['id'];
  $fname = ""; ///////
  $mname = ""; ///////
  $lname = ""; ///////
  $mobile = ""; ///////
  $gender = ""; ///////
  $personal_email = ""; ///////
  $job_title = "";  ///////
  $job_type = "";   ///////
  $category = ""; ///////
  $career_level = ""; ///////
  $notes = ""; ///////
  $street = "";  ///////
  $city = "";  ///////
  $state = "";   ///////
  $postal = "";   ///////
  $country = "";  ///////
  $role = "";   ///////
  $email = "";   ///////
  $net_salary = "";   ///////


  if (isset($_POST['fname'])) {
    if (!empty($_POST['fname'])) {
      $fname = trim(filter_var($_POST['fname'], FILTER_SANITIZE_STRING));
      if (preg_match('~[0-9]+~', $fname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $fname)) {
        $errors["fname"] = "First name can't contain numbers or special character";
      } else {
        if (strlen($fname) < 3) {
          $errors["fname"] = "First name is too small minimun 3 character";
        } elseif (strlen($fname) > 64) {
          $errors["fname"] = "First name is too long maximun 64 character";
        }
      }
    } else {
      $errors["fname"] = "First name is required";
    }
  }


  if (isset($_POST['mname'])) {
    if (!empty($_POST['mname'])) {
      $mname = trim(filter_var($_POST['mname'], FILTER_SANITIZE_STRING));
      if (preg_match('~[0-9]+~', $mname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $mname)) {
        $errors["mname"] = "Middle name can't contain numbers or special character";
      } else {
        if (strlen($mname) < 3) {
          $errors["mname"] = "Middle name is too small minimun 3 character";
        } elseif (strlen($mname) > 64) {
          $errors["mname"] = "Middle name is too long maximun 64 character";
        }
      }
    }
  }

  if (isset($_POST['lname'])) {
    if (!empty($_POST['lname'])) {
      $lname = trim(filter_var($_POST['lname'], FILTER_SANITIZE_STRING));
      if (preg_match('~[0-9]+~', $lname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lname)) {
        $errors["lname"] = "Last name can't contain numbers or special character";
      } else {
        if (strlen($lname) < 3) {
          $errors["lname"] = "Last name is too small minimun 3 character";
        } elseif (strlen($lname) > 64) {
          $errors["lname"] = "Last name is too long maximun 64 character";
        }
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
  if (isset($_POST['gender'])) {
    if (!empty($_POST['gender'])) {
      $gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING);
      if (strlen($notes) > 300) {
        $errors["gender"] = "Maximun characters are 300";
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

  if (isset($_POST['salary'])) {
    if (!empty($_POST['salary'])) {
      $net_salary = $_POST['salary'];
    } else {
      $net_salary = 0;
    }
  }

  if (isset($_POST['personal_email'])) {
    if (!empty($_POST['personal_email'])) {
      $personal_email = $_POST['personal_email'];
      if (!filter_var($personal_email, FILTER_VALIDATE_EMAIL)) {
        $errors["personal_email"] = "Personal Email is not valid";
      }
    }
  }


  if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if ($_POST['email'] == "") {
      $errors["email"] = "Email is required";
    } else {
      $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = '$email' AND `id` != '$id'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count > 0) {
        $errors["email"] = "Email is already exist";
      }
    }
  }


  if (isset($_POST['role'])) {
    if (!empty($_POST['role'])) {
      $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `id` = '$role'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count <= 0) {
        $errors["role"] = "Role is not Valid";
      }
    }
  }



  if (isset($_POST['job_title'])) {
    if (!empty($_POST['job_title'])) {
      $job_title = filter_var($_POST['job_title'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `job_titles` WHERE `id` = '$job_title'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count <= 0) {
        $errors["job_title"] = "Job Title is not valid";
      }
    } else {
      $errors["job_title"] = "This field is required and cannot be empty";
    }
  }

  if (isset($_POST['category'])) {
    if (!empty($_POST['category'])) {
      $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `categories` WHERE `id` = '$category'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count <= 0) {
        $errors["category"] = "Category is not valid";
      }
    } else {
      $errors["category"] = "This field is required and cannot be empty";
    }
  }

  if (isset($_POST['jobtype'])) {
    if (!empty($_POST['jobtype'])) {
      $job_type = filter_var($_POST['jobtype'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `job_types` WHERE `id` = '$job_type'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count <= 0) {
        $errors["job_type"] = "Job Type is not valid";
      }
    } else {
      $errors["job_type"] = "This field is required and cannot be empty";
    }
  }

  if (isset($_POST['careerlevel'])) {
    if (!empty($_POST['careerlevel'])) {
      $career_level = filter_var($_POST['careerlevel'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `career_levels` WHERE `id` = '$career_level'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count <= 0) {
        $errors["career_level"] = "Career Level is not valid";
      }
    } else {
      $errors["career_level"] = "This field is required and cannot be emptys";
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
  if (isset($_POST['state'])) {
    if (!empty($_POST['state'])) {
      $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
      if (strlen($state) > 25) {
        $errors["state"] = "Maximun characters are 25";
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
            $errors["postal"] = "Postal number is too small minimun 2 numbers";
          } elseif (strlen($postal) > 20) {
            $errors["postal"] = "Postal number is too long maximun 13 numbers";
          }
        }
      } else {
        $errors["postal"] = "Postal number can't contain any characters";
      }
    }
  }




  $name = $fname . " " . $mname . " " . $lname;

  if (empty(array_filter($errors))) {
    if ($_FILES['profile-pic']['error'] == 4) {
      $stmt6 = $con->prepare("UPDATE `users` SET  `name` = '$name',`fname` = '$fname'  , `mname` = '$mname', `lname` = '$lname', `email` = '$email',`personal_email` = '$personal_email',`mobile` = '$mobile'  ,`notes` = '$notes' , `street` = '$street' , `city` = '$city' , `state` = '$state' , `postal` = '$postal' ,`country` = '$country' ,`net_salary` = '$net_salary' ,`gender` = '$gender' , `job_title` = '$job_title' , `job_type` = '$job_type' , `category` = '$category' ,`career_level` = '$career_level',`role`='$role' WHERE `id` = '$id'");
      $stmt6->execute(); // Update salary in salary_employee
    } else {
      $pdf_type = $_FILES['profile-pic']['type'];
      $pdf_temp = $_FILES['profile-pic']['tmp_name'];
      $pdf_size = $_FILES['profile-pic']['size'];
      $pdf_extension = @strtolower(end(explode('.', $_FILES['profile-pic']['name'])));
      $pdf_name = rand(0, 100000000000000) . "." . $pdf_extension;
      $allowed_extensions_pdf = [
        "pdf",
        "jpg",
        "jpeg",
        "png",
        "gif",
        "jfif"
      ];

      if ($pdf_size > 10000000) {
        echo "Image must be less than 10MB";
      } else if (!in_array($pdf_extension, $allowed_extensions_pdf)) {
        echo "File is not valid";
      } else {

        if (move_uploaded_file($pdf_temp, __DIR__ . "/../../../images/ur-img/" . $pdf_name)) {
          move_uploaded_file($pdf_temp, __DIR__ . "/../../../images/ur-img/" . $pdf_name);
        } else {
          echo "Upload image failed";
        }
      }
      $stmt5 = $con->prepare("UPDATE `users` SET  `picture`= '$pdf_name' , `name` = '$name',`fname` = '$fname'  , `mname` = '$mname', `lname` = '$lname', `email` = '$email',`personal_email` = '$personal_email',`mobile` = '$mobile'  ,`notes` = '$notes' , `street` = '$street' , `city` = '$city' , `state` = '$state' , `postal` = '$postal' ,`country` = '$country' ,`net_salary` = '$net_salary' ,`gender` = '$gender' , `job_title` = '$job_title' , `job_type` = '$job_type' , `category` = '$category' ,`career_level` = '$career_level',`role`='$role' WHERE `id` = '$id'");
      $stmt5->execute(); // Update salary in salary_employee
    }

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
