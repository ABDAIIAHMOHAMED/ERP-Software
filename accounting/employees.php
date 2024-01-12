<?php
$pg_name = "Wonder - Employees";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();

?>

  <div class="att-part">
    <div class="title-head">
      <div class="headso">
        <h3>Employees <span class="max_count">Users ( <?= users_count() ?> / 20 )</span></h3>
        <hr class="head-line">
        <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Employees</p>
      </div>
      <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
      ?>
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
          <button class="new-btn">New Employee</button>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="request-section filter-section">
      <form action="" method="POST">
        <input type="hidden" name="page" value="">
        <h6 class="fhead">Filteration</h6>
        <div class="inputs inputs-grid">
          <div class="inputs">
            <label for="cities">City</label>
            <select name="city" id="cities">
              <option value="all">All</option>
            </select>
          </div>
          <div class="inputs">
            <label for="type_filter">Type</label>
            <select name="type" id="type_filter">
              <option value="all">All</option>
              <option value="individual">Individual</option>
              <option value="company">Company</option>
            </select>
          </div>
          <div class="inputs">
            <label for="create-date-filter">Created Date</label>
            <input type="date" name="date" id="create-date-filter">
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
                <th>City</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Due Balance (E£)</th>
                <th>Status</th>
                <th>Created Time</th>
                <th>Action</th>
              </tr>
            </thead>

          </table>
        </div>
        <input type="submit" class="delete-btn" name="inactive-submit" value="Mark as Inactive">
      </form>
    </div>
    <div class="black_screen"></div>

    <div class="add_new">
      <div class="custome-head">
        <h3>New Employee</h3>
        <button class="close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form class="" id="new_supplier" action="" method="POST">
        <div class="custom-form">
          <div class="sectra">
            <span class="sm-head">General info</span>
            <?php
            if (users_count() < 20) {
            ?>
              <span class="ask">
                <label for="ask1">Will be a software user ?</label>
                <input type="checkbox" name="type" value="1" id="ask1">
              </span>
            <?php
            }
            ?>
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
                <label for="phone">Mobile</label>
                <input type="number" value="" class="" name="phone" id="phone" min="0" max="1999999999">

              </div>
              <div class="inputs gd3">
                <label for="personal_email">Personal Email</label>
                <input type="text" value="" class="" name="personal_email" id="personal_email">

              </div>
              <div class="inputs gd2">
                <label for="job_title">Job Title</label>
                <select name="job_title" id="job_title" class="">
                  <option value="headoffice">Head Office</option>
                </select>

              </div>
              <div class="inputs gd2">
                <label for="category">Category</label>
                <select name="category" id="category" class="">
                  <option value="accounting">Accounting</option>
                </select>

              </div>
              <div class="inputs gd2">
                <label for="jobtype">Type of Job</label>
                <select name="jobtype" id="jobtype" class="">
                  <option value="office">Office</option>
                </select>

              </div>
              <div class="inputs gd2">
                <label for="careerlevel">Career Level</label>
                <select name="careerlevel" id="careerlevel" class="">
                  <option value="senior">Senior</option>
                </select>

              </div>
              <div class="inputs gd4">
                <label for="salary">Net Salary</label>
                <input type="number" value="" class="" name="salary" id="salary" min="0" placeholder="0">

              </div>
              <?php
              if (users_count() < 20) {
              ?>
                <div class="inputs gd4 user-input">
                  <label for="email">Email</label>
                  <input type="text" value="" class="" name="email" id="email">
                </div>
                <div class="inputs gd2 user-input">
                  <label for="role">Role</label>
                  <select name="role" id="role">
                    <option value="1">Admin</option>
                    <option value="2">Tester</option>
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
              <div class="inputs gd3">
                <label for="birthday">Birthday</label>
                <input type="date" value="" class="" name="birthday" id="birthday">

              </div>
              <div class="inputs gd3">
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                  <option value="male">Male</option>
                  <option value="female">Femal</option>
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

    <div class="mga"></div>
    <?= inactive_list('employees') ?>
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
          url: 'json/suppliers.php',
          type: 'GET',
          dataSrc: '',
          data: {},
        },
        buttons: [{
            extend: 'csv',
            exportOptions: {
              columns: function(idx, data, node) {
                return [0, 1, 10].indexOf(idx) === -1;
              }
            }

          },
          {
            extend: 'pdfHtml5',

            customize: function(doc) {
              // Modify the PDF document here
              doc.pageSize = 'A4';
              doc.pageOrientation = 'landscape';
              doc.pageMargins = [20, 30, 20, 30];
              doc.styles.title = {
                fontSize: 18,
                bold: true,
                alignment: 'left',
                color: "#ad6420",
              };

              doc.content[1].table.body.forEach(function(row, rowIndex) {
                row.forEach(function(cell, cellIndex) {
                  if (rowIndex !== 0) {
                    cell.margin = [5, 5, 20, 5]; // Add padding (top, right, bottom, left)
                    cell.fontSize = 9;
                    cell.alignment = 'left';
                  } else {
                    cell.margin = [5, 5, 20, 5];
                    cell.fillColor = "#ad6420";
                    cell.fontSize = 10;
                    cell.bold = true;
                    cell.color = "#fff";
                    cell.alignment = 'left';
                  }
                });
              });
              console.log(doc.content[1].table);
            },
            title: "Suppliers Report",
            exportOptions: {
              columns: function(idx, data, node) {
                return [0, 1, 10].indexOf(idx) === -1;
              }
            }
          }

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
          {
            targets: 5,
            orderable: false
          },
          {
            targets: 6,
            orderable: false
          },
        ],
        order: [
          [1, 'desc']
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
            "visible": false
          },
          {
            data: 'city',
            width: "150px"
          },
          {
            data: 'phone',
            width: "120px"
          },
          {
            data: 'email',
            width: "200px"
          },
          {
            data: 'due_balance',
            width: "150px"
          },
          {
            data: 'status',
            width: "100px"
          },
          {
            data: 'created_time',
            "visible": false
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
      $("#ExportReporttoPdf").on("click", function() {
        table.button('.buttons-pdf').trigger();
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
          url: 'functions/core/add-supplier.php',
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
include "includes/footer.inc";
?>