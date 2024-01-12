<?php
$pg_name = "Wonder - Warehouses";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_id('warehouses')) {
    if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(603) == 1) {
      $info = info('warehouses');
      $stmt996 = $con->prepare("DELETE FROM `transfers` WHERE `quantity` = '0'");
      $stmt996->execute();
      import_transfer_warehouse($info['id']);
?>

      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Manage Warehouse</h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "warehouses.php" ?>">Warehouses</a>
              / Manage Warehouse</p>
          </div>
        </div>
        <div class="profile-section">
          <div class="profile-head-box">
            <div class="l-main-prof">
              <input type="hidden" id="profile_id" value="<?= $info['id'] ?>">
              <div class="l-main-prof-img">
                <img src="../images/ur-img/warehouse3.png" alt="">
              </div>
              <div class="l-main-prof-info">
                <h2><?= $info['name'] ?></h2>
                <span class="company-name">
                  <?= "WH-" . $info['code'] ?>
                </span>
                <?php
                if ($info['id'] !== 314) {
                ?>
                  <button class="add_notes">Add Notes</button>
                  <input type="hidden" id="id" name="id" value="<?= $info['id'] ?>">
                  <textarea name="quicknotes" id="notes" cols="30" rows="10" placeholder="Add Notes"><?= $info['notes'] ?></textarea>
                  <div class="notes-cont">
                    <?= $info['notes'] ?>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>

            <div class="rt-profile-head">
              <div class="buttons">
                <?php
                if ($info['id'] !== 314) {
                ?>
                  <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(604) == 1) { ?>
                    <button class="edit edit-btn">Edit</button>
                  <?php } ?>
                  <button class="transactions">New <i class="fa-solid fa-caret-down"></i></button>
                  <ul class="transactions-list">
                    <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(607) == 1) { ?>
                      <li class="trans-option" id="trans_btn">Transfer Request</li>
                    <?php } ?>
                  </ul>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <ul class="profile-lnks warehouse-lnks">
            <li class="details-lnk  active"><button id="details-lnk">Warehouse Details</button></li>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(605) == 1) { ?>
              <li class="transfer-lnk"><button id="transfer-lnk">Transfers</button></li>
            <?php } ?>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(606) == 1) { ?>
              <li class="inventory-lnk"><button id="inventory-lnk">Inventory</button></li>
            <?php } ?>
          </ul>
          <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(605) == 1) { ?>
            <div class="transfer-list listo">
              <h4 class='submarin'>Transfers</h4>
              <div class="btns">
                <button class="export export-transfer"><i class="fa-solid fa-download"></i>
                  <ul class="export-options transfer-options">
                    <li class="option" id="ExportReporttoPdf3">
                      <div><i class="fa-solid fa-print"></i> Print List</div>
                    </li>
                    <li class="option" id="ExportReporttoExcel3">
                      <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                    </li>
                  </ul>
                </button>
              </div>
              <div class="resp-table">
                <div class="serch">
                  <input type="text" id="search-filter-transfers" value="" placeholder="Search...">
                </div>
                <table id="warehousetransfer" style="width:100% !important;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Transfer</th>
                      <th>Responsible</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>

              <script>
                $(function() {

                  $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
                    var ukDate = date.split('/');
                    return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
                  };

                  var table3 = $('#warehousetransfer').DataTable({
                    ajax: {
                      url: 'json/get_transfer_item.php',
                      type: 'GET',
                      dataSrc: '',
                      data: {
                        uid: $('#profile_id').val()
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
                    order: [
                      [0, 'desc']
                    ],
                    columnDefs: [{
                        targets: -1,
                        orderable: false
                      },
                      {
                        targets: 1,
                        orderable: false
                      }
                    ],
                    columns: [{
                        data: 'no',
                        width: "40px"
                      },
                      {
                        data: 'transfer',
                      },
                      {
                        data: 'resp',
                      },
                      {
                        data: 'from',
                      },
                      {
                        data: 'to',
                      },
                      {
                        data: 'date',
                        width: '140px'
                      },
                      {
                        data: 'action',
                        width: "50px"
                      },
                    ],
                    autoWidth: false,
                    responsive: true,
                  });

                  $("#ExportReporttoExcel3").on("click", function() {
                    table3.button('.buttons-csv').trigger();
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
                    var barcodeDiv = document.getElementById("warehousetransfer");
                    var printWindow = window.open('', '');

                    printWindow.document.write('<html><head><title>Transfers for ' + $('.l-main-prof-info h2').html() + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                    printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
                    printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
                    printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Transfers for ' + $('.l-main-prof-info h2').html() + '</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
                    printWindow.document.write(barcodeDiv.innerHTML);
                    printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                  });

                  $('#search-filter-transfers').on('keyup', function() {
                    var searchValue = $(this).val();
                    table3.search(searchValue).draw();
                  });


                  $("button.export-transfer").click(function() {
                    if ($("ul.transfer-options").css("height") == "0px") {
                      var exportHeight =
                        $("ul.transfer-options").prop("scrollHeight") + 70;
                      $("ul.transfer-options").css({
                        height: exportHeight + "px",
                        padding: "20px",
                        border: "1px solid #eeee",
                        "border-bottom": "2px solid var(--main-color)",
                      });
                    } else {
                      $("ul.transfer-options").css({
                        height: "0",
                        padding: "0px",
                        border: "0px solid rgba(238, 238, 238, 0.933)",
                      });
                    }
                  });



                });
              </script>
            </div>
          <?php } ?>

          <div class="details-list">
            <div class="detail-table">
              <div class="table-col">
                <div class="table-row">
                  <div class="info-title">Warehouse Name</div>
                  <div class="info-detail">
                    <?= $info['name'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Warehouse Code</div>
                  <div class="info-detail">
                    <?= "WH-" . $info['code'] ?>
                  </div>
                </div>
                <?php
                if ($info['id'] !== 314) {
                ?>
                  <div class="table-row">
                    <div class="info-title">Phone</div>
                    <div class="info-detail">
                      <?= $info['phone'] ?>
                    </div>
                  </div>
                  <div class="table-row ex-height">
                    <div class="info-title">Address</div>
                    <div class="info-detail">
                      <?= $info['street'] . " , " . $info['state'] . "<br>" . $info['city'] . " , " . $info['country'] ?>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
              <div class="table-col">
                <div class="table-row">
                  <div class="info-title">Status</div>
                  <div class="info-detail">
                    <?php
                    if ($info['status'] == "1") {
                      echo '<span class="paid">Active</span>';
                    } else {

                      echo '<span class="closed">Inactive</span>';
                    } ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Created Date</div>
                  <div class="info-detail">
                    <?= $info['created_time'] ?>
                  </div>
                </div>
                <?php
                if ($info['id'] !== 314) {
                ?>
                  <div class="table-row ex-height">
                    <div class="info-title">Notes</div>
                    <div class="info-detail qknote">
                      <?= $info['notes'] ?>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(606) == 1) { ?>
            <div class="inventory-list listo">
              <h4 class='submarin'>Inventory</h4>
              <div class="btns">
                <button class="filter"><i class="fa-solid fa-filter"></i></button>
                <button class="export export-inventory"><i class="fa-solid fa-download"></i>
                  <ul class="export-options inventory-options">
                    <li class="option" id="ExportReporttoPdf2">
                      <div><i class="fa-solid fa-print"></i> Print List</div>
                    </li>
                    <li class="option" id="ExportReporttoExcel2">
                      <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                    </li>
                  </ul>
                </button>
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
                  </div>
                </form>
              </div>
              <div class="resp-table">
                <div class="serch">
                  <input type="text" id="search-filter-purch" value="" placeholder="Search...">
                </div>
                <table id="supplierpurch" style="width:100% !important;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Item</th>
                      <th>Supplier/Manufacturer</th>
                      <th>Referred Order</th>
                      <th>Rate (E£)</th>
                      <th>Sell Rate (E£)</th>
                      <th>Quantity</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>



              <script>
                $(function() {

                  $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
                    var ukDate = date.split('/');
                    return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
                  };

                  var table4 = $('#supplierpurch').DataTable({
                    ajax: {
                      url: 'json/warehouse_inventory.php',
                      type: 'GET',
                      dataSrc: '',
                      data: {
                        uid: $('#profile_id').val()
                      },
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
                    order: [
                      [0, 'desc']
                    ],
                    columnDefs: [{
                      targets: -1,
                      orderable: false
                    }, {
                      targets: 2,
                      orderable: false
                    }, {
                      targets: 1,
                      orderable: false
                    }],
                    columns: [{
                        data: 'item_id',
                        width: "60px"
                      },
                      {
                        data: 'item',
                        width: "350px"
                      },
                      {
                        data: 'supplier',
                        width: "270px"
                      },
                      {
                        data: 'order',
                        width: "120px"
                      },
                      {
                        data: 'rate',
                        width: "120px"
                      },
                      {
                        data: 'sell_rate',
                        width: "120px"
                      },
                      {
                        data: 'status',
                        width: "120px"
                      },
                      {
                        data: 'action',
                        width: "100px"
                      },
                    ],
                    autoWidth: false,
                    responsive: true,
                  });


                  $("#ExportReporttoExcel2").on("click", function() {
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

                  $("#ExportReporttoPdf2").on("click", function() {
                    var currentTime = getCurrentTime();
                    event.preventDefault();
                    var barcodeDiv = document.getElementById("supplierpurch");
                    var printWindow = window.open('', '');

                    printWindow.document.write('<html><head><title>Inventory for ' + $('.l-main-prof-info h2').html() + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                    printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
                    printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
                    printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Invenvtory for ' + $('.l-main-prof-info h2').html() + '</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
                    printWindow.document.write(barcodeDiv.innerHTML);
                    printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                  });

                  $('#supplierslist_wrapper').on('click', '.transfer_btn', function() {
                    event.preventDefault();
                  });

                  $('select#type_filter').on('change', function() {
                    var type = $(this).val();
                    if ($(this).val() === 'all') {
                      table4.column(2).search('').draw();
                    } else if ($(this).val() === 'supplier') {
                      table4.column(2).search('supplier').draw();
                    } else {
                      table4.column(2).search(type).draw();
                    }
                  });




                  $('#search-filter-purch').on('keyup', function() {
                    var searchValue = $(this).val();
                    table4.search(searchValue).draw();
                  });




                  $("button.export-inventory").click(function() {
                    if ($("ul.inventory-options").css("height") == "0px") {
                      var exportHeight =
                        $("ul.inventory-options").prop("scrollHeight") + 70;
                      $("ul.inventory-options").css({
                        height: exportHeight + "px",
                        padding: "20px",
                        border: "1px solid #eeee",
                        "border-bottom": "2px solid var(--main-color)",
                      });
                    } else {
                      $("ul.inventory-options").css({
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
                });
              </script>



            </div>
          <?php } ?>
        </div>
        <div class="black_screen"></div>
        <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(604) == 1) { ?>
          <div class="add_new edit_supplo">
            <div class="custome-head">
              <h3>Edit Warehouse</h3>
              <button class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form class="" id="edit_supplier" action="" method="POST">
              <div class="custom-form">
                <div class="sectra">
                  <span class="sm-head">Warehouse info</span>
                  <span class="ask">
                    <label for="ask">Active ?</label>
                    <input type="checkbox" name="status" value="1" <?php if ($info['status'] == 1) {
                                                                      echo "checked";
                                                                    } ?>>
                  </span>
                  <div class="form-section">
                    <div class="inputs gd2 code-ext">
                      <label for="fname">Code</label>
                      <input type="number" value="<?= $info['code'] ?>" class="" name="code" id="code" min="0" required disabled>
                    </div>
                    <div class="inputs gd4">
                      <label for="name">Name</label>
                      <input type="text" value="<?= $info['name'] ?>" class="" name="name" id="name" required>
                    </div>
                    <div class="inputs gd6">
                      <label for="phone">Phone Number</label>
                      <input type="number" value="<?= $info['phone'] ?>" class="" name="phone" id="phone" min="0" max="1999999999">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd6">
                      <label for="note">Notes</label>
                      <textarea name="notes" id="note" cols="30" rows="10"><?= $info['notes'] ?></textarea>
                      <span class="error-field"></span>
                    </div>
                  </div>
                </div>
                <div class="sectra">
                  <span class="sm-head">Address</span>
                  <div class="form-section">
                    <div class="inputs gd6">
                      <label for="street">Street</label>
                      <textarea name="street" id="street" cols="30" rows="10"><?= $info['street'] ?></textarea>
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd3">
                      <label for="city">City/Town</label>
                      <input type="text" id="city" value="<?= $info['city'] ?>" class="" name="city">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd3">
                      <label for="state">State</label>
                      <input type="text" id="state" value="<?= $info['state'] ?>" class="" name="state">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd3">
                      <label for="postal">Postal Code</label>
                      <input type="text" value="<?= $info['postal'] ?>" class="" name="postal" id="postal">
                      <span class=" error-field"></span>
                    </div>
                    <div class="inputs gd3">
                      <label for="country">Country</label>
                      <?php $mycountry = ip_info($_SERVER['REMOTE_ADDR'], "Country"); ?>
                      <select name="country" id="country" class='' required>
                        <?php
                        $countries = countries();
                        foreach ($countries as $key => $country) {
                          echo "<option value='$country'";
                          if (isset($_POST['country']) && $_POST['country'] == $country) {
                            echo "selected";
                          } elseif ($country == $info['country']) {
                            echo "selected";
                          }
                          echo ">$country</option>";
                        }
                        ?>
                      </select>
                      <span class="error-field"></span>
                    </div>
                  </div>

                </div>
              </div>
              <hr class="hr_form">
              <div class="loadings"><i class=""></i></div>
              <input type="hidden" name="id" id="warehouse_id" value="<?= $info['id'] ?>">
              <input type="hidden" name="edit" value="Save">
              <input type="submit" class="add" value="Save">
            </form>
          </div>
        <?php } ?>

        <div class="add_new edit_transfer">
          <div class="custome-head">
            <h3>Transfer Request</h3>
            <button class="close_visible"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" id="new_supplier" action="" method="POST">
            <div class="custom-form transfer-form">
              <div class="tp-warehouse">
                <div class="wh-box">
                  <div class="inputs">
                    <label for="edit_trans_id">Transfer ID</label>
                    <input type="number" name="trans_id" id="edit_trans_id" value="..." disabled>
                  </div>
                </div>
                <div class="wh-box">
                  <div class="inputs">
                    <label for="edit_resp">Responsible</label>
                    <span>
                      <div class="img_conatainer">
                        <img src="../images/ur-img/profile3.png" id="resp_img" alt="">
                      </div>
                      <input type="text" name="resp_visible" id="edit_resp" value="..." disabled style="width: calc(100% - 48px);">
                    </span>
                  </div>
                </div>
                <div class="wh-box">
                  <div class="inputs">
                    <label for="edit_created_date">Transfer Date</label>
                    <input type="datetime-local" name="created_date" id="edit_created_date" value="" disabled>
                  </div>
                </div>
                <div class="wh-box">
                  <div class="inputs">
                    <label for="edit_from_wh">From</label>
                    <select name="from_wh" id="edit_from_wh" disabled style="opacity:1;">
                      <option value="choose">Choose Warehouse</option>
                      <?= get_warehouses_option() ?>
                    </select>
                  </div>
                </div>
                <span class="arr"><i class="fa-solid fa-angles-down fa-beat"></i></span>
                <div class="wh-box">
                  <div class="inputs">
                    <label for="edit_to_wh">To</label>
                    <select name="to_wh" id="edit_to_wh" disabled style="opacity:1;">
                      <option value="choose">Choose Warehouse</option>
                      <?= get_warehouses_option() ?>
                      <option value="314">Manufacturing Warehouse</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="bt-warehouse">
                <div class="search-list">
                  <div class="search-head">
                    <div class="search-row">
                      <div>#</div>
                      <div>Item</div>
                      <div>Quantity</div>
                      <div>Unit</div>
                      <div>Cost (E£)</div>
                      <div>Total Cost (E£)</div>
                    </div>
                  </div>
                  <div class="search-body search-body-edit">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="add_new new_transfer">
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
                  <div class="search-body search-body-view">
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
      </div>
      <script>
        $(document).ready(function() {
          var warehouse_id = $("#warehouse_id").val();
          $("#from_wh").val(warehouse_id);
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
            var exportHeight = $(".new_transfer").prop("scrollHeight") + 50;
            $(".new_transfer").css({
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
                  var len = $('.search-body-view .search-row').length + 1;
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
                    var count = $('.search-body-view .num').length;
                    // Rearrange the numbers after removing the div
                    $('.search-body-view .num').each(function(index) {
                      $(this).html(index + 1);
                    });
                  });
                }


              }

            });



          });
          // Transfer Functions end










          // Transfer View
          $("button.close_visible").click(function() {
            $(".black_screen").fadeOut(200);
            $(".edit_transfer").css({
              height: "0px",
              padding: "0px",
              border: "0px solid #cfcfcf",
              overflow: "hidden",
            });
          });
          $('#warehousetransfer').on('click', 'button.view_purchase', function() {
            var exportHeight = $(".edit_transfer").prop("scrollHeight") + 50;
            $(".edit_transfer").css({
              height: exportHeight + "px",
              padding: "20px 25px",
              border: "1px solid #cfcfcf",
              overflow: "visible",
            });
            $(".black_screen").fadeIn(200);

            $.ajax({
              url: 'json/get_tranfer_page.php',
              type: 'POST',
              dataType: 'json',
              data: {
                order_id: $(this).attr("btn-data"),
              },
              success: function(data) {
                $("#edit_trans_id").val(data.id).trigger("change");
                $("#edit_resp").val(data.resp_name);
                $("#edit_created_date").val(data.date);
                $("#edit_from_wh").val(data.from);
                $("#edit_to_wh").val(data.to);
                $("#edit_resp_img").attr("src", "../images/ur-img/" + data.resp_img);

              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });

            $("#trans_id").on("change", function() {
              var input = $("#trans_id");
              var value = input.val();

              while (value.length < 6) {
                value = "0" + value;
              }
              input.val(value);
            });

            $.ajax({
              url: 'json/get_transfer_list.php',
              type: 'POST',
              dataType: 'json',
              data: {
                order_id: $(this).attr("btn-data"),
              },
              success: function(data2) {
                $(".search-body-edit .search-row").remove();
                $.each(data2, function(index, value) {
                  var objectString = '';
                  $.each(value, function(key, val) {
                    objectString += key + ': ' + val + ', ';
                  });
                  $('.search-body-edit').append('<div class="search-row"><div>' + value.no + '</div><div><div class="flex fx-start"><div class="img-frame"><img src="../assets/items/' + value.item_img + '" alt=""></div><div class="info"><div class="name">' + value.item_name + '</div><div class="sku">#' + value.item_id + '</div></div></div></div><div>' + value.item_quantity + '</div><div>' + value.item_unit + '</div><div>' + value.item_amount + '</div><div>' + value.item_total + '</div></div>');
                });
              },
              error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.log(xhr.responseText);
              }
            });


          });



          // Transfer View




          $("ul.warehouse-lnks li.transfer-lnk button#transfer-lnk").click(function() {
            $("li.transfer-lnk").addClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").show();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
            window.localStorage["warehouse-menu"] = "transfer";
          });
          $("ul.warehouse-lnks li.details-lnk button#details-lnk").click(function() {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").addClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").show();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
            window.localStorage["warehouse-menu"] = "details";
          });
          $("ul.warehouse-lnks li.orders-lnk button#orders-lnk").click(function() {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").addClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").show();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
            window.localStorage["warehouse-menu"] = "orders";
          });
          $("ul.warehouse-lnks li.stocktake-lnk button#stocktake-lnk").click(function() {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").addClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").show();
            $(".inventory-list").hide();
            window.localStorage["warehouse-menu"] = "stocktake";
          });
          $("ul.warehouse-lnks li.inventory-lnk button#inventory-lnk").click(function() {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").addClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").show();
            window.localStorage["warehouse-menu"] = "inventory";
          });

          if (window.localStorage["warehouse-menu"] == "transfer") {
            $("li.transfer-lnk").addClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").show();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
          } else if (window.localStorage["warehouse-menu"] == "orders") {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").addClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").show();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
          } else if (window.localStorage["warehouse-menu"] == "stocktake") {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").addClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").show();
            $(".inventory-list").hide();
          } else if (window.localStorage["warehouse-menu"] == "inventory") {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").addClass("active");
            $(".transfer-list").hide();
            $(".details-list").hide();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").show();
          } else {
            $("li.transfer-lnk").removeClass("active");
            $("li.details-lnk").addClass("active");
            $("li.orders-lnk").removeClass("active");
            $("li.stocktake-lnk").removeClass("active");
            $("li.inventory-lnk").removeClass("active");
            $(".transfer-list").hide();
            $(".details-list").show();
            $(".orders-list").hide();
            $(".stocktake-list").hide();
            $(".inventory-list").hide();
          }










          $("#supplierpurch").on("click", ".re_order_btn", function() {


            $.ajax({
              url: 'json/re_order_material.php',
              type: 'POST',
              dataType: 'json',
              data: {
                item_id: $(this).attr("re-order-data"),
              },
              success: function(data) {
                var rate = data.rate;
                var rate_format = rate.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                });
                $("#vat").val("0");
                $(".item_name1").val(data.name);
                $(".item_id1").val(data.item_id);
                $("input[name='p[1][description]']").val(data.desc);
                $(".item_unit1").val(data.unit);
                $(".item_quantity1").val(1);
                $(".item_amount1").val(data.rate);
                $(".item_total1").val(data.rate);
                $("#due_balance").val(data.rate);
                $(".subtotal-amount").html("E£ " + rate_format);
                $(".total-amount").html("E£ " + rate_format);
                $(".due-balance strong").html("E£ " + rate_format);
                $("#subtotal_purchase").val(data.rate);
                $("#total_purchase").val(data.rate);
                $("#vat_amount").val(0);
                console.log(data);
              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });




            if ($(".invoice-page").css("height") == "0px") {
              $(".invoice-page").css({
                height: "100vh",
                "border-bottom": "1px solid #cfcfcf",
              });
            }
          });





          $('#suppliertrans').on('click', 'button.view_purchase', function() {
            $.ajax({
              url: 'json/get_purchase_page.php',
              type: 'POST',
              dataType: 'json',
              data: {
                order_id: $(this).attr("btn-data"),
              },
              success: function(data) {
                $("#order_title").html("Purchase Order #" + data.order_id);
                $(".order_edit_id").val(data.order_id);
                $(".curr_name").html(data.supplier_name);
                $(".curr_status").html(data.status);
                $(".curr_vat_perc").html(data.vat_perc);
                $(".curr_subtotal_amount").html(data.subtotal);
                $(".curr_total_vat").html(data.vat_amount);
                $(".curr_total_amount").html("E£ " + data.order_total);
                $("#curr_total").val(data.order_total);
                $("#curr_due").val(data.balance_due);
                $(".old_paid").val(data.paid);
                $(".order_edit_supplier_id").val(data.supplier_id);
                $("#old_due").val(data.old_balance);
                $(".curr_due_date").html(data.due_to);
                $(".mg-invoice-go").html(data.hardcopy);
                $(".curr_balance_due").html("E£ " + data.balance_due);
                $(".curr_due_date_input").val(data.due_to);
                $(".curr_create_date").html(data.created_time);
                if (data.storable == "0") {
                  $("#curr_storable").prop('checked', false);
                  $("#curr_storable").prop('disabled', true);
                } else {
                  $("#curr_storable").prop('checked', true);
                  $("#curr_storable").prop('disabled', true);
                }
                $(".curr_warehouse").html(data.warehouse_name);

                if (data.received == "0") {
                  $("#curr_received").prop('checked', false);
                  $("#curr_received").prop('disabled', false);
                } else {
                  $("#curr_received").prop('checked', true);
                  $("#curr_received").prop('disabled', true);
                }

              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
            });


            $.ajax({
              url: 'json/get_purchase_list.php',
              type: 'POST',
              dataType: 'json',
              data: {
                order_id: $(this).attr("btn-data"),
              },
              success: function(data2) {
                $("#inv-edit-list .request-row").remove();
                $.each(data2, function(index, value) {
                  var objectString = '';
                  $.each(value, function(key, val) {
                    objectString += key + ': ' + val + ', ';
                  });

                  $('#inv-edit-list').append('<div class="request-row"><div></div><div><div class="val">' + value.item_name + '</div></div><div><div class="val">' + value.item_desc + '</div></div><div><div class="val">' + value.item_quantity + '</div></div><div><div class="val">' + value.item_unit + '</div></div><div><div class="val">' + value.item_amount + '</div></div><div><div class="val">' + value.item_total + '</div></div><div></div>');
                });
              },
              error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.log(xhr.responseText);
              }
            });

            if ($(".edit-invoice-page").css("height") == "0px") {
              $(".edit-invoice-page").css({
                height: "100vh",
                "border-bottom": "1px solid #cfcfcf",
              });
            }


          });














          $("#amount_payment").on("change", function() {
            var total_due_changed = $("#payment_old_due").val() - $(this).val();
            if ($("#refer_order").val() !== "custom") {
              $(".payment_due").html(total_due_changed.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }));
              if ($(".payment_due").html() == "0.00") {
                $(this).css({
                  "color": "green"
                });
              } else {
                $(this).css({
                  "color": "var(--alt-color)"
                });
              }
            }
          });

          $("#refer_order").on("change", function() {
            if ($("#refer_order").val() !== "custom") {

              $.ajax({
                type: "POST",
                url: "json/order_payment_details.php",
                dataType: 'json',
                data: {
                  order_id: $(this).val(),
                },
                success: function(data) {
                  var total_paid = data.due - $("#amount_payment").val();
                  if (data.due == "0.00") {
                    var total_due_formated = 0.00;
                  } else {

                    var total_due_formated = total_paid.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    });
                    var total = Number(data.total);
                    var due = Number(data.due);
                    var total_formated = total.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    });
                    var due_formated = due.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    });
                  }
                  $(".payment_total").html((total_formated).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }));
                  $("#payment_old_due").val(data.due);
                  $(".old_payment_due").html(due_formated);
                  $(".payment_due").html(total_due_formated);
                  $(".order_payment_st").css({
                    "opacity": data.opacity
                  });
                  if (due == $("#amount_payment").val()) {
                    $("#amount_payment").css({
                      "color": "green"
                    });
                  } else {
                    $("#amount_payment").css({
                      "color": "var(--alt-color)"
                    });
                  }
                },
              });

            } else {
              $(".order_payment_st").css({
                "opacity": "0.2"
              });
              $(".payment_total").html("0.00");
              $(".old_payment_due").html("0.00");
              $(".payment_due").html("0.00");
              $("#amount_payment").css({
                "color": "var(--alt-color)"
              });
            }
          });

          $("#notes").change(function() {
            $.ajax({
              type: 'POST',
              url: 'functions/core/quicknotes.php',
              data: {
                id: $("#id").val(),
                quicknotes: $("#notes").val(),
                type: 'warehouses',
              },
              success: function(data) {
                $(".notes-cont").html(data);
                $(".qknote").html(data);
              },
            });
          });
          $("#storable").change(function() {

            if ($(this).is(":checked")) {
              $(".warehouse_input").show();
              $("#warehouse").addAttr("required");
            } else {
              $(".warehouse_input").hide();
              $("#warehouse").removeAttr("required");
            }
          });

          $(".inv-body").on("submit", function() {
            $(".inv-body input").prop("disabled", false);
          });
          $(".item_quantity1").on("input", function() {
            var new_amount = $(this).val() * $(".item_amount1").val();
            $(".item_total1").val(new_amount).trigger("change");
          });
          $(".item_amount1").on("input", function() {
            var new_amount = $(this).val() * $(".item_quantity1").val();
            $(".item_total1").val(new_amount).trigger("change");
          });

          $(".item_name1").on("input", function() {
            $.ajax({
              type: 'POST',
              url: 'functions/core/item-search.php',
              data: {
                item_search: $(this).val(),
              },
              success: function(data) {
                $(".suggestion1").html(data);
              },
            });

          });




          $(".suggestion1").on("click", ".sug", function() {
            $.ajax({
              type: "POST",
              url: "functions/core/import_item_details.php",
              data: {
                data_id: $(this).attr("data-id"),
              },
              dataType: "json",
              success: function(data) {
                var name = data.name;
                var amount = data.amount;
                var id = data.id;
                var unit = data.unit;
                $(".item_name1").val(name);
                $(".item_amount1").val(amount);
                $(".item_unit1").val(unit);
                $(".item_id1").val(id);
                $(".item_quantity1").val(1);
                $(".item_total1").val(amount).trigger("change");
              },
            });

          });



          $("#inv-list").on("change", ".item_total", function() {
            var total = 0;
            $("#inv-list .item_total").each(function() {
              var value = parseFloat($(this).val());
              total += value;

            });
            console.log(total);
            var paid = $("#paid").val();
            var vat_perc = $("#vat").val() / 100;
            var total_vat = vat_perc * total;
            var total_amount = (total_vat + total);
            var total_due = total_amount - paid;
            $(".due-balance strong").html("E£ " + total_due.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".total_vat").html("E£ " + total_vat.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".total-amount").html("E£ " + total_amount.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".subtotal-amount").html("E£ " + total.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total_due);
            $("#vat_amount").val(total_vat);
            $("#subtotal_purchase").val(total);
            $("#total_purchase").val(total_amount);

          });

          $("#paid").on("change", function() {
            var paid = $(this).val();
            var total_purchase = $("#total_purchase").val();
            var total = total_purchase - paid;
            $(".due-balance strong").html("E£ " + total.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total);
          });

          $("#vat").on("change", function() {
            var vat_perc = $(this).val() / 100;
            var total = parseFloat($("#subtotal_purchase").val());
            var paid = parseFloat($("#paid").val());
            if (!paid) {
              var paid = 0;
            }
            var total_vat = vat_perc * total;
            var total_amount = (total_vat + total);
            var total_due = total_amount - paid;
            $(".total_vat").html("E£ " + total_vat.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".due-balance strong").html("E£ " + total_due.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".total-amount").html("E£ " + total_amount.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $(".subtotal-amount").html("E£ " + total.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total_due);
            $("#vat_amount").val(total_vat);
            $("#subtotal_purchase").val(total);
            $("#total_purchase").val(total_amount);
          });

          $('#new_item').submit(function(event) {
            event.preventDefault(); // prevent default form submission
            $("#new_item input").prop("disabled", false);
            var formData = new FormData(this);
            $.ajax({
              type: 'POST',
              url: 'functions/core/add-material.php',
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
              },
            });
            $(this)[0].reset();
          });


          $('#edit_supplier').submit(function(event) {
            event.preventDefault(); // prevent default form submission
            $.ajax({
              type: 'POST',
              url: 'functions/core/edit-warehouse.php',
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
          });

          var fileInput = document.getElementById('item_img_input');
          var imagePreview = document.getElementById('preview_item_img');

          fileInput.addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.addEventListener('load', function() {
              imagePreview.src = reader.result;
            });

            reader.readAsDataURL(file);
          });

          let list = document.getElementById("inv-list");
          Sortable.create(list, {
            animation: 500,
            handle: ".handle",

          });





        });
      </script>

<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/warehouses.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/warehouses.php");
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