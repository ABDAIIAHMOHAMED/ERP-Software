<?php
$pg_name = "Wonder - Balance Sheet";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2002) == 1 && check_user_role(2004) == 1) {
    if (isset($_GET['f']) && !empty($_GET['f']) && isset($_GET['t']) && !empty($_GET['t'])) {
      $start_date = $_GET['f'];
      $trim_year = substr($_GET['t'], 0, 4);
      $end_date = $trim_year . "-12-31";
    } else {
      $start_date = "0001-01-01";
      $end_date = date('Y') . "-12-31";
      $trim_year = substr($end_date, 0, 4);
    }
    check_dep();
?>
    <style>
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

        /* table.dataTable thead th,
      table.dataTable thead td {
        width: 60% !important;
      } */

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
          width: 120px !important;
        }

        table.dataTable thead th:first-child,
        table.dataTable thead td:first-child {
          width: 390px !important;
        }


      }
    </style>

    <div class="att-part income-part vat-part balance-sheet">
      <div class="title-head">
        <div class="headso">
          <h3>Balance Sheet
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
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Balance Sheet</p>
        </div>
        <?php if (check_user_role(1) == 1 || check_user_role(4) == 1 || check_user_role(5) == 1) {
        ?>
          <div class="btns">
            <button class="export"><i class="fa-solid fa-download"></i>
              <ul class="export-options">
                <li class="option" id="ExportReporttoPdf">
                  <div><i class=" fa-solid fa-print"></i> Print List</div>
                </li>
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
          <h3>Balance Sheet</h3>
          <div class="date-of-income"><?= $end_date ?></div>
        </div>

        <form action="" method="POST" class="list-form">
          <div class="main-table-style">

            <h2 class="head_of_sheet">Assets</h2>
            <table id="dates" style="width:100% !important;border: 0;">
              <thead style="border: 0;outline: 0;">
                <tr>
                  <th style="width: 60%;text-align: left;"></th>
                  <th style="text-align: left;">Dec 31, <?= date("Y", strtotime($end_date . " -1 year")) ?></th>
                  <th style="text-align: left;">Dec 31, <?= date("Y", strtotime($end_date)) ?></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist2" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Non-Current Assets:</th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist3" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Current Assets:</th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist4" style="width:100% !important;">
            </table>
            <h2 class="head_of_sheet">Liabilities</h2>
            <table id="supplierslist5" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Non-Current Liabilities:</th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist6" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Current Liabilities:</th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <h2 class="head_of_sheet">Stockholders' Equity</h2>
            <table id="supplierslist7" style="width:100% !important;">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Stockholders Equity:</th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                  <th><i class="fa-solid fa-caret-down"></i></th>
                </tr>
              </thead>
            </table>
            <table id="supplierslist8" style="width:100% !important;">

            </table>
          </div>
        </form>
        <div id="income-foot">...</div>

      </div>
    </div>
    <?php
    $first_year = $trim_year . "-01-01";
    $start_date_income = $first_year;


    $last_end_date = date("Y-m-d", strtotime($end_date . " -1 year"));
    $trim_year = substr($last_end_date, 0, 4);
    $start_last = $trim_year . "-01-01";
    $last_start_date = date("Y-m-d", strtotime($last_end_date . "-1 year"));
    ?>
    <iframe id="current_income" src="<?php $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
                                      echo $path . "/incomestatement.php?f=" . $start_date_income . "&t=" . $end_date; ?>" style="display:none !important;">

    </iframe>
    <iframe id="current_income_last" src="<?php $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                          $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
                                          echo $path . "/incomestatement.php?f=" . $start_last . "&t=" . $last_end_date; ?>" style="display:none !important;">

    </iframe>
    <iframe id="last_income" src="<?php $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
                                  echo $path . "/incomestatement.php?f=" . $start_date . "&t=" . $last_end_date; ?>" style="display:none !important;">

    </iframe>
    <iframe id="last_income_last" src="<?php $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                                        $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
                                        echo $path . "/incomestatement.php?f=" . $start_date . "&t=" . $last_start_date; ?>" style="display:none !important;">

    </iframe>
    <script>
      $(document).ready(function() {
        function start2() {
          var iframe = $('#current_income'); // or some other selector to get the iframe
          var income = iframe.contents().find('#net_income').text();
          $("#earn").html(income);
          var iframe_last = $('#last_income'); // or some other selector to get the iframe
          var income_last = iframe_last.contents().find('#net_income').text();
          $("#ret_earn").html(income_last);

          var iframe_last = $('#current_income_last'); // or some other selector to get the iframe
          var income_last = iframe_last.contents().find('#net_income').text();
          $("#earn_last").html(income_last);



          var iframe_last = $('#last_income_last'); // or some other selector to get the iframe
          var income_last = iframe_last.contents().find('#net_income').text();
          $("#ret_earn_last").html(income_last);


          // alert(income);
        }
        setTimeout(start2, 2000);


        function start3() {
          var capital = parseFloat($("#capital").html().replace(/,/g, ''));
          var ret_earn = parseFloat($("#ret_earn").html().replace(/,/g, ''));
          var earn = parseFloat($("#earn").html().replace(/,/g, ''));
          var total_stock = capital + ret_earn + earn;
          $("#total_stock").html(total_stock.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));




          var last_capital = parseFloat($("#last_capital").html().replace(/,/g, ''));
          var last_ret_earn = parseFloat($("#ret_earn_last").html().replace(/,/g, ''));
          var last_earn = parseFloat($("#earn_last").html().replace(/,/g, ''));
          var last_total_stock = last_capital + last_ret_earn + last_earn;
          $("#last_total_stock").html(last_total_stock.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));


          var total_lia = parseFloat($("#total_lia").html().replace(/,/g, ''));
          var last_total_lia = parseFloat($("#last_total_lia").html().replace(/,/g, ''));


          var total_stock_lia = total_stock + total_lia;
          var last_total_stock_lia = last_total_stock + last_total_lia;

          $("#total_stock_lia").html(total_stock_lia.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          $("#last_total_stock_lia").html(last_total_stock_lia.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));


        }
        setTimeout(start3, 3000);

        function startupBalance() {
          var past_total_non_curr_assets = parseFloat($("#past_total_non_curr_assets").html().replace(/,/g, ''));
          var total_non_curr_assets = parseFloat($("#total_non_curr_assets").html().replace(/,/g, ''));
          var past_total_curr_assets = parseFloat($("#past_total_curr_assets").html().replace(/,/g, ''));
          var total_curr_assets = parseFloat($("#total_curr_assets").html().replace(/,/g, ''));
          var past_total_assets = past_total_curr_assets + past_total_non_curr_assets;
          var total_assets = total_curr_assets + total_non_curr_assets;
          $("#past_total_assets").html(past_total_assets.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          $("#total_assets").html(total_assets.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));





          // var total_non_curr_lia = parseFloat($("#total_non_curr_lia").html().replace(/,/g, ''));
          // var last_total_non_curr_lia = parseFloat($("#last_total_non_curr_lia").html().replace(/,/g, ''));
          var total_non_curr_lia = parseFloat($("#total_non_curr_lia").html().replace(/,/g, ''));
          var total_curr_lia = parseFloat($("#total_curr_lia").html().replace(/,/g, ''));

          var last_total_curr_lia = parseFloat($("#last_total_curr_lia").html().replace(/,/g, ''));
          var last_total_non_curr_lia = parseFloat($("#last_total_non_curr_lia").html().replace(/,/g, ''));

          var total_lia = total_non_curr_lia + total_curr_lia;
          var last_total_lia = last_total_non_curr_lia + last_total_curr_lia;


          $("#total_lia").html(total_lia.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          $("#last_total_lia").html(last_total_lia.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
        };

        setTimeout(startupBalance, 800);









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



        var table = $('#supplierslist2').DataTable({
          ajax: {
            url: 'json/balance/fixedassets.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        var table = $('#supplierslist3').DataTable({
          ajax: {
            url: 'json/balance/currentassets.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });

        var table = $('#supplierslist4').DataTable({
          ajax: {
            url: 'json/balance/totalassets.php',
            type: 'GET',
            dataSrc: '',
            data: {},
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });




        var table = $('#supplierslist5').DataTable({
          ajax: {
            url: 'json/balance/longtermliab.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });


        var table = $('#supplierslist6').DataTable({
          ajax: {
            url: 'json/balance/currentliab.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });





        var table = $('#supplierslist7').DataTable({
          ajax: {
            url: 'json/balance/stockholders.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });



        var table = $('#supplierslist8').DataTable({
          ajax: {
            url: 'json/balance/totalliabtock.php',
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
              width: "150px"
            },
            {
              data: 'type',
              width: "150px"
            },

          ],
          autoWidth: true,
          responsive: true,
        });
















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