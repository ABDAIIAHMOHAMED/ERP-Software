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
  "description" => "",
];
if (isset($_POST['type'])) {
  if ($_POST['type'] == 'f') {
    if (isset($_POST['add_item']) && !empty($_POST['add_item'])) {
      $name = "";
      $code = "";
      $unit = "";
      $rate = "";
      $pf_supplier = "";
      $desc = "";
      $id = $_POST['id'];
      $old_id = $_POST['old_id'];

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
            $errors["code"] = "barcode can't contain special character";
          }
          // else {
          //   if (strlen($code) !== 12) {
          //     $errors["code"] = "Product Code in not valid";
          //   }
          // }
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




      if (empty(array_filter($errors))) {
        if (isset($_POST['p'])) {
          $is_comp = "1";
          $filteredArray = array_values(array_filter($_POST["p"], function ($row) {
            return
              !empty($row["id"]);
          }));
          $id_array = array();
          $quantity_array = array();
          foreach ($filteredArray as $fa) {
            array_push($id_array, $fa['id']);
            array_push($quantity_array, $fa['quantity']);
          }
          $imploded_ids = implode("-", $id_array);
          $imploded_quantity = implode("-", $quantity_array);
        } else {
          $is_comp = "0";
          $imploded_ids = "";
          $imploded_quantity = "";
        }

        if ($_FILES['item_img']['error'] == 4) {
          $stmt = $con->prepare("UPDATE `final_items` SET  `code` = '$code'  , `name` = '$name', `description` = '$desc', `unit` = '$unit',`amount` = '$rate',`is_composite` = '$is_comp',`sub_items`='$imploded_ids',`sub_quantity`= '$imploded_quantity' WHERE `id` = '$id'");
          $stmt2 = $con->prepare("UPDATE `av_items` SET  `name` = '$name'  , `unit` = '$unit', `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt3 = $con->prepare("UPDATE `manufacturer_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt4 = $con->prepare("UPDATE `sell_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt5 = $con->prepare("UPDATE `transfers` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
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
          $stmt = $con->prepare("UPDATE `final_items` SET  `code` = '$code'  , `name` = '$name', `description` = '$desc', `unit` = '$unit',`amount` = '$rate',`img`='$pdf_name',`is_composite` = '$is_comp',`sub_items`='$imploded_ids',`sub_quantity`= '$imploded_quantity' WHERE `id` = '$id'");
          $stmt2 = $con->prepare("UPDATE `av_items` SET  `name` = '$name'  , `unit` = '$unit', `item_id` = '$code',`img`='$pdf_name' WHERE `item_id` = '$old_id'");
          $stmt3 = $con->prepare("UPDATE `manufacturer_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt4 = $con->prepare("UPDATE `sell_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt5 = $con->prepare("UPDATE `transfers` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
        }
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();
        $stmt5->execute();
        echo "<div class='pop_box success_box'><div class='pop_title'>Item was edited Successfully</div>";
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
  } else if ($_POST['type'] == 'm') {
    if (isset($_POST['add_item']) && !empty($_POST['add_item'])) {
      $name = "";
      $code = "";
      $unit = "";
      $rate = "";
      $pf_supplier = "";
      $desc = "";
      $id = $_POST['id'];
      $old_id = $_POST['old_id'];

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



      if (empty(array_filter($errors))) {
        if ($_FILES['item_img']['error'] == 4) {
          $stmt = $con->prepare("UPDATE `items` SET  `code` = '$code'  , `name` = '$name', `description` = '$desc', `unit` = '$unit',`amount` = '$rate' WHERE `id` = '$id'");
          $stmt2 = $con->prepare("UPDATE `av_items` SET  `name` = '$name'  , `unit` = '$unit', `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt3 = $con->prepare("UPDATE `supplier_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt5 = $con->prepare("UPDATE `transfers` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
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
          $stmt = $con->prepare("UPDATE `items` SET  `code` = '$code'  , `name` = '$name', `description` = '$desc', `unit` = '$unit',`amount` = '$rate',`img`='$pdf_name' WHERE `id` = '$id'");
          $stmt2 = $con->prepare("UPDATE `av_items` SET  `name` = '$name'  , `unit` = '$unit', `item_id` = '$code',`img`='$pdf_name' WHERE `item_id` = '$old_id'");
          $stmt3 = $con->prepare("UPDATE `supplier_orders` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
          $stmt5 = $con->prepare("UPDATE `transfers` SET `item_id` = '$code' WHERE `item_id` = '$old_id'");
        }
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt5->execute();
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
  }
}
