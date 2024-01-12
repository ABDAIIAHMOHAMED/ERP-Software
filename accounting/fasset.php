<?php
$pg_name = "Wonder - Fixed Assets";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_id('assets_category')) {
    if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(901) == 1) {
      $info = info('assets_category');
      import_asset($info['id']);
      import_sell_asset();
      if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(903) == 1) {
        if (!check_asset_category($info['id'])) {
          delete_category();
        }
      }
      if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(907) == 1) {
        delete_asset();
      }
      function getLastDayOfMonth($month, $year)
      {
        $lastDay = date('t', strtotime("$year-$month-01"));
        return $lastDay;
      }
      if (isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['t']) && !empty($_GET['t'])) {
        $start_date = "0001-01-01";
        // $start_date = date("Y") . "-01-01";
        $end_date = $_GET['t'];
      } else {
        $start_date = "0001-01-01";
        $end_date = date("Y-m-d", strtotime(date("Y-m-d") . " +1 day"));
      }
      check_dep();
?>

      <div class="att-part vat-part">
        <input type="hidden" id="name_balance" value="<?= $info['name'] ?>">
        <div class="title-head">
          <div class="headso">
            <h3>Fixed Assets: <?= $info['name'] ?>
              <form action="" method="GET" class="filter_date_range">
                <div class="inputs">
                  <label for="create-date-filter"></label>
                  <input type="date" name="f" id="create-date-filter" value="<?= $start_date ?>" style="display:none;">
                </div>
                <div class="inputs">
                  <label for="end-date-filter">On</label>
                  <input type="date" name="t" id="end-date-filter" value="<?= $end_date ?>">
                </div>
                <input type="hidden" name="uid" value="<?= $info['id'] ?>">
                <input type="submit" value="Filter">
              </form>
            </h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "fassets.php" ?>">Fixed Assets</a>
              / Fixed Assets: <?= $info['name'] ?></p>
          </div>

          <div class="btns">

            <button class="export"><i class="fa-solid fa-download"></i>
              <ul class="export-options">
                <li class="option" id="ExportReporttoPdf">
                  <div><i class=" fa-solid fa-print"></i> Print List</div>
                </li>
                <li class="option btn-print" id="ExportReporttoExcel">
                  <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                </li>
              </ul>
            </button>
            <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(908) == 1) {
            ?>
              <button class="rev-btn"><a href="fassets_sell.php">Revenues <i class="fa-solid fa-eye"></i></a></button>
            <?php } ?>
            <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(904) == 1) {
            ?>
              <button class="new-btn" id="payment-btn">New Asset</button>
            <?php } ?>
            <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(903) == 1) {
            ?>
              <?php if (!check_asset_category($info['id'])) { ?>
                <button class="delete_btn" id="delete-btn"><i class="fa-solid fa-trash"></i></button>
              <?php } ?>
            <?php
            }
            ?>
          </div>

        </div>



        <div class="employee-section request-section trial_list">
          <div class="main-table-style">
            <div class="serch">
              <input type="text" id="name-search" value="" placeholder="Search...">
            </div>
            <table id="suppliertrans" style="width:100% !important;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item</th>
                  <th>Purchase Date</th>
                  <th>Qty.</th>
                  <th>Price/Unit (E£)</th>
                  <th>Gross Cost (E£)</th>
                  <th>Depre. Rate</th>
                  <th>Total Depre. (E£)</th>
                  <th>Exclusion Depre. (E£)</th>
                  <th>Gross Depre. (E£)</th>
                  <th>Carrying Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>




        <script>
          $(function() {
            $.fn.dataTable.Api.register('sum()', function() {
              return this.flatten().reduce(function(a, b) {
                if (typeof a === 'string') {
                  a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if (typeof b === 'string') {
                  b = b.replace(/[^\d.-]/g, '') * 1;
                }
                return a + b;
              }, 0);
            });
            $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
              var ukDate = date.split('/');
              return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
            };

            var table2 = $('#suppliertrans').DataTable({
              ajax: {
                url: 'json/fasset.php',
                type: 'GET',
                dataSrc: '',
                data: {
                  uid: $('#profile_id').val(),
                  start_date: $("#create-date-filter").val(),
                  end_date: $("#end-date-filter").val(),
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
                  columns: ':not(:last-child)' // Exclude last column and column index 3
                },
              }],
              "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
              ],
              pageLength: -1, // Set default selection to "All"
              language: {
                paginate: {
                  previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                  next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                }
              },
              "footerCallback": function(row, data, start, end, display) {
                var api = this.api();

                var colIndex2 = 5; // Set the index of the first column to calculate the sum for

                var colIndex4 = 9; // Set the index of the first column to calculate the sum for
                var colIndex5 = 10; // Set the index of the first column to calculate the sum for


                var colData2 = api.column(colIndex2, {
                  page: 'current'
                }).data();
                var total2 = 0;

                var colData4 = api.column(colIndex4, {
                  page: 'current'
                }).data();
                var total4 = 0;
                var colData5 = api.column(colIndex5, {
                  page: 'current'
                }).data();
                var total5 = 0;




                var total2 = api.column(colIndex2, {
                  page: 'current'
                }).data().sum();

                var total4 = api.column(colIndex4, {
                  page: 'current'
                }).data().sum();
                var total5 = api.column(colIndex5, {
                  page: 'current'
                }).data().sum();



                var footer2 = api.column(colIndex2).footer();

                var footer4 = api.column(colIndex4).footer();
                var footer5 = api.column(colIndex5).footer();

                $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));

                $(footer4).html('E£ (' + total4.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }) + ')');
                $(footer5).html('E£ ' + total5.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
              },
              order: [
                [0, 'asc']
              ],
              columnDefs: [{
                  targets: 1,
                  orderable: false
                },
                {
                  targets: 0,
                  orderable: false
                },

                {
                  targets: 2,
                  orderable: false
                }, {
                  targets: 3,
                  type: 'date',
                  orderable: false
                },
                {
                  targets: 4,
                  orderable: false
                },
                {
                  targets: 5,
                  orderable: false
                },
                {
                  targets: 6,
                  orderable: false
                },
                {
                  targets: 7,
                  orderable: false
                },
                {
                  targets: 8,
                  orderable: false
                },
                {
                  targets: 9,
                  orderable: false
                },
              ],
              columns: [{
                  data: 'number',
                  width: "40px"
                },
                {
                  data: 'name',
                },

                {
                  data: 'created_time',
                  width: "120px"
                },
                {
                  data: 'quantity',
                  width: "40px",
                },
                {
                  data: 'cost',
                  width: "120px",
                },
                {
                  data: 'total',
                  width: "120px",
                },
                {
                  data: 'dep_perc',
                  width: "60px",
                },
                {
                  data: 'total_dep',
                  width: "120px",
                },
                {
                  data: 'total_ex',
                  width: "120px",
                },
                {
                  data: 'total_total_dep',
                  width: "120px",
                },
                {
                  data: 'total_carry',
                  width: "120px",
                },
                {
                  data: 'Action',
                  width: "150px",
                },
              ],
              autoWidth: false,
              responsive: true,
            });
            $("#ExportReporttoExcel").on("click", function() {
              table2.button('.buttons-csv').trigger();
            });

            $('#name-search').on('keyup', function() {
              var searchValue = $(this).val();
              table2.search(searchValue).draw();
            });

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
              var userDate = $(".profile-info h5").html();
              var title = $("#name_balance").val();
              var barcodeDiv = document.getElementById("suppliertrans");
              var printWindow = window.open('', '');

              printWindow.document.write('<html><head><title>Fixed Assets: ' + title + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
              printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
              printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Fixed Assets: ' + title + '</h3><span class="dt-range">From <span class="bold">' + $("#start-date-filter-trans").val() + '</span>  To <span class="bold">' + $("#end-date-filter-trans").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
              printWindow.document.write(barcodeDiv.innerHTML);
              printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
            });
            // $("#suppliertrans_length").remove();
            // $("#suppliertrans_paginate").remove();
            // $("#suppliertrans_info").remove();
            $("#suppliertrans_filter").remove();




            function startupBalance() {
              var create_date = $('input#start-date-filter-trans').val();
              var end_date = $('input#end-date-filter-trans').val();
              create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
              end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
              if ($('input#start-date-filter-trans').val() === '') {
                filtered = '';
              } else {
                var filtered = table2.column(2).data().filter(function(value, index) {
                  return value >= create_date && value <= end_date; // Filter the data based on the entered date
                }).join("|");
                var valuesToDraw = filtered.split("|");
                var regex = valuesToDraw.map(function(value) {
                  return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                }).join('|');
                table2.column(2).search(regex, true, false).draw();



                var open_balance_index = Array.from(table2.column(2).data()).filter(function(value) {
                  return value <= create_date; // Filter the data based on the entered date
                });
                var lastItemIndex = -1;
                var cellValue = 0;
                open_balance_index.forEach(function(value, index) {
                  if (value <= create_date) {
                    lastItemIndex = index;
                  }
                });
                var cellValue = table2.cell(lastItemIndex, 6).data();
                if (!cellValue) {
                  cellValue = 0;
                }
                $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
              }

            };
            setTimeout(startupBalance, 500);

            $('input#start-date-filter-trans').on('change', function() {
              var create_date = $(this).val();
              var end_date = $('input#end-date-filter-trans').val();
              create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
              end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
              if ($(this).val() === '') {
                filtered = '';
              } else {
                var filtered = table2.column(2).data().filter(function(value, index) {
                  return value >= create_date && value <= end_date; // Filter the data based on the entered date
                }).join("|");
                var valuesToDraw = filtered.split("|");
                var regex = valuesToDraw.map(function(value) {
                  return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                }).join('|');
                table2.column(2).search(regex, true, false).draw();



                var open_balance_index = Array.from(table2.column(2).data()).filter(function(value) {
                  return value <= create_date; // Filter the data based on the entered date
                });
                var lastItemIndex = -1;
                var cellValue = 0;
                open_balance_index.forEach(function(value, index) {
                  if (value <= create_date) {
                    lastItemIndex = index;
                  }
                });
                var cellValue = table2.cell(lastItemIndex, 6).data();
                if (!cellValue) {
                  cellValue = 0;
                }
                $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
              }

            });
            $('input#start-date-filter-trans').on('blur', function() {
              if ($(this).val() === '') {
                table2.column(2).search('').draw();
              }
            });
            $('input#end-date-filter-trans').on('change', function() {
              var end_date = $(this).val();
              var create_date = $('input#start-date-filter-trans').val();
              create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
              end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
              if ($(this).val() === '') {
                filtered = '';
              } else {
                var filtered = table2.column(2).data().filter(function(value, index) {
                  return value >= create_date && value <= end_date; // Filter the data based on the entered date
                }).join("|");
                var valuesToDraw = filtered.split("|");
                var regex = valuesToDraw.map(function(value) {
                  return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                }).join('|');
                table2.column(2).search(regex, true, false).draw();



                var open_balance_index = Array.from(table2.column(2).data()).filter(function(value) {
                  return value <= create_date; // Filter the data based on the entered date
                });
                var lastItemIndex = -1;
                var lastItemValue = 0;
                open_balance_index.forEach(function(value, index) {
                  if (value <= create_date) {
                    lastItemIndex = index;
                  }
                });
                var cellValue = table2.cell(lastItemIndex, 6).data();
                $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
              }

            });
            $('input#end-date-filter-trans').on('blur', function() {
              if ($(this).val() === '') {
                table2.column(2).search('').draw();
              }
            });

            $("#suppliertrans").on("click", ".view_purchase", function() {
              $(".black_screen").fadeIn(200);
              $.ajax({
                url: 'json/get_asset_page.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  item_id: $(this).attr("btn-data"),
                  carry: $(this).attr("btn-carry"),
                },
                success: function(data) {
                  $(".table_1 table tbody tr").remove();
                  $(".asset_value_name").html(data.name);
                  $(".asset_value_date").html(data.date);
                  $(".asset_value_qty").html(data.quantity);
                  $(".asset_value_init_qty").html(data.init_quantity);
                  $(".asset_value_price").html(data.amount);
                  $(".asset_value_cost").html(data.init_price);
                  $(".asset_value_vat").html(data.vat);
                  $(".asset_value_with").html(data.with);
                  $(".asset_value_rate").html(data.dep_perc + "%");
                  $(".asset_value_dep_num").html(data.dep_numbers);
                  $(".asset_value_freq").html(data.dep_freq);
                  $(".asset_value_method").html(data.payment_method);
                  $(".asset_value_carry").html(data.carry);
                  for (let i = 0; i < data.dep_transactions.length; i++) {
                    const amount = data.dep_transactions[i].amount;
                    const date = data.dep_transactions[i].date;
                    $(".table_1:first-child table tbody").append("<tr><td>" + (i + 1) + "</td><td>" + amount + "</td><td>" + date + "</td></tr>");
                  }
                  for (let i = 0; i < data.dep_ex_transactions.length; i++) {
                    const amount = data.dep_ex_transactions[i].amount;
                    const date = data.dep_ex_transactions[i].date;
                    $(".table_1:last-child table tbody").append("<tr><td>" + (i + 1) + "</td><td>" + amount + "</td><td>" + date + "</td></tr>");
                  }
                  var confirmHeight = $(".asset_details_page").prop("scrollHeight") + 50;
                  $(".asset_details_page").css({
                    height: confirmHeight + "px",
                    padding: "20px 25px",
                    border: "1px solid #cfcfcf",
                  });
                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }

              });

            });
            $("#suppliertrans").on("click", ".sell_asset", function() {
              $(".black_screen").fadeIn(200);

              $.ajax({
                url: 'json/get_asset_detail.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  item_id: $(this).attr("btn-data"),
                  carry: $(this).attr("btn-carry"),
                },
                success: function(data) {
                  if (data.quantity == '0') {
                    $("#carr_amount").val(0);
                  } else {
                    $("#carr_amount").val(data.carry / data.quantity);
                  }
                  $(".item_id2").val(data.id);
                  $(".item_name2").val(data.name);
                  $(".item_limit2").html("/ " + data.quantity);
                  $(".item_limit2").attr("data-limit", data.quantity);
                  console.log(data.id);
                  var sell_height = $(".sell_form").prop("scrollHeight") + 50;
                  $(".sell_form").css({
                    height: sell_height + "px",
                    padding: "20px 25px",
                    border: "1px solid #cfcfcf",
                  });
                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }

              });


            });

          });
        </script>
      </div>


      <div class="black_screen"></div>
      <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(904) == 1) {
      ?>
        <div class="pay_payment_section share_payment expense_form">
          <div class="custome-head">
            <h3>New Asset</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="profile_id" name="supplier_id" value="<?= $info['id'] ?>">
            <div class="custom-form custom-item-form payment_form">
              <div class="inputs w50">
                <label for="amount_pdate">Purchase Date</label>
                <input type="date" name="amount_pdate" id="amount_pdate" value="<?= date("Y-m-d") ?>" required>
              </div>
              <div class="inputs w50">
                <label for="amount_cdate">Start Dep. Date</label>
                <input type="date" name="amount_cdate" id="amount_cdate" value="<?php if (date('d') < '15') {
                                                                                  echo date("Y-m") . "-01";
                                                                                } else {
                                                                                  echo date("Y-m", strtotime(date("Y-m") . " +1 month")) . "-01";
                                                                                }
                                                                                ?>" required>
              </div>
              <div class="inputs w50">
                <label for="vat_amount">Vat Amount (E£)</label>
                <input type="number" name="vat_amount" id="vat_amount" step="0.01" min="0" value="0" required>
              </div>
              <!-- <div class="inputs w50">
                <label for="withholding">Withholding Tax (E£)</label>
                <input type="number" name="withholding" id="withholding" step="0.01" min="0" value="0" required>
              </div> -->
              <div class="inputs w50">
                <label for="dep_rate">Depreciation Rate (%)</label>
                <input type="number" name="dep_rate" id="dep_rate" step="0.01" min="0" value="0" required>
              </div>
              <div class="inputs w100">
                <label for="amount_payment_method">Payment Mehtod</label>
                <select name="amount_payment_method" id="amount_payment_method" required>
                  <option value="cash">Cash</option>
                  <option value="bank">Bank Account</option>
                </select>
              </div>
              <div class="inputs amount_bank_choose w50">
                <label for="amount_bank_name">Bank Name</label>
                <select name="bank_name" id="amount_bank_name">
                  <?= get_banks() ?>
                </select>
              </div>
              <div class="inputs amount_bank_num_choose w50">
                <label for="amount_bank_number">Bank Account</label>
                <select name="bank_number" id="amount_bank_number">
                </select>
              </div>
              <div class="employee-section request-section invoice-list subcomp-list w100">
                <div class="request-list">
                  <div class="request-row request-head-list">
                    <div>Asset Name</div>
                    <div>Qty</div>
                    <div>Amount (E£)</div>
                    <div>Total Amount (Tax Exclu.) (E£)</div>
                  </div>
                  <div class="request-body-list" id="sub-list">
                    <div class='request-row'>
                      <div><input type="text" class="item_name" name="name" required></div>
                      <div><input type="number" class="item_quantity" name="quantity" value="0" step="0.01" min="0" required></div>
                      <div><input type="number" class="item_amount" name="amount" value="0" min="0" step="0.01" required></div>
                      <div><input type="number" class="item_total" name="total" value="0" min="0" step="0.01" required></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <input type="submit" name="pay" value="Add">
          </form>
        </div>
      <?php } ?>
      <div class="confirm_delete_page">
        <div class="custome-head">
          <h3>Are you sure to delete ( <?= $info['name'] ?> ) Category</h3>
          <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST">
          <input type="hidden" class="supplier_id" value="<?= $info['id'] ?>" name="confirm_id">
          <button class="confirm_delete_btn" data-btn="">Confirm</button>
        </form>
      </div>
      <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(907) == 1) {
      ?>
        <div class="confirm_delete_page_trans">
          <div class="custome-head">
            <h3>Are you sure to delete an Asset</h3>
            <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form method="POST">
            <input type="hidden" class="trans_id" name="trans_id">
            <button class="confirm_delete_btn_trans" name="confirm_trans">Confirm</button>
          </form>
        </div>
      <?php } ?>
      <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(905) == 1) {
      ?>
        <div class="asset_details_page">
          <div class="custome-head">
            <h3>Asset Profile</h3>
            <button class="close_asset"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <div class="asset_contain">
            <div class="up-contain">
              <div class="lt-contain">
                <div class="asset_img">
                  <img src="../assets/items/no-photo.png" alt="">
                </div>
              </div>
              <div class="rt-contain">
                <div class="asset_detail">
                  <div class="asset_title_name">Name</div>
                  <div class="asset_value_name">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_date">Purchase Date</div>
                  <div class="asset_value_date">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_qty">Available Quantity</div>
                  <div class="asset_value_qty">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_qty">Initial Quantity</div>
                  <div class="asset_value_init_qty">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_price">Price/Unit (E£)</div>
                  <div class="asset_value_price">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_vat">VAT Amount (E£)</div>
                  <div class="asset_value_vat">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_with">Withholding Tax (E£)</div>
                  <div class="asset_value_with">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_cost">Purchase Cost (E£)</div>
                  <div class="asset_value_cost">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_rate">Depreciation Rate</div>
                  <div class="asset_value_rate">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_method">Payment Method</div>
                  <div class="asset_value_method">...</div>
                </div>
                <div class="asset_detail">
                  <div class="asset_title_carry">Carrying Amount (E£)</div>
                  <div class="asset_value_carry">...</div>
                </div>
              </div>
            </div>
            <div class="down-contain">
              <div class="table_1">
                <h3>Depreciation History</h3>
                <table>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Depreciation</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>..</td>
                      <td>...</td>
                      <td>...</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table_1">
                <h3>Exclusions Depreciation</h3>
                <table>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Depreciation</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>..</td>
                      <td>...</td>
                      <td>...</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(906) == 1) {
      ?>
        <div class="sell_form">
          <div class="custome-head">
            <h3>Sell Asset</h3>
            <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="sell_asset_form" action="" method="POST" enctype="multipart/form-data">
            <div class="custom-form custom-item-form payment_form">
              <div class="inputs w50">
                <label for="carr_amount">Carrying Amount/Unit (E£)</label>
                <input type="number" name="carr_amount" id="carr_amount" min="0" value="0" required disabled>
              </div>
              <div class="inputs w50">
                <label for="issue_date">Issue Date</label>
                <input type="datetime-local" name="cdate" id="issue_date" value="<?= date("Y-m-d\TH:i") ?>" required>
              </div>
              <div class="inputs w50">
                <label for="vat_amount">VAT Amount (E£)</label>
                <input type="number" name="vat_amount" id="vat_amount" min="0" value="0">
              </div>
              <div class="inputs w50">
                <label for="withholding">Withholding Tax (E£)</label>
                <input type="number" name="withholding" id="withholding" min="0" value="0">
              </div>
              <div class="employee-section request-section invoice-list subcomp-list w100">
                <div class="request-list">
                  <div class="request-row request-head-list">
                    <div>Asset Name</div>
                    <div>Qty</div>
                    <div>Amount (E£)</div>
                    <div>Total Amount (Tax Exclu.) (E£)</div>
                  </div>
                  <input type="hidden" class="item_id2" name="id" required>
                  <div class="request-body-list" id="sub-list">
                    <div class='request-row'>
                      <div><input type="text" class="item_name2" name="name" required disabled></div>
                      <div><input type="number" class="item_quantity2" name="quantity" value="0" step="0.01" min="0" required><span class="item_limit2" data-limit="0">/ -</span></div>
                      <div><input type="number" class="item_amount2" name="amount" value="0" min="0" step="0.01" required></div>
                      <div><input type="number" class="item_total2" name="total" value="0" min="0" step="0.01" required></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <input type="submit" name="sell" value="Sell Now">
          </form>
        </div>
      <?php } ?>
      <div class="mga"></div>
      </div>

      <script>
        $(document).ready(function() {
          let valueDisplays = document.querySelectorAll(".w-value");
          let totalDuration = 2000; // Total duration for all elements
          let duration = Math.floor(totalDuration / valueDisplays.length); // Duration for each element
          let startTimestamp = null;

          function formatNumber(number) {
            return number.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
          }

          function step(timestamp) {
            if (!startTimestamp) startTimestamp = timestamp;
            let progress = timestamp - startTimestamp;

            valueDisplays.forEach((valueDisplay) => {
              let startValue = 0;
              let endValue = parseFloat(valueDisplay.getAttribute("data-value"));
              let currentValue = Math.floor((progress / duration) * (endValue + 1)); // Calculate the current value based on the progress and duration

              if (currentValue > endValue) {
                currentValue = endValue;
              }

              valueDisplay.textContent = formatNumber(currentValue);
            });

            if (progress < totalDuration) {
              window.requestAnimationFrame(step);
            }
          }

          window.requestAnimationFrame(step);
          $(".item_quantity").on("input", function() {
            var new_amount = $(this).val() * $(".item_amount").val();
            $(".item_total")
              .val(new_amount)
              .trigger("change");
          });
          $(".sell_asset_form").on("submit", function() {
            $(".sell_asset_form input").prop("disabled", false);
          });
          $(".item_quantity2").on("input", function() {
            var new_amount = $(this).val() * $(".item_amount2").val();
            $(".item_total2")
              .val(new_amount)
              .trigger("change");
          });
          $(".item_quantity2").on("change", function() {
            var limit = $(".item_limit2").attr("data-limit");
            if ($(this).val() > Number(limit)) {
              $(this).val(limit).trigger("input");
            }
          });
          $(".item_amount").on("input", function() {
            var new_amount = $(this).val() * $(".item_quantity").val();
            $(".item_total")
              .val(new_amount)
              .trigger("change");
          });
          $(".item_amount2").on("input", function() {
            var new_amount = $(this).val() * $(".item_quantity2").val();
            $(".item_total2")
              .val(new_amount)
              .trigger("change");
          });
          $("#delete-btn").click(function() {
            var confirmHeight = $(".confirm_delete_page").prop("scrollHeight") + 50;
            $(".confirm_delete_page").css({
              height: confirmHeight + "px",
              padding: "20px 25px",
              border: "1px solid #cfcfcf",
            });
            var orderId = $(this).attr("btn-data");
            $(".confirm_id").val(orderId);
            $("span.order_id_confirm").html(orderId);
            $(".black_screen").fadeIn(200);
          });

          $(".confirm_delete_page .close_confirm").click(function() {

            $(".confirm_delete_page").css({
              height: "0px",
              padding: "0",
              "border": "0px solid #cfcfcf",
            });
            $(".black_screen").fadeOut(200);
          });
          $(".sell_form .close_confirm").click(function() {

            $(".sell_form").css({
              height: "0px",
              padding: "0",
              "border": "0px solid #cfcfcf",
            });
            $(".black_screen").fadeOut(200);
          });


          $(".confirm_delete_page_trans .close_confirm").click(function() {

            $(".confirm_delete_page_trans").css({
              height: "0px",
              padding: "0",
              "border": "0px solid #cfcfcf",
            });
            $(".black_screen").fadeOut(200);
          });

          $(".asset_details_page .close_asset").click(function() {

            $(".asset_details_page").css({
              height: "0px",
              padding: "0",
              "border": "0px solid #cfcfcf",
            });
            $(".black_screen").fadeOut(200);
          });


          $("#suppliertrans").on("click", "button.delete_order", function(e) {
            var confirmHeight = $(".confirm_delete_page_trans").prop("scrollHeight") + 50;
            $(".confirm_delete_page_trans").css({
              height: confirmHeight + "px",
              padding: "20px 25px",
              border: "1px solid #cfcfcf",
            });
            var orderId = $(this).attr("btn-data");
            var orderAmount = $(this).attr("btn-balance");
            var orderDate = $(this).attr("btn-date");
            $(".trans_id").val(orderId);
            $(".trans_amount").val(orderAmount);
            $(".trans_date").val(orderDate);
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
          $("#amount_payment_method").on("change", function() {
            if ($(this).val() == "cash") {
              $(".amount_bank_choose").css({
                "visibility": "hidden"
              });
              $(".amount_bank_num_choose").css({
                "display": "none"
              });
            } else {
              $(".amount_bank_choose").css({
                "visibility": "visible"
              });
              $(".amount_bank_num_choose").css({
                "display": "flex"
              });

              $.ajax({
                type: "POST",
                url: "json/get_bank_number.php",
                data: {
                  bank_name: $("#amount_bank_name").val(),
                },
                dataType: "json",
                success: function(data2) {
                  $("#amount_bank_number option").remove();
                  $.each(data2, function(index, value) {
                    var objectString = '';
                    $.each(value, function(key, val) {
                      objectString += key + ': ' + val + ', ';
                    });

                    $("#amount_bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                  });

                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }

              });

            }
          });


          $("#amount_bank_name").on("change", function() {
            $.ajax({
              type: "POST",
              url: "json/get_bank_number.php",
              data: {
                bank_name: $("#amount_bank_name").val(),
              },
              dataType: "json",
              success: function(data2) {
                $("#amount_bank_number option").remove();
                $.each(data2, function(index, value) {
                  var objectString = '';
                  $.each(value, function(key, val) {
                    objectString += key + ': ' + val + ', ';
                  });

                  $("#amount_bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                });

              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }

            });
          });

        });
      </script>

<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/fassets.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/fassets.php");
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