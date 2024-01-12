<?php
$pg_name = "Wonder - Job Titles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(501) == 1) {
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Job Titles</h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Job Titles</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(502) == 1) {  ?>
            <button class="new-btn">New Job Title</button>
          <?php } ?>
        </div>
      </div>
      <div class="request-section filter-section">
        <form action="" method="POST">
          <input type="hidden" name="page" value="">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <div class="inputs">
              <label for="status_filter">Status</label>
              <select name="type" id="status_filter">
                <option value="active">Active Only</option>
                <option value="inactive">Inactive Only</option>
                <option value="all" selected>Inactive Included</option>
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
                  <th style="text-align: center;"><input type="checkbox" id="ck-all" class="delete-bx" name="delete[]" value="all"></th>
                  <th>#</th>
                  <th>Name</th>
                  <th>Number of Employees</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>

            </table>
          </div>
          <input type="submit" class="delete-btn" name="inactive-submit" value="Mark as Inactive">
        </form>
      </div>
      <div class="black_screen"></div>
      <?php if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(502) == 1) {  ?>
        <div class="add_new new_account">
          <div class="custome-head">
            <h3>New Job Title</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" id="new_supplier" action="" method="POST">
            <input type="hidden" value="job_titles" name="type">
            <div class="custom-form">
              <div class="form-section">
                <div class="inputs gd6">
                  <label for="name">Name</label>
                  <input type="text" value="" class="" name="name" id="name" required="">
                  <span class="error-field"></span>
                </div>
                <div class="inputs gd6">
                  <label for="desc">Description</label>
                  <textarea name="description" id="desc" cols="30" rows="10"></textarea>
                  <span class="error-field"></span>
                </div>
                <div class="inputs gd6">
                  <label for="status">Status</label>
                  <select name="status" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
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
      <?php } ?>
      <div class="mga"></div>
      <?= inactive_list('job_titles') ?>
    </div>

    <script>
      $(document).ready(function() {


        $('#new_supplier').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-org.php',
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
            url: 'json/org.php',
            type: 'GET',
            dataSrc: '',
            data: {
              type: "job_titles",
              once: "job_title",
              view: "jobtitle",
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
              columns: ':not(:last-child,:first-child)' // Exclude last column and column index 3
            }
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
          columnDefs: [{
              targets: -1,
              className: 'dt-body-right',
              orderable: false
            },
            {
              targets: 0,
              className: 'dt-body-center',
              orderable: false
            },
          ],
          order: [
            [1, 'asc']
          ],
          columns: [{
              data: 'check',
              width: "40px"
            },
            {
              data: 'no',
              width: "40px"
            },
            {
              data: 'name',
              width: "320px"
            },
            {
              data: 'count',
              width: "150px"
            },
            {
              data: 'status',
              width: "150px"
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

          printWindow.document.write('<html><head><title>Job Titles</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child,table td:first-child,table th:first-child {display: none;}</style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Job Titles</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('.dataTables_filter').remove();
        $('select#status_filter').on('change', function() {
          var status = $(this).val();
          if ($(this).val() === 'all') {
            table.column(4).search('').draw();
          } else if ($(this).val() === 'active') {
            table.column(4).search('\\bactive\\b(?!\\s*inactive)', true, false).draw();
          } else {
            table.column(4).search(status, true, false).draw();
          }
        });

        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
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