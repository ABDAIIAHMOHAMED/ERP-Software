<?php
$pg_name = "Wonder - Sales Trial Balance";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1005) == 1) {
    if (isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['t']) && !empty($_GET['t'])) {
      $start_date = $_GET['f'];
      $end_date = $_GET['t'];
    } else {
      $start_date = date("Y-m") . "-01";
      $end_date = date("Y-m-d", strtotime(date("Y-m-d") . " +1 day"));
    }
?>

    <div class="att-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Sales Trial balance
            <form action="" method="GET" class="filter_date_range">
              <div class="inputs">
                <label for="create-date-filter">From Date </label>
                <input type="date" name="f" id="create-date-filter" value="<?= $start_date ?>">
              </div>
              <div class="inputs">
                <label for="end-date-filter">To </label>
                <input type="date" name="t" id="end-date-filter" value="<?= $end_date ?>">
              </div>
              <input type="submit" value="Filter">
            </form>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Sales Trial Balanace</p>
        </div>
        <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
        ?>
          <div class="btns">
            <!-- <button class="filter"><i class="fa-solid fa-filter"></i></button> -->
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
          </div>
        <?php
        }
        ?>
      </div>
      <!-- <div class="request-section filter-section">
        <form action="" method="POST">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <div class="inputs">
              <label for="type_filtering">Type</label>
              <select name="type" id="type_filtering">
                <option value="all">All</option>
                <option value="عملاء محل">عملاء محل</option>
                <option value="عملاء اون لاين">عملاء اون لاين</option>
              </select>
            </div>
          </div>
        </form>
      </div> -->
      <div class="employee-section request-section trial_list">
        <form action="" method="POST" class="list-form">
          <div class="main-table-style">
            <table id="supplierslist" style="width:100% !important;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Invoice #</th>
                  <th>Customer Name</th>
                  <th>Open Balance (E£)</th>
                  <th>Debit (E£)</th>
                  <th>Credit (E£)</th>
                  <th>Balance (E£)</th>
                  <th>Cost (E£)</th>
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
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
      </div>
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
            url: 'json/trial_sales.php',
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
                encoding: 'UTF-8'
              }
            },

          ],
          "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
          ],
          pageLength: -1,
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
            var colIndex4 = 3; // Set the index of the first column to calculate the sum for
            var colIndex5 = 7; // Set the index of the first column to calculate the sum for

            var colData = api.column(colIndex, {
              page: 'current'
            }).data();
            var total = 0;
            var colData2 = api.column(colIndex2, {
              page: 'current'
            }).data();
            var total2 = 0;
            var colData2 = api.column(colIndex2, {
              page: 'current'
            }).data();
            var total2 = 0;
            var colData3 = api.column(colIndex5, {
              page: 'current'
            }).data();
            var total3 = 0;




            var total = api.column(colIndex, {
              page: 'current'
            }).data().sum();
            var total2 = api.column(colIndex2, {
              page: 'current'
            }).data().sum();
            var total3 = api.column(colIndex5, {
              page: 'current'
            }).data().sum();

            var lastValue = 'E£ ' + api.column(colIndex3, {
              page: 'current'
            }).data().sum().toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
            var openBalance = 'E£ ' + api.column(colIndex4, {
              page: 'current'
            }).data().sum().toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });


            var footer = api.column(colIndex).footer();
            var footer2 = api.column(colIndex2).footer();
            var footer3 = api.column(colIndex5).footer();
            $(api.column(colIndex3).footer()).html(lastValue);
            $(footer).html('E£ ' + total.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(api.column(colIndex4).footer()).html(openBalance);
            $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(footer3).html('E£ ' + total3.toLocaleString('en-US', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
          },
          columnDefs: [

          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'no',
              width: "80px"
            },
            {
              data: 'name',
            },
            {
              data: 'type',
              visible: false
            },
            {
              data: 'open_balance',
              width: "150px"
            },
            {
              data: 'debit',
              width: "150px"
            },
            {
              data: 'credit',
              width: "150px"
            },
            {
              data: 'balance',
              width: "150px"
            },
            {
              data: 'cost',
              width: "150px",
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
          printWindow.document.write('<html><head><title>Sales Trial Balance</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Sales Trial Balance</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('select#type_filtering').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(2).search('').draw();
          } else {
            table.column(2).search(type).draw();
          }
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


        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
        });

        $("#supplierslist_paginate").remove();
        $("#supplierslist_info").remove();
        $("#supplierslist_length").remove();
        $("#supplierslist_filter").remove();

        var cities = ["Cairo", "Alexandria", "Giza", "Shubra El-Kheima", "Port Said", "Suez", "Luxor", "al-Mansura", "El-Mahalla El-Kubra", "Tanta", "Asyut", "Ismailia", "Fayyum", "Zagazig", "Aswan", "Damietta", "Damanhur", "Minya", "Beni Suef", "Qena", "Sohag", "Hurghada", "6th of October City", "Shibin El Kom", "Banha", "Kafr el-Sheikh", "Arish", "Mallawi", "10th of Ramadan City", "Bilbais", "Marsa Matruh", "Idfu", "Mit Ghamr", "Al-Hamidiyya", "Desouk", "Qalyub", "Abu Kabir", "Kafr el-Dawwar", "Girga", "Akhmim", "Matareya", "Qift", "Awlad Saqr", "Abu Hummus", "Al-Qanatir al-Khayriyya", "Al-Matariyyah", "Al-Qanayat", "Al-Badari", "Dayr Mawas", "Al-Qusayr", "Juhaynah", "Isna", "Al-Fashn", "Al-Shalalat", "Samannud", "Al-Hawamidiyah", "Disuq", "Al-Ayyat", "Al-Masara", "Al-Qurayn", "Al-Manzilah", "Al-Basaliyah Tahta", "Ibsheway", "Al-Bajur", "Talkha", "Dikirnis", "Al-Tor", "Al-Qasr", "Al-Balyana", "Al-Qanatir al-Khayriyyah", "Bani Mazar", "Al-Qanatir al-Khayriyyah", "Al-Qanatir al-Khayriyyah"];
        var select = document.getElementById("cities");
        for (var i = 0; i < cities.length; i++) {
          var option = document.createElement("option");
          option.text = cities[i];
          option.value = cities[i];
          select.appendChild(option);
        }

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