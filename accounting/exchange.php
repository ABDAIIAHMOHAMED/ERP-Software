<?php
$pg_name = "Wonder - Exchange Difference";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(5000) == 1 || check_user_role(5001) == 1) {
    import_exchange();
?>

    <div class="att-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Exchange Difference
            <div class="inputs">
              <label for="start-date-filter-trans">From Date </label>
              <input type="date" name="date" id="start-date-filter-trans" value="<?= date("Y-m") . "-01" ?>">
            </div>
            <div class="inputs">
              <label for="end-date-filter-trans">To </label>
              <input type="date" name="date" id="end-date-filter-trans" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>">
            </div>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Exchange Difference</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(5000) == 1 || check_user_role(5002) == 1) {
          ?>
            <button class="new-btn" id="payment-btn">New Exchange Difference</button>
          <?php
          }
          ?>
        </div>

      </div>



      <div class="employee-section request-section trial_list">
        <div class="main-table-style">
          <table id="suppliertrans" style="width:100% !important;">
            <thead>
              <tr>
                <th>#</th>
                <th>Statement</th>
                <th>To Account</th>
                <th>Created Date</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>Open Balance</th>
                <th id="open_balance_trans">E£ 0.00</th>
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
              url: 'json/exchange.php',
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
              }
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
              var colIndex = 4; // Set the index of the first column to calculate the sum for
              var colIndex2 = 5; // Set the index of the first column to calculate the sum for
              var colIndex3 = 6; // Set the index of the first column to calculate the sum for

              var colData = api.column(colIndex, {
                page: 'current'
              }).data();
              var total = 0;
              var colData2 = api.column(colIndex2, {
                page: 'current'
              }).data();
              var total2 = 0;


              // Get the data of the desired column (column index: 3)

              var lastValue = 0;

              // Get the visible rows and iterate through them
              api.rows({
                filter: 'applied'
              }).every(function(rowIdx, tableLoop, rowLoop) {
                var columnValue = this.cell(rowIdx, 6).data();

                // Update the 'lastValue' variable with the current value
                lastValue = columnValue;
              });
              // Get the last row value



              var total = api.column(colIndex, {
                page: 'current'
              }).data().sum();
              var total2 = api.column(colIndex2, {
                page: 'current'
              }).data().sum();


              var footer = api.column(colIndex).footer();
              var footer2 = api.column(colIndex2).footer();
              $(api.column(colIndex3).footer()).html('E£ ' + lastValue);
              $(footer).html('E£ ' + total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }));
              $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
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

            ],
            columns: [{
                data: 'no',
                width: "60px"
              },
              {
                data: 'name',
              },
              {
                data: 'order_id',
                width: "280px"
              },
              {
                data: 'created_time',
                width: "160px",
              },
              {
                data: 'debit',
                width: "200px",
              },
              {
                data: 'credit',
                width: "200px",
              },
              {
                data: 'balance',
                width: "200px",
              },

            ],
            autoWidth: false,
            responsive: true,
          });
          $("#ExportReporttoExcel").on("click", function() {
            table2.button('.buttons-csv').trigger();
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
            var barcodeDiv = document.getElementById("suppliertrans");
            var printWindow = window.open('', '');

            printWindow.document.write('<html><head><title>Exchange Difference</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
            printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Exchange Difference</h3><span class="dt-range">From <span class="bold">' + $("#start-date-filter-trans").val() + '</span>  To <span class="bold">' + $("#end-date-filter-trans").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
            printWindow.document.write(barcodeDiv.innerHTML);
            printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
          });
          $("#suppliertrans_length").remove();
          $("#suppliertrans_paginate").remove();
          $("#suppliertrans_info").remove();
          $("#suppliertrans_filter").remove();
          $('select#filter_refered').on('change', function() {
            var refered = $(this).val();
            if ($(this).val() === 'all') {
              table2.column(3).search('').draw();
            } else {
              table2.column(3).search(refered, true, false).draw();
            }
          });
          $('#search-filter-trans').on('keyup', function() {
            var searchValue = $(this).val();
            table2.search(searchValue).draw();
          });


          function startupBalance() {
            var create_date = $('input#start-date-filter-trans').val();
            var end_date = $('input#end-date-filter-trans').val();
            create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
            end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
            if ($('input#start-date-filter-trans').val() === '') {
              filtered = '';
            } else {
              var filtered = table2.column(3).data().filter(function(value, index) {
                return value >= create_date && value <= end_date; // Filter the data based on the entered date
              }).join("|");
              var valuesToDraw = filtered.split("|");
              var regex = valuesToDraw.map(function(value) {
                return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
              }).join('|');
              table2.column(3).search(regex, true, false).draw();



              var open_balance_index = Array.from(table2.column(3).data()).filter(function(value) {
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
            console.log(cellValue);
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
              var filtered = table2.column(3).data().filter(function(value, index) {
                return value >= create_date && value <= end_date; // Filter the data based on the entered date
              }).join("|");
              var valuesToDraw = filtered.split("|");
              var regex = valuesToDraw.map(function(value) {
                return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
              }).join('|');
              table2.column(3).search(regex, true, false).draw();



              var open_balance_index = Array.from(table2.column(3).data()).filter(function(value) {
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
            console.log(cellValue);
          });
          $('input#start-date-filter-trans').on('blur', function() {
            if ($(this).val() === '') {
              table2.column(3).search('').draw();
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
              var filtered = table2.column(3).data().filter(function(value, index) {
                return value >= create_date && value <= end_date; // Filter the data based on the entered date
              }).join("|");
              var valuesToDraw = filtered.split("|");
              var regex = valuesToDraw.map(function(value) {
                return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
              }).join('|');
              table2.column(3).search(regex, true, false).draw();



              var open_balance_index = Array.from(table2.column(3).data()).filter(function(value) {
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
            console.log(cellValue);
          });
          $('input#end-date-filter-trans').on('blur', function() {
            if ($(this).val() === '') {
              table2.column(3).search('').draw();
            }
          });



        });
      </script>

    </div>


    <div class="black_screen"></div>
    <?php if (check_user_role(1) == 1 || check_user_role(5000) == 1 || check_user_role(5002) == 1) {
    ?>
      <div class="pay_payment_section share_payment">
        <div class="custome-head">
          <h3>New Exchange Difference</h3>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" action="" method="POST" enctype="multipart/form-data">

          <div class="custom-form custom-item-form payment_form">
            <div class="inputs w100 radio_type">
              <label for="fund"><input type="radio" id="fund" name="type" value="1" class="fund" required><span class="radio_label fund">Profit +</span></label>
              <label for="withdraw"><input type="radio" id="withdraw" name="type" value="2" required><span class="radio_label withdraw">Loss -</span></label>
            </div>
            <div class="inputs w100">
              <label for="amount_payment">Amount</label>
              <input type="number" name="amount_payment" id="amount_payment" min="0" value="0" step="0.01" required>
            </div>
            <div class="inputs w50">
              <label for="amount_payment_method">To Account</label>
              <select name="amount_payment_method" id="amount_payment_method">
                <option value="bank">Bank Account</option>
              </select>
            </div>
            <div class="inputs amount_bank_choose w50">
              <label for="amount_bank_name">Bank Name</label>
              <select name="amount_bank_name" id="amount_bank_name">
                <?= get_banks() ?>
              </select>
            </div>
            <div class="inputs amount_bank_num_choose w100">
              <label for="amount_bank_number">Bank Account</label>
              <select name="amount_bank_number" id="amount_bank_number">
              </select>
            </div>
            <div class="inputs w100">
              <label for="description">Statement</label>
              <textarea name="description" id="description"></textarea>
            </div>
            <div class="inputs w100">
              <label for="amount_cdate">Create Date</label>
              <input type="datetime-local" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d\TH:i") ?>">
            </div>
          </div>
          <input type="submit" name="pay" value="Add">
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


        $(".confirm_delete_page_trans .close_confirm").click(function() {

          $(".confirm_delete_page_trans").css({
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
          if ($(this).val() !== "bank") {
            $(".amount_bank_choose").css({
              "visibility": "hidden"
            });
            $(".amount_bank_num_choose").css({
              "display": "none"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight") - 70;
            $(".pay_payment_section").css({
              height: paymentHeight + "px",
            });
          } else if ($(this).val() == "bank") {
            $(".amount_bank_choose").css({
              "visibility": "visible"
            });
            $(".amount_bank_num_choose").css({
              "display": "flex"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight");
            $(".pay_payment_section").css({
              height: paymentHeight + "px",
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

        if ($("#amount_payment_method").val() !== "bank") {
          $(".amount_bank_choose").css({
            "visibility": "hidden"
          });
          $(".amount_bank_num_choose").css({
            "display": "none"
          });

        } else if ($("#amount_payment_method").val() == "bank") {
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
        $('#edit_bank').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $.ajax({
            type: 'POST',
            url: 'functions/core/edit-account.php',
            data: $(this).serialize(),
            success: function(data) {
              $(".mga").html(data);
              setTimeout(function() {
                location.reload();
              }, 1000);
            },
          });
        });
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