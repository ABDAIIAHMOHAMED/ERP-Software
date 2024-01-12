<?php
$pg_name = "Wonder - Customers";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_id('customers')) {
    $info = info('customers');
    if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(103) == 1) {
      import_customer_purchase();
      edit_customer_purchase();
      import_quick_sell_payment();
      delete_order("sell_orders");
?>
      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Customer Profile</h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "customers.php" ?>">Customers</a>
              / Customer Profile</p>
          </div>
        </div>
        <div class="profile-section">
          <div class="profile-head-box">
            <div class="l-main-prof">
              <input type="hidden" id="profile_id" value="<?= $info['id'] ?>">
              <div class="l-main-prof-img">
                <img src="../images/ur-img/<?php if ($info['is_company'] == "0") {
                                              echo "profile3.png";
                                            } else {
                                              echo "company3.png";
                                            }
                                            ?>" alt="">
              </div>
              <div class="l-main-prof-info">
                <h2>
                  <?php
                  if ($info['is_company'] == "0") {
                    echo $info['first_name'] . " " . $info['middle_name'] . " " . $info['last_name'];
                  } else {
                    echo $info['company_name'];
                  }
                  ?>
                </h2>
                <span class="company-name">
                  <?php
                  if ($info['is_company'] == "0") {
                    if (empty($info['company_name'])) {
                      echo "Individual";
                    } else {
                      echo "<span class='cname'>Individual on </span>" . $info['company_name'];
                    }
                  } else {
                    echo "Company";
                  }
                  ?>
                </span>
                <button class="add_notes">Add Notes</button>
                <input type="hidden" id="id" name="id" value="<?= $info['id'] ?>">
                <textarea name="quicknotes" id="notes" cols="30" rows="10" placeholder="Add Notes"><?= $info['notes'] ?></textarea>
                <div class="notes-cont">
                  <?= $info['notes'] ?>
                </div>
              </div>
            </div>

            <div class="rt-profile-head">
              <div class="buttons">
                <?php
                if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(104) == 1) {
                ?>
                  <button class="edit edit-btn">Edit</button>
                <?php } ?>
                <button class="transactions">New <i class="fa-solid fa-caret-down"></i></button>
                <ul class="transactions-list">
                  <?php
                  if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(107) == 1) {
                  ?>
                    <li class="trans-option" id="invoice-btn">Sale Invoice</li>
                  <?php } ?>
                  <?php
                  if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(108) == 1) {
                  ?>
                    <li class="trans-option" id="payment-btn">Receive Money</li>
                  <?php } ?>
                  <?php
                  if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(107) == 1) {
                  ?>
                    <li class="trans-option" id="return-btn">Return Order</li>
                  <?php } ?>
                </ul>
              </div>
              <div class="dues">
                <div class="due open-dues">
                  <span class="due-value"><span>E£</span>
                    <?= get_sell_due() ?>
                  </span>
                  <span class="due-title">BALANCE DUE</span>
                </div>
                <!-- <div class="due over-dues">
                  <span class="due-value">E£
                    
                  </span>
                  <span class="due-title">OVERDUE</span>
                </div> -->
              </div>
            </div>
          </div>
          <ul class="profile-lnks customer">
            <li class="details-lnk  active"><button id="details-lnk">Customer Details</button></li>
            <?php
            if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(105) == 1) {
            ?>
              <li class="mony-lnk"><button id="mony-lnk">Account Statement</button></li>
            <?php } ?>
            <?php
            if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(106) == 1) {
            ?>
              <li class="transaction-lnk"><button id="transaction-lnk">Orders</button></li>
            <?php } ?>
          </ul>
          <?php
          if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(105) == 1) {
          ?>
            <div class="mony-list listo">
              <h4 class='submarin'>Customer Account Statement
                <div class="inputs">
                  <label for="start-date-filter-trans">From Date </label>
                  <input type="date" name="date" id="start-date-filter-trans" value="<?= date("Y-m") . "-01" ?>">
                </div>
                <div class="inputs">
                  <label for="end-date-filter-trans">To </label>
                  <input type="date" name="date" id="end-date-filter-trans" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>">
                </div>
              </h4>
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

              <div class="resp-table">
                <table id="suppliertrans" style="width:100% !important;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Statement</th>
                      <th>Refered Order</th>
                      <th>Payment Method</th>
                      <th>Created Date</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>Open Balance</th>
                      <th id="open_balance_trans">E£ 0.00</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>







              <script>
                $(function() {
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

                  var table2 = $('#suppliertrans').DataTable({

                    ajax: {
                      url: 'json/selltrans.php',
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
                      },
                      filename: $(".l-main-prof-info h2").html() + '\'s Account Statement', // Set the desired filename
                    }],
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
                    "footerCallback": function(row, data, start, end, display) {
                      var api = this.api();
                      var colIndex = 5; // Set the index of the first column to calculate the sum for
                      var colIndex2 = 6; // Set the index of the first column to calculate the sum for
                      var colIndex3 = 7; // Set the index of the first column to calculate the sum for

                      var colData = api.column(colIndex, {
                        page: 'current'
                      }).data();
                      var total = 0;
                      var colData2 = api.column(colIndex2, {
                        page: 'current'
                      }).data();
                      var total2 = 0;


                      // Get the data of the desired column (column index: 3)

                      var lastValue = 0;

                      // Get the visible rows and iterate through them
                      api.rows({
                        filter: 'applied'
                      }).every(function(rowIdx, tableLoop, rowLoop) {
                        var columnValue = this.cell(rowIdx, 7).data();

                        // Update the 'lastValue' variable with the current value
                        lastValue = columnValue;
                      });
                      // Get the last row value



                      var total = api.column(colIndex, {
                        page: 'current'
                      }).data().sum();
                      var total2 = api.column(colIndex2, {
                        page: 'current'
                      }).data().sum();


                      var footer = api.column(colIndex).footer();
                      var footer2 = api.column(colIndex2).footer();
                      $(api.column(colIndex3).footer()).html('E£ ' + lastValue);
                      $(footer).html('E£ ' + total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    },
                    order: [
                      [4, 'asc']
                    ],
                    columnDefs: [{
                        targets: 1,
                        orderable: false
                      },
                      {
                        targets: 0,
                        orderable: false
                      },
                      {
                        targets: 2,
                        orderable: false
                      },
                      {
                        targets: 3,
                        orderable: false
                      }, {
                        targets: 4,
                        type: 'date',
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
                      {
                        targets: 7,
                        orderable: false
                      },
                    ],
                    columns: [{
                        data: 'number',
                        width: "60px"
                      },
                      {
                        data: 'note',
                        width: "200px"
                      },
                      {
                        data: 'refere_order',
                        width: "160px"
                      },
                      {
                        data: 'payment',
                        width: "300px"
                      },
                      {
                        data: 'created_time',
                        width: "160px",
                      },
                      {
                        data: 'debit'
                      },
                      {
                        data: 'credit'
                      },
                      {
                        data: 'balance'
                      },
                    ],
                    autoWidth: false,
                    responsive: true,
                  });



                  $("#suppliertrans_length").remove();
                  $("#suppliertrans_paginate").remove();
                  $("#suppliertrans_info").remove();
                  $("#ExportReporttoExcel").on("click", function() {
                    table2.button('.buttons-csv').trigger();
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
                    var barcodeDiv = document.getElementById("suppliertrans");
                    var printWindow = window.open('', '');

                    printWindow.document.write('<html><head><title>' + $(".l-main-prof-info h2").html() + '\'s Account Statement [Customer]</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                    printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
                    printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>' + $(".l-main-prof-info h2").html() + '\'s Account Statement [Customer]</h3><span class="dt-range">From <span class="bold">' + $("#start-date-filter-trans").val() + '</span>  To <span class="bold">' + $("#end-date-filter-trans").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
                    printWindow.document.write(barcodeDiv.innerHTML);
                    printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                  });

                  $('select#filter_refered').on('change', function() {
                    var refered = $(this).val();
                    if ($(this).val() === 'all') {
                      table2.column(3).search('').draw();
                    } else {
                      table2.column(3).search(refered, true, false).draw();
                    }
                  });
                  $('#search-filter-trans').on('keyup', function() {
                    var searchValue = $(this).val();
                    table2.search(searchValue).draw();
                  });

                  function startupBalance() {
                    var create_date = $('input#start-date-filter-trans').val();
                    var end_date = $('input#end-date-filter-trans').val();
                    create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                    end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                    if ($('input#start-date-filter-trans').val() === '') {
                      filtered = '';
                    } else {
                      var filtered = table2.column(4).data().filter(function(value, index) {
                        return value >= create_date && value <= end_date; // Filter the data based on the entered date
                      }).join("|");
                      var valuesToDraw = filtered.split("|");
                      var regex = valuesToDraw.map(function(value) {
                        return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                      }).join('|');
                      table2.column(4).search(regex, true, false).draw();



                      var open_balance_index = Array.from(table2.column(4).data()).filter(function(value) {
                        return value <= create_date; // Filter the data based on the entered date
                      });
                      var lastItemIndex = -1;
                      var cellValue = 0;
                      open_balance_index.forEach(function(value, index) {
                        if (value <= create_date) {
                          lastItemIndex = index;
                        }
                      });
                      var cellValue = table2.cell(lastItemIndex, 7).data();
                      if (!cellValue) {
                        cellValue = 0;
                      }
                      $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    }
                  };
                  setTimeout(startupBalance, 500);

                  $('input#start-date-filter-trans').on('change', function() {
                    var create_date = $(this).val();
                    var end_date = $('input#end-date-filter-trans').val();
                    create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                    end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                    if ($(this).val() === '') {
                      filtered = '';
                    } else {
                      var filtered = table2.column(4).data().filter(function(value, index) {
                        return value >= create_date && value <= end_date; // Filter the data based on the entered date
                      }).join("|");
                      var valuesToDraw = filtered.split("|");
                      var regex = valuesToDraw.map(function(value) {
                        return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                      }).join('|');
                      table2.column(4).search(regex, true, false).draw();



                      var open_balance_index = Array.from(table2.column(4).data()).filter(function(value) {
                        return value <= create_date; // Filter the data based on the entered date
                      });
                      var lastItemIndex = -1;
                      var cellValue = 0;
                      open_balance_index.forEach(function(value, index) {
                        if (value <= create_date) {
                          lastItemIndex = index;
                        }
                      });
                      var cellValue = table2.cell(lastItemIndex, 7).data();
                      if (!cellValue) {
                        cellValue = 0;
                      }
                      $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    }
                    console.log(cellValue);
                  });
                  $('input#start-date-filter-trans').on('blur', function() {
                    if ($(this).val() === '') {
                      table2.column(4).search('').draw();
                    }
                  });
                  $('input#end-date-filter-trans').on('change', function() {
                    var end_date = $(this).val();
                    var create_date = $('input#start-date-filter-trans').val();
                    create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                    end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                    if ($(this).val() === '') {
                      filtered = '';
                    } else {
                      var filtered = table2.column(4).data().filter(function(value, index) {
                        return value >= create_date && value <= end_date; // Filter the data based on the entered date
                      }).join("|");
                      var valuesToDraw = filtered.split("|");
                      var regex = valuesToDraw.map(function(value) {
                        return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                      }).join('|');
                      table2.column(4).search(regex, true, false).draw();



                      var open_balance_index = Array.from(table2.column(4).data()).filter(function(value) {
                        return value <= create_date; // Filter the data based on the entered date
                      });
                      var lastItemIndex = -1;
                      var lastItemValue = 0;
                      open_balance_index.forEach(function(value, index) {
                        if (value <= create_date) {
                          lastItemIndex = index;
                        }
                      });
                      var cellValue = table2.cell(lastItemIndex, 7).data();
                      $("#open_balance_trans").html('E£ ' + cellValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    }
                  });
                  $('input#end-date-filter-trans').on('blur', function() {
                    if ($(this).val() === '') {
                      table2.column(4).search('').draw();
                    }
                  });


                });
              </script>

            </div>
          <?php } ?>
          <?php
          if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(106) == 1) {
          ?>
            <div class="transaction-list listo">
              <h4 class='submarin'>Orders</h4>
              <div class="btns">
                <button class="filter"><i class="fa-solid fa-filter"></i></button>
                <button class="export"><i class="fa-solid fa-download"></i>
                  <ul class="export-options">
                    <li class="option" id="ExportReporttoPdf2">
                      <div><i class=" fa-solid fa-print"></i> Print List</div>
                    </li>
                    <li class="option btn-print" id="ExportReporttoExcel2">
                      <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
                    </li>
                  </ul>
                </button>
              </div>
              <div class="request-section filter-section">
                <form action="">
                  <input type="hidden" name="page" value="">
                  <h6 class="fhead">Filteration</h6>
                  <div class="inputs inputs-grid">
                    <div class="inputs">
                      <label for="status">Status</label>
                      <select name="status" id="filter_status">
                        <option value="all">All</option>
                        <option value="paid">Paid</option>
                        <option value="due">Due</option>
                        <option value="overdue">OverDue</option>
                      </select>
                    </div>
                    <div class="inputs">
                      <label for="order_received">Order Received</label>
                      <select name="order_received" id="order_received">
                        <option value="all">All</option>
                        <option value="received">Received Only</option>
                        <option value="not">Not Received Yet</option>
                      </select>
                    </div>
                    <div class="inputs">
                      <label for="date">Create Date</label>
                      <input type="date" name="date" id="create-date-filter">
                    </div>
                    <div class="inputs">
                      <label for="date">Due Date</label>
                      <input type="date" name="date" id="due-date-filter">
                    </div>
                  </div>
                </form>
              </div>

              <div class="resp-table">
                <div class="serch">
                  <input type="text" id="search-filter" value="" placeholder="Search...">
                </div>
                <table id="suppliertable" style="width:100% !important;">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Type</th>
                      <th>Created Date</th>
                      <th>Due Date</th>
                      <th>Debit (E£)</th>
                      <th>Balance Due (E£)</th>
                      <th>Total Amount (E£)</th>
                      <th>Status</th>
                      <th>Received</th>
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
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="request-list">
                <div class="request-row out">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div class="jo">E£
                    <?= get_selling_paid() ?>
                  </div>
                  <div class="jo">E£
                    <?= get_selling_due() ?>
                  </div>
                  <div class="jo">E£
                    <?= get_sell_total() ?>
                  </div>
                </div>
              </div>








              <script>
                $(function() {
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





                  var table = $('#suppliertable').DataTable({
                    ajax: {
                      url: 'json/sell_transactions.php',
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
                      filename: $(".l-main-prof-info h2").html() + '\'s Orders', // Set the desired filename
                    }],
                    language: {
                      paginate: {
                        previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                        next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                      }
                    },
                    "lengthMenu": [
                      [10, 25, 50, 100, -1],
                      [10, 25, 50, 100, "All"]
                    ],
                    "footerCallback": function(row, data, start, end, display) {
                      var api = this.api();
                      var colIndex1 = 4; // Set the index of the first column to calculate the sum for
                      var colIndex2 = 5; // Set the index of the second column to calculate the sum for
                      var colIndex3 = 6; // Set the index of the third column to calculate the sum for
                      var colData1 = api.column(colIndex1, {
                        page: 'current'
                      }).data();
                      var colData2 = api.column(colIndex2, {
                        page: 'current'
                      }).data();
                      var colData3 = api.column(colIndex3, {
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
                      total3 = api.column(colIndex3, {
                        page: 'current'
                      }).data().sum();

                      var footer1 = api.column(colIndex1).footer();
                      var footer2 = api.column(colIndex2).footer();
                      var footer3 = api.column(colIndex3).footer();
                      $(footer1).html('E£ ' + total1.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      $(footer2).html('E£ ' + total2.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      $(footer3).html('E£ ' + total3.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));

                    },

                    columnDefs: [{
                      targets: -1,
                      className: 'dt-body-right',
                      orderable: false
                    }],
                    order: [
                      [0, 'desc']
                    ],
                    columns: [{
                        data: 'order_id',
                        width: "150px"
                      },
                      {
                        data: 'type'
                      },
                      {
                        data: 'created_time'
                      },
                      {
                        data: 'due_to'
                      },
                      {
                        data: 'paid'
                      },
                      {
                        data: 'balance_due'
                      },
                      {
                        data: 'order_total'
                      },

                      {
                        data: 'status',
                        width: "100px"
                      },
                      {
                        data: 'received',
                        "visible": false
                      },
                      {
                        data: 'action'
                      },
                    ],
                    autoWidth: false,
                    responsive: true,
                  });



                  $('.dataTables_filter').remove();
                  $("#ExportReporttoExcel2").on("click", function() {
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

                  $("#ExportReporttoPdf2").on("click", function() {
                    var currentTime = getCurrentTime();
                    event.preventDefault();
                    var userDate = $(".profile-info h5").html();
                    var barcodeDiv = document.getElementById("suppliertable");
                    var printWindow = window.open('', '');

                    printWindow.document.write('<html><head><title>' + $(".l-main-prof-info h2").html() + '\'s Orders [Customer]</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                    printWindow.document.write('<style>table td:last-child,table th:last-child {display: none;}</style>');
                    printWindow.document.write('<style>@page {size: A4 55% landscape;margin: 0;} </style>');
                    printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>' + $(".l-main-prof-info h2").html() + '\'s Orders [Customer]</h3><span class="dt-range"></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div><table>');
                    printWindow.document.write(barcodeDiv.innerHTML);
                    printWindow.document.write('</table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                  });
                  $('select#filter_status').on('change', function() {
                    var status = $(this).val();
                    if ($(this).val() === 'all') {
                      table.column(7).search('').draw();
                    } else if ($(this).val() === 'due') {
                      table.column(7).search('\\bdue\\b(?!\\s*overdue)', true, false).draw();
                    } else {
                      table.column(7).search(status, true, false).draw();
                    }
                  });
                  $('select#order_received').on('change', function() {
                    var rec = $(this).val();
                    if ($(this).val() === 'all') {
                      table.column(-2).search('').draw();
                    } else {
                      table.column(-2).search(rec, true, false).draw();
                    }
                  });
                  $('input#create-date-filter').on('change', function() {
                    var create_date = $(this).val();
                    create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format

                    if ($(this).val() === '') {
                      table.column(2).search('').draw();
                    } else {
                      table.column(2).search(create_date).draw();
                    }
                  });
                  $('input#due-date-filter').on('change', function() {
                    var due_date = $(this).val();
                    due_date = new Date(due_date).toISOString().substring(0, 10); // Convert to ISO string format

                    if ($(this).val() === '') {
                      table.column(2).search('').draw();
                    } else {
                      table.column(2).search(due_date).draw();
                    }
                  });
                  $('input#create-date-filter').on('blur', function() {
                    if ($(this).val() === '') {
                      table.column(2).search('').draw();
                    }
                  });
                  $('input#due-date-filter').on('blur', function() {
                    if ($(this).val() === '') {
                      table.column(2).search('').draw();
                    }
                  });
                  $('#search-filter').on('keyup', function() {
                    var searchValue = $(this).val();
                    table.search(searchValue).draw();
                  });


                  $("#curr_paid").on("change", function() {
                    var due_balance = $('#old_due').val();
                    var curr_paid = $(this).val();
                    var total_due = due_balance - curr_paid;
                    var formattedNumber = total_due.toLocaleString('en-US', {
                      minimumFractionDigits: 2
                    });
                    $(".curr_balance_due").html("E£ " + formattedNumber);
                    $("#curr_due").val(total_due);
                  });

                  $('#suppliertable').on('click', 'button.view_purchase', function() {
                    $.ajax({
                      url: 'json/get_sell_page.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        order_id: $(this).attr("btn-data"),
                      },
                      success: function(data) {
                        $("#order_title").html("Sale Invoice #" + data.order_id);
                        $(".order_edit_id").val(data.order_id);
                        $(".curr_name").html(data.supplier_name);
                        $(".curr_status").html(data.status);
                        $(".curr_vat_perc").html(data.vat_perc);
                        $(".curr_with_perc").html(data.withholding_perc);
                        $(".curr_subtotal_amount").html("E£ " + data.subtotal);
                        $(".curr_total_vat").html("E£ " + data.vat_amount);
                        $(".curr_total_amount").html("E£ " + data.order_total);
                        $("#curr_total").val(data.order_total);
                        $("#sell_cost").html("E£ " + data.sell_cost.toLocaleString('en-US', {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2
                        }));
                        $("#curr_due").val(data.balance_due);
                        $(".curr_old_paid").html("E£ " + data.paid.toLocaleString('en-US', {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2
                        }));
                        $(".curr_discount_amount").html("E£ - " + data.discount);
                        $(".curr_withholding_amount").html("E£ - " + data.withholding);
                        $(".old_paid").val(data.paid);
                        if (data.payment_m !== "bank") {
                          $(".curr_bank").css({
                            "opacity": "0"
                          });
                          $(".curr_payment_m").html(data.payment_m);
                          $(".curr_bank_name").html("");
                          $(".curr_bank_number").html("");
                        } else if (data.payment_m == "bank") {
                          $(".curr_bank").css({
                            "opacity": "1"
                          });
                          $(".curr_payment_m").html("Bank Account");
                          $(".curr_bank_name").html(data.bank_name);
                          $(".curr_bank_number").html(data.bank_number);
                        }
                        $(".order_edit_supplier_id").val(data.supplier_id);
                        $("#old_due").val(data.old_balance);
                        $(".curr_due_date").html(data.due_to);
                        $(".mg-note-go").html(data.notes);
                        $(".curr_balance_due").html("E£ " + data.balance_due);
                        $(".curr_due_date_input").val(data.due_to);
                        $(".curr_create_date").html(data.created_time);
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
                      url: 'json/get_sell_list.php',
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




                  $('#suppliertable').on('click', 'button.print_purchase', function() {
                    $.ajax({
                      url: 'json/get_sell_page.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        order_id: $(this).attr("print-data"),
                      },
                      success: function(data) {
                        $("#order_title").html("Sale Invoice #" + data.order_id);
                        $(".order_edit_id").val(data.order_id);
                        $(".curr_name").html(data.supplier_name);
                        $(".curr_status").html(data.status);
                        $(".curr_vat_perc").html(data.vat_perc);
                        $(".curr_with_perc").html(data.withholding_perc);
                        $(".curr_subtotal_amount").html("E£ " + data.subtotal);
                        $(".curr_total_vat").html("E£ " + data.vat_amount);
                        $(".curr_total_amount").html("E£ " + data.order_total);
                        $("#curr_total").val(data.order_total);
                        $("#curr_due").val(data.balance_due);
                        $(".curr_old_paid").html("E£ " + data.paid.toLocaleString('en-US', {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2
                        }));
                        $(".curr_discount_amount").html("E£ - " + data.discount);
                        $(".curr_withholding_amount").html("E£ - " + data.withholding);
                        $(".old_paid").val(data.paid);
                        if (data.payment_m == "cash") {
                          $(".curr_bank").css({
                            "opacity": "0"
                          });
                          $(".curr_payment_m").html(data.payment_m);
                          $(".curr_bank_name").html("");
                          $(".curr_bank_number").html("");
                        } else {
                          $(".curr_bank").css({
                            "opacity": "1"
                          });
                          $(".curr_payment_m").html("Bank Account");
                          $(".curr_bank_name").html(data.bank_name);
                          $(".curr_bank_number").html(data.bank_number);
                        }
                        $(".order_edit_supplier_id").val(data.supplier_id);
                        $("#old_due").val(data.old_balance);
                        $(".curr_due_date").html(data.due_to);
                        $(".mg-note-go").html(data.notes);
                        $(".curr_balance_due").html("E£ " + data.balance_due);
                        $(".curr_due_date_input").val(data.due_to);
                        $(".curr_create_date").html(data.created_time);
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
                      url: 'json/get_sell_list.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        order_id: $(this).attr("print-data"),
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




                    $.when(new Promise(res =>
                        setTimeout(res, 200)))
                      .then(() => {
                        printInvoice($(this).attr("print-data"));
                      });
                  });

                  function formatDate(dateString) {
                    var date = new Date(dateString);
                    var options = {
                      month: 'short',
                      day: 'numeric',
                      year: 'numeric',
                      hour: 'numeric',
                      minute: 'numeric',
                      hour12: true
                    };
                    return date.toLocaleString('en-US', options);
                  };



                  function printInvoice(invoiceId) {

                    var currentTime = getCurrentTime();
                    var userDate = $(".profile-info h5").html();
                    var barcodeDiv = document.getElementById("suppliertable");
                    var printWindow = window.open('', '');


                    var startDate = $(".curr_create_date").html();
                    var dueDate = $(".curr_due_date").html()
                    var formattedStartDate = formatDate(startDate);
                    var formattedDueDate = formatDate(dueDate);
                    printWindow.document.write('<html><head><title>Invoice #' + invoiceId + '</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                    printWindow.document.write('<style>@page { size: A4; margin: 0; orientation: portrait;zoom: 100%; } table td:last-child,table th:last-child {display: none;}</style>');
                    printWindow.document.write('</head><body><div class="container">');
                    printWindow.document.write('<div class="upper_header">');
                    printWindow.document.write('<div class="lt_u_header"><h2 class="inv_code">Invoice #' + invoiceId + '</h2><span class="info"><span class="lt-info">Status: </span><span class="rt-info">Valid</span></span>');
                    printWindow.document.write('<span class="info"><span class="lt-info">Submission Date: </span><span class="rt-info">' + formattedStartDate + '</span></span>');
                    printWindow.document.write('<span class="info"><span class="lt-info">Due Date: </span><span class="rt-info">' + formattedDueDate + '</span></span>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('<div class="rt_u_header"><div class="logo_img"><img src="../images/logo.png" /></div></div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('<div class="upper_head">');
                    printWindow.document.write('<div class="lt_head">');
                    printWindow.document.write('<h4>Issuer (From)</h4>');
                    printWindow.document.write('<div class="sm_contain"><div class="sm_title"><span class="sm_h">Name:</span><span class="sm_v">Orgasafe</span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Address:</span><span class="sm_v"></span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Registeration Number:</span><span class="sm_v"></span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Phone:</span><span class="sm_v"></span></div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('<div class="rt_head">');
                    printWindow.document.write('<h4>Recipient (To)</h4>');
                    printWindow.document.write('<div class="sm_contain"><div class="sm_title"><span class="sm_h">Name:</span><span class="sm_v">' + $(".detail-table .table-col .table-row:first-child .info-detail").html() + '</span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Address:</span><span class="sm_v">' + $(".detail-table .table-col:nth-child(2) .table-row:first-child .info-detail").html() + '</span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Registeration Number:</span><span class="sm_v">' + $(".detail-table .table-col:nth-child(2) .table-row:nth-child(3) .info-detail").html() + '</span></div>');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Phone:</span><span class="sm_v">' + $(".detail-table .table-col .table-row:nth-child(4) .info-detail").html() + '</span></div>');

                    printWindow.document.write('</div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('<div class="method_section">');
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Payment Method:</span><span class="sm_v">' + $(".curr_payment_m").html() + '</span></div>');
                    if ($(".curr_payment_m").html() == "Bank Account") {
                      printWindow.document.write('<div class="sm_title"><span class="sm_h">Bank Details:</span><span class="sm_v">' + $(".curr_bank_number").html() + ' ( ' + $(".curr_bank_name").html() + ' )</span></div>');
                    }
                    printWindow.document.write('<div class="sm_title"><span class="sm_h">Payment Status:</span><span class="sm_v">' + $(".curr_status").html() + '</span></div>');
                    printWindow.document.write('</div>');
                    printWindow.document.write('<div class="invoice_table_head"><div class="request-row"><div>Name</div><div>Description</div><div>Qty.</div><div>Price/Unit (E£)</div><div>Total (E£)</div></div></div>');

                    printWindow.document.write("<div class='invoice_table'>" + $('#inv-edit-list').html() + "</div>");
                    printWindow.document.write("<div class='bottom_section'>");
                    printWindow.document.write("<div class='lt_b_section'><div class='bottom_title'>Comment:</div><div class='bottom_title_value'></div></div>");
                    printWindow.document.write("<div class='rt_b_section'><div><div class='rt_title'>SubTotal</div><div class='rt_value'>" + $(".curr_subtotal_amount").html().replace("E£", "").trim() + "</div></div><div><div class='rt_title'>Discount</div><div class='rt_value'>" + $(".curr_discount_amount").html().replace("E£", "").trim() + "</div></div><div><div class='rt_title'>Withholding Tax(%" + parseInt($('.curr_with_perc').html()) + ")</div><div class='rt_value'>" + $(".curr_withholding_amount").html().replace("E£", "").trim() + "</div></div><div><div class='rt_title'>Total VAT(%" + parseInt($('.curr_vat_perc').html()) + ")</div><div class='rt_value'>" + $(".curr_total_vat").html().replace("E£", "").trim() + "</div></div><div style='font-size:13px;font-weight:600;'><div class='rt_title'>Total Amount</div><div class='rt_value'>" + $(".curr_total_amount").html().replace("E£", "").trim() + "</div></div></div>");
                    printWindow.document.write("</div>");

                    printWindow.document.write('</div></body></html>');



                  };



                  $(".edit-invoice-page .cancels-btn").click(function(event) {
                    event.preventDefault();
                    $(".edit-invoice-page").css({
                      height: "0px",
                      padding: "0",
                      "border-bottom": "0px solid #cfcfcf",
                    });
                    $(".inv-edit-body")[0].reset();
                  });

                });
              </script>

            </div>
          <?php } ?>
          <div class="details-list">
            <div class="detail-table">
              <div class="table-col">
                <div class="table-row">
                  <div class="info-title">Customer</div>
                  <div class="info-detail">
                    <?php
                    if ($info['is_company'] == "0") {
                      if (empty($info['company_name'])) {
                        echo $info['first_name'] . " " . $info['middle_name'] . " " . $info['last_name'];
                      } else {
                        echo $info['first_name'] . " " . $info['middle_name'] . " " . $info['last_name'] . " [ " . $info['company_name'] . " ] ";
                      }
                    } else {
                      echo $info['company_name'];
                    }
                    ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Email</div>
                  <div class="info-detail">
                    <?= $info['email'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Phone</div>
                  <div class="info-detail">
                    <?= $info['phone'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Mobile</div>
                  <div class="info-detail">
                    <?= $info['mobile'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Fax</div>
                  <div class="info-detail">
                    <?= $info['fax'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Website</div>
                  <div class="info-detail">
                    <?= $info['website'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Other</div>
                  <div class="info-detail">
                    <?= $info['other'] ?>
                  </div>
                </div>
              </div>
              <div class="table-col">
                <div class="table-row ex-height">
                  <div class="info-title">Address</div>
                  <div class="info-detail">
                    <?= $info['street'] . " , " . $info['state'] . "<br>" . $info['city'] . " , " . $info['country'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Account No.</div>
                  <div class="info-detail">
                    <?= $info['acc_num'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Tax Reg. ID</div>
                  <div class="info-detail">
                    <?= $info['taxid'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Created Date</div>
                  <div class="info-detail">
                    <?= $info['created_time'] ?>
                  </div>
                </div>
                <div class="table-row">
                  <div class="info-title">Last Modifications</div>
                  <div class="info-detail">
                    <?= $info['last_modification'] ?>
                  </div>
                </div>
                <div class="table-row ex-height">
                  <div class="info-title">Notes</div>
                  <div class="info-detail qknote">
                    <?= $info['notes'] ?>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <?php
        if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(107) == 1) {
        ?>
          <div class="confirm_delete_page">
            <div class="custome-head">
              <h3>Are you sure to cancel invoice #<span class="order_id_confirm">...</span></h3>
              <button class="close_confirm"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form method="POST">
              <input type="hidden" class="supplier_id" value="<?= $info['id'] ?>" name="id">
              <input type="hidden" class="confirm_id" value="" name="confirm_id">
              <button class="confirm_delete_btn" data-btn="">Confirm</button>
            </form>
          </div>
        <?php } ?>
        <div class="black_screen"></div>
        <?php
        if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(104) == 1) {
        ?>
          <div class="add_new edit_supplo">
            <div class="custome-head">
              <h3>Edit Customer</h3>
              <button class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form class="" id="edit_supplier" action="" method="POST">
              <div class="custom-form">
                <div class="sectra">
                  <span class="sm-head">Contact info</span>
                  <span class="ask">
                    <label for="ask">Active ?</label>
                    <input type="checkbox" name="status" value="1" <?php if ($info['status'] == 1) {
                                                                      echo "checked";
                                                                    } ?>>
                  </span>
                  <div class="form-section">
                    <div class="inputs gd2">
                      <label for="fname">First Name</label>
                      <input type="text" value="<?= $info['first_name'] ?>" class="" name="fname" id="fname" <?php if ($info['is_company'] == "0") {
                                                                                                                echo "required";
                                                                                                              } ?>>
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="mname">Middle Name</label>
                      <input type="text" value="<?= $info['middle_name'] ?>" class="" name="mname" id="mname">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="lname">Last Name</label>
                      <input type="text" value="<?= $info['last_name'] ?>" class="" name="lname" id="lname">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd6">
                      <label for="company">Company</label>
                      <input type="text" value="<?= $info['company_name'] ?>" class="" name="cname" id="company" <?php if ($info['is_company'] == "1") {
                                                                                                                    echo "required";
                                                                                                                  } ?>>
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="phone">Phone Number</label>
                      <input type="number" value="<?= $info['phone'] ?>" class="" name="phone" id="phone" min="0" max="1999999999">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="mobile">Mobile</label>
                      <input type="number" value="<?= $info['mobile'] ?>" class="" name="mobile" id="mobile" min="0" max="1999999999">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="fax">Fax</label>
                      <input type="number" value="<?= $info['fax'] ?>" class="" name="fax" id="fax" min="0" max="1999999999">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="email">Email Address</label>
                      <input type="text" value="<?= $info['email'] ?>" class="" name="email" id="email">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="website">Website</label>
                      <input type="text" value="<?= $info['website'] ?>" class="" name="website" id="website">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd2">
                      <label for="other">Other</label>
                      <input type="text" value="<?= $info['other'] ?>" class="" name="other" id="other">
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
                      <input type="number" value="<?= $info['postal'] ?>" class="11411" name="postal" id="postal" min="0">
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
                  <span class="sm-head">Payment and Billing</span>
                  <div class="form-section">
                    <div class="inputs gd6">
                      <label for="acc_num">Account no.</label>
                      <input type="text" id="acc_num" value="<?= $info['acc_num'] ?>" class="" name="acc_num" placeholder="Appears in the memo of all payments">
                      <span class="error-field"></span>
                    </div>
                    <div class="inputs gd6">
                      <label for="taxid">Tax Reg. ID</label>
                      <input type="text" id="taxid" value="<?= $info['taxid'] ?>" class="" name="taxid">
                      <span class="error-field"></span>
                    </div>

                  </div>
                </div>
              </div>
              <hr class="hr_form">
              <div class="loadings"><i class=""></i></div>
              <input type="hidden" name="id" value="<?= $info['id'] ?>">
              <input type="hidden" name="is_company" value="<?= $info['is_company'] ?>">
              <input type="hidden" name="edit" value="Save">
              <input type="submit" class="add" value="Save">
            </form>
          </div>
        <?php  } ?>
        <div class="black_screen"></div>

        <div class="invoice-page">
          <form action="" method="POST" class="inv-body" enctype="multipart/form-data">
            <div class="inv-head">
              <h2 class="inv-title">Sale Invoice #
                <input type="text" class="inv_number" name="inv_number" value=<?= get_sell_order_number() ?> />
              </h2>
              <button id="close-btn" class="close"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="top-form">

              <div class="form-section">
                <div class="inputs gd3">
                  <label for="supploer">Customer</label>
                  <input type="text" id="supplier" class="hand" name="supplier_name" value="<?php
                                                                                            if ($info['is_company'] == "1") {
                                                                                              echo $info['company_name'];
                                                                                            } else {
                                                                                              echo $info['first_name'] . " " . $info['middle_name'] . " " . $info['last_name'];
                                                                                            }
                                                                                            ?>" disabled>
                  <input type="hidden" id="supplier_id" value="<?= $info['id'] ?>" name="supplier_id">
                </div>
                <div class="inputs gd2">
                  <label for="terms">Terms</label>
                  <select name="terms" id="terms">
                    <option value="dueonreceipt">On delivery</option>
                    <option value="15">Net 15</option>
                    <option value="30">Net 30</option>
                    <option value="60">Net 60</option>
                  </select>
                </div>
                <div class="inputs gd2" style="display:none;">
                  <label for="inv_type">Invoice Type</label>
                  <select name="inv_type" id="inv_type">
                    <option value="1" selected>Non-tax</option>
                    <option value="2">Tax(1%)</option>
                    <option value="3">Tax(3%)</option>
                  </select>
                </div>
                <div class="inputs gd1 vat">
                  <label for="vat">VAT(14%)</label>
                  <input type="number" name="vat" id="vat" min="0" value="0" step="0.01">
                </div>
                <div class="inputs gd3">
                  <label for="payment_m">Receiving Payment Mehtod</label>
                  <select name="payment_m" id="payment_m" required>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank Account</option>
                    <option value="notes receivables">Notes Receivables</option>
                    <option value="checks under collection">Check Under Collection</option>
                  </select>
                </div>
                <div class="inputs gd1 bank_choose">
                  <label for="bank">Bank Name</label>
                  <select name="bank" id="bank">
                    <?= get_banks() ?>
                  </select>
                </div>
                <div class="inputs gd2 bank_choose">
                  <label for="bank_number">Bank Account</label>
                  <select name="bank_number" id="bank_number">
                  </select>
                </div>
                <div class="inputs gd3 vat">
                  <label for="cdate">Created Date</label>
                  <input type="datetime-local" name="cdate" id="cdate" value="<?= date("Y-m-d H:i") ?>" required>
                </div>
                <div class="inputs gd1">
                  <label for="received">Delivered?</label>
                  <input type="checkbox" name="received" id="received">
                </div>

              </div>
              <div class="due-balance">
                <h6>Balance Due</h6>
                <strong>E£ 0.00</strong>
              </div>
            </div>
            <div class="mid-form">
              <div class="employee-section request-section invoice-list">
                <div class="request-list">
                  <div class="request-row request-head-list">
                    <div></div>
                    <div>Item</div>
                    <div>Description</div>
                    <div>Qty</div>
                    <div>Unit</div>
                    <div>Amount (E£)</div>
                    <div>Total (E£)</div>
                    <div></div>
                  </div>
                  <div class="request-body-list" id="inv-list">
                    <div class='request-row' id="row1">
                      <div class="handle"><i class="fa-solid fa-ellipsis"></i></div>
                      <div>
                        <input type="text" class="item_name item_name1" name="p[1][name]">
                        <input type="number" class="item_id1 hidden" name="p[1][id]">
                        <ul class="suggestion suggestion1"></ul>
                      </div>
                      <div><input type="text" name="p[1][description]"></div>
                      <div><input type="number" class="item_quantity1" name="p[1][quantity]" value="0" step="0.0000001"><span class="item_limit item_limit1" data-limit="0">/ -</span></div>
                      <div><input type="text" class="item_unit1" name="p[1][unit]" disabled></div>
                      <div><input type="number" class="item_amount1" name="p[1][amount]" value="0" step="0.00001"></div>
                      <div><input type="number" class="item_total item_total1" name="p[1][total]" value="0" step="0.0000001" disabled></div>
                      <div class="hidden"><input type="hidden" class="item_idy item_idy1" name="p[1][idy]" disabled></div>
                    </div>
                  </div>
                </div>
                <div class="bottom-list">
                  <div class="lt">
                    <div class="btns">
                      <button id="add-line-y"><i class="fa-solid fa-plus"></i> Add Line</button>
                    </div>
                    <div class="form-section">
                      <div class="inputs gd6">
                        <label for="inv_notes">Invoice Notes</label>
                        <textarea name="notes" id="inv_notes"></textarea>
                      </div>
                      <div class="inputs gd6">
                        <label for="statement">Statement</label>
                        <textarea name="statement" id="statement">فاتورة مبيعات</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="rt">
                    <div class="total-gd">
                      <div class="total-title">SubTotal</div>
                      <div class="total-value subtotal-amount">E£ 0.00</div>
                    </div>
                    <div class="total-gd">
                      <div class="total-title">Discount</div>
                      <div class="total-value minus">E£ - <input type="number" name="discount" id="discount" value="0" step="0.0001"></div>
                    </div>
                    <!-- <div class="total-gd">
                      <div class="total-title withholding_title">Withholing Tax (0%)</div>
                      <div class="total-value withholding-amount minus">E£ - 0.00</div>
                    </div> -->
                    <div class="total-gd">
                      <div class="total-title">VAT Amount</div>
                      <div class="total-value total_vat">E£ 0.00</div>
                    </div>
                    <div class=" total-gd gaint">
                      <div class="total-title">Total</div>
                      <div class="total-value total-amount">E£ 0.00</div>
                    </div>
                    <div class="total-gd">
                      <div class="total-title">Payment Received</div>
                      <div class="total-value">E£
                        <input type="number" name="paid" id="paid" value="0" step="0.01">
                        <input type="hidden" name="due_balance" id="due_balance" value="0">
                        <input type="hidden" name="subtotal" id="subtotal_purchase" value="0">
                        <input type="hidden" name="withholding" id="withholding" value="0">
                        <input type="hidden" name="total" id="total_purchase" value="0">
                        <input type="hidden" name="vat_amount" id="vat_amount" value="0">
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>

            <div class="saving-bar">
              <button class="cancels-btn">Cancel</button>
              <div class="tw-btns">
                <button class="save-btn new-inv-btn" name="save_order_purchase"><i class="fa-solid fa-floppy-disk"></i> Save</button>
              </div>
            </div>
          </form>
        </div>


        <div class="edit-invoice-page">
          <div class="inv-head">
            <h2 class="inv-title" id="order_title">Sale Invoice #..</h2>
            <button id="close-btn-inv" class="closes"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form action="" method="POST" class="inv-body inv-edit-body" enctype="multipart/form-data">
            <div class="top-form">

              <div class="form-section">
                <div class="inputs gd3">
                  <label for="supploer">Customer</label>
                  <div class="curr curr_name">...</div>
                </div>
                <div class="inputs gd3">
                  <label for="">Status</label>
                  <div class="curr curr_status">...</div>
                </div>
                <div class="inputs gd3">
                  <label for="">Created Date</label>
                  <div class="curr curr_create_date"></div>
                </div>
                <div class="inputs gd3">
                  <label for="">Due Date</label>
                  <div class="curr curr_due_date"></div>
                  <input type="hidden" name="due_to" class="curr_due_date_input">
                </div>
                <div class="inputs gd3">
                  <label for="received">Received?</label>
                  <input type="checkbox" name="received" id="curr_received">
                  <input type="hidden" name="order_id" class="order_edit_id">
                  <input type="hidden" name="supplier_id" class="order_edit_supplier_id">
                </div>
                <div class="inputs gd1">
                  <label for="">VAT(%)</label>
                  <div class="curr curr_vat_perc"></div>
                </div>
                <!-- <div class="inputs gd1">
                  <label for="">Withholding Tax(%)</label>
                  <div class="curr curr_with_perc"></div>
                </div> -->
                <div class="inputs gd3">
                  <label for="">Payment Method</label>
                  <div class="curr curr_payment_m"></div>
                </div>
                <div class="inputs gd1 curr_bank">
                  <label for="">Bank Name</label>
                  <div class="curr curr_bank_name"></div>
                </div>
                <div class="inputs gd2 curr_bank">
                  <label for="">Bank Account</label>
                  <div class="curr curr_bank_number"></div>
                </div>
              </div>
              <div class="due-balance">
                <h6>Balance Due</h6>
                <strong class="curr_balance_due">E£ 0.00</strong>
                <!-- <h6>Cost</h6>
                <strong class="" id="sell_cost">E£ 0.00</strong> -->
              </div>
            </div>
            <div class="mid-form">
              <div class="employee-section request-section invoice-list">
                <div class="request-list">
                  <div class="request-row request-head-list">
                    <div></div>
                    <div>Item</div>
                    <div>Description</div>
                    <div>Qty</div>
                    <div>Unit</div>
                    <div>Amount (E£)</div>
                    <div>Total (E£)</div>
                    <div></div>
                  </div>
                  <div class="request-body-list" id="inv-edit-list">
                  </div>
                </div>
                <div class="bottom-list">
                  <div class="lt">
                    <div class="form-section">
                      <div class="inputs gd6">
                        <label for="mg-note">Invoice Notes</label>
                        <div class="mg-note-go"></div>
                      </div>
                    </div>
                  </div>
                  <div class="rt">

                    <div class="total-gd">
                      <div class="total-title">SubTotal</div>
                      <div class="total-value curr_subtotal_amount">E£ 0.00</div>
                    </div>
                    <div class="total-gd">
                      <div class="total-title">Discount</div>
                      <div class="total-value curr_discount_amount">E£ - 0.00</div>
                    </div>
                    <!-- <div class="total-gd">
                      <div class="total-title">Withholding Tax</div>
                      <div class="total-value curr_withholding_amount">E£ - 0.00</div>
                    </div> -->
                    <div class="total-gd">
                      <div class="total-title">Total VAT</div>
                      <div class="total-value curr_total_vat">E£ 0.00</div>
                    </div>
                    <div class="total-gd">
                      <div class="total-title">Previous Payment</div>
                      <div class="total-value curr_old_paid">E£ 0.00</div>
                    </div>
                    <input type="hidden" name="paid" id="curr_paid" value="0" step="0.01">
                    <input type="hidden" name="curr_total" id="curr_total">
                    <input type="hidden" name="curr_due" id="curr_due">
                    <input type="hidden" id="old_due">
                    <input type="hidden" name="old_paid" class="old_paid">
                    <div class="total-gd gaint">
                      <div class="total-title">Total</div>
                      <div class="total-value curr_total_amount">E£ 0.00</div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="saving-bar">
              <button class="cancels-btn">Cancel</button>
              <div class="tw-btns">
                <button class="save-btn" name="edit_order_purchase"><i class="fa-solid fa-floppy-disk"></i> Save</button>
              </div>
            </div>
          </form>
        </div>
        <div class="pay_payment_section">
          <div class="custome-head">
            <h3>Receive Money</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="profile_id" name="supplier_id" value="<?= $info['id'] ?>">
            <div class="custom-form custom-item-form payment_form">
              <div class="inputs w50">
                <label for="refer_order">Refered Order</label>
                <select name="order_id" id="refer_order">
                  <option value="custom">Custom</option>
                  <?= get_sell_orders_option() ?>
                </select>
              </div>
              <div class="inputs w50">
                <label for="amount_payment">Amount</label>
                <input type="number" name="amount_payment" id="amount_payment" value="0" step="0.01">
              </div>
              <div class="inputs w50">
                <label for="amount_payment_method">Receiving Payment Mehtod</label>
                <select name="amount_payment_method" id="amount_payment_method">
                  <option value="cash">Cash</option>
                  <option value="bank">Bank Account</option>
                  <option value="notes receivables">Notes Receivables</option>
                  <option value="checks under collection">Checks Under Collection</option>
                </select>
              </div>
              <div class="inputs amount_bank_choose w50">
                <label for="amount_bank_name">Bank Name</label>
                <select name="amount_bank_name" id="amount_bank_name">
                  <?= get_banks() ?>
                </select>
              </div>
              <div class="inputs amount_bank_num_choose w100">
                <label for="amount_bank_number">Bank Account</label>
                <select name="amount_bank_number" id="amount_bank_number">
                </select>
              </div>
              <div class="inputs w100">
                <label for="amount_cdate">Create Date</label>
                <input type="datetime-local" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d\TH:i") ?>">
              </div>
              <div class="inputs w100">
                <label for="amount_statement">Statement</label>
                <textarea name="amount_statement" id="amount_statement" cols="30" rows="10">استلام نقديه</textarea>
              </div>
            </div>

            <div class="order_payment_st">
              <h6>Order Quick Details</h6>
              <div class="payment_line">
                <div class="payment_title">Total Amount</div>
                <div class="payment_value">E£ <span class="payment_total"> 0.00</span></div>
              </div>
              <div class="payment_line">
                <div class="payment_title">Balance Due</div>
                <div class="payment_value">E£ <span class="old_payment_due"> 0.00</span></div>
              </div>
              <div class="payment_line">
                <div class="payment_title">Balance Due After</div>
                <div class="payment_value">E£ <span class="payment_due"> 0.00</span></div>
              </div>
            </div>
            <input type="hidden" name="old_due" id="payment_old_due" value="" disabled>
            <input type="submit" name="pay" value="Pay Now">
          </form>
        </div>

        <div class="mga"></div>
      </div>
      <script>
        $(document).ready(function() {

          $("#invoice-btn").click(function() {
            if ($(".invoice-page").css("height") == "0px") {
              $(".invoice-page").css({
                height: "100vh",
                "border-bottom": "1px solid #cfcfcf",
              });
              $("#statement").val("فاتورة مبيعات");
            }
          });

          $(".inv_number").on('keyup', function() {
            var inv_number = $(this).val();
            if (inv_number == '') {
              $(this).addClass('wrong');
              $(".new-inv-btn").prop('disabled', true);
            } else {
              $.ajax({
                type: "POST",
                url: "json/check_customer_invoice.php",
                data: {
                  inv_number,
                },
                dataType: "json",
                success: function(data2) {
                  if (data2 == true) {
                    $(".inv_number").addClass('wrong');
                    $(".new-inv-btn").prop('disabled', true);
                  } else {
                    $(".inv_number").removeClass('wrong');
                    $(".new-inv-btn").prop('disabled', false);
                  }
                  console.log(data2);
                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }
              });
            }
          });



          $(".confirm_delete_page .close_confirm").click(function() {

            $(".confirm_delete_page").css({
              height: "0px",
              padding: "0",
              "border": "0px solid #cfcfcf",
            });
            $(".black_screen").fadeOut(200);
          });
          $("#suppliertable").on("click", "button.delete_order", function() {
            var confirmHeight = $(".confirm_delete_page").prop("scrollHeight") + 50;
            $(".confirm_delete_page").css({
              height: confirmHeight + "px",
              padding: "20px 25px",
              border: "1px solid #cfcfcf",
            });
            var orderId = $(this).attr("btn-data");
            $(".confirm_id").val(orderId);
            $("span.order_id_confirm").html(orderId);
            $(".black_screen").fadeIn(200);
          });
          $("ul.customer li.activity-lnk button#activity-lnk").click(function() {
            $("li.activity-lnk").addClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".activity-list").show();
            $(".transaction-list").hide();
            $(".details-list").hide();
            $(".mony-list").hide();
            $(".purchase-list").hide();
            window.localStorage["active-menu"] = "activity";
          });

          $("ul.customer li.purchase-lnk button#purchase-lnk").click(function() {
            $("li.purchase-lnk").addClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.activity-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".purchase-list").show();
            $(".transaction-list").hide();
            $(".mony-list").hide();
            $(".details-list").hide();
            $(".activity-list").hide();
            window.localStorage["active-menu"] = "purchase";
          });
          $("ul.customer li.transaction-lnk button#transaction-lnk").click(function() {
            $("li.transaction-lnk").addClass("active");
            $("li.activity-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".transaction-list").show();
            $(".details-list").hide();
            $(".mony-list").hide();
            $(".activity-list").hide();
            $(".purchase-list").hide();

            window.localStorage["active-menu"] = "transaction";
          });

          $("ul.customer li.mony-lnk button#mony-lnk").click(function() {
            $("li.mony-lnk").addClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.activity-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $(".mony-list").show();
            $(".transaction-list").hide();
            $(".details-list").hide();
            $(".activity-list").hide();
            $(".purchase-list").hide();

            window.localStorage["active-menu"] = "mony";
          });

          $("ul.customer li.details-lnk button#details-lnk").click(function() {
            $("li.details-lnk").addClass("active");
            $("li.activity-lnk").removeClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".transaction-list").hide();
            $(".mony-list").hide();
            $(".details-list").show();
            $(".activity-list").hide();
            $(".purchase-list").hide();
            window.localStorage["active-menu"] = "details";
          });
          if (window.localStorage["active-menu"] == "details") {
            $("li.details-lnk").addClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".transaction-list").hide();
            $(".details-list").show();
            $(".purchase-list").hide();
            $(".mony-list").hide();
          } else if (window.localStorage["active-menu"] == "transaction") {
            $("li.transaction-lnk").addClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $("li.mony-lnk").removeClass("active");
            $(".transaction-list").show();
            $(".details-list").hide();
            $(".purchase-list").hide();
            $(".mony-list").hide();
          } else if (window.localStorage["active-menu"] == "mony") {
            $("li.mony-lnk").addClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.activity-lnk").removeClass("active");
            $("li.details-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $(".mony-list").show();
            $(".transaction-list").hide();
            $(".details-list").hide();
            $(".purchase-list").hide();
          } else {
            $("li.details-lnk").addClass("active");
            $("li.mony-lnk").removeClass("active");
            $("li.transaction-lnk").removeClass("active");
            $("li.purchase-lnk").removeClass("active");
            $(".transaction-list").hide();
            $(".details-list").show();
            $(".purchase-list").hide();
            $(".mony-list").hide();
          }



          $(".edit-invoice-page #close-btn-inv").click(function() {
            $(".edit-invoice-page").css({
              height: "0px",
              padding: "0",
              "border-bottom": "0px solid #cfcfcf",
            });
            $(".inv-edit-body")[0].reset();
          });

          $(".item_quantity1").on("change", function() {
            var limit = $(".item_limit1").attr("data-limit");
            if ($(this).val() > Number(limit)) {
              $(this).val(limit).trigger("input");
            }
          });


          $(".invoice-page #add-line-y").on("click", function() {
            event.preventDefault();

            var randomNumber = Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;

            $(".invoice-list .request-body-list").append('<div class="request-row" id="' + randomNumber + '"><div class="handle"><i class="fa-solid fa-ellipsis"></i></div><div><input type="text" class="item_name item_name' + randomNumber + '" name="p[' + randomNumber + '][name]" value=""><input type="number" class="hidden item_id' + randomNumber + '" name="p[' + randomNumber + '][id]" value=""><ul class="suggestion suggestion' + randomNumber + '"></ul></div><div><input type="text" name="p[' + randomNumber + '][description]" value=""></div><div><input type="number" class="item_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" step="0.01"><span class="item_limit item_limit' + randomNumber + '" data-limit="0">/ -</span></div><div><input type="text" class="item_unit' + randomNumber + '" name="p[' + randomNumber + '][unit]" value=""  disabled></div><div><input type="number" class="item_amount' + randomNumber + '" name="p[' + randomNumber + '][amount]" value="0" step="0.01"></div><div><input type="number" class="item_total item_total' + randomNumber + '" name="p[' + randomNumber + '][total]" value="0"  step="0.01"  disabled></div><div><button class="delete_row" data-row="' + randomNumber + '"><i class="fa-solid fa-trash"></i></button></div><div class="hidden"><input type="hidden" class="item_idy item_idy' + randomNumber + '" name="p[' + randomNumber + '][idy]" disabled></div></div>');

            $(".item_quantity" + randomNumber).on("input", function() {
              var new_amount = $(this).val() * $(".item_amount" + randomNumber).val();
              $(".item_total" + randomNumber).val(new_amount).trigger("change");
            });
            $(".item_amount" + randomNumber).on("input", function() {
              var new_amount = $(this).val() * $(".item_quantity" + randomNumber).val();
              $(".item_total" + randomNumber)
                .val(new_amount)
                .trigger("change");
            });

            $(".suggestion" + randomNumber).on("click", ".sug", function() {
              $.ajax({
                type: "POST",
                url: "functions/core/import_sell_item_details.php",
                data: {
                  data_id: $(this).attr("data-id"),
                },
                dataType: "json",
                success: function(data) {
                  var name = data.name;
                  var amount = data.amount;
                  var id = data.id;
                  var unit = data.unit;
                  var rate = data.cost;
                  var limit = data.limit;
                  $(".item_limit" + randomNumber).html("/ " + limit);
                  $(".item_limit" + randomNumber).attr("data-limit", limit);
                  $(".item_name" + randomNumber).val(name);
                  $(".item_amount" + randomNumber).val(amount);
                  $(".item_id" + randomNumber).val(id);
                  $(".item_unit" + randomNumber).val(unit);
                  $(".item_idy" + randomNumber).val(rate);
                  $(".item_quantity" + randomNumber).val(1);
                  $(".item_total" + randomNumber)
                    .val(amount)
                    .trigger("change");
                },
              });
            });
            $(".item_quantity" + randomNumber).on("change", function() {
              var limit = $(".item_limit" + randomNumber).attr("data-limit");
              if ($(this).val() > Number(limit)) {
                $(this).val(limit).trigger("input");
              }
            });
            $(".item_name" + randomNumber).focus(function() {
              if ($("ul.suggestion" + randomNumber).css("height") == "0px") {
                $("ul.suggestion" + randomNumber).css({
                  height: "auto",
                  border: "1px solid #cfcfcf",
                });
              } else {
                $("ul.suggestion" + randomNumber).css({
                  height: "0",
                  border: "0px solid #cfcfcf",
                });
              }
            });
            $(".item_name" + randomNumber).blur(function() {
              if ($(".item_id" + randomNumber) !== "") {
                $(this).val("");
                $(".item_id" + randomNumber).val("");
                $(".item_quantity" + randomNumber).val(0);
                $(".item_amount" + randomNumber).val(0);
                $(".item_unit" + randomNumber).val("");
                $(".item_idy" + randomNumber).val("");
                $(".item_total" + randomNumber)
                  .val(0)
                  .trigger("change");

              }
              $("ul.suggestion" + randomNumber).css({
                height: "0",
                border: "0px solid #cfcfcf",
              });
            });

            $(".item_name" + randomNumber).on("input", function() {
              $.ajax({
                type: "POST",
                url: "functions/core/sell_item_search.php",
                data: {
                  item_search: $(this).val(),
                },
                success: function(data) {
                  $(".suggestion" + randomNumber).html(data);
                },
              });
            });

            $(".delete_row").click(function(event) {
              event.preventDefault();
              var rowNumber = $(this).attr("data-row");
              $(".item_total" + rowNumber)
                .val(0)
                .trigger("change");
              var row_id = $(this).attr("data-row");
              var selectedrow = document.getElementById(row_id);
              selectedrow.remove();
            });
          });









          $("#amount_payment_method").on("change", function() {
            if ($(this).val() !== "bank") {
              $(".amount_bank_choose").css({
                "visibility": "hidden"
              });
              $(".amount_bank_num_choose").css({
                "display": "none"
              });
              paymentHeight = $(".pay_payment_section form").prop("scrollHeight") + 100;
              $(".pay_payment_section").css({
                height: paymentHeight + "px",
              });
            } else if ($(this).val() == "bank") {
              $(".amount_bank_choose").css({
                "visibility": "visible"
              });
              $(".amount_bank_num_choose").css({
                "display": "flex"
              });
              paymentHeight = $(".pay_payment_section form").prop("scrollHeight") + 100;
              $(".pay_payment_section").css({
                height: paymentHeight + "px",
              });

              $.ajax({
                type: "POST",
                url: "json/get_bank_number.php",
                data: {
                  bank_name: $("#amount_bank_name").val(),
                },
                dataType: "json",
                success: function(data2) {
                  $("#amount_bank_number option").remove();
                  $.each(data2, function(index, value) {
                    var objectString = '';
                    $.each(value, function(key, val) {
                      objectString += key + ': ' + val + ', ';
                    });

                    $("#amount_bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                  });

                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }

              });

            }
          });



          $("#amount_bank_name").on("change", function() {
            $.ajax({
              type: "POST",
              url: "json/get_bank_number.php",
              data: {
                bank_name: $("#amount_bank_name").val(),
              },
              dataType: "json",
              success: function(data2) {
                $("#amount_bank_number option").remove();
                $.each(data2, function(index, value) {
                  var objectString = '';
                  $.each(value, function(key, val) {
                    objectString += key + ': ' + val + ', ';
                  });

                  $("#amount_bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                });

              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }

            });
          });

          var taxFactor = 0;
          withholdingTitle = "Withholing Tax (0%)";
          $("#inv_type").on("change", function() {
            if ($(this).val() == "1") {
              taxFactor = 0;
              withholdingTitle = "Withholing Tax (0%)";
            } else if ($(this).val() == "2") {
              taxFactor = 0.01;
              withholdingTitle = "Withholing Tax (1%)";
            } else if ($(this).val() == "3") {
              taxFactor = 0.03;
              withholdingTitle = "Withholing Tax (3%)";
            }

            var paid = $("#paid").val();
            var vat_perc = $("#vat").val() / 100;
            var discount = $("#discount").val();
            var total = parseFloat($("#subtotal_purchase").val());
            var total_before = total - (parseFloat(discount));
            var total_vat = vat_perc * total_before;
            var withholding_tax = (total_before * taxFactor);
            var total_amount = (total_vat + total_before - parseFloat(withholding_tax));
            var total_due = total_amount - paid;
            $(".withholding_title").html(withholdingTitle);
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
            $(".withholding-amount").html("E£ - " + withholding_tax.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total_due);
            $("#vat_amount").val(total_vat);
            $("#withholding").val(withholding_tax);
            $("#subtotal_purchase").val(total);
            $("#total_purchase").val(total_amount);

          });





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
                var finalWith = (rate * taxFactor);
                var finalRate = (rate - finalWith);
                $("#vat").val("0");
                $(".item_name1").val(data.name);
                $(".item_id1").val(data.item_id);
                $("input[name='p[1][description]']").val(data.desc);
                $(".item_unit1").val(data.unit);
                $(".item_quantity1").val(-1);
                $(".item_amount1").val(data.rate);
                $(".item_total1").val(-1 * data.rate);
                $("#due_balance").val(-1 * data.rate);
                $(".subtotal-amount").html("E£ " + -1 * rate_format);
                $(".total-amount").html("E£ " + -1 * finalRate);
                $(".due-balance strong").html("E£ " + -1 * finalRate);
                $("#subtotal_purchase").val(-1 * data.rate);
                $("#withholding").val(-1 * finalWith);
                $(".withholding-amount").html("E£ - " + -1 * finalWith);
                $("#total_purchase").val(-1 * finalRate);
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
              url: 'json/get_sell_page.php',
              type: 'POST',
              dataType: 'json',
              data: {
                order_id: $(this).attr("btn-data"),
              },
              success: function(data) {
                $("#order_title").html("Sale Invoice #" + data.order_id);
                $(".order_edit_id").val(data.order_id);
                $(".curr_name").html(data.supplier_name);
                $(".curr_status").html(data.status);
                $(".curr_vat_perc").html(data.vat_perc);
                $(".curr_with_perc").html(data.withholding_perc);
                $(".curr_subtotal_amount").html("E£ " + data.subtotal);
                $(".curr_total_vat").html("E£ " + data.vat_amount);
                $(".curr_total_amount").html("E£ " + data.order_total);
                $("#curr_total").val(data.order_total);
                $("#curr_due").val(data.balance_due);
                $(".old_paid").val(data.paid);
                $(".order_edit_supplier_id").val(data.supplier_id);
                $("#old_due").val(data.old_balance);
                $(".curr_due_date").html(data.due_to);
                $(".mg-note-go").html(data.notes);
                $(".curr_discount_amount").html("E£ - " + data.discount);
                $(".curr_old_paid").html("E£ " + data.paid.toLocaleString('en-US', {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
                }));
                $(".curr_withholding_amount").html("E£ - " + data.withholding);
                if (data.payment_m !== "bank") {
                  $(".curr_bank").css({
                    "opacity": "0"
                  });
                  $(".curr_payment_m").html(data.payment_m);
                  $(".curr_bank_name").html("");
                  $(".curr_bank_number").html("");
                } else if (data.payment_m == "bank") {
                  $(".curr_bank").css({
                    "opacity": "1"
                  });
                  $(".curr_payment_m").html("Bank Account");
                  $(".curr_bank_name").html(data.bank_name);
                  $(".curr_bank_number").html(data.bank_number);
                }
                $(".curr_balance_due").html("E£ " + data.balance_due);
                $(".curr_due_date_input").val(data.due_to);
                $(".curr_create_date").html(data.created_time);

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
              url: 'json/get_sell_list.php',
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
                url: "json/order_payment_sell_details.php",
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
                type: 'customers',
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
              url: 'functions/core/sell_item_search.php',
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
              url: "functions/core/import_sell_item_details.php",
              data: {
                data_id: $(this).attr("data-id"),
              },
              dataType: "json",
              success: function(data) {
                var name = data.name;
                var amount = data.amount;
                var id = data.id;
                var unit = data.unit;
                var rate = data.cost;
                var limit = data.limit;
                $(".item_limit1").html("/ " + limit);
                $(".item_limit1").attr("data-limit", limit);
                $(".item_name1").val(name);
                $(".item_amount1").val(amount);
                $(".item_unit1").val(unit);
                $(".item_idy1").val(rate);
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
            var paid = $("#paid").val();
            var vat_perc = $("#vat").val() / 100;
            var discount = $("#discount").val();
            var total_before = total - (parseFloat(discount));
            var total_vat = vat_perc * total_before;
            var withholding_tax = (total_before * taxFactor);
            var total_amount = (total_vat + total_before - parseFloat(withholding_tax));
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
            $(".withholding-amount").html("E£ - " + withholding_tax.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total_due);
            $("#vat_amount").val(total_vat);
            $("#subtotal_purchase").val(total);
            $("#withholding").val(withholding_tax);
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


          $("#payment_m").on("change", function() {
            if ($(this).val() !== "bank") {
              $(".bank_choose").css({
                "visibility": "hidden"
              });



            } else if ($(this).val() == "bank") {
              $(".bank_choose").css({
                "visibility": "visible"
              });

              $.ajax({
                type: "POST",
                url: "json/get_bank_number.php",
                data: {
                  bank_name: $("#bank").val(),
                },
                dataType: "json",
                success: function(data2) {
                  $("#bank_number option").remove();
                  $.each(data2, function(index, value) {
                    var objectString = '';
                    $.each(value, function(key, val) {
                      objectString += key + ': ' + val + ', ';
                    });

                    $("#bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                  });

                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }

              });


            }
          });


          $("#bank").on("change", function() {

            $.ajax({
              type: "POST",
              url: "json/get_bank_number.php",
              data: {
                bank_name: $("#bank").val(),
              },
              dataType: "json",
              success: function(data2) {
                $("#bank_number option").remove();
                $.each(data2, function(index, value) {
                  var objectString = '';
                  $.each(value, function(key, val) {
                    objectString += key + ': ' + val + ', ';
                  });

                  $("#bank_number").append("<option value='" + value.bank_account + "'>" + value.bank_account + "</option>");
                });

              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }

            });


          });






          $("#discount").on("change", function() {
            var paid = $("#paid").val();
            var vat_perc = $("#vat").val() / 100;
            var discount = $("#discount").val();
            var total = parseFloat($("#subtotal_purchase").val());
            var total_before = total - (parseFloat(discount));
            var total_vat = vat_perc * total_before;
            var withholding_tax = (total_before * taxFactor);
            var total_amount = (total_vat + total_before - parseFloat(withholding_tax));
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
            $(".withholding-amount").html("E£ - " + withholding_tax.toLocaleString(undefined, {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            }));
            $("#due_balance").val(total_due);
            $("#vat_amount").val(total_vat);
            $("#withholding").val(withholding_tax);
            $("#subtotal_purchase").val(total);
            $("#total_purchase").val(total_amount);

          });
          $("#vat").on("change", function() {
            var vat_perc = $(this).val() / 100;
            var total = parseFloat($("#subtotal_purchase").val());
            var discount = $("#discount").val();
            var total_before = total - (parseFloat(discount));
            var total_vat = vat_perc * total_before;
            var withholding_tax = (total_before * taxFactor);
            var total_amount = (total_vat + total_before - parseFloat(withholding_tax));
            var paid = parseFloat($("#paid").val());
            var total_due = total_amount - paid;
            if (!paid) {
              var paid = 0;
            }
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
            $("#withholding").val(withholding_tax);
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
              url: 'functions/core/edit-customer.php',
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
      header("location:" . $path . "/customers.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/customers.php");
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