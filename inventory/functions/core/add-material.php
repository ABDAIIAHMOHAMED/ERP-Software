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
if (isset($_POST['add_item']) && !empty($_POST['add_item'])) {
  $name = "";
  $code = "";
  $unit = "";
  $rate = "";
  $pf_supplier = "";
  $desc = "";
  $created_time = date("Y-m-d h:i A");
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
  if (isset($_POST['unit'])) {
    if (!empty($_POST['unit'])) {
      $unit = trim(filter_var($_POST['unit'], FILTER_SANITIZE_STRING));
    } else {
      $errors["unit"] = "Unit is required";
    }
  }
  if (isset($_POST['code'])) {
    if (!empty($_POST['code'])) {
      $code = trim($_POST['code']);
      if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $code)) {
        $errors["code"] = "Code can't contain special character";
      }
    } else {
      $errors["code"] = "Product Code is required";
    }
  }
  if (isset($_POST['rate'])) {
    if (!empty($_POST['rate'])) {
      $rate = filter_var($_POST['rate'], FILTER_SANITIZE_STRING);
      if (is_numeric($rate)) {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $rate)) {
          $errors["rate"] = "rate can't contain special character";
        } else {
          if ($rate == trim($rate) && strpos($rate, ' ') !== false) {
            $errors["rate"] = "rate can't contain any spaces";
          } else {
            if ($rate < 0) {
              $errors["rate"] = "Minimum rate is 0 EGP";
            }
          }
        }
      } else {
        $errors["rate"] = "rate can't contain any characters";
      }
    }
  }
  if (isset($_POST['description'])) {
    if (!empty($_POST['description'])) {
      $desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      if (strlen($desc) > 256) {
        $errors["description"] = "Maximun characters are 256";
      }
    }
  }
  if (isset($_POST['supplier_list'])) {
    if (!empty($_POST['supplier_list'])) {
      $pf_supplier = filter_var($_POST['supplier_list'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `suppliers` WHERE `id` = '$pf_supplier'");
      $stmt->execute();
      $count = $stmt->rowCount();
      if ($count == 0) {
        $errors["supplier_list"] = "Supplier is not already exist";
      }
    }
  }

  if ($_FILES['item_img']['error'] == 4) {
    $pdf_name = "no-photo.png";
  } else {
    $pdf_type = $_FILES['item_img']['type'];
    $pdf_temp = $_FILES['item_img']['tmp_name'];
    $pdf_size = $_FILES['item_img']['size'];
    $pdf_extension = @strtolower(end(explode('.', $_FILES['item_img']['name'])));
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
      echo "pdf must be less than 10MB";
    } else if (!in_array($pdf_extension, $allowed_extensions_pdf)) {
      echo "File is not valid";
    } else {

      if (move_uploaded_file($pdf_temp, __DIR__ . "/../../../assets/items/" . $pdf_name)) {
        move_uploaded_file($pdf_temp, __DIR__ . "/../../../assets/items/" . $pdf_name);
      } else {
        echo "Upload image failed";
      }
    }
  }

  if (empty(array_filter($errors))) {
    $stmt = $con->prepare("INSERT INTO `items`(`code`, `name`,`description`,`unit`,`amount`,`img`,`created_time`) VALUES ('$code','$name','$desc','$unit','$rate','$pdf_name','$created_time')");
    $stmt->execute();
    echo "<div class='pop_box success_box'><div class='pop_title'>Item was added Successfully</div>";
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
