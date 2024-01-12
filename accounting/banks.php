<?php
$pg_name = "Wonder - Bank Accounts";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3002) == 1) {
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Bank Accounts</h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Bank Accounts</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3004) == 1) {
          ?>
            <button class="new-btn">New Account</button>
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
                  <th>Account Number</th>
                  <th>Bank Name</th>
                  <th>Balance (E£)</th>
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
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
      </div>
      <div class="black_screen"></div>
      <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3004) == 1) {
      ?>
        <div class="add_new new_account">
          <div class="custome-head">
            <h3>New Account</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" id="new_supplier" action="" method="POST">
            <div class="custom-form">
              <div class="form-section">
                <div class="inputs gd6">
                  <label for="bank_name">Bank Name</label>
                  <select name="bank_name" id="bank_name" required>
                    <option value="البنك الأهلى المصرى">البنك الأهلى المصرى</option>
                    <option value="بنك الإسكندرية">بنك الإسكندرية</option>
                    <option value="بنك ابو ظبي التجاري – مصر">بنك ابو ظبي التجاري – مصر</option>
                    <option value="مصرف أبو ظبي الإسلامي">مصرف أبو ظبي الإسلامي</option>
                    <option value="البنك الأهلي المتحد - مصر">البنك الأهلي المتحد - مصر</option>
                    <option value="البنك العربي الافريقي">البنك العربي الافريفي</option>
                    <option value="البنك العربي">البنك العربي</option>
                    <option value="المصرف العربي الدولي">المصرف العربي الدولي</option>
                    <option value="بنك التجاري وفا">بنك التجاري وفا</option>
                    <option value="بنك القاهرة">بنك القاهرة</option>
                    <option value="بنك مصر">بنك مصر</option>
                    <option value="البنك المركزي المصري">البنك المركزي المصري</option>
                    <option value="سيتي بنك">سيتي بنك</option>
                    <option value="البنك التجاري الدولي">البنك التجاري الدولي</option>
                    <option value="بنك كريدي أجريكول مصر">بنك كريدي أجريكول مصر</option>
                    <option value="البنك العقاري المصري العربي">البنك العقاري المصري العربي</option>
                    <option value="البنك المصري الخليجي">البنك المصري الخليجي</option>
                    <option value="بنك الإمارات دبي الوطني مصر">بنك الإمارات دبي الوطني مصر</option>
                    <option value="Export Development Bank of Egypt">Export Development Bank of Egypt</option>
                    <option value="بنك فيصل الاسلامى">بنك فيصل الاسلامى</option>
                    <option value="HSBC Bank Egypt S.A.E">HSBC Bank Egypt S.A.E</option>
                    <option value="بنك التعمير والإسكان">بنك التعمير والإسكان</option>
                    <option value="بنك المشرق">بنك المشرق</option>
                    <option value="بنك الكويت الوطني">بنك الكويت الوطني</option>
                    <option value="QNB ALAHLI">QNB ALAHLI</option>
                    <option value="Societe Arabe Internationale De Banque">Societe Arabe Internationale De Banque</option>
                    <option value="بنك قناة السويس">بنك قناة السويس</option>
                    <option value="المصرف المتحد">المصرف المتحد</option>
                    <option value="aiBANK">aiBANK</option>
                    <option value="بنك البركة">بنك لبركة</option>
                  </select>
                </div>
                <div class="inputs gd6">
                  <label for="account_number">Account Number</label>
                  <input type="text" pattern="[0-9]*" value="" class="" name="account_number" id="account_number" required>
                  <span class="error-field"></span>
                </div>
              </div>
            </div>
            <hr class="hr_form">
            <div class="loadings"><i class=""></i></div>
            <input type="hidden" name="add" value="Save">
            <input type="submit" class="add" value="Add">
          </form>
        </div>
      <?php
      }
      ?>
      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {
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
            url: 'json/bankaccounts.php',
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
              }
            },

          ],
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
            var colIndex2 = 3; // Set the index of the first column to calculate the sum for


            var colData2 = api.column(colIndex2, {
              page: 'current'
            }).data();
            var total2 = 0;




            var total2 = api.column(colIndex2, {
              page: 'current'
            }).data().sum();


            var footer2 = api.column(colIndex2).footer();
            $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
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
              data: 'bank_name',
              width: "250px"
            },
            {
              data: 'balance',
              width: "250px"
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
          printWindow.document.write('<html><head><title>Bank Accounts</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Bank Accounts</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
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