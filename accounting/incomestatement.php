<?php
$pg_name = "Wonder - Income Statement";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2002) == 1) {
    if (isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['t']) && !empty($_GET['t'])) {
      $start_date = $_GET['f'];
      $end_date = $_GET['t'];
    } else {
      $start_date = date("Y-m") . "-01";
      $end_date = date("Y-m-d", strtotime(date("Y-m-d") . " +1 day"));
    }
    check_dep();
?>
    <style>
      #supplierslist4 tbody {
        display: none !important;
      }

      @media print {

        * {
          font-family: "Poppins", sans-serif;
        }

        .lside {
          display: none;
        }

        .rside {
          width: 100%;
          margin-left: 0;
        }

        .header {
          display: none;
        }

        .body {
          margin-top: 0;
        }

        .title-head {
          display: none;
        }

        table.dataTable thead th,
        table.dataTable thead td {
          width: 60% !important;
        }

        div#income-statement {
          width: 100%;
          border: 0;
          padding: 0 !important;
        }

        .att-part {
          margin: 0;
        }

        @page {
          size: A4;
          scale: 55%;
        }

        table.dataTable thead th:nth-child(2),
        table.dataTable thead td:nth-child(2) {
          width: 0px;
        }

        table.dataTable thead th:last-child,
        table.dataTable thead td:last-child {
          width: 40% !important;
        }
      }
    </style>
    <div class="att-part income-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Income Statement
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
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Income Statement</p>
        </div>
        <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
        ?>
          <div class="btns">
            <button class="export"><i class="fa-solid fa-download"></i>
              <ul class="export-options">
                <li class="option" id="ExportReporttoPdf">
                  <div><i class=" fa-solid fa-print"></i> Print List</div>
                </li>
                <!-- <li class="option btn-print" id="ExportReporttoExcel">
                  <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                </li> -->
              </ul>
            </button>
          </div>
        <?php
        }
        ?>
      </div>
      <div class="employee-section request-section income-statement" style="padding: 20px;margin-bottom:60px;" id="income-statement">
        <div class="head-of-income">
          <div class="logo_frame">
            <img src="../images/logo.png" alt="">
          </div>
          <h3>Income Statement (Profit and Loss)</h3>
          <div class="date-of-income"><?= $start_date ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $end_date ?></div>
        </div>
        <form action="" method="POST" class="list-form">
          <div class="main-table-style">
            <table id="supplierslist" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Revenue Sales</th>
                  <th></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist2" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Cost of Sales</th>
                  <th></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist5" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Other Revenue</th>
                  <th></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist3" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Expenses</th>
                  <th></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist4" style="width:100% !important;">

            </table>
          </div>
        </form>
        <div id="income-foot">...</div>
      </div>
    </div>

    <script>
      $(document).ready(function() {

        $("#supplierslist thead").click(function() {
          $("#supplierslist tbody").toggle();
          $("#supplierslist thead i").toggleClass('rotated');


        });
        $("#supplierslist2 thead").click(function() {
          $("#supplierslist2 tbody").toggle();
          $("#supplierslist2 thead i").toggleClass('rotated');


        });
        $("#supplierslist3 thead").click(function() {
          $("#supplierslist3 tbody").toggle();
          $("#supplierslist3 thead i").toggleClass('rotated');


        });
        $("#supplierslist4 thead").click(function() {
          $("#supplierslist4 tbody").toggle();
          $("#supplierslist4 thead i").toggleClass('rotated');

        });
        $("#supplierslist5 thead").click(function() {
          $("#supplierslist5 tbody").toggle();
          $("#supplierslist5 thead i").toggleClass('rotated');

        });



        var currentDate = new Date();
        var options = {
          weekday: 'long',
          month: 'long',
          day: 'numeric',
          year: 'numeric',
          hour: 'numeric',
          minute: 'numeric',
          hour12: true
        };
        var formattedDate = currentDate.toLocaleString('en-US', options);

        document.getElementById('income-foot').textContent = formattedDate;


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
            url: 'json/netsales.php',
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
          columnDefs: [{
              targets: 0,
              orderable: false,
              visible: false,
            },
            {
              targets: 1,
              orderable: false
            },
            {
              targets: 2,
              orderable: false
            },
            {
              targets: 3,
              orderable: false
            },
          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'id',
            }, {
              data: 'check',
            },
            {
              data: 'name',
              width: "30%"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        function startupBalance() {
          var net_sales = parseFloat($("#net_sales").html().replace(/,/g, ''));
          var total_costs = parseFloat($("#total_costs").html().replace(/,/g, ''));
          var total_revenue = parseFloat($("#total_rev").html().replace(/,/g, ''));
          var total_exp = parseFloat($("#total_exp").html().replace(/,/g, ''));
          var gross_income = net_sales - total_costs;
          var net_income = gross_income + total_revenue - total_exp;
          $("#gross_income").html(gross_income.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          $("#net_income_before").html(net_income.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));

          $('#income_taxes').on('input', function() {
            var inputValue = $(this).val();
            var formattedValue = formatNumber(inputValue);
            $(this).val(formattedValue);


          });
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2003) == 1) { ?>
            $('#income_taxes').on('change', function() {
              $.ajax({
                type: 'POST',
                url: 'functions/core/edit-tax.php',
                data: {
                  amount: $(this).val(),
                  date: $("#end-date-filter").val(),
                },
                success: function(data) {
                  console.log(data);
                },
              });
            });
          <?php } ?>

          function formatNumber(number) {
            // Remove any non-digit characters
            var cleanedNumber = number.replace(/\D/g, '');

            // Add trailing zero if a zero is added after non-zero digits

            // Format the number with commas
            var formattedNumber = Number(cleanedNumber).toLocaleString();

            return formattedNumber;
          }
          var inputValue = $('#income_taxes').val();
          var formattedValue = formatNumber(inputValue);
          $('#income_taxes').val(formattedValue);

          var income_taxes = parseFloat($('#income_taxes').val().replace(/,/g, ''));
          var income_before = parseFloat($('#net_income_before').html().replace(/,/g, ''));
          $("#net_income").html((income_before - income_taxes).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2003) == 1) { ?>
            $('#income_taxes').on('input', function() {
              var income_taxes = parseFloat($('#income_taxes').val().replace(/,/g, ''));
              var income_before = parseFloat($('#net_income_before').html().replace(/,/g, ''));
              $("#net_income").html((income_before - income_taxes).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }));
            });
          <?php } ?>
        };

        setTimeout(startupBalance, 500);



        var table2 = $('#supplierslist5').DataTable({
          ajax: {
            url: 'json/otherrevenue.php',
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
          columnDefs: [{
              targets: 0,
              orderable: false,
              visible: false,
            },
            {
              targets: 1,
              orderable: false
            },
            {
              targets: 2,
              orderable: false
            },
            {
              targets: 3,
              orderable: false
            },
          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'id',
            }, {
              data: 'check',
            },
            {
              data: 'name',
              width: "30%"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        var table3 = $('#supplierslist2').DataTable({
          ajax: {
            url: 'json/netcostsales.php',
            type: 'GET',
            dataSrc: '',
            data: {
              start_date: $("#create-date-filter").val(),
              end_date: $("#end-date-filter").val(),
            },
          },
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
          columnDefs: [{
              targets: 0,
              orderable: false,
              visible: false,
            },
            {
              targets: 1,
              orderable: false
            },
            {
              targets: 2,
              orderable: false
            },
            {
              targets: 3,
              orderable: false
            },
          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'id',
            }, {
              data: 'check',
            },
            {
              data: 'name',
              width: "30%"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        var table4 = $('#supplierslist3').DataTable({
          ajax: {
            url: 'json/operatingexp.php',
            type: 'GET',
            dataSrc: '',
            data: {
              start_date: $("#create-date-filter").val(),
              end_date: $("#end-date-filter").val(),
            },
          },
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
          columnDefs: [{
              targets: 0,
              orderable: false,
              visible: false,
            },
            {
              targets: 1,
              orderable: false
            },

            {
              targets: 2,
              orderable: false
            },
            {
              targets: 3,
              orderable: false
            },
          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'id',
            }, {
              data: 'check',
            },
            {
              data: 'name',
              width: "30%"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        var table5 = $('#supplierslist4').DataTable({
          ajax: {
            url: 'json/netincome.php',
            type: 'GET',
            dataSrc: '',
            data: {
              start_date: $("#create-date-filter").val(),
              end_date: $("#end-date-filter").val(),
            },
          },
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
          columnDefs: [{
              targets: 0,
              orderable: false,
              visible: false,
            },
            {
              targets: 1,
              orderable: false
            },

            {
              targets: 2,
              orderable: false
            },
            {
              targets: 3,
              orderable: false
            },
          ],
          order: [
            [0, 'asc']
          ],
          columns: [{
              data: 'id',
            }, {
              data: 'check',
            },
            {
              data: 'name',
              width: "30%"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });
        // $("#ExportReporttoExcel").on("click", function() {
        //   table.button('.buttons-csv').trigger();
        // });
        $("#ExportReporttoPdf").on("click", function() {
          event.preventDefault();
          window.print();
        });

        $('.dataTables_filter').remove();


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