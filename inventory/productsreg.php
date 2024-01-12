<?php
$pg_name = "Wonder - Product Registeration";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(613) == 1) {
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Product Registeration</h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Product Registeration</p>
        </div>

        <div class="btns">

          <button class="filter"><i class="fa-solid fa-filter"></i></button>
          <button class="export"><i class="fa-solid fa-download"></i>
            <ul class="export-options">
              <li class="option" id="ExportReporttoPdf3">
                <div><i class="fa-solid fa-print"></i> Print List</div>
              </li>
              <li class="option" id="ExportReporttoExcel3">
                <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
              </li>
            </ul>
          </button>
          <div class="buttons">
            <button class="transactions">Action <i class="fa-solid fa-caret-down"></i></button>
            <ul class="transactions-list">
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(614) == 1) {
              ?>
                <li class="trans-option" id="invoice-btn">Add Material</li>
              <?php
              }
              ?>
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(615) == 1) {
              ?>
                <li class="trans-option" id="payment-btn">Add Final Product</li>
              <?php
              }
              ?>
            </ul>
          </div>
        </div>

      </div>
      <div class="request-section filter-section">
        <form action="" method="POST">
          <input type="hidden" name="page" value="">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <div class="inputs">
              <label for="avail_filter">Type</label>
              <select name="avail" id="avail_filter">
                <option value="all">All</option>
                <option value="final">Final Product</option>
                <option value="material">Material</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="employee-section request-section">
        <form action="" method="POST" class="list-form">
          <div class="main-table-style">
            <div class="serch">
              <input type="text" id="name-search" value="" placeholder="Search...">
            </div>
            <table id="supplierslist" style="width:100% !important;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item</th>
                  <th>type</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Rate (E£)</th>
                  <th>Action</th>
                </tr>
              </thead>

            </table>
          </div>
          <input type="submit" class="delete-btn" name="inactive-submit" value="Mark as Inactive">
        </form>
      </div>
      <div class="black_screen"></div>
      <div class="add_new_item">
        <div class="custome-head">
          <h3>Add Material</h3>
          <button class="close_not_final"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" id="new_item" action="" method="POST" enctype="multipart/form-data">
          <div class="custom-form custom-item-form">
            <div class="spectra">
              <label for="item_img_input1">
                <div class="item_image">
                  <span class="edit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 492.493 492" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                      <g>
                        <path d="M304.14 82.473 33.165 353.469a10.799 10.799 0 0 0-2.816 4.949L.313 478.973a10.716 10.716 0 0 0 2.816 10.136 10.675 10.675 0 0 0 7.527 3.114 10.6 10.6 0 0 0 2.582-.32l120.555-30.04a10.655 10.655 0 0 0 4.95-2.812l271-270.977zM476.875 45.523 446.711 15.36c-20.16-20.16-55.297-20.14-75.434 0l-36.949 36.95 105.598 105.597 36.949-36.949c10.07-10.066 15.617-23.465 15.617-37.715s-5.547-27.648-15.617-37.719zm0 0" fill="#ad6420" data-original="#000000" class=""></path>
                      </g>
                    </svg>
                  </span>
                  <img src="../assets/items/no-photo.png" class="item-img" id="preview_item_img1" alt="item_image">
                </div>
              </label>
              <input type="file" name="item_img" id="item_img_input1" class="item_img_input" value="" accept="image/png,image/jpeg,image/jpg">
            </div>

            <script>
              $(document).ready(function() {

                var $fileInput = $('#item_img_input1');
                var $imagePreview = $('#preview_item_img1');

                $fileInput.on('change', function() {
                  var file = this.files[0];
                  var reader = new FileReader();

                  reader.addEventListener('load', function() {
                    $imagePreview.attr('src', reader.result);
                  });

                  reader.readAsDataURL(file);
                });
              });
            </script>
            <div class="sectra item_sectra">
              <div class="form-section">
                <div class="inputs gd4">
                  <label for="name">Name <span>*</span></label>
                  <input type="text" class="" name="name" id="name" required>
                </div>
                <div class="inputs gd2">
                  <label for="code">Unique Product Code <span>*</span></label>
                  <input type="number" class="" name="code" id="code" required>
                </div>
                <div class="inputs gd3">
                  <label for="unit">Unit <span>*</span></label>
                  <select name="unit" id="unit">
                    <optgroup label="">
                      <option value="Piece">Pieces</option>
                    </optgroup>
                    <optgroup label="Area Units">
                      <option value="mm">mm</option>
                      <option value="mm2">mm2</option>
                      <option value="cm">cm</option>
                      <option value="cm2">cm2</option>
                      <option value="m">m</option>
                      <option value="m2">m2</option>
                    </optgroup>
                    <optgroup label="Volume Units">
                      <option value="mm3">mm3</option>
                      <option value="cm3">cm3</option>
                      <option value="m3">m3</option>
                      <option value="mL">mL</option>
                      <option value="L">L</option>
                    </optgroup>
                    <optgroup label="Weight Units">
                      <option value="mg">mg</option>
                      <option value="g">g</option>
                      <option value="kg">kg</option>
                      <option value="ton">ton</option>
                    </optgroup>
                  </select>
                </div>
                <div class="inputs gd3">
                  <label for="rate">Rate (E£)</label>
                  <input type="number" value="0" class="" min="0" name="rate" id="rate2" step="0.00000001" required>
                </div>
                <div class="inputs gd6">
                  <label for="supplier_list">Prefered Supplier</label>
                  <select name="supplier_list" id="supplier_list">
                    <option value=""></option>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM `suppliers`");
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                        foreach ($row as $supp) {
                          if ($supp['is_company'] == "0") {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['first_name'] . " " . $supp['middle_name'] . " " . $supp['last_name'] . "</option>";
                          } else {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['company_name'] . "</option>";
                          }
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="inputs gd6">
                  <label for="description">Description</label>
                  <textarea name="description" id="description2" cols="30" rows="10"></textarea>
                </div>
              </div>
            </div>
          </div>
          <hr class="hr_form">
          <div class="loadings"><i class=""></i></div>
          <input type="hidden" name="add_item" value="Save">
          <input type="submit" class="add" value="Add" id="save_item">
        </form>
      </div>
      <div class="add_new_item_final">
        <div class="custome-head">
          <h3>Add Product</h3>
          <button class="close_final"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" id="new_item_final" action="" method="POST" enctype="multipart/form-data">
          <div class="custom-form custom-item-form">
            <div class="spectra">
              <label for="item_img_input">
                <div class="item_image">
                  <span class="edit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 492.493 492" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                      <g>
                        <path d="M304.14 82.473 33.165 353.469a10.799 10.799 0 0 0-2.816 4.949L.313 478.973a10.716 10.716 0 0 0 2.816 10.136 10.675 10.675 0 0 0 7.527 3.114 10.6 10.6 0 0 0 2.582-.32l120.555-30.04a10.655 10.655 0 0 0 4.95-2.812l271-270.977zM476.875 45.523 446.711 15.36c-20.16-20.16-55.297-20.14-75.434 0l-36.949 36.95 105.598 105.597 36.949-36.949c10.07-10.066 15.617-23.465 15.617-37.715s-5.547-27.648-15.617-37.719zm0 0" fill="#ad6420" data-original="#000000" class=""></path>
                      </g>
                    </svg>
                  </span>
                  <img src="../assets/items/no-photo.png" class="item-img" id="preview_item_img" alt="item_image">
                </div>
              </label>
              <input type="file" name="item_img" id="item_img_input" class="item_img_input" value="" accept="image/png,image/jpeg,image/jpg">
            </div>
            <script>
              $(document).ready(function() {
                var $fileInput = $('#item_img_input');
                var $imagePreview = $('#preview_item_img');

                $fileInput.on('change', function() {
                  var file = this.files[0];
                  var reader = new FileReader();

                  reader.addEventListener('load', function() {
                    $imagePreview.attr('src', reader.result);
                  });

                  reader.readAsDataURL(file);
                });
              });
            </script>
            <div class="sectra item_sectra">
              <div class="form-section">
                <div class="inputs gd4">
                  <label for="name">Name <span>*</span></label>
                  <input type="text" class="" name="name" id="name" required>
                </div>
                <div class="inputs gd2">
                  <label for="code">Unique Product Code <span>*</span></label>
                  <input type="number" class="" name="code" id="final_code" required>
                </div>
                <div class="inputs gd3">
                  <label for="unit">Unit <span>*</span></label>
                  <select name="unit" id="unit">
                    <optgroup label="">
                      <option value="Piece">Pieces</option>
                    </optgroup>
                    <optgroup label="Area Units">
                      <option value="mm">mm</option>
                      <option value="mm2">mm2</option>
                      <option value="cm">cm</option>
                      <option value="cm2">cm2</option>
                      <option value="m">m</option>
                      <option value="m2">m2</option>
                    </optgroup>
                    <optgroup label="Volume Units">
                      <option value="mm3">mm3</option>
                      <option value="cm3">cm3</option>
                      <option value="m3">m3</option>
                      <option value="mL">mL</option>
                      <option value="L">L</option>
                    </optgroup>
                    <optgroup label="Weight Units">
                      <option value="mg">mg</option>
                      <option value="g">g</option>
                      <option value="kg">kg</option>
                      <option value="ton">ton</option>
                    </optgroup>
                  </select>
                </div>
                <div class="inputs gd3">
                  <label for="rate">Est. Cost (E£)</label>
                  <input type="number" value="0" class="" min="0" name="rate" id="rate" step="0.000000001" required>
                </div>
                <div class="inputs gd6">
                  <label for="supplier_list">Prefered Manufacturer</label>
                  <select name="supplier_list" id="supplier_list">
                    <option value=""></option>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM `manufacturers`");
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                        foreach ($row as $supp) {
                          if ($supp['is_company'] == "0") {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['first_name'] . " " . $supp['middle_name'] . " " . $supp['last_name'] . "</option>";
                          } else {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['company_name'] . "</option>";
                          }
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="inputs gd6">
                  <label for="description">Description</label>
                  <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>
                <div class="inputs gd6">
                  <label for="comp_check">Composite Product</label>
                  <input type="checkbox" name="is_composite" class="comp_check">
                </div>
                <div class="comp-items gd6">
                  <hr class="hr_form">
                  <div class="employee-section request-section invoice-list subcomp-list">
                    <div class="request-list">
                      <div class="request-row request-head-list">
                        <div>Item</div>
                        <div>Qty</div>
                        <div>Unit</div>
                        <div>Cost/Unit (E£)</div>
                        <div>Total Cost (E£)</div>
                        <div></div>
                      </div>
                      <div class="request-body-list" id="sub-list">
                        <div class='request-row' id="row1">
                          <div>
                            <input type="text" class="item_name subitem_name1" name="p[1][name]">
                            <input type="text" class="subitem_id1 hidden" name="p[1][id]">
                            <ul class="subsuggestion subsuggestion1"></ul>
                          </div>
                          <div><input type="number" class="subitem_quantity1" name="p[1][quantity]" value="0" step="0.000001" min="0"><span class="subitem_limit subitem_limit1" data-limit="0">/ -</span></div>
                          <div><input type="text" class="subitem_unit1" name="p[1][unit]" disabled></div>
                          <div><input type="number" class="subitem_amount1" name="p[1][amount]" value="0" min="0" step="0.01" disabled></div>
                          <div><input type="number" class="subitem_total subitem_total1" name="p[1][total]" value="0" min="0" step="0.01" disabled></div>
                          <div></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button id="add-line-sub"><i class="fa-solid fa-plus"></i> Add Line</button>
                </div>
              </div>
            </div>
          </div>

          <hr class="hr_form">
          <div class="loadings"><i class=""></i></div>
          <input type="hidden" name="add_item" value="Save">
          <input type="submit" class="add" value="Add" id="final_save_item">
        </form>
      </div>

      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {

        $("#final_code").on('keyup', function() {
          var item_number = $(this).val();
          if (item_number == '') {
            $(this).addClass('wrong');
            $("#final_save_item").prop('disabled', true);
          } else {
            $.ajax({
              type: "POST",
              url: "../contacts/json/check_final_item_code.php",
              data: {
                item_number,
              },
              dataType: "json",
              success: function(data2) {
                if (data2 == true) {
                  $("#final_code").addClass('wrong');
                  $("#final_save_item").prop('disabled', true);
                } else {
                  $("#final_code").removeClass('wrong');
                  $("#final_save_item").prop('disabled', false);
                }
              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });
          }
        });

        $("#code").on('keyup', function() {
          var item_number = $(this).val();
          if (item_number == '') {
            $(this).addClass('wrong');
            $("#save_item").prop('disabled', true);
          } else {
            $.ajax({
              type: "POST",
              url: "../contacts/json/check_item_code.php",
              data: {
                item_number,
              },
              dataType: "json",
              success: function(data2) {
                if (data2 == true) {
                  $("#code").addClass('wrong');
                  $("#save_item").prop('disabled', true);
                } else {
                  $("#code").removeClass('wrong');
                  $("#save_item").prop('disabled', false);
                }
              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });
          }
        });



        $("button.close_not_final").click(function() {
          $(".black_screen").fadeOut(200);
          $(".add_new_item").css({
            height: "0px",
            padding: "0px",
            border: "0px solid #cfcfcf",
          });
          // $("#new_item")[0].reset();
          // $("#preview_item_img1").attr("src", "../assets/items/no-photo.png");
        });
        $("button.close_final").click(function() {
          $(".black_screen").fadeOut(200);
          $(".add_new_item_final").css({
            height: "0px",
            padding: "0px",
            border: "0px solid #cfcfcf",
          });
          // $("#new_item_final")[0].reset();
          // $("#preview_item_img").attr("src", "../assets/items/no-photo.png");
        });


        $(".comp-items #add-line-sub").on("click", function() {
          event.preventDefault();

          var randomNumber =
            Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;

          $(".subcomp-list .request-body-list").append(
            '<div class="request-row" id="' +
            randomNumber +
            '"><div><input type="text" class="subitem_name subitem_name' + randomNumber + '" name="p[' + randomNumber + '][name]"><input type="number" class="subitem_id' + randomNumber + ' hidden" name="p[' + randomNumber + '][id]"><ul class="subsuggestion subsuggestion' + randomNumber + '"></ul></div><div><input type="number" class="subitem_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" min="0" step="0.000001"><span class="subitem_limit subitem_limit' + randomNumber + '" data-limit="0">/ -</span></div><div><input type="text" class="subitem_unit' + randomNumber + '" name="p[' + randomNumber + '][unit]" disabled></div><div><input type="number" class="subitem_amount' + randomNumber + '" name="p[' + randomNumber + '][amount]" value="0" min="0" step="0.01" disabled></div><div><input type="number" class="subitem_total subitem_total' + randomNumber + '" name="p[' + randomNumber + '][total]" value="0" min="0" step="0.01" disabled></div><div><button class="delete_row" data-row="' +
            randomNumber +
            '"><i class="fa-solid fa-trash"></i></button></div></div>'
          );

          $(".subitem_quantity" + randomNumber).on("input", function() {
            var new_amount = $(this).val() * $(".subitem_amount" + randomNumber).val();
            $(".subitem_total" + randomNumber)
              .val(new_amount.toFixed(3))
              .trigger("change");
          });
          $(".subitem_amount" + randomNumber).on("input", function() {
            var new_amount = $(this).val() * $(".subitem_quantity" + randomNumber).val();
            $(".subitem_total" + randomNumber)
              .val(new_amount)
              .trigger("change");
          });



          $(".subsuggestion" + randomNumber).on("click", ".sug", function() {
            $.ajax({
              type: "POST",
              url: "functions/core/import_subitem_details.php",
              data: {
                data_id: $(this).attr("data-id"),
              },
              dataType: "json",
              success: function(data) {
                var name = data.name;
                var amount = data.amount.toFixed(3);
                var id = data.id;
                var unit = data.unit;
                var limit = 999999999999999999999;
                $(".subitem_name" + randomNumber).val(name);
                $(".subitem_amount" + randomNumber).val(amount);
                $(".subitem_id" + randomNumber).val(id);
                $(".subitem_unit" + randomNumber).val(unit);
                $(".subitem_quantity" + randomNumber).val(1);
                $(".subitem_limit" + randomNumber).html("/ ∞");
                $(".subitem_limit" + randomNumber).attr("data-limit", limit);
                $(".subitem_total" + randomNumber)
                  .val(amount)
                  .trigger("change");
              },
            });
          });

          $(".subitem_name" + randomNumber).focus(function() {
            if ($("ul.subsuggestion" + randomNumber).css("height") == "0px") {
              $("ul.subsuggestion" + randomNumber).css({
                height: "auto",
                border: "1px solid #cfcfcf",
              });
            } else {
              $("ul.subsuggestion" + randomNumber).css({
                height: "0",
                border: "0px solid #cfcfcf",
              });
            }
          });

          $(".subitem_quantity" + randomNumber).on("change", function() {
            var limit = $(".subitem_limit" + randomNumber).attr("data-limit");
            if ($(".subitem_quantity" + randomNumber).val() > Number(limit)) {
              $(".subitem_quantity" + randomNumber).val(limit).trigger("input");
            }

          });
          $(".subitem_name" + randomNumber).blur(function() {
            if ($(".subitem_id" + randomNumber) !== "") {
              $(this).val("");
              $(".subitem_id" + randomNumber).val("");
              $(".subitem_quantity" + randomNumber).val(0);
              $(".subitem_amount" + randomNumber).val(0);
              $(".subitem_unit" + randomNumber).val("");
              $(".subitem_total" + randomNumber).val(0).trigger("change");
              $(".subitem_limit" + randomNumber).html("/ -");
              $(".subitem_limit" + randomNumber).attr("data-limit", 0);
            }
            $("ul.subsuggestion" + randomNumber).css({
              height: "0",
              border: "0px solid #cfcfcf",
            });
          });

          $(".subitem_name" + randomNumber).on("input", function() {
            $.ajax({
              type: "POST",
              url: "functions/core/subitem-search.php",
              data: {
                item_search: $(this).val(),
              },
              success: function(data) {
                $(".subsuggestion" + randomNumber).html(data);
              },
            });
          });

          $(".delete_row").click(function(event) {
            event.preventDefault();
            var rowNumber = $(this).attr("data-row");
            $(".subitem_total" + rowNumber)
              .val(0)
              .trigger("change");
            var row_id = $(this).attr("data-row");
            var selectedrow = document.getElementById(row_id);
            selectedrow.remove();
          });
        });

        $(".comp_check").change(function() {
          if ($(this).is(":checked")) {

            $(".subitem_name1").prop("required", true);
            $(".subitem_id1").prop("required", true);
            $(".subitem_unit1").prop("required", true);
            $(".subitem_amount1").prop("required", true);
            $(".subitem_total1").prop("required", true);
            $(".subitem_quantity1").prop("required", true);
            $(".comp-items").css({
              "height": "auto",
              "overflow": "visible",
            });

            var total_subs = 0;
            $("#sub-list .subitem_total").each(function() {
              var value = parseFloat($(this).val());
              total_subs += value;
            });
            $("#rate").val(total_subs.toFixed(3));

          } else {
            $(".subitem_name1").prop("required", false);
            $(".subitem_id1").prop("required", false);
            $(".subitem_unit1").prop("required", false);
            $(".subitem_amount1").prop("required", false);
            $(".subitem_total1").prop("required", false);
            $(".subitem_quantity1").prop("required", false);
            $(".comp-items").css({
              "height": "0px",
              "overflow": "hidden",
            });
            $("#rate").val(0);

          }
        });
        $("#rate").on("input", function() {
          if ($(".comp_check").is(":checked")) {
            var total_subs = 0;
            $("#sub-list .subitem_total").each(function() {
              var value = parseFloat($(this).val());
              total_subs += value;
            });
            $("#rate").val(total_subs.toFixed(3));
          }
        });
        $(".subitem_quantity1").on("input", function() {
          var sub_new_amount = $(this).val() * $(".subitem_amount1").val();
          $(".subitem_total1").val(parseFloat(sub_new_amount.toFixed(3))).trigger("change");
        });
        $(".subitem_amount1").on("input", function() {
          var sub_new_amount = $(this).val() * $(".subitem_quantity1").val();
          $(".subitem_total1").val(sub_new_amount).trigger("change");
        });

        $(".subitem_name1").focus(function() {
          if ($("ul.subsuggestion").css("height") == "0px") {
            $("ul.subsuggestion1").css({
              height: "auto",
              border: "1px solid #cfcfcf",
            });
          } else {
            $("ul.subsuggestion1").css({
              height: "0",
              border: "0px solid #cfcfcf",
            });
          }
        });

        $(".subitem_name1").blur(function() {
          if ($(".subitem_id1") !== "") {
            $(this).val("");
            $(".subitem_id1").val("");
            $(".subitem_quantity1").val(0);
            $(".subitem_amount1").val(0);
            $(".subitem_unit1").val("");
            $(".subitem_total1").val(0).trigger("change");
            $(".subitem_limit1").html("/ -");
            $(".subitem_limit1").attr("data-limit", 0);
          }
          $("ul.subsuggestion1").css({
            height: "0",
            border: "0px solid #cfcfcf",
          });
        });

        $(".subitem_name1").on("input", function() {
          $.ajax({
            type: 'POST',
            url: 'functions/core/subitem-search.php',
            data: {
              item_search: $(this).val(),
            },
            success: function(data) {
              $(".subsuggestion1").html(data);
            },
          });

        });


        $(".subsuggestion1").on("click", ".sug", function() {
          $.ajax({
            type: "POST",
            url: "functions/core/import_subitem_details.php",
            data: {
              data_id: $(this).attr("data-id"),
            },
            dataType: "json",
            success: function(data) {
              var name = data.name;
              var amount = parseFloat(data.amount.toFixed(3));
              var id = data.id;
              var limit = 999999999999999999999999;
              var unit = data.unit;
              $(".subitem_name1").val(name);
              $(".subitem_amount1").val(amount);
              $(".subitem_unit1").val(unit);
              $(".subitem_limit1").html("/ ∞");
              $(".subitem_limit1").attr("data-limit", limit);
              $(".subitem_id1").val(id);
              $(".subitem_quantity1").val(1);
              $(".subitem_total1").val(amount).trigger("change");
            },
          });

        });

        $(".suggestion1").on("click", ".sug", function() {
          $.ajax({
            type: "POST",
            url: "functions/core/import_final_item_details.php",
            data: {
              data_id: $(this).attr("data-id"),
            },
            dataType: "json",
            success: function(data) {
              var name = data.name;
              var amount = data.amount;
              var id = data.id;
              var unit = data.unit;
              var limit = data.limit;
              if (limit == 999999999999999) {
                limit_txt = "∞";
              } else {
                limit_txt = limit;
              }
              if (limit == 0) {
                $(".item_quantity1").val(0);
              } else {
                $(".item_quantity1").val(1);
              }
              $(".item_limit1").html("/ " + limit_txt);
              $(".item_limit1").attr("data-limit", limit);
              $(".item_name1").val(name);
              $(".item_amount1").val(amount);
              $(".item_unit1").val(unit);
              $(".item_id1").val(id);

              $(".item_total1").val(amount * $('.item_quantity1').val()).trigger("change");
            },
          });

        });

        $("#sub-list").on("change", ".subitem_total", function() {
          var total_subs = 0;
          $("#sub-list .subitem_total").each(function() {
            var value = parseFloat($(this).val());
            total_subs += value;
          });
          if ($(".comp_check").is(":checked")) {
            $("#rate").val(total_subs.toFixed(3));
          } else {
            $("#rate").val(0);
          }

        });


        $(".subitem_quantity1").on("change", function() {
          var limit = $(".subitem_limit1").attr("data-limit");
          if ($(this).val() > Number(limit)) {
            $(this).val(limit).trigger("input");
          }
        });


        $('#new_item').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $("#new_item input").prop("disabled", false);
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-material.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
              $(".black_screen").fadeOut(200);
              $(".add_new_item").css({
                "height": '0px',
                "padding": "0px",
                "border": "0px solid #cfcfcf"
              });
              $(".mga").html(data);
              setTimeout(function() {
                location.reload();
              }, 1000);
            },
          });
          $(this)[0].reset();
        });

        $('#new_item_final').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $("#new_item_final input").prop("disabled", false);
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-final-item.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
              $(".black_screen").fadeOut(200);
              $(".add_new_item_final").css({
                "height": '0px',
                "padding": "0px",
                "border": "0px solid #cfcfcf"
              });
              $(".mga").html(data);
              setTimeout(function() {
                location.reload();
              }, 1000);
            },
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
          });
          // $(this)[0].reset();
        });

        $("#invoice-btn").click(function() {
          var item_height = $(".add_new_item").prop("scrollHeight") + 70;
          $(".add_new_item").css({
            height: item_height + "px",
            padding: "20px 25px",
            border: "1px solid #cfcfcf",
          });
          $(".black_screen").fadeIn(200);
        });
        $("#payment-btn").click(function() {
          $(".add_new_item_final").css({
            height: "auto",
            padding: "20px 25px",
            border: "1px solid #cfcfcf",
          });
          $(".black_screen").fadeIn(200);
        });

        $("button.export").click(function() {
          if ($("ul.export-options").css("height") == "0px") {
            var exportHeight =
              $("ul.export-options").prop("scrollHeight") + 70;
            $("ul.export-options").css({
              height: exportHeight + "px",
              padding: "20px",
              border: "1px solid #eeee",
              "border-bottom": "2px solid var(--main-color)",
            });
          } else {
            $("ul.export-options").css({
              height: "0",
              padding: "0px",
              border: "0px solid rgba(238, 238, 238, 0.933)",
            });
          }
        });
        $("button.filter").on("click", function() {
          var filterHeight = $(".filter-section").prop(
            "scrollHeight"
          );
          if ($(".filter-section").css("height") == "0px") {

            $(".filter-section").css({
              border: "0px solid #cfcfcf"
            });

            $(".filter-section").css({
              height: filterHeight + "px",
              padding: "5px 25px",
              border: "1px solid #cfcfcf",
            });
          } else {
            $(".filter-section").css({
              height: "0",
              padding: "0px",
              border: "0px solid #cfcfcf",
            });
            $("input.delete-btn").css({
              top: "-45px"
            });
          }
        });

        var table = $('#supplierslist').DataTable({
          ajax: {
            url: 'json/items.php',
            type: 'GET',
            dataSrc: '',
            data: {},

            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
          },
          buttons: [{
            extend: 'csv',
            charset: 'UTF-8',
            bom: true,
            exportOptions: {
              encoding: 'UTF-8',
              columns: ':not(:last-child)' // Exclude last column and column index 3
            },
          }],
          pageLength: -1,
          "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
          ],
          language: {
            paginate: {
              previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
              next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
            }
          },
          columnDefs: [{
              targets: -1,
              className: 'dt-body-right',
              orderable: false
            },
            {
              targets: 2,
              visible: false
            }
          ],
          order: [
            [0, 'desc']
          ],
          columns: [{
              data: 'no',
              width: "40px"
            },
            {
              data: 'name',
            },
            {
              data: 'type',
            },
            {
              data: 'quantity',
              width: "120px"
            },
            {
              data: 'unit',
              width: "120px"
            },
            {
              data: 'amount',
              width: "120px"
            },
            {
              data: 'action',
              width: "90px"
            },
          ],
          autoWidth: true,
          responsive: true,
        });
        $("#ExportReporttoExcel3").on("click", function() {
          table.button('.buttons-csv').trigger();
        });
        $('.dataTables_filter').remove();



        function getCurrentTime() {
          var currentDate = new Date();
          var year = currentDate.getFullYear();
          var month = padZero(currentDate.getMonth() + 1);
          var day = padZero(currentDate.getDate());
          var hour = padZero(currentDate.getHours() % 12 || 12);
          var minute = padZero(currentDate.getMinutes());
          var period = currentDate.getHours() >= 12 ? "PM" : "AM";

          var formattedTime = year + "-" + month + "-" + day + " " + hour + ":" + minute + " " + period;

          return formattedTime;
        }

        // Function to pad zeros for single digits
        function padZero(number) {
          return (number < 10 ? "0" : "") + number;
        }

        // Usage

        $("#ExportReporttoPdf3").on("click", function() {
          var currentTime = getCurrentTime();
          event.preventDefault();
          var barcodeDiv = document.getElementById("supplierslist");
          var printWindow = window.open('', '');

          printWindow.document.write('<html><head><title>Products Registeration</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
          printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Products Registeration</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });




        $('select#avail_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(2).search('').draw();
          } else {
            table.column(2).search(type).draw();
          }
        });



        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
        });


        $('#new_supplier').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $("#new_supplier input").prop("disabled", false);
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-warehouse.php',
            data: $(this).serialize(),
            success: function(data) {
              $(".black_screen").fadeOut(200);
              $(".add_new").css({
                "height": '0px',
                "padding": "0px",
                "border": "0px solid #cfcfcf"
              });
              $(".mga").html(data);
              setTimeout(function() {
                location.reload();
              }, 1000);
            },
          });
          $(this)[0].reset();
        });
        // $(document).on({
        //   ajaxStart: function() {
        //     $(".loadings i").addClass("fa-solid");
        //     $(".loadings i").addClass("fa-spinner");
        //     $(".loadings i").addClass("fa-spin-pulse");
        //   },
        //   ajaxStop: function() {
        //     $(".loadings i").removeClass("fa-spin-pulse");
        //     $(".loadings i").removeClass("fa-spinner");
        //     $(".loadings i").removeClass("fa-solid");
        //   }
        // });


      });
    </script>

<?php
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/../login.php");
    exit();
  }
} else {
  $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
  header("location:" . $path . "/../login.php");
  exit();
}
include "includes/footer.inc";
?>