<?php
$pg_name = "Wonder - Expenses";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_user_role(1) == 1 || check_user_role(800) == 1 || check_user_role(801) == 1) {
    $user_info = login_info();
    import_expense();
    if (check_user_role(1) == 1 || check_user_role(800) == 1 || check_user_role(803) == 1) {
      delete_expense();
    }
?>

    <div class="att-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Expenses
            <div class="inputs">
              <label for="create-date-filter">From Date </label>
              <input type="date" name="date" id="create-date-filter" value="<?= date("Y-m") . "-01" ?>" pattern="\d{2}/\d{2}/\d{4}" />
            </div>
            <div class="inputs">
              <label for="end-date-filter">To </label>
              <input type="date" name="date" id="end-date-filter" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>" pattern="\d{2}/\d{2}/\d{4}">
            </div>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Expenses</p>
        </div>

        <div class="btns">

          <button class="filter"><i class="fa-solid fa-filter"></i></button>
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
          <?php if (check_user_role(1) == 1 || check_user_role(800) == 1 || check_user_role(802) == 1) {
          ?>
            <button class="new-btn" id="payment-btn">New Expense</button>
          <?php
          }
          ?>
        </div>

      </div>
      <div class="request-section filter-section">
        <form action="" method="POST">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <!-- <div class="inputs">
              <label for="payment_method_filter">Payment Method</label>
              <select name="city" id="payment_method_filter">
                <option value="all">All</option>
                <option value="cash">Cash</option>
                <option value="bank">Bank Account</option>
                <option value="accured expenses">Accrued Expenses</option>
                <option value="accured salaries">Accrued Salaries</option>
              </select>
            </div> -->
            <div class="inputs">
              <label for="type_filtering">Type</label>
              <select name="type" id="type_filtering">
                <option value="all">All</option>
                <?= get_expenses_option() ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="employee-section request-section trial_list">
        <div class="main-table-style">
          <div class="serch">
            <input type="text" id="name-search" value="" placeholder="Search...">
          </div>
          <table id="supplierslist" style="width:100% !important;">
            <thead>
              <tr>
                <th>#</th>
                <th>Item</th>
                <th>Type</th>
                <th>Payment Method</th>
                <th>Created Date</th>
                <th>Amount (E£)</th>
                <th>Quantity</th>
                <th>Total Amount (E£)</th>
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
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="black_screen"></div>
      <div class="confirm_delete_page">
        <div class="custome-head">
          <h3>Are you sure to cancel expense #<span class="order_id_confirm">...</span></h3>
          <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST">
          <input type="hidden" class="confirm_id" value="" name="confirm_id">
          <button class="confirm_delete_btn" data-btn="">Confirm</button>
        </form>
      </div>
      <div class="pay_payment_section share_payment expense_form">
        <div class="custome-head">
          <h3>New Expense</h3>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" action="" method="POST" enctype="multipart/form-data">
          <div class="custom-form custom-item-form payment_form">
            <div class="inputs w50">
              <label for="expense_type">Expense Type</label>
              <input type="text" name="type" id="expense_type" required>
            </div>
            <div class="inputs w50">
              <label for="amount_cdate">Create Date</label>
              <input type="datetime-local" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d\TH:i") ?>" required>
            </div>
            <div class="inputs w50">
              <label for="amount_payment_method">Payment Mehtod</label>
              <select name="amount_payment_method" id="amount_payment_method" required>
                <option value="cash">Cash</option>
                <option value="bank">Bank Account</option>
                <option value="accrued expenses">Accrued Expenses</option>
                <option value="petty cash">Petty Cash</option>
                <option value="accrued salaries">Accrued Salaries</option>
                <option value="accrued rents">Accrued Rents</option>
                <option value="prepaid expenses">Prepaid Expenses</option>
                <option value="payroll taxes">Payroll Taxes</option>
                <option value="solidarity contribution">Solidarity Contribution</option>
                <option value="national authority for social insurance">National Authority for Social Insurance</option>
                <option value="insurance for others">Insurance for Others</option>
              </select>
            </div>
            <div class="inputs amount_bank_choose w50">
              <label for="amount_bank_name">Bank Name</label>
              <select name="bank_name" id="amount_bank_name">
                <?= get_banks() ?>
              </select>
            </div>
            <div class="inputs amount_bank_num_choose w100">
              <label for="amount_bank_number">Bank Account</label>
              <select name="bank_number" id="amount_bank_number">
              </select>
            </div>
            <div class="employee-section request-section invoice-list subcomp-list w100">
              <div class="request-list">
                <div class="request-row request-head-list">
                  <div>Item</div>
                  <div>Qty</div>
                  <div>Amount (E£)</div>
                  <div>Total Amount (E£)</div>
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
      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {
        function formatDate(date) {
          var year = date.getFullYear();
          var month = date.getMonth() + 1; // Note: Month starts from 0, so we add 1
          var day = date.getDate();

          // Format the date as YYYY-MM-DD
          var formattedDate = year + '-' + addLeadingZero(month) + '-' + addLeadingZero(day);

          return formattedDate;
        }

        // Helper function to add leading zero to single-digit month or day
        function addLeadingZero(number) {
          return number.toString().padStart(2, '0');
        }
        $(".item_quantity").on("input", function() {
          var new_amount = $(this).val() * $(".item_amount").val();
          $(".item_total")
            .val(new_amount)
            .trigger("change");
        });
        $(".item_amount").on("input", function() {
          var new_amount = $(this).val() * $(".item_quantity").val();
          $(".item_total")
            .val(new_amount)
            .trigger("change");
        });


        $("#amount_payment_method").on("change", function() {
          if ($(this).val() == "cash") {
            $(".amount_bank_choose").css({
              "visibility": "hidden"
            });
            $(".amount_bank_num_choose").css({
              "display": "none"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight");
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

          } else {
            $(".amount_bank_choose").css({
              "visibility": "hidden"
            });
            $(".amount_bank_num_choose").css({
              "display": "none"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight");
            $(".pay_payment_section").css({
              height: paymentHeight + "px",
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
        $(".confirm_delete_page .close_confirm").click(function() {

          $(".confirm_delete_page").css({
            height: "0px",
            padding: "0",
            "border": "0px solid #cfcfcf",
          });
          $(".black_screen").fadeOut(200);
        });

        $("#supplierslist").on("click", "button.delete_order", function(e) {
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

        var table = $('#supplierslist').DataTable({
          ajax: {
            url: 'json/expenses.php',
            type: 'GET',
            dataSrc: '',
            data: {},
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
          },
          'createdRow': function(row, data, dataIndex) {
            $('td', row).css('min-width', '200px');
          },
          buttons: [{
            extend: 'csv',
            charset: 'UTF-8',
            bom: true,
            exportOptions: {
              encoding: 'UTF-8',
              columns: ':not(:last-child)' // Exclude last column and column index 3
            }
          }],
          pageLength: -1,
          "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
          ],
          language: {
            paginate: {
              previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
              next: '<i class="fa fa-chevron-right"></i>', // Customize the next button
            }
          },
          "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            var colIndex = 7; // Set the index of the first column to calculate the sum for

            var colData = api.column(colIndex, {
              page: 'current'
            }).data();
            var total = 0;



            var total = api.column(colIndex, {
              page: 'current'
            }).data().sum();


            var footer = api.column(colIndex).footer();
            $(footer).html('E£ ' + total.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
          },
          columnDefs: [{
              targets: 0,
            },
            {
              targets: 5,
              orderable: false
            },
            {
              targets: 1,
              orderable: false
            },
            {
              targets: 4,
              orderable: false,
              type: 'date',
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
          ],
          order: [
            [0, 'desc']
          ],
          columns: [{
              data: 'no',
              width: "80px"
            },
            {
              data: 'name',
              width: "230px"
            },
            {
              data: 'type',
              width: "230px"
            },
            {
              data: 'payment_method',
            },
            {
              data: 'created_time',
              width: "150px"
            },
            {
              data: 'amount',
              width: "140px"
            },
            {
              data: 'quantity',
              width: "90px"
            },
            {
              data: 'total_amount',
              width: "140px"
            },
            {
              data: 'action',
              width: "50px"
            },
          ],
          autoWidth: true,
          responsive: true,
        });
        $("#ExportReporttoExcel").on("click", function() {
          table.button('.buttons-csv').trigger();
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
          var barcodeDiv = document.getElementById("supplierslist");
          var printWindow = window.open('', '');

          printWindow.document.write('<html><head><title>Expenses</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Expenses</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });


        $('.dataTables_filter').remove();

        $('input#create-date-filter').on('change', function() {
          var create_date_input = $(this).val(); // Retrieve the value of the input field
          var date = new Date(create_date_input);
          date.setMonth(date.getMonth());
          var create_date = formatDate(date);
          var end_date_input = $('input#end-date-filter').val(); // Retrieve the value of the input field
          var date = new Date(end_date_input);
          date.setMonth(date.getMonth());
          var end_date = formatDate(date);
          create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
          end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
          if ($(this).val() === '') {
            filtered = '';
          } else {
            var filtered = table.column(4).data().filter(function(value, index) {
              return value >= create_date && value <= end_date; // Filter the data based on the entered date
            }).join("|");
            var valuesToDraw = filtered.split("|");
            var regex = valuesToDraw.map(function(value) {
              return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
            }).join('|');
            table.column(4).search(regex, true, false).draw();
          }

        });
        $('input#create-date-filter').on('blur', function() {
          if ($(this).val() === '') {
            table.column(4).search('').draw();
          }
        });
        $('input#end-date-filter').on('change', function() {
          var create_date_input = $('input#create-date-filter').val(); // Retrieve the value of the input field
          var date = new Date(create_date_input);
          date.setMonth(date.getMonth());
          var create_date = formatDate(date);
          var end_date_input = $(this).val(); // Retrieve the value of the input field
          var date = new Date(end_date_input);
          date.setMonth(date.getMonth());
          var end_date = formatDate(date);

          create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
          end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
          if ($(this).val() === '') {
            filtered = '';
          } else {
            var filtered = table.column(4).data().filter(function(value, index) {
              return value >= create_date && value <= end_date; // Filter the data based on the entered date
            }).join("|");
            var valuesToDraw = filtered.split("|");
            var regex = valuesToDraw.map(function(value) {
              return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
            }).join('|');
            table.column(4).search(regex, true, false).draw();
          }
        });
        $('input#end-date-filter').on('blur', function() {
          if ($(this).val() === '') {
            table.column(4).search('').draw();
          }
        });

        function startupBalance3() {
          var create_date_input = $('input#create-date-filter').val(); // Retrieve the value of the input field
          var date = new Date(create_date_input);
          date.setMonth(date.getMonth());
          var create_date = formatDate(date);
          var end_date_input = $('input#end-date-filter').val(); // Retrieve the value of the input field
          var date = new Date(end_date_input);
          date.setMonth(date.getMonth());
          var end_date = formatDate(date);



          create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
          end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
          if ($('input#create-date-filter').val() === '') {
            filtered = '';
          } else {
            var filtered = table.column(4).data().filter(function(value, index) {
              return value >= create_date && value <= end_date; // Filter the data based on the entered date
            }).join("|");
            var valuesToDraw = filtered.split("|");
            var regex = valuesToDraw.map(function(value) {
              return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
            }).join('|');
            table.column(4).search(regex, true, false).draw();
          }
          console.log(create_date + " - " + end_date);
        };

        setTimeout(startupBalance3, 500);


        // $('select#payment_method_filter').on('change', function() {
        //   var method = $(this).val();
        //   if ($(this).val() === 'all') {
        //     table.column(3).search('').draw();
        //   } else if ($(this).val() === 'cash') {
        //     table.column(3).search(method).draw();
        //   } else if ($(this).val() === 'bank') {
        //     table.column(3).search('^(?!.*\\bcash\\b)', true, false).draw();
        //   }
        // });
        $('select#type_filtering').on('change', function() {
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

        $(document).on({
          ajaxStart: function() {
            $(".loadings i").addClass("fa-solid");
            $(".loadings i").addClass("fa-spinner");
            $(".loadings i").addClass("fa-spin-pulse");
          },
          ajaxStop: function() {
            $(".loadings i").removeClass("fa-spin-pulse");
            $(".loadings i").removeClass("fa-spinner");
            $(".loadings i").removeClass("fa-solid");
          }
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