<?php
$pg_name = "Wonder - Loans";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(6000) == 1 || check_user_role(6001) == 1) {
    if (isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['t']) && !empty($_GET['t'])) {
      $start_date = $_GET['f'];
      $end_date = $_GET['t'];
    } else {
      $start_date = "0001-01-01";
      $end_date = date("Y-m-d", strtotime(date("Y-m-d") . " +1 day"));
    }
    if (check_user_role(1) == 1 || check_user_role(6000) == 1 || check_user_role(6002) == 1) {
      import_loan();
      delete_loan();
    }
?>

    <div class="att-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Loans
            <form action="" method="GET" class="filter_date_range">
              <div class="inputs">
                <label for="create-date-filter"></label>
                <input type="date" name="f" id="create-date-filter" value="<?= $start_date ?>" style="display:none;">
              </div>
              <div class="inputs">
                <label for="end-date-filter">On</label>
                <input type="date" name="t" id="end-date-filter" value="<?= $end_date ?>">
              </div>
              <input type="submit" value="Filter">
            </form>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Loans</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(6000) == 1 || check_user_role(6002) == 1) {
          ?>
            <button class="new-btn" id="payment-btn">New Loan</button>
          <?php
          }
          ?>
        </div>

      </div>
      <div class="employee-section request-section trial_list_2">
        <form action="" method="POST" class="list-form">
          <div class="main-table-style">
            <div class="serch">
              <input type="text" id="name-search" value="" placeholder="Search...">
            </div>
            <table id="supplierslist" style="width:100% !important;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Bank Name</th>
                  <th>Start Date</th>
                  <th>Due Date</th>
                  <th>Duration (Months)</th>
                  <th>Total Amount (E£)</th>
                  <th>Total Paid (E£)</th>
                  <th>Due Balance (E£)</th>
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
        </form>
      </div>
      <div class="black_screen"></div>
      <?php if (check_user_role(1) == 1 || check_user_role(6000) == 1 || check_user_role(6002) == 1) {
      ?>
        <div class="pay_payment_section share_payment expense_form">
          <div class="custome-head">
            <h3>New Loan</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" id="new_supplier" action="" method="POST">
            <div class="custom-form custom-item-form payment_form">

              <div class="inputs w50">
                <label for="main_bank">Bank Name</label>
                <input type="text" name="main_bank" id="main_bank" required>
              </div>
              <div class="inputs w50">
                <label for="amount_loan">Amount of Loan (E£)</label>
                <input type="number" name="amount_loan" id="amount_loan" min="0" step="0.01" required>
              </div>
              <div class="inputs w50">
                <label for="amount_cdate">Start Date</label>
                <input type="date" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d") ?>" required>
              </div>
              <div class="inputs w50">
                <label for="amount_edate">Due Date</label>
                <input type="date" name="amount_edate" id="amount_edate" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 year")) ?>" required>
              </div>
              <div class="inputs w50">
                <label for="amount_payment_method">Recieved Mehtod</label>
                <select name="amount_payment_method" id="amount_payment_method" required>
                  <option value="cash">Cash</option>
                  <option value="bank">Bank Account</option>
                </select>
              </div>
              <div class="inputs amount_bank_choose w50">
                <label for="amount_bank_name">Received Bank Name</label>
                <select name="bank_name" id="amount_bank_name">
                  <?= get_banks() ?>
                </select>
              </div>
              <div class="inputs amount_bank_num_choose w100">
                <label for="amount_bank_number">Bank Account</label>
                <select name="bank_number" id="amount_bank_number">
                </select>
              </div>
            </div>
            <div class="loadings"><i class=""></i></div>
            <input type="hidden" name="add" value="Save">
            <input type="submit" class="add" value="Add">
          </form>
        </div>

        <div class="confirm_delete_page">
          <div class="custome-head">
            <h3>Are you sure to remove loan #<span class="order_id_confirm">...</span></h3>
            <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form method="POST">
            <input type="hidden" class="confirm_id" value="" name="confirm_id">
            <button class="confirm_delete_btn" data-btn="">Confirm</button>
          </form>
        </div>
      <?php } ?>
      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {

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



        $("#amount_payment_method").on("change", function() {
          if ($(this).val() == "cash") {
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
          } else {
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
          e.preventDefault();
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

        var table = $('#supplierslist').DataTable({
          ajax: {
            url: 'json/loans.php',
            type: 'GET',
            dataSrc: '',
            data: {
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
            }
          }, ],
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
          "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            var colIndex2 = 5; // Set the index of the first column to calculate the sum for
            var colIndex3 = 6; // Set the index of the first column to calculate the sum for
            var colIndex4 = 7; // Set the index of the first column to calculate the sum for


            var colData2 = api.column(colIndex2, {
              page: 'current'
            }).data();
            var total2 = 0;
            var colData3 = api.column(colIndex3, {
              page: 'current'
            }).data();
            var total3 = 0;
            var colData4 = api.column(colIndex4, {
              page: 'current'
            }).data();
            var total4 = 0;




            var total2 = api.column(colIndex2, {
              page: 'current'
            }).data().sum();

            var total3 = api.column(colIndex3, {
              page: 'current'
            }).data().sum();

            var total4 = api.column(colIndex4, {
              page: 'current'
            }).data().sum();


            var footer2 = api.column(colIndex2).footer();
            $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            var footer3 = api.column(colIndex3).footer();
            $(footer3).html('E£ ' + total3.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            var footer4 = api.column(colIndex4).footer();
            $(footer4).html('E£ ' + total4.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
          },
          columnDefs: [{
              targets: 1,
              orderable: false
            },

            {
              targets: -1,
              className: 'dt-body-right',
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
              data: 'account',
            },
            {
              data: 'created_time',
              width: "150px"
            },
            {
              data: 'due_to',
              width: "150px"
            },
            {
              data: 'duration',
              width: "120px"
            },
            {
              data: 'balance',
              width: "160px"
            },
            {
              data: 'paid',
              width: "160px"
            },
            {
              data: 'due',
              width: "160px"
            },
            {
              data: 'action',
              width: "100px"
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
          printWindow.document.write('<html><head><title>Loans</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Loans</h3><span class="dt-range">On <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('.dataTables_filter').remove();
        $('select#status_filter').on('change', function() {
          var status = $(this).val();
          if ($(this).val() === 'all') {
            table.column(-3).search('').draw();
          } else if ($(this).val() === 'active') {
            table.column(-3).search('\\bactive\\b(?!\\s*inactive)', true, false).draw();
          } else {
            table.column(-3).search(status, true, false).draw();
          }
        });
        $('select#cities').on('change', function() {
          var city = $(this).val();
          if ($(this).val() === 'all') {
            table.column(4).search('').draw();
          } else {
            console.log(city);
            table.column(4).search(city).draw();
          }
        });
        $('select#type_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(3).search('').draw();
          } else {
            console.log(city);
            table.column(3).search(type).draw();
          }
        });
        $('input#create-date-filter').on('change', function() {
          var create_date = $(this).val();
          create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format

          if ($(this).val() === '') {
            table.column(-2).search('').draw();
          } else {
            table.column(-2).search(create_date).draw();
          }
        });
        $('input#create-date-filter').on('blur', function() {
          if ($(this).val() === '') {
            table.column(-2).search('').draw();
          }
        });

        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
        });

        var cities = ["Cairo", "Alexandria", "Giza", "Shubra El-Kheima", "Port Said", "Suez", "Luxor", "al-Mansura", "El-Mahalla El-Kubra", "Tanta", "Asyut", "Ismailia", "Fayyum", "Zagazig", "Aswan", "Damietta", "Damanhur", "Minya", "Beni Suef", "Qena", "Sohag", "Hurghada", "6th of October City", "Shibin El Kom", "Banha", "Kafr el-Sheikh", "Arish", "Mallawi", "10th of Ramadan City", "Bilbais", "Marsa Matruh", "Idfu", "Mit Ghamr", "Al-Hamidiyya", "Desouk", "Qalyub", "Abu Kabir", "Kafr el-Dawwar", "Girga", "Akhmim", "Matareya", "Qift", "Awlad Saqr", "Abu Hummus", "Al-Qanatir al-Khayriyya", "Al-Matariyyah", "Al-Qanayat", "Al-Badari", "Dayr Mawas", "Al-Qusayr", "Juhaynah", "Isna", "Al-Fashn", "Al-Shalalat", "Samannud", "Al-Hawamidiyah", "Disuq", "Al-Ayyat", "Al-Masara", "Al-Qurayn", "Al-Manzilah", "Al-Basaliyah Tahta", "Ibsheway", "Al-Bajur", "Talkha", "Dikirnis", "Al-Tor", "Al-Qasr", "Al-Balyana", "Al-Qanatir al-Khayriyyah", "Bani Mazar", "Al-Qanatir al-Khayriyyah", "Al-Qanatir al-Khayriyyah"];
        var select = document.getElementById("cities");
        for (var i = 0; i < cities.length; i++) {
          var option = document.createElement("option");
          option.text = cities[i];
          option.value = cities[i];
          select.appendChild(option);
        }

        $('#new_supplier').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-bank.php',
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