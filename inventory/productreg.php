<?php
$pg_name = "Wonder - Product Registeration";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_item_id()) {
    if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(608) == 1) {
      $info = item_id_info();
      if (isset($_GET['del'])) {
        $del = '1';
      } else {
        $del = '';
      }
?>

      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Edit <?php if ($_GET['type'] == 'f') {
                        echo 'Final Product';
                      } else {
                        echo 'Material';
                      } ?> </h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "productsreg.php" ?>">Product Registration</a> / Edit <?php if ($_GET['type'] == 'f') {
                                                                                                                                                      echo 'Final Product';
                                                                                                                                                    } else {
                                                                                                                                                      echo 'Material';
                                                                                                                                                    } ?></p>
          </div>
          <div class="btns">
            <?php
            $id = $info['code'];
            $stmt15 = $con->prepare("SELECT * FROM `av_items` WHERE `item_id` = '$id'");
            $stmt15->execute();
            $count15 = $stmt15->rowCount();
            if ($count15 > 0) {
              $row15 = $stmt15->fetchAll(PDO::FETCH_ASSOC);
              $code = $row15[0]['sku'];
              $del_btn = '';
              $view_btn = '<button class="rev-btn"><a href="itemdetails.php?uid=' . $code . '">View Inventory <i class="fa-solid fa-eye"></i></a></button>';
            } else {
              $view_btn = '';
              $del_btn = '<button class="delete_btn"><a class="delete_order" href="productreg.php?uid=' . $id . '&type=' . $_GET['type'] . '&del=1"><i class="fa-solid fa-trash"></i></a></button>';
              delete_item($_GET['type'], $_GET['uid'], $del);
            }
            ?>

            <?= $view_btn . $del_btn ?>
          </div>
        </div>
        <div class="item-body">
          <div class="lt-body pd-form" style="width:100%;">
            <form class="" id="new_item_final" action="" method="POST" enctype="multipart/form-data">
              <div class="custom-form custom-item-form">
                <input type="hidden" name="type" value="<?= $_GET['type'] ?>">
                <input type="hidden" name="id" value="<?= $info['id'] ?>">
                <input type="hidden" name="old_id" value="<?= $info['code'] ?>">
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
                      <img src="../assets/items/<?= $info['img'] ?>" class="item-img" id="preview_item_img" alt="item_image">
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
                      <input type="text" class="" name="name" id="name" value="<?= ucfirst($info['name']) ?>" required>
                    </div>
                    <div class="inputs gd2">
                      <label for="code">Unique Product Code<span>*</span></label>
                      <input type="number" class="" name="code" id="code" value="<?= ucfirst($info['code']) ?>" <?= $count15 > 0 ? 'disabled' : '' ?> required>
                      <input type="hidden" class="" name="curr_id" id="curr_id" value="<?= ucfirst($info['code']) ?>" required>
                    </div>
                    <div class="inputs gd4">
                      <label for="unit">Unit <span>*</span></label>
                      <select name="unit" id="unit">
                        <optgroup label="">
                          <option value="Piece" <?php if ($info['unit'] == 'Piece') {
                                                  echo 'selected';
                                                } ?>>Pieces</option>
                        </optgroup>
                        <optgroup label="Area Units">
                          <option value="mm" <?php if ($info['unit'] == 'mm') {
                                                echo 'selected';
                                              } ?>>mm</option>
                          <option value="mm2" <?php if ($info['unit'] == 'mm2') {
                                                echo 'selected';
                                              } ?>>mm2</option>
                          <option value="cm" <?php if ($info['unit'] == 'cm') {
                                                echo 'selected';
                                              } ?>>cm</option>
                          <option value="cm2" <?php if ($info['unit'] == 'cm2') {
                                                echo 'selected';
                                              } ?>>cm2</option>
                          <option value="m" <?php if ($info['unit'] == 'm') {
                                              echo 'selected';
                                            } ?>>m</option>
                          <option value="m2" <?php if ($info['unit'] == 'm2') {
                                                echo 'selected';
                                              } ?>>m2</option>
                        </optgroup>
                        <optgroup label="Volume Units">
                          <option value="mm3" <?php if ($info['unit'] == 'mm3') {
                                                echo 'selected';
                                              } ?>>mm3</option>
                          <option value="cm3" <?php if ($info['unit'] == 'cm3') {
                                                echo 'selected';
                                              } ?>>cm3</option>
                          <option value="m3" <?php if ($info['unit'] == 'm3') {
                                                echo 'selected';
                                              } ?>>m3</option>
                          <option value="mL" <?php if ($info['unit'] == 'mL') {
                                                echo 'selected';
                                              } ?>>mL</option>
                          <option value="L" <?php if ($info['unit'] == 'L') {
                                              echo 'selected';
                                            } ?>>L</option>
                        </optgroup>
                        <optgroup label="Weight Units">
                          <option value="mg" <?php if ($info['unit'] == 'mg') {
                                                echo 'selected';
                                              } ?>>mg</option>
                          <option value="g" <?php if ($info['unit'] == 'g') {
                                              echo 'selected';
                                            } ?>>g</option>
                          <option value="kg" <?php if ($info['unit'] == 'kg') {
                                                echo 'selected';
                                              } ?>>kg</option>
                          <option value="ton" <?php if ($info['unit'] == 'ton') {
                                                echo 'selected';
                                              } ?>>ton</option>
                        </optgroup>
                      </select>
                    </div>
                    <div class="inputs gd2">
                      <label for="rate">Main Rate (E£)</label>
                      <input type="number" value="<?php if ($_GET['type'] == 'f' && $info['is_composite'] == '1') {
                                                    echo round(get_total_amount($info['sub_items'], $info['sub_quantity']), 3);
                                                  } else {
                                                    echo $info['amount'];
                                                  }
                                                  ?>" class="" min="0" name="rate" id="rate" step="0.000001" required>
                    </div>
                    <div class="inputs gd6">
                      <label for="description">Description</label>
                      <textarea name="description" id="description" cols="30" rows="10"><?= $info['description'] ?></textarea>
                    </div>

                    <?php if ($_GET['type'] == 'f') { ?>
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
                            </div>
                          </div>
                        </div>
                        <button id="add-line-sub"><i class="fa-solid fa-plus"></i> Add Line</button>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <hr class="hr_form">
              <div class="loadings"><i class=""></i></div>
              <input type="hidden" name="add_item" value="Save">
              <input type="submit" class="add" value="Save Changes" id="save_item">
            </form>
          </div>
        </div>
        <div class="mga"></div>
      </div>
      <script>
        $(document).ready(function() {

          $("#code").on('keyup', function() {
            var item_number = $(this).val();
            var exist_number = $("#curr_id").val();
            if (item_number == '') {
              $(this).addClass('wrong');
              $("#save_item").prop('disabled', true);
            } else {
              $.ajax({
                type: "POST",
                url: "../contacts/json/check_exist_code.php",
                data: {
                  item_number,
                  exist_number,
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
                  console.log(data2);
                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }
              });
            }
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
          $("#rate").on("input", function() {
            if ($('.subitem_total').val()) {
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
            $("#rate").val(total_subs.toFixed(3));
          });


          $(".subitem_quantity1").on("change", function() {
            var limit = $(".subitem_limit1").attr("data-limit");
            if ($(this).val() > Number(limit)) {
              $(this).val(limit).trigger("input");
            }
          });


















          $.ajax({
            url: 'json/get_components.php',
            type: 'POST',
            dataType: 'json',
            data: {
              item_id: "<?= $info['code'] ?>",
            },
            success: function(data2) {
              // $("#sub-list .request-row").remove();
              $.each(data2, function(index, value) {
                var objectString = '';

                $.each(value, function(key, val) {
                  objectString += key + ': ' + val + ', ';
                });
                // console.log(value);
                $('#sub-list').append('<div class="request-row" id="row' + value.id + '"><div><input type="text" class="item_name subitem_name' + value.id + '" value="' + value.item_name + '" name="p[' + value.id + '][name]" ><input type="text" class="subitem_id' + value.id + ' hidden" name="p[' + value.id + '][id]" value="' + value.id + '"><ul class="subsuggestion subsuggestion' + value.id + '"></ul></div><div><input type="number" class="subitem_quantity' + value.id + '" name="p[' + value.id + '][quantity]" value="' + value.item_curr_quantity + '" step="0.000000001" min="0" ><span class="subitem_limit subitem_limit' + value.id + '" data-limit="99999999999999999999">/ ∞</span></div><div><input type="text" class="subitem_unit' + value.id + '" name="p[' + value.id + '][unit]" value="' + value.item_unit + '" ></div><div><input type="number" class="subitem_amount' + value.id + '" name="p[' + value.id + '][amount]" value="' + value.rate.toFixed(3) + '" min="0" step="0.000001" disabled></div><div><input type="number" class="subitem_total subitem_total' + value.id + '" name="p[' + value.id + '][total]" value="' + value.item_total.toFixed(3) + '" min="0" step="0.0000001" disabled></div><div><button class="delete_row" data-row="' + value.id + '"><i class="fa-solid fa-trash"></i></button></div></div>');


                $(".subitem_quantity" + value.id).on("input", function() {
                  var new_amount = $(this).val() * $(".subitem_amount" + value.id).val();
                  $(".subitem_total" + value.id)
                    .val(new_amount.toFixed(3))
                    .trigger("change");
                });

                $(".subitem_amount" + value.id).on("input", function() {
                  var new_amount = $(this).val() * $(".subitem_quantity" + value.id).val();
                  $(".subitem_total" + value.id)
                    .val(new_amount)
                    .trigger("change");
                });



                $(".subsuggestion" + value.id).on("click", ".sug", function() {
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
                      $(".subitem_name" + value.id).val(name);
                      $(".subitem_amount" + value.id).val(amount);
                      $(".subitem_id" + value.id).val(id);
                      $(".subitem_unit" + value.id).val(unit);
                      $(".subitem_quantity" + value.id).val(1);
                      $(".subitem_limit" + value.id).html("/ ∞");
                      $(".subitem_limit" + value.id).attr("data-limit", limit);
                      $(".subitem_total" + value.id)
                        .val(amount)
                        .trigger("change");
                    },
                  });
                });

                $(".subitem_name" + value.id).focus(function() {
                  if ($("ul.subsuggestion" + value.id).css("height") == "0px") {
                    $("ul.subsuggestion" + value.id).css({
                      height: "auto",
                      border: "1px solid #cfcfcf",
                    });
                  } else {
                    $("ul.subsuggestion" + value.id).css({
                      height: "0",
                      border: "0px solid #cfcfcf",
                    });
                  }
                });

                $(".subitem_quantity" + value.id).on("change", function() {
                  var limit = $(".subitem_limit" + value.id).attr("data-limit");
                  if ($(".subitem_quantity" + value.id).val() > Number(limit)) {
                    $(".subitem_quantity" + value.id).val(limit).trigger("input");
                  }

                });
                $(".subitem_name" + value.id).blur(function() {
                  if ($(".subitem_id" + value.id) !== "") {
                    $(this).val("");
                    $(".subitem_id" + value.id).val("");
                    $(".subitem_quantity" + value.id).val(0);
                    $(".subitem_amount" + value.id).val(0);
                    $(".subitem_unit" + value.id).val("");
                    $(".subitem_total" + value.id).val(0).trigger("change");
                    $(".subitem_limit" + value.id).html("/ -");
                    $(".subitem_limit" + value.id).attr("data-limit", 0);
                  }
                  $("ul.subsuggestion" + value.id).css({
                    height: "0",
                    border: "0px solid #cfcfcf",
                  });
                });

                $(".subitem_name" + value.id).on("input", function() {
                  $.ajax({
                    type: "POST",
                    url: "functions/core/subitem-search.php",
                    data: {
                      item_search: $(this).val(),
                    },
                    success: function(data) {
                      $(".subsuggestion" + value.id).html(data);
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
                  var selectedrow = document.getElementById("row" + row_id);
                  selectedrow.remove();
                });
              });
            },
            error: function(xhr, status, error) {
              // Handle any errors that occur during the AJAX request
              console.log(xhr.responseText);
            }
          });
          $('#new_item_final').submit(function(event) {
            event.preventDefault(); // prevent default form submission
            $("#new_item_final input").prop("disabled", false);
            var formData = new FormData(this);
            $.ajax({
              type: 'POST',
              url: 'functions/core/edit_item.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function(data) {
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

        });
      </script>
<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/productsreg.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/productsreg.php");
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