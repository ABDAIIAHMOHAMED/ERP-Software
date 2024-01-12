<?php
$pg_name = "Wonder - Inventory";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_sku()) {
    if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(606) == 1) {
      $info = sku_info();
      $supp_info = get_supplierinfo_by_id($info['supplier_id']);
      $ware = get_warehouseinfo_by_id($info['warehouse_id']);
      if (substr($info['supplier_id'], 0, 1) == "M") {
        $type = 'f';
      } else {
        $type = 'm';
      }
      change_rate();
?>
      <input type="hidden" id="item_type" value="<?= $type ?>">
      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Product View</h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "inventory.php" ?>">Inventory</a> / Product View</p>
          </div>
          <div class="btns">
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(608) == 1) { ?>
              <button class="edit-mode"><a href="productreg.php?uid=<?= $info['item_id'] ?>&type=<?= $type ?>" style="color:var(--main-color);padding:15px"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</a></button>
            <?php } ?>
            <div class="buttons">
              <button class="transactions">Action <i class="fa-solid fa-caret-down"></i></button>
              <ul class="transactions-list">
                <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(608) == 1) { ?>
                  <li class="trans-option" id="payment-btn">Change Sell Rate</li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="item-body">
          <div class="lt-body">
            <form class="" id="new_item" action="" method="POST" enctype="multipart/form-data">
              <div class="custom-form custom-item-form">
                <div class="spectra">
                  <label for="item_img_input">
                    <div class="item_image">
                      <span class="edit-icon hide">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 492.493 492" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                          <g>
                            <path d="M304.14 82.473 33.165 353.469a10.799 10.799 0 0 0-2.816 4.949L.313 478.973a10.716 10.716 0 0 0 2.816 10.136 10.675 10.675 0 0 0 7.527 3.114 10.6 10.6 0 0 0 2.582-.32l120.555-30.04a10.655 10.655 0 0 0 4.95-2.812l271-270.977zM476.875 45.523 446.711 15.36c-20.16-20.16-55.297-20.14-75.434 0l-36.949 36.95 105.598 105.597 36.949-36.949c10.07-10.066 15.617-23.465 15.617-37.715s-5.547-27.648-15.617-37.719zm0 0" fill="#ad6420" data-original="#000000" class=""></path>
                          </g>
                        </svg>
                      </span>
                      <img src="../assets/items/<?= $info['img'] ?>" class="item-img" alt="item_image">
                    </div>
                  </label>
                </div>
                <div class="sectra item_sectra">
                  <div class="form-section">
                    <div class="inputs gd3">
                      <label for="name">Name</label>
                      <input type="text" class="" name="name" id="name" value="<?= $info['name'] ?>" required disabled>
                    </div>
                    <div class="inputs gd3">
                      <label for="code">Unique Product Code</label>
                      <input type="number" class="" name="code" id="code_input" value="<?= $info['item_id'] ?>" required disabled>
                    </div>
                    <div class="inputs gd3">
                      <label for="unit">Unit</label>
                      <select name="unit" id="unit" disabled>
                        <optgroup label="">
                          <option value="Piece" <?php if ($info['unit'] == "piece") {
                                                  echo "selected";
                                                } ?>>Pieces</option>
                        </optgroup>
                        <optgroup label="Area Units">
                          <option value="mm" <?php if ($info['unit'] == "mm") {
                                                echo "selected";
                                              } ?>>mm</option>
                          <option value="mm2" <?php if ($info['unit'] == "mm2") {
                                                echo "selected";
                                              } ?>>mm2</option>
                          <option value="cm" <?php if ($info['unit'] == "cm") {
                                                echo "selected";
                                              } ?>>cm</option>
                          <option value="cm2" <?php if ($info['unit'] == "cm2") {
                                                echo "selected";
                                              } ?>>cm2</option>
                          <option value="m" <?php if ($info['unit'] == "m") {
                                              echo "selected";
                                            } ?>>m</option>
                          <option value="m2" <?php if ($info['unit'] == "m2") {
                                                echo "selected";
                                              } ?>>m2</option>
                        </optgroup>
                        <optgroup label="Volume Units">
                          <option value="mm3" <?php if ($info['unit'] == "mm3") {
                                                echo "selected";
                                              } ?>>mm3</option>
                          <option value="cm3" <?php if ($info['unit'] == "cm3") {
                                                echo "selected";
                                              } ?>>cm3</option>
                          <option value="m3" <?php if ($info['unit'] == "m3") {
                                                echo "selected";
                                              } ?>>m3</option>
                          <option value="mL" <?php if ($info['unit'] == "mL") {
                                                echo "selected";
                                              } ?>>mL</option>
                          <option value="L" <?php if ($info['unit'] == "L") {
                                              echo "selected";
                                            } ?>>L</option>
                        </optgroup>
                        <optgroup label="Weight Units">
                          <option value="mg" <?php if ($info['unit'] == "mg") {
                                                echo "selected";
                                              } ?>>mg</option>
                          <option value="g" <?php if ($info['unit'] == "g") {
                                              echo "selected";
                                            } ?>>g</option>
                          <option value="kg" <?php if ($info['unit'] == "kg") {
                                                echo "selected";
                                              } ?>>kg</option>
                          <option value="ton" <?php if ($info['unit'] == "ton") {
                                                echo "selected";
                                              } ?>>ton</option>
                        </optgroup>
                      </select>
                    </div>
                    <div class="inputs gd3">
                      <?php if (strpos($info['supplier_id'], "ORD-") !== 0) { ?>
                        <label for="supplier_list"> <?php if (substr($info['supplier_id'], 0, 1) == "M") {
                                                      echo "Manufacturer";
                                                    } else {
                                                      echo "Supplier";
                                                    } ?></label>
                        <input type="text" value="<?php
                                                  if ($supp_info['is_company'] == "1") {
                                                    $name = $supp_info['company_name'];
                                                    echo $name;
                                                  } else {
                                                    $name = $supp_info['first_name'] . " " . $supp_info['middle_name'] . " " . $supp_info['last_name'];
                                                    echo $name;
                                                  }  ?>" disabled>
                      <?php } ?>
                    </div>
                    <div class="inputs gd2">
                      <label for="rate">Cost Rate (E£)</label>
                      <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(612) == 1) { ?>
                        <input type="number" value="<?= number_format($info['rate'], 2, '.', '') ?>" class="" min="0" name="rate" id="rate" step="0.01" required disabled>
                      <?php } ?>
                    </div>

                    <div class="inputs gd2">
                      <label for="rate">Margin (%)</label>
                      <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(612) == 1) { ?>
                        <input type="number" value="<?= number_format($info['margin'], 2, '.', '') ?>" class="" min="0" name="margin" id="margin" step="0.01" disabled>
                      <?php } ?>
                    </div>
                    <div class="inputs gd2">
                      <label for="rate">Sell Rate (E£)</label>
                      <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(612) == 1) { ?>
                        <input type="number" value="<?= number_format($info['sell_rate'], 2, '.', '') ?>" class="" min="0" name="sell_rate" id="sell_rate" step="0.01" disabled>
                      <?php } ?>
                    </div>

                    <div class="inputs gd4">
                      <label for="description">Description</label>
                      <textarea name="description" id="description" cols="30" rows="10" disabled><?= $info['description'] ?></textarea>
                    </div>
                    <div class="inputs gd2">
                      <?php if (strpos($info['supplier_id'], "ORD-") !== 0) { ?>
                        <label for="type">Product Type</label>
                        <div class="type_product"><?php if (substr($info['supplier_id'], 0, 1) == "M") {
                                                    echo 'Manufactured Product <i class="fa-solid fa-circle-info"></i>
                                                  <div class="i-box">Manufactured Product means that this product can be sold and was manufactured by <a href="../contacts/manufacturerdetails.php?uid=' . $info["supplier_id"] . '" target="_blank">' . $name . ' <i class="fa-solid fa-arrow-up-right-from-square"></i></a> </div>';
                                                  } else {
                                                    echo 'Supplied Product <i class="fa-solid fa-circle-info"></i>
                                                <div class="i-box">Supplied Product means that this product was supplied by <a href="../contacts/supplierdetails.php?uid=' . $info["supplier_id"] . '" target="_blank">' . $name . ' <i class="fa-solid fa-arrow-up-right-from-square"></i></a> </div>';
                                                  } ?>

                        </div>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <?php if (substr($info['supplier_id'], 0, 1) == "M") {
                ?>
                  <div class="comp-items gd6">
                    <hr class="hr_form">
                    <h4 class="heads">Components/Unit</h4>
                    <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(612) == 1) { ?>
                      <div class="employee-section request-section invoice-list subcomp-list">
                        <div class="request-list">
                          <div class="request-row request-head-list">
                            <div>Item</div>
                            <div>Qty</div>
                            <div>Unit</div>
                            <div>Rate (E£)</div>
                            <div>Total (E£)</div>
                            <div></div>
                          </div>
                          <div class="request-body-list" id="sub-list">
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <button id="add-line-sub" class="hide"><i class="fa-solid fa-plus"></i> Add Line</button>
                  </div>

                <?php
                }
                ?>
              </div>
            </form>
            <ul class="profile-lnks">
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(610) == 1) { ?>
                <li class="operations-lnk"><button id="operations-lnk">Operations History</button></li>
              <?php } ?>
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(609) == 1) { ?>
                <li class="transfer-lnk"><button id="transfer-lnk">Transfers</button></li>
              <?php } ?>
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(611) == 1) { ?>
                <li class="sales-perf-lnk"><button id="sales-perf-lnk">Sales Performance</button></li>
              <?php } ?>
            </ul>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(610) == 1) { ?>
              <div class="operations-list listo">
                <h4 class="submarin">Operations</h4>
                <div class="btns">
                  <button class="export export-operations"><i class="fa-solid fa-download"></i>
                    <ul class="export-options operations-options">
                      <li class="option" id="ExportReporttoPdf">
                        <div><i class="fa-solid fa-print"></i> Print List</div>
                      </li>
                      <li class="option" id="ExportReporttoExcel">
                        <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                      </li>
                    </ul>
                  </button>
                </div>
                <div class="resp-table">
                  <div class="serch">
                    <input type="text" id="search-filter-trans" value="" placeholder="Search...">
                  </div>
                  <table id="supplieroper" style="width:100% !important;">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Invoice #</th>
                        <th>Supplier/Manufacturer</th>
                        <th>Created Date</th>
                        <th>Quantity</th>
                        <th>Cost (E£)</th>
                        <th>Total (E£)</th>
                      </tr>
                    </thead>

                  </table>
                </div>
              </div>
            <?php } ?>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(609) == 1) { ?>
              <div class="transfer-list listo">
                <h4 class="submarin">Transfers</h4>
                <div class="btns">
                  <button class="export export-transfers"><i class="fa-solid fa-download"></i>
                    <ul class="export-options transfers-options">
                      <li class="option" id="ExportReporttoPdf2">
                        <div><i class="fa-solid fa-print"></i> Print List</div>
                      </li>
                      <li class="option" id="ExportReporttoExcel2">
                        <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                      </li>
                    </ul>
                  </button>
                </div>
                <div class="resp-table">
                  <div class="serch">
                    <input type="text" id="search-filter-trans2" value="" placeholder="Search...">
                  </div>
                  <table id="suppliertransfer" style="width:100% !important;">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Transfer #</th>
                        <th>Created Date</th>
                        <th>Quantity</th>
                        <th>From</th>
                        <th>To</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            <?php } ?>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(611) == 1) { ?>
              <div class="sales-perf-list listo">
                <h4 class="submarin">Sales Performance</h4>
                <div class="btns">
                  <button class="export export-sale"><i class="fa-solid fa-download"></i>
                    <ul class="export-options sale-options">
                      <li class="option" id="ExportReporttoPdf3">
                        <div><i class="fa-solid fa-print"></i> Print List</div>
                      </li>
                      <li class="option" id="ExportReporttoExcel3">
                        <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                      </li>
                    </ul>
                  </button>
                </div>
                <div class="resp-table">
                  <div class="serch">
                    <input type="text" id="search-filter-trans3" value="" placeholder="Search...">
                  </div>
                  <table id="suppliersell" style="width:100% !important;">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Created Date</th>
                        <th>Quantity</th>
                        <th>Amount (E£)</th>
                        <th>Total Amount (E£)</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="rt-body">
            <div class="main-inv-box inv-box">
              <div class="info-w50">
                <h4>Warehouse</h4>
                <?php
                if ($info['storable'] == "1") {
                ?>
                  <p><a href="warehousedetails.php?uid=<?= $info['warehouse_id'] ?>" id="curr_warehouse" target="_blank"><?= $ware['name'] ?> <i class="fa-solid fa-arrow-up-right-from-square"></i></a> </p>
                <?php

                } else {
                  echo "<p>Not Stored</p>";
                }
                ?>
              </div>
              <div class="info-w50 align-rt">
                <h4>Available Quantity</h4>
                <p><span class="value"><?= $info['quantity'] ?></span></p>
              </div>
              <div class="info-w100">
                <h4>Barcode</h4>
                <div id="barcodediv">
                  <img id="barcode_view" alt="">
                </div>
                <button id="prnt_barcode"><i class="fa-solid fa-print"></i> Print</button>
              </div>
            </div>
            <hr class="hr_form">

            <div class="inv-listing">

            </div>
            <hr class="hr_form" style="margin-bottom:20px">
            <!-- <a href="#" class="dwn-btn" target="_blank">Download Sales Performance Report <i class="fa-solid fa-download"></i></a> -->
          </div>
        </div>
        <div class="pay_payment_section share_payment">
          <div class="custome-head">
            <h3>Change Sale Rate</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" action="" method="POST" enctype="multipart/form-data">
            <div class="custom-form custom-item-form payment_form" style="flex-direction:column;">
              <input type="hidden" name="id" id="item_id" value="<?= $info['item_id'] ?>">
              <input type="hidden" name="code" value="<?= $info['sku'] ?>">
              <div class="inputs w100">
                <label for="change_type">Change by</label>
                <select name="type" id="change_type" required>
                  <option value="margin">Margin (%)</option>
                  <option value="rate">Sale Rate (E£)</option>
                </select>
              </div>
              <div class="inputs w100">
                <label for="margin_amount">Profit Margin (%)</label>
                <input type="number" name="margin" id="margin_amount" min="0" max="99" value="<?= $info['margin'] ?>">
                <input type="hidden" name="margin_hidden" id="margin_hidden" value="<?= $info['margin'] ?>">
              </div>
              <div class="inputs w100">
                <label for="rate_amount">Sale Rate (E£)</label>
                <input type="number" name="rate" id="rate_amount" value="<?= $info['sell_rate'] ?>" disabled>
                <input type="hidden" name="rate_hidden" id="rate_amount_hidden" value="<?= $info['sell_rate'] ?>">
              </div>
            </div>
            <input type="submit" name="change_rate" value="Change">
          </form>
        </div>
        <div class="black_screen"></div>
        <div class="mga"></div>
      </div>
      <script>
        $(document).ready(function() {

          var table3 = $('#suppliersell').DataTable({
            ajax: {
              url: 'json/get_item_sell.php',
              type: 'GET',
              dataSrc: '',
              data: {
                type: $("#item_type").val(),
                item_id: $("#item_id").val(),
              },
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
              },
              filename: $("#name").val() + '\'s Sales', // Set the desired filename
            }],
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
            columnDefs: [

              {
                targets: 5,
                orderable: false
              },
            ],
            order: [
              [1, 'desc']
            ],
            columns: [{
                data: 'no',
                width: "40px"
              },
              {
                data: 'invoice',
                width: "150px",
              },
              {
                data: 'supplier',
                width: "200px"
              },
              {
                data: 'created_time',
                width: "150px",
              },
              {
                data: 'quantity',
                width: "100px",
              },
              {
                data: 'cost',
                width: "100px",
              },
              {
                data: 'total',
                width: "100px"
              },
            ],
            autoWidth: true,
            responsive: true,
          });
          $('.dataTables_filter').remove();




          $("#ExportReporttoExcel3").on("click", function() {
            table3.button('.buttons-csv').trigger();
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
            var barcodeDiv = document.getElementById("suppliersell");
            var printWindow = window.open('', '');

            printWindow.document.write('<html><head><title>Sales for ' + $("#name").val() + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
            printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
            printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Sales for ' + $("#name").val() + '</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
            printWindow.document.write(barcodeDiv.innerHTML);
            printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
          });


          $('#search-filter-trans3').on('keyup', function() {
            var searchValue = $(this).val();
            table3.search(searchValue).draw();
          });







          var table2 = $('#suppliertransfer').DataTable({
            ajax: {
              url: 'json/get_item_transfer.php',
              type: 'GET',
              dataSrc: '',
              data: {
                type: $("#item_type").val(),
                item_id: $("#item_id").val(),
              },
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
              },
              filename: $("#name").val() + '\'s Transfers', // Set the desired filename
            }],
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
            columnDefs: [

              {
                targets: 5,
                orderable: false
              },
            ],
            order: [
              [1, 'desc']
            ],
            columns: [{
                data: 'no',
                width: "40px"
              },
              {
                data: 'invoice',
                width: "150px",
              },
              {
                data: 'created_time',
                width: "200px"
              },
              {
                data: 'quantity',
                width: "100px",
              },
              {
                data: 'from',
                width: "150px",
              },
              {
                data: 'to',
                width: "100px",
              }
            ],
            autoWidth: true,
            responsive: true,
          });
          $('.dataTables_filter').remove();




          $("#ExportReporttoExcel2").on("click", function() {
            table2.button('.buttons-csv').trigger();
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

          $("#ExportReporttoPdf2").on("click", function() {
            var currentTime = getCurrentTime();
            event.preventDefault();
            var barcodeDiv = document.getElementById("suppliertransfer");
            var printWindow = window.open('', '');

            printWindow.document.write('<html><head><title>Transfers for ' + $("#name").val() + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
            printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
            printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Transfers for ' + $("#name").val() + '</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
            printWindow.document.write(barcodeDiv.innerHTML);
            printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
          });


          $('#search-filter-trans2').on('keyup', function() {
            var searchValue = $(this).val();
            table2.search(searchValue).draw();
          });















          var table = $('#supplieroper').DataTable({
            ajax: {
              url: 'json/get_item_operation.php',
              type: 'GET',
              dataSrc: '',
              data: {
                type: $("#item_type").val(),
                item_id: $("#item_id").val(),
              },
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
              },
              filename: $("#name").val() + '\'s Operations', // Set the desired filename
            }],
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
            columnDefs: [

              {
                targets: 5,
                orderable: false
              },
              {
                targets: 6,
                orderable: false
              },
            ],
            order: [
              [1, 'desc']
            ],
            columns: [{
                data: 'no',
                width: "40px"
              },
              {
                data: 'invoice',
                width: "150px",
              },
              {
                data: 'supplier',
                width: "200px"
              },
              {
                data: 'created_time',
                width: "150px",
              },
              {
                data: 'quantity',
                width: "100px",
              },
              {
                data: 'cost',
                width: "100px",
              },
              {
                data: 'total',
                width: "100px"
              },
            ],
            autoWidth: true,
            responsive: true,
          });
          $('.dataTables_filter').remove();




          $("#ExportReporttoExcel").on("click", function() {
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

          $("#ExportReporttoPdf").on("click", function() {
            var currentTime = getCurrentTime();
            event.preventDefault();
            var barcodeDiv = document.getElementById("supplieroper");
            var printWindow = window.open('', '');

            printWindow.document.write('<html><head><title>Operations for ' + $("#name").val() + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
            printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
            printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Operations for ' + $("#name").val() + '</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
            printWindow.document.write(barcodeDiv.innerHTML);
            printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
          });


          $('#search-filter-trans').on('keyup', function() {
            var searchValue = $(this).val();
            table.search(searchValue).draw();
          });



          $("button.export-operations").click(function() {
            if ($("ul.operations-options").css("height") == "0px") {
              var exportHeight =
                $("ul.operations-options").prop("scrollHeight") + 70;
              $("ul.operations-options").css({
                height: exportHeight + "px",
                padding: "20px",
                border: "1px solid #eeee",
                "border-bottom": "2px solid var(--main-color)",
              });
            } else {
              $("ul.operations-options").css({
                height: "0",
                padding: "0px",
                border: "0px solid rgba(238, 238, 238, 0.933)",
              });
            }
          });


          $("button.export-transfers").click(function() {
            if ($("ul.transfers-options").css("height") == "0px") {
              var exportHeight =
                $("ul.transfers-options").prop("scrollHeight") + 70;
              $("ul.transfers-options").css({
                height: exportHeight + "px",
                padding: "20px",
                border: "1px solid #eeee",
                "border-bottom": "2px solid var(--main-color)",
              });
            } else {
              $("ul.transfers-options").css({
                height: "0",
                padding: "0px",
                border: "0px solid rgba(238, 238, 238, 0.933)",
              });
            }
          });


          $("button.export-sale").click(function() {
            if ($("ul.sale-options").css("height") == "0px") {
              var exportHeight =
                $("ul.sale-options").prop("scrollHeight") + 70;
              $("ul.sale-options").css({
                height: exportHeight + "px",
                padding: "20px",
                border: "1px solid #eeee",
                "border-bottom": "2px solid var(--main-color)",
              });
            } else {
              $("ul.sale-options").css({
                height: "0",
                padding: "0px",
                border: "0px solid rgba(238, 238, 238, 0.933)",
              });
            }
          });
















          var barcodeValue = <?= $info['item_id'] ?>;

          <?php if (!empty($info['item_id']) && strlen($info['item_id']) == 12) { ?>
            JsBarcode("#barcode_view", barcodeValue, {
              format: "EAN13",
              displayValue: true,
              width: 2.8,
              height: 85
            });
          <?php }
          ?>
          $("#margin_amount").on("keyup", function() {
            var margin = $(this).val();
            var rate = $("#rate").val();
            if (margin >= 100) {
              margin = 99.99;
              $(this).val(margin).trigger("change");
            }
            var new_rate = rate / (1 - (margin / 100));
            var new_rate_format = Number(new_rate.toFixed(2));
            $("#rate_amount").val(new_rate_format);
            $("#rate_amount_hidden").val(new_rate_format);
            $("#margin_hidden").val(margin);
          });
          $("#rate_amount").on("keyup", function() {
            var sell_rate = $(this).val();
            var rate = $("#rate").val();

            var new_margin = (1 - (rate / sell_rate)) * 100;
            var new_margin_format = Number(new_margin.toFixed(2));
            $("#margin_amount").val(new_margin_format);
            $("#margin_hidden").val(new_margin_format);
            $("#rate_amount_hidden").val(sell_rate);
          });
          $("#change_type").on("change", function() {
            var type = $(this).val();
            if (type == 'margin') {
              $("#margin_amount").removeAttr("disabled");
              $("#rate_amount").prop("disabled", true);
              console.log(type);
            } else if (type == 'rate') {
              $("#margin_amount").prop("disabled", true);
              $("#rate_amount").removeAttr("disabled");
              console.log(type);
            }
          });
          $.ajax({
            url: 'json/get_components.php',
            type: 'POST',
            dataType: 'json',
            data: {
              item_id: "<?= $info['item_id'] ?>",
            },
            success: function(data2) {
              // $("#sub-list .request-row").remove();
              $.each(data2, function(index, value) {
                var objectString = '';
                $.each(value, function(key, val) {
                  objectString += key + ': ' + val + ', ';
                });
                console.log(value);
                $('#sub-list').append('<div class="request-row" id="row' + value.id + '"><div><input type="text" class="item_name subitem_name' + value.id + '" value="' + value.item_name + '" name="p[' + value.id + '][name]" disabled><input type="text" class="subitem_id' + value.id + ' hidden" name="p[' + value.id + '][id]" disabled><ul class="subsuggestion subsuggestion' + value.id + '"></ul></div><div><input type="number" class="subitem_quantity' + value.id + '" name="p[' + value.id + '][quantity]" value="' + value.item_curr_quantity + '" step="0.01" min="0" disabled><span class="subitem_limit subitem_limit' + value.id + '" data-limit="' + value.item_quantity + '">/ ' + value.item_quantity + '</span></div><div><input type="text" class="subitem_unit' + value.id + '" name="p[' + value.id + '][unit]" value="' + value.item_unit + '" disabled></div><div><input type="number" class="subitem_amount' + value.id + '" name="p[' + value.id + '][amount]" value="' + value.rate.toFixed(3) + '" min="0" step="0.01" disabled></div><div><input type="number" class="subitem_total subitem_total' + value.id + '" name="p[' + value.id + '][total]" value="' + value.item_total.toFixed(3) + '" min="0" step="0.01" disabled></div><div></div></div>');
              });

            },
            error: function(xhr, status, error) {
              // Handle any errors that occur during the AJAX request
              console.log(xhr.responseText);
            }
          });


          $.ajax({
            url: 'json/get_warehouses_except.php',
            type: 'POST',
            dataType: 'json',
            data: {
              item_id: "<?= $info['item_id'] ?>",
              sku: "<?= $info['sku'] ?>",
            },
            success: function(data2) {
              // $("#sub-list .request-row").remove();
              $.each(data2, function(index, value) {
                var objectString = '';
                $.each(value, function(key, val) {
                  objectString += key + ': ' + val + ', ';
                });
                if (value.id === "314") {
                  $('.inv-listing').append('<div class="inv-box"><div class="info-w50"><h4>Warehouse</h4><p><a href="warehousedetails.php?uid=' + value.id + '" id="curr_warehouse" target="_blank">' + value.name + ' <i class="fa-solid fa-arrow-up-right-from-square"></i></a> </p></div><div class="info-w50 align-rt"><h4>Available Quantity</h4><p><span class="value">' + value.quantity + '</span></p></div><div class="info-w100 btns"><button class="view_btn"><a href="itemdetails.php?uid=' + value.sku + '" target="_blank">View <i class="fa-solid fa-eye"></i></a></button></div></div>');
                } else {
                  $('.inv-listing').append('<div class="inv-box"><div class="info-w50"><h4>Warehouse</h4><p><a href="warehousedetails.php?uid=' + value.id + '" id="curr_warehouse" target="_blank">' + value.name + ' <i class="fa-solid fa-arrow-up-right-from-square"></i></a> </p></div><div class="info-w50 align-rt"><h4>Available Quantity</h4><p><span class="value">' + value.quantity + '</span></p></div><div class="info-w100 btns"><button class="view_btn"><a href="itemdetails.php?uid=' + value.sku + '" target="_blank">View <i class="fa-solid fa-eye"></i></a></button></div></div>');
                }
              });
              if (data2.length === 0) {

                $('.inv-listing').append('<span class="no-ware">No other item with the same code</span>');
              }
            },
            error: function(xhr, status, error) {
              // Handle any errors that occur during the AJAX request
              console.log(xhr.responseText);
            }
          });

          $("#prnt_barcode").on("click", function() {
            event.preventDefault();
            var barcodeDiv = document.getElementById("barcodediv");
            var printWindow = window.open('', '');
            printWindow.document.write('<html><head><title>Barcode</title>');
            printWindow.document.write('<style> @page { size: 41.9mm 19.5mm landscape;margin: -5mm; } img#barcode_view { width: 100%;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(barcodeDiv.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print({});
            printWindow.close();
          });


          $("li.transfer-lnk button#transfer-lnk").click(function() {
            $("li.operations-lnk").removeClass("active");
            $("li.transfer-lnk").addClass("active");
            $("li.sales-perf-lnk").removeClass("active");
            $(".transfer-list").show();
            $(".operations-list").hide();
            $(".sales-perf-list").hide();
            window.localStorage["product-menu"] = "transfer";
          });
          $("li.sales-perf-lnk button#sales-perf-lnk").click(function() {
            $("li.operations-lnk").removeClass("active");
            $("li.transfer-lnk").removeClass("active");
            $("li.sales-perf-lnk").addClass("active");
            $(".transfer-list").hide();
            $(".operations-list").hide();
            $(".sales-perf-list").show();
            window.localStorage["product-menu"] = "sales-perf";
          });
          $("li.operations-lnk button#operations-lnk").click(function() {
            $("li.operations-lnk").addClass("active");
            $("li.transfer-lnk").removeClass("active");
            $("li.sales-perf-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".operations-list").show();
            $(".sales-perf-list").hide();
            window.localStorage["product-menu"] = "operations";
          });

          if (window.localStorage["product-menu"] == "transfers") {
            $("li.operations-lnk").removeClass("active");
            $("li.transfer-lnk").addClass("active");
            $("li.sales-perf-lnk").removeClass("active");
            $(".transfer-list").show();
            $(".operations-list").hide();
            $(".sales-perf-list").hide();
          } else if (window.localStorage["product-menu"] == "sales-perf") {
            $("li.operations-lnk").removeClass("active");
            $("li.transfer-lnk").removeClass("active");
            $("li.sales-perf-lnk").addClass("active");
            $(".transfer-list").hide();
            $(".operations-list").hide();
            $(".sales-perf-list").show();
          } else {
            $("li.operations-lnk").addClass("active");
            $("li.transfer-lnk").removeClass("active");
            $("li.sales-perf-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".operations-list").show();
            $(".sales-perf-list").hide();
          }
        });
      </script>
<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/inventory.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/inventory.php");
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