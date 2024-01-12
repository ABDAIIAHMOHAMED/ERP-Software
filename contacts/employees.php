<?php
$pg_name = "Wonder - Employees";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(401) == 1) {
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Employees <span class="max_count">Users ( <?= users_count() ?> / 20 )</span></h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Employees</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(402) == 1) {
          ?>
            <button class="new-btn">New Employee</button>
          <?php } ?>
        </div>

      </div>
      <div class="request-section filter-section">
        <form action="" method="POST">
          <input type="hidden" name="page" value="">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <div class="inputs">
              <label for="type_filter">Type</label>
              <select name="type" id="type_filter">
                <option value="all">All</option>
                <option value="user">User</option>
                <option value="employee">Employee</option>
              </select>
            </div>
            <div class="inputs">
              <label for="department_filter">Department</label>
              <select name="department_filter" id="department_filter">
                <option value="all">All</option>
                <?= get_org_option_name('categories') ?>
              </select>
            </div>
            <div class="inputs">
              <label for="job_title_filter">Job Title</label>
              <select name="job_title_filter" id="job_title_filter">
                <option value="all">All</option>
                <?= get_org_option_name('job_titles') ?>
              </select>
            </div>
            <div class="inputs">
              <label for="job_type_filter">Job Type</label>
              <select name="job_type_filter" id="job_type_filter">
                <option value="all">All</option>
                <?= get_org_option_name('job_types') ?>
              </select>
            </div>
            <div class="inputs">
              <label for="career_level_filter">Career Level</label>
              <select name="career_level_filter" id="career_level_filter">
                <option value="all">All</option>
                <?= get_org_option_name('career_levels') ?>
              </select>
            </div>
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
                  <th>Employee</th>
                  <th>Type</th>
                  <th>Department</th>
                  <th>Job Title</th>
                  <th>Job Type</th>
                  <th>Career Level</th>
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
      <?php if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(402) == 1) {
      ?>
        <div class="add_new">
          <div class="custome-head">
            <h3>New Employee</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" id="new_supplier" method="POST" enctype="multipart/form-data">
            <div class="custom-form">
              <div class="sectra">
                <span class="sm-head">General info</span>
                <?php
                if (users_count() < 20) {
                ?>
                  <span class="ask">
                    <label for="ask1">Will be a software user ?</label>
                    <input type="checkbox" name="type" value="user" id="ask1">
                  </span>
                <?php
                }
                ?>
                <span class="ask">
                  <label for="ask">Active ?</label>
                  <input type="checkbox" name="status" value="1" checked>
                </span>
                <div class="form-section">
                  <div class="inputs gd2">
                    <label for="fname">First Name</label>
                    <input type="text" value="" class="" name="fname" id="fname" required>

                  </div>
                  <div class="inputs gd2">
                    <label for="mname">Middle Name</label>
                    <input type="text" value="" class="" name="mname" id="mname">

                  </div>
                  <div class="inputs gd2">
                    <label for="lname">Last Name</label>
                    <input type="text" value="" class="" name="lname" id="lname">

                  </div>
                  <div class="inputs gd6">
                    <label for="profile-pic">Profile Picture</label>
                    <input type="file" name="profile-pic" id="profile-pic" accept="image/png,image/jpeg,image/jpg" onchange="previewFile(this);">
                    <div class="drag-file ">
                      <div class="none-file">
                        <img src="../images/upload.png" alt=""> Drag picture here or <span>&nbsp;choose from your device</span>
                      </div>
                      <div class="exist-file">
                        <div class="pic-frame">
                          <img class="preview-avatar" src="" alt="">
                        </div>
                        <div class="remove-pic">X</div>
                      </div>
                    </div>

                  </div>
                  <div class="inputs gd3">
                    <label for="mobile">Mobile</label>
                    <input type="number" value="" class="" name="mobile" id="mobile" min="0" max="1999999999">

                  </div>
                  <div class="inputs gd3">
                    <label for="personal_email">Personal Email</label>
                    <input type="text" value="" class="" name="personal_email" id="personal_email">

                  </div>
                  <div class="inputs gd2">
                    <label for="job_title">Job Title</label>
                    <select name="job_title" id="job_title" class="">
                      <?= get_org_option('job_titles') ?>
                    </select>

                  </div>
                  <div class="inputs gd2">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="">
                      <?= get_org_option('categories') ?>
                    </select>

                  </div>
                  <div class="inputs gd2">
                    <label for="jobtype">Type of Job</label>
                    <select name="jobtype" id="jobtype" class="">
                      <?= get_org_option('job_types') ?>
                    </select>

                  </div>
                  <div class="inputs gd2">
                    <label for="careerlevel">Career Level</label>
                    <select name="careerlevel" id="careerlevel" class="">
                      <?= get_org_option('career_levels') ?>
                    </select>

                  </div>
                  <div class="inputs gd4">
                    <label for="salary">Net Salary</label>
                    <input type="number" value="" class="" name="salary" id="salary" min="0" placeholder="0">

                  </div>
                  <?php
                  if (users_count() < 20) {
                  ?>
                    <div class="inputs gd4 user-input email_wonder">
                      <label for="email">Email</label>
                      <input type="text" value="" class="" name="email" id="email">
                    </div>
                    <div class="inputs gd2 user-input">
                      <label for="role">Role</label>
                      <select name="role" id="role">
                        <?php if (check_user_role(1) == 1) {
                          echo '<option value="1">Admin</option>';
                        }
                        ?>

                        <?= get_org_option('user_roles') ?>
                      </select>
                    </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
              <div class="sectra">
                <span class="sm-head">Personal Info</span>
                <div class="form-section">
                  <div class="inputs gd6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>

                  </div>
                  <div class="inputs gd6">
                    <label for="note">Notes</label>
                    <textarea name="notes" id="note" cols="30" rows="10"></textarea>

                  </div>
                </div>
                <span class="sm-head">Address</span>
                <div class="form-section">
                  <div class="inputs gd6">
                    <label for="street">Street</label>
                    <textarea name="street" id="street" cols="30" rows="10"></textarea>

                  </div>
                  <div class="inputs gd3">
                    <label for="city">City/Town</label>
                    <input type="text" id="city" value="" class="" name="city">

                  </div>
                  <div class="inputs gd3">
                    <label for="state">State</label>
                    <input type="text" id="state" value="" class="" name="state">

                  </div>
                  <div class="inputs gd3">
                    <label for="postal">Postal Code</label>
                    <input type="number" value="" class="" name="postal" id="postal" min="0">
                    <span class=" error-field"></span>
                  </div>
                  <div class="inputs gd3">
                    <label for="country">Country</label>
                    <?php $mycountry = ip_info($_SERVER['REMOTE_ADDR'], "Country"); ?>
                    <select name="country" id="country" class='<?php if ($errors['country'] !== "") {
                                                                  echo " error_field";
                                                                } ?>' required>
                      <?php
                      $countries = countries();
                      foreach ($countries as $key => $country) {
                        echo "<option value='$country'";
                        if (isset($_POST['country']) && $_POST['country'] == $country) {
                          echo "selected";
                        } elseif ($country == $mycountry) {
                          echo "selected";
                        }
                        echo ">$country</option>";
                      }
                      ?>
                    </select>

                  </div>
                </div>
              </div>
            </div>
            <hr class="hr_form">
            <div class="loadings"><i class=""></i></div>
            <input type="hidden" name="add" value="Save">
            <input type="submit" class="add" value="Save">
          </form>
        </div>
      <?php } ?>
      <div class="mga"></div>
      <?php if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(404) == 1) { ?>
        <?= inactive_list('users') ?>
      <?php } ?>
    </div>

    <script>
      $(document).ready(function() {






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
            url: 'json/users.php',
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
              data: 'type',
              width: "150px"
            },
            {
              data: 'category',
              width: "150px"
            },
            {
              data: 'job_title',
              width: "150px"
            },
            {
              data: 'job_type',
              width: "150px"
            },
            {
              data: 'career_level',
              width: "150px"
            },
            {
              data: 'status',
              width: "100px"
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

          printWindow.document.write('<html><head><title>Employees</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child,table td:first-child,table th:first-child {display: none;}</style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Employees</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('.dataTables_filter').remove();
        $('select#status_filter').on('change', function() {
          var status = $(this).val();
          if ($(this).val() === 'all') {
            table.column(8).search('').draw();
          } else if ($(this).val() === 'active') {
            table.column(8).search('\\bactive\\b(?!\\s*inactive)', true, false).draw();
          } else {
            table.column(8).search(status, true, false).draw();
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
        $('select#department_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(4).search('').draw();
          } else {
            console.log(city);
            table.column(4).search(type).draw();
          }
        });
        $('select#job_title_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(5).search('').draw();
          } else {
            console.log(city);
            table.column(5).search(type).draw();
          }
        });
        $('select#job_type_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(6).search('').draw();
          } else {
            console.log(city);
            table.column(6).search(type).draw();
          }
        });
        $('select#career_level_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(7).search('').draw();
          } else {
            console.log(city);
            table.column(7).search(type).draw();
          }
        });
        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
        });


        $('#new_supplier').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-user.php',
            data: formData,
            processData: false,
            contentType: false,
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