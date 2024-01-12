<?php
$pg_name = "Wonder - Withholding Taxes Report";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2007) == 1) {
    $user_info = login_info();
?>

    <div class="att-part vat-part vvat">
      <div class="title-head">
        <div class="headso">
          <h3>Withholding Taxes Report
            <div class="inputs">
              <label for="create-date-filter">From Date </label>
              <input type="date" name="date" id="create-date-filter" value="<?= date("Y-m") . "-01" ?>">
            </div>
            <div class="inputs">
              <label for="end-date-filter">To </label>
              <input type="date" name="date" id="end-date-filter" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>">
            </div>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Withholding Taxes Report</p>
        </div>
        <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
        ?>
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
          </div>
        <?php
        }
        ?>
      </div>
      <div class="cash-container">
        <div class="cash-history">
          <div class="cash-history" style="margin-bottom: 0px;">
            <h4>Withholding Taxes Report</h4>
            <div class="resp-table">
              <table id="supvatreport" style="width:100% !important;">
                <thead>
                  <tr>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Debit (E£)</th>
                    <th>Credit (E£)</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td>Balance</td>
                    <td></td>
                    <td></td>
                    <td></td>

                  </tr>
                </tfoot>
              </table>
            </div>
            <script>
              $(function() {


                $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
                  var ukDate = date.split('/');
                  return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
                };
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
                var table = $('#supvatreport').DataTable({
                  ajax: {
                    url: 'json/withvat.php',
                    type: 'GET',
                    dataSrc: '',
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
                  "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var colIndex1 = 2; // Set the index of the first column to calculate the sum for
                    var colIndex2 = 3; // Set the index of the first column to calculate the sum for

                    var colData1 = api.column(colIndex1, {
                      page: 'current'
                    }).data();
                    var colData2 = api.column(colIndex2, {
                      page: 'current'
                    }).data();
                    var total1 = 0;
                    var total2 = 0;
                    var total3 = 0;

                    total1 = api.column(colIndex1, {
                      page: 'current'
                    }).data().sum();
                    total2 = api.column(colIndex2, {
                      page: 'current'
                    }).data().sum();
                    total3 = total2 - total1;
                    $(api.column(colIndex2).footer()).html(total3.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }));


                  },
                  pageLength: -1, // Set default selection to "All"
                  order: [
                    [1, 'desc']
                  ],
                  pageLength: -1, // Set default selection to "All"
                  language: {
                    paginate: {
                      previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                      next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                    }
                  },
                  columnDefs: [{
                      targets: 1,
                      orderable: false,
                    },
                    {
                      targets: 0,
                      orderable: false
                    },
                    {
                      targets: 2,
                      orderable: false,
                      type: 'date',
                    },
                    {
                      targets: 3,
                      orderable: false
                    },
                  ],
                  columns: [{
                      data: 'order_id',
                    },
                    {
                      data: 'date',
                      width: "150px",
                      // visible: false,
                    },
                    {
                      data: 'debit',
                      width: "130px"
                    },
                    {
                      data: 'credit',
                      width: "130px"
                    },
                  ],
                  autoWidth: false,
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
                  var barcodeDiv = document.getElementById("supvatreport");
                  var printWindow = window.open('', '');
                  printWindow.document.write('<html><head><title>Withholding taxes Report</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                  printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Withholding taxes Report</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
                  printWindow.document.write('<style>table td:nth-child(2), table th:nth-child(2),td:nth-child(3), table th:nth-child(3), td:nth-child(4), table th:nth-child(4){width: 400px !important;}</style>');
                  printWindow.document.write(barcodeDiv.innerHTML);
                  printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                });

                $('input#create-date-filter').on('change', function() {
                  var create_date = $(this).val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#create-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table.column(1).search('').draw();
                  }
                });
                $('input#end-date-filter').on('change', function() {
                  var end_date = $(this).val();
                  var create_date = $('input#create-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#end-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table.column(1).search('').draw();
                  }
                });

                function startupBalance() {
                  var create_date = $('input#create-date-filter').val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($('input#create-date-filter').val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                };

                setTimeout(startupBalance, 500);
                $("#supvatreport_paginate").remove();
                $("#supvatreport_info").remove();
                $("#supvatreport_length").remove();
                $("#supvatreport_filter").remove();





              });
            </script>
          </div>
        </div>
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

        $("#ExportReporttoExcel").on("click", function() {
          table.button('.buttons-csv').trigger();
        });
        $("#ExportReporttoPdf").on("click", function() {
          table.button('.buttons-pdf').trigger();
        });

        $('.dataTables_filter').remove();

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