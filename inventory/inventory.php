<?php
$pg_name = "Wonder - Inventory";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(606) == 1) {
    $user_info = login_info();
    import_transfer();
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Inventory</h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Inventory</p>
        </div>

        <div class="btns">

          <button class="filter"><i class="fa-solid fa-filter"></i></button>
          <button class="export"><i class="fa-solid fa-download"></i>
            <ul class="export-options">
              <li class="option" id="ExportReporttoPdf3">
                <div><i class="fa-solid fa-print"></i> Print List</div>
              </li>
              <li class="option" id="ExportReporttoExcel3">
                <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
              </li>
            </ul>
          </button>
          <div class="buttons">
            <button class="transactions">Action <i class="fa-solid fa-caret-down"></i></button>
            <ul class="transactions-list">
              <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(607) == 1) {
              ?>
                <li class="trans-option" id="trans_btn">Transfer Request</li>
            </ul>
          <?php
              }
          ?>
          </div>
        </div>

      </div>
      <div class="request-section filter-section">
        <form action="" method="POST">
          <input type="hidden" name="page" value="">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">
            <div class="inputs">
              <label for="type_filter">Supplier / Manufacturer</label>
              <select name="type" id="type_filter">
                <option value="all">All</option>
                <option value="supplier">Supplier</option>
                <option value="manufacturer">Manufacturer</option>
              </select>
            </div>
            <div class="inputs">
              <label for="warehouse_filter">Warehouse</label>
              <select name="warehouse" id="warehouse_filter">
                <option value="all">All</option>
                <option value="Not Stored">Not Stored</option>
                <?= get_warehouses_option_name() ?>
              </select>
            </div>

            <div class="inputs">
              <label for="avail_filter">Availability</label>
              <select name="avail" id="avail_filter">
                <option value="all">All</option>
                <option value="paid">On Stock</option>
                <option value="Out of Stock">Out of Stock</option>
                <option value="Short of Stock">Short of Stock</option>
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
                  <th>#</th>
                  <th>Item</th>
                  <th>Supplier/Manufacturer</th>
                  <th>Item ID</th>
                  <th>Rate (E£)</th>
                  <th>Margin</th>
                  <th>Sell Rate (E£)</th>
                  <th>Quantity</th>
                  <th>Warehouse</th>
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
          <h3>Transfer Request</h3>
          <button class="close_visible"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" id="new_supplier" action="" method="POST">
          <div class="custom-form transfer-form">
            <div class="tp-warehouse">
              <div class="wh-box">
                <div class="inputs">
                  <label for="trans_id">Transfer ID</label>
                  <input type="number" name="trans_id" id="trans_id" value="<?= get_transfer_order_number() ?>">
                </div>
              </div>
              <div class="wh-box">
                <div class="inputs">
                  <label for="resp">Responsible</label>
                  <span>
                    <div class="img_conatainer">
                      <img src="../images/ur-img/<?= $user_info['picture'] ?>" alt="">
                    </div>
                    <input type="text" name="resp_visible" id="resp" value="<?= ucfirst($user_info['name']) ?>" disabled style="width: calc(100% - 48px);">
                  </span>
                  <input type="hidden" name="resp" value="<?= $user_info['id'] ?>">
                </div>
              </div>
              <div class="wh-box">
                <div class="inputs">
                  <label for="created_date">Transfer Date</label>
                  <input type="datetime-local" name="created_date" id="created_date" value="<?= date("Y-m-d H:i") ?>">
                </div>
              </div>
              <div class="wh-box">
                <div class="inputs">
                  <label for="from_wh">From</label>
                  <select name="from_wh" id="from_wh">
                    <option value="choose">Choose Warehouse</option>
                    <?= get_warehouses_option() ?>
                  </select>
                </div>
              </div>
              <span class="arr"><i class="fa-solid fa-angles-down fa-beat"></i></span>
              <div class="wh-box">
                <div class="inputs">
                  <label for="to_wh">To</label>
                  <select name="to_wh" id="to_wh">
                    <option value="choose">Choose Warehouse</option>
                    <?= get_warehouses_option() ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="bt-warehouse">
              <div class="inputs">
                <label for="inv_search">Search by name or code</label>
                <input type="text" name="search" id="inv_search" placeholder="Ex. 62290489378">
                <ul class="suggestion suggest-inv"></ul>
              </div>
              <div class="search-list">
                <div class="search-head">
                  <div class="search-row">
                    <div>#</div>
                    <div>Item</div>
                    <div>Supplier/Manufacturer</div>
                    <div>Quantity</div>
                    <div>Cost (E£)</div>
                    <div>Sell Rate (E£)</div>
                    <div></div>
                  </div>
                </div>
                <div class="search-body">
                </div>
              </div>
            </div>
            <script class="new"></script>
          </div>
          <hr class="hr_form">
          <div class="loadings"><i class=""></i></div>
          <input type="hidden" name="add" value="Save">
          <input type="submit" class="add" value="Transfer Now">
        </form>
      </div>
      <div class="mga"></div>
      <?= inactive_list('warehouses') ?>
    </div>

    <script>
      $(document).ready(function() {


        // Transfer Functions Start
        var input = $("#trans_id");
        var value = input.val();

        while (value.length < 6) {
          value = "0" + value;
        }
        input.val(value);
        $("#trans_id").on("change", function() {
          var input = $("#trans_id");
          var value = input.val();

          while (value.length < 6) {
            value = "0" + value;
          }
          input.val(value);
        });
        $("#from_wh").on("change", function() {
          var to_id = $("#to_wh").val();
          if (to_id == $(this).val()) {
            $("#to_wh").val("choose"); // Set the value of the select element
            $("#to_wh option[value='choose']").prop("selected", true); // Set 
          }
          $(".suggest-inv .sug").remove();
          $('.search-body .search-row').remove();
        });
        $("#to_wh").on("change", function() {
          var from_id = $("#from_wh").val();
          if (from_id == $(this).val()) {
            $("#from_wh").val("choose").trigger("change"); // Set the value of the select element
            $("#from_wh option[value='choose']").prop("selected", true); // Set 
          }
        });

        $("#trans_btn").click(function() {
          var exportHeight = $(".add_new").prop("scrollHeight") + 50;
          $(".add_new").css({
            height: exportHeight + "px",
            padding: "20px 25px",
            border: "1px solid #cfcfcf",
            overflow: "visible",
          });
          $(".black_screen").fadeIn(200);
        });

        $("#inv_search").focus(function() {
          if ($("ul.suggestion").css("height") == "0px") {
            $("ul.suggestion").css({
              height: "auto",
              border: "1px solid #cfcfcf",
            });
          } else {
            $("ul.suggestion").css({
              height: "0",
              border: "0px solid #cfcfcf",
            });
          }
        });
        $("#inv_search").blur(function() {
          $("ul.suggestion").css({
            height: "0",
            border: "0px solid #cfcfcf",
          });
        });
        $("#inv_search").on("input", function() {
          $.ajax({
            type: 'POST',
            url: 'functions/core/inventory-search.php',
            data: {
              item_search: $(this).val(),
              warehouse: $("#from_wh").val(),
            },
            success: function(data) {
              $(".suggestion").html(data);
            },
          });

        });

        $(".suggestion").on("click", ".sug", function() {
          var randomNumber = Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;
          $.ajax({
            url: 'functions/core/import_transfer.php',
            type: 'POST',
            dataType: 'json',
            data: {
              sku: $(this).attr("data-id"),
            },
            success: function(data2) {
              if ($('#row' + data2.id).length == 0) {
                var len = $('.search-body .search-row').length + 1;
                $('.search-body').append('<div class="search-row" id="row' + data2.id + '"><div class="num">' + len + '</div><div><div class="flex fx-start"><div class="img-frame"><img src="../assets/items/' + data2.img + '" alt=""></div><div class="info"><div class="name">' + data2.name + '</div><div class="sku">#' + data2.item_id + '</div><input type="hidden" name="p[' + randomNumber + '][id]" value="' + data2.id + '"></div></div></div><div><div class="flex fx-start"><div class="info"><div class="name">' + data2.supp_name + '</div><div class="sku">' + data2.supp_comp + '</div></div></div></div><div><input type="number" class="item_quantity item_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" min="0" step="0.01"><span class="item_limit item_limit' + randomNumber + '" data-limit="' + data2.quantity + '">/ ' + data2.quantity + '</span></div><div>' + data2.cost + '</div><div>' + data2.sell + '</div><div><button class="delete_row" data-row="' + data2.id + '"><i class="fa-solid fa-trash"></i></button></div></div>');
                $(".item_quantity" + randomNumber).on("change", function() {
                  var limit = $(".item_limit" + randomNumber).attr("data-limit");
                  if ($(this).val() > Number(limit)) {
                    $(this).val(limit).trigger("input");
                  }
                });
                $(".delete_row").click(function(event) {
                  event.preventDefault();
                  var row_id = "row" + $(this).attr("data-row");
                  var selectedrow = document.getElementById(row_id);
                  selectedrow.remove();
                  // Update the count after removing the div
                  var count = $('.num').length;
                  // Rearrange the numbers after removing the div
                  $('.num').each(function(index) {
                    $(this).html(index + 1);
                  });
                });
              }


            }

          });



        });
        // Transfer Functions end


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
            url: 'json/inventory.php',
            type: 'GET',
            dataSrc: '',
            data: {},
          },
          buttons: [{
            extend: 'csv',
            charset: 'UTF-8',
            bom: true,
            exportOptions: {
              encoding: 'UTF-8',
              columns: ':not(:last-child)' // Exclude last column and column index 3
            },
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
            },
            {
              targets: 5,
            },
            {
              targets: 6,
            },
          ],
          order: [
            [1, 'desc']
          ],
          columns: [{
              data: 'no',
              width: "40px"
            },
            {
              data: 'name',
              width: "350px"
            },
            {
              data: 'supp_manu',
              width: "360px"
            },
            {
              data: 'item_id',
              visible: false,
            },
            {
              data: 'rate',
              width: "120px"
            },
            {
              data: 'margin',
              visible: false,
            },
            {
              data: 'sell_rate',
              width: "120px"
            },
            {
              data: 'quantity',
            },
            {
              data: 'warehouse',
            },
            {
              data: 'action',
              width: "90px"
            },
          ],
          autoWidth: true,
          responsive: true,
        });
        $("#ExportReporttoExcel3").on("click", function() {
          table.button('.buttons-csv').trigger();
        });
        $('.dataTables_filter').remove();



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

        $("#ExportReporttoPdf3").on("click", function() {
          var currentTime = getCurrentTime();
          event.preventDefault();
          var barcodeDiv = document.getElementById("supplierslist");
          var printWindow = window.open('', '');

          printWindow.document.write('<html><head><title>Inventory</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
          printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
          printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
          printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Invenvtory</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
          printWindow.document.write(barcodeDiv.innerHTML);
          printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
        });

        $('#supplierslist_wrapper').on('click', '.transfer_btn', function() {
          event.preventDefault();
        });

        $('select#type_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(2).search('').draw();
          } else if ($(this).val() === 'supplier') {
            table.column(2).search('supplier').draw();
          } else {
            table.column(2).search(type).draw();
          }
        });

        $('select#warehouse_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(-2).search('').draw();
          } else {
            table.column(-2).search(type).draw();
          }
        });

        $('select#avail_filter').on('change', function() {
          var type = $(this).val();
          if ($(this).val() === 'all') {
            table.column(-3).search('').draw();
          } else {
            table.column(-3).search(type).draw();
          }
        });



        $('#name-search').on('keyup', function() {
          var searchValue = $(this).val();
          table.search(searchValue).draw();
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