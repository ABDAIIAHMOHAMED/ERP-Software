<?php
$pg_name = "Wonder - Roles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1) {
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>User Roles</h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / User Roles</p>
        </div>
        <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
        ?>
          <div class="btns">
            <a href="new_role.php" class="new-btn">New Role</a>
          </div>
        <?php
        }
        ?>
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
                  <th>#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </form>
      </div>
    </div>

    <script>
      $(document).ready(function() {



        var table = $('#supplierslist').DataTable({
          ajax: {
            url: 'json/roles.php',
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
            [0, 'desc']
          ],
          columns: [{
              data: 'no',
              width: "40px"
            },
            {
              data: 'name',
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

          printWindow.document.write('<html><head><title>User Roles</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:first-child,table th:first-child {display: none;}</style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>User Roles</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('.dataTables_filter').remove();
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