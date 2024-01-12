<?php
$pg_name = "Wonder - VAT Taxes Report";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2005) == 1) {
    $user_info = login_info();
    if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2006) == 1) {
      import_vat_payment();
    }
?>

    <div class="att-part vat-part vvat">
      <div class="title-head">
        <div class="headso">
          <h3>VAT Taxes Report
            <div class="inputs">
              <label for="create-date-filter">From Date </label>
              <input type="date" name="date" id="create-date-filter" value="<?= date("Y-m") . "-01" ?>">
            </div>
            <div class="inputs">
              <label for="end-date-filter">To </label>
              <input type="date" name="date" id="end-date-filter" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>">
            </div>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / VAT Taxes Report</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2006) == 1) {
          ?>
            <button class="new-btn" id="payment-btn">New Payment</button>
          <?php
          }
          ?>
        </div>

      </div>
      <div class="cash-container">
        <div class="cash-history">
          <div class="cash-history" style="margin-bottom: 0px;">
            <h4>VAT Report</h4>
            <div class="resp-table">
              <table id="supvatreport" style="width:100% !important;">
                <thead>
                  <div class="table_heading">Input VAT</div>
                  <tr>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Debit (E£)</th>
                    <th>Credit (E£)</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td>Total Input</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <script>
              $(function() {


                $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
                  var ukDate = date.split('/');
                  return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
                };
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
                var table = $('#supvatreport').DataTable({
                  ajax: {
                    url: 'json/supvat.php',
                    type: 'GET',
                    dataSrc: '',
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  },
                  "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                  ],
                  "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var colIndex1 = 2; // Set the index of the first column to calculate the sum for
                    var colIndex2 = 3; // Set the index of the first column to calculate the sum for

                    var colData1 = api.column(colIndex1, {
                      page: 'current'
                    }).data();
                    var colData2 = api.column(colIndex2, {
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
                    total3 = total1 - total2;
                    $(api.column(colIndex2).footer()).html('( ' + total3.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }) + ' )');
                    $("#total_supp").html('( ' + total3.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }) + ' )');
                    $("#total_due").html(-1 * total3);


                  },
                  pageLength: -1, // Set default selection to "All"
                  order: [
                    [1, 'desc']
                  ],
                  pageLength: -1, // Set default selection to "All"
                  language: {
                    paginate: {
                      previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                      next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                    }
                  },
                  columnDefs: [{
                      targets: 1,
                      orderable: false,
                    },
                    {
                      targets: 0,
                      orderable: false
                    },
                    {
                      targets: 2,
                      orderable: false,
                      type: 'date',
                    },
                    {
                      targets: 3,
                      orderable: false
                    },
                  ],
                  columns: [{
                      data: 'order_id',
                    },
                    {
                      data: 'date',
                      width: "150px",
                      // visible: false,
                    },
                    {
                      data: 'debit',
                      width: "130px"
                    },
                    {
                      data: 'credit',
                      width: "130px"
                    },
                  ],
                  autoWidth: false,
                  responsive: true,
                });
                $('input#create-date-filter').on('change', function() {
                  var create_date = $(this).val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#create-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table.column(1).search('').draw();
                  }
                });
                $('input#end-date-filter').on('change', function() {
                  var end_date = $(this).val();
                  var create_date = $('input#create-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#end-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table.column(1).search('').draw();
                  }
                });

                function startupBalance() {
                  var create_date = $('input#create-date-filter').val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($('input#create-date-filter').val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table.column(1).search(regex, true, false).draw();
                  }
                };

                setTimeout(startupBalance, 500);
                $("#supvatreport_paginate").remove();
                $("#supvatreport_info").remove();
                $("#supvatreport_length").remove();
                $("#supvatreport_filter").remove();





              });
            </script>
          </div>
          <div class="cash-history">
            <div class="resp-table">
              <table id="custvatreport" style="width:100% !important;">
                <thead style="background-color: #fff;">
                  <tr>
                    <th style="border-right:none;">Output VAT</th>
                    <th style="border-right:none;"></th>
                    <th style="border-right:none;"></th>
                    <th style="border-right:none;"></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td>Total Output</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <script>
              $(function() {

                $.fn.dataTable.ext.order['date-uk-pre'] = function(date) {
                  var ukDate = date.split('/');
                  return (ukDate[2] + ukDate[1] + ukDate[0]) * 1;
                };

                var table2 = $('#custvatreport').DataTable({
                  ajax: {
                    url: 'json/custvat.php',
                    type: 'GET',
                    dataSrc: '',
                  },
                  "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                  ],
                  "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var colIndex1 = 2; // Set the index of the first column to calculate the sum for
                    var colIndex2 = 3; // Set the index of the first column to calculate the sum for

                    var colData1 = api.column(colIndex1, {
                      page: 'current'
                    }).data();
                    var colData2 = api.column(colIndex2, {
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
                    total3 = total2 - total1;
                    $(api.column(colIndex2).footer()).html(total3.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }));
                    $("#total_customer").html(total3.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }));
                    $("#total_due").html((parseFloat($("#total_due").html()) + total3).toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }));

                  },
                  pageLength: -1, // Set default selection to "All"
                  order: [
                    [1, 'desc']
                  ],
                  pageLength: -1, // Set default selection to "All"
                  language: {
                    paginate: {
                      previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                      next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                    }
                  },
                  columnDefs: [{
                      targets: 1,
                      orderable: false,
                    },
                    {
                      targets: 0,
                      orderable: false
                    },
                    {
                      targets: 2,
                      orderable: false,
                      type: 'date',
                    },
                    {
                      targets: 3,
                      orderable: false
                    },
                  ],
                  columns: [{
                      data: 'order_id',
                    },
                    {
                      data: 'date',
                      width: "150px",
                      // visible: false,
                    },
                    {
                      data: 'debit',
                      width: "130px"
                    },
                    {
                      data: 'credit',
                      width: "130px"
                    },
                  ],
                  autoWidth: false,
                  responsive: true,
                });
                $('input#create-date-filter').on('change', function() {
                  var create_date = $(this).val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table2.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table2.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#create-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table2.column(1).search('').draw();
                  }
                });
                $('input#end-date-filter').on('change', function() {
                  var end_date = $(this).val();
                  var create_date = $('input#create-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table2.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table2.column(1).search(regex, true, false).draw();
                  }
                });
                $('input#end-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table2.column(1).search('').draw();
                  }
                });

                function startupBalance2() {
                  var create_date = $('input#create-date-filter').val();
                  var end_date = $('input#end-date-filter').val();
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($('input#create-date-filter').val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table2.column(1).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table2.column(1).search(regex, true, false).draw();
                  }
                };

                setTimeout(startupBalance2, 500);
                $("#custvatreport_paginate").remove();
                $("#custvatreport_info").remove();
                $("#custvatreport_length").remove();
                $("#custvatreport_filter").remove();





              });
            </script>
          </div>
        </div>
        <div class="cash-history" style="flex: 0.75;">
          <div class="cash-history">
            <h4>Due VAT</h4>
            <div class="resp-table">
              <table id="duevat" style="width:100% !important;">
                <thead>
                  <tr>
                    <th>Statement</th>
                    <th>Balance (E£)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Total Amount VAT</td>
                    <td id="total_due"></td>
                  </tr>
                  <tr>
                    <td>Total Withholding Tax.</td>
                    <td id="total_with">0.00</td>
                  </tr>
                  <tr>
                    <td>Deferred VAT</td>
                    <td id="total_deferred">0.00</td>
                  </tr>
                  <tr>
                    <td>Total Due</td>
                    <td id="total_vat">0.00</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
          <div class="cash-history">
            <h4>Payments on Next Month</h4>
            <div class="resp-table">
              <table id="transactions" style="width:100% !important;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Payment Method</th>
                    <th>Created Date</th>
                    <th>Amount (E£)</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
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

                var table4 = $('#transactions').DataTable({
                  ajax: {
                    url: 'json/vattrans.php',
                    type: 'GET',
                    dataSrc: '',
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  },
                  buttons: [{
                      extend: 'csv',
                      charset: 'UTF-8',
                      bom: true,
                      exportOptions: {
                        encoding: 'UTF-8'
                      }
                    },

                  ],
                  "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                  ],
                  "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var colIndex = 3; // Set the index of the first column to calculate the sum for

                    var colData = api.column(colIndex, {
                      page: 'current'
                    }).data();
                    var total = 0;



                    var total = api.column(colIndex, {
                      page: 'current'
                    }).data().sum();


                    var footer = api.column(colIndex).footer();
                    $(footer).html('E£ ' + total.toLocaleString('en-US', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    }));

                  },
                  pageLength: -1, // Set default selection to "All"
                  order: [
                    [0, 'desc']
                  ],
                  pageLength: -1, // Set default selection to "All"
                  language: {
                    paginate: {
                      previous: '<i class="fa fa-chevron-left"></i>', // Customize the previous button
                      next: '<i class="fa fa-chevron-right"></i>' // Customize the next button
                    }
                  },
                  columnDefs: [{
                      targets: 1,
                      orderable: false,
                      type: 'date',
                    },
                    {
                      targets: 0,
                      orderable: false
                    },
                    {
                      targets: 3,
                      orderable: false
                    }, {
                      targets: 2,
                      orderable: false
                    },
                  ],
                  columns: [{
                      data: 'no',
                      width: "50px"
                    },
                    {
                      data: 'payment_method',
                    },
                    {
                      data: 'date',
                      width: "150px"
                    },
                    {
                      data: 'amount',
                      width: "130px"
                    },
                  ],
                  autoWidth: false,
                  responsive: true,
                });

                function formatDate(date) {
                  var year = date.getFullYear();
                  var month = date.getMonth() + 1; // Note: Month starts from 0, so we add 1
                  var day = date.getDate();

                  // Format the date as YYYY-MM-DD
                  var formattedDate = year + '-' + addLeadingZero(month) + '-' + addLeadingZero(day);

                  return formattedDate;
                }

                // Helper function to add leading zero to single-digit month or day
                function addLeadingZero(number) {
                  return number.toString().padStart(2, '0');
                }

                $('input#create-date-filter').on('change', function() {
                  var create_date_input = $(this).val(); // Retrieve the value of the input field
                  var date = new Date(create_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var create_date = formatDate(date);
                  var end_date_input = $('input#end-date-filter').val(); // Retrieve the value of the input field
                  var date = new Date(end_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var end_date = formatDate(date);
                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table4.column(2).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table4.column(2).search(regex, true, false).draw();
                  }

                  $.ajax({
                    url: 'json/get_due_vat.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                      start_date: $('#create-date-filter').val(),
                      end_date: $('#end-date-filter').val(),
                    },
                    success: function(data) {
                      $("#total_deferred").html(data.due.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      var total3 = parseFloat($("#total_due").html().replace(/,/g, ''));
                      $("#total_with").html(data.with.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      var total_with = parseFloat($("#total_with").html().replace(/,/g, ''));
                      var total_due = total3 + data.due + total_with;
                      $("#total_vat").html(total_due.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });
                });
                $('input#create-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table4.column(2).search('').draw();
                  }
                });
                $('input#end-date-filter').on('change', function() {
                  var create_date_input = $('input#create-date-filter').val(); // Retrieve the value of the input field
                  var date = new Date(create_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var create_date = formatDate(date);
                  var end_date_input = $(this).val(); // Retrieve the value of the input field
                  var date = new Date(end_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var end_date = formatDate(date);

                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($(this).val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table4.column(2).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table4.column(2).search(regex, true, false).draw();
                  }

                  $.ajax({
                    url: 'json/get_due_vat.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                      start_date: $('#create-date-filter').val(),
                      end_date: $('#end-date-filter').val(),
                    },
                    success: function(data) {
                      $("#total_deferred").html(data.due.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      var total3 = parseFloat($("#total_due").html().replace(/,/g, ''));
                      $("#total_with").html(data.with.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      var total_with = parseFloat($("#total_with").html().replace(/,/g, ''));
                      var total_due = total3 + data.due + total_with;
                      $("#total_vat").html(total_due.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });
                });
                $('input#end-date-filter').on('blur', function() {
                  if ($(this).val() === '') {
                    table4.column(2).search('').draw();
                  }
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
                  var barcodeDiv = document.getElementById("supvatreport");
                  var barcodeDiv2 = document.getElementById("custvatreport");
                  var printWindow = window.open('', '');
                  printWindow.document.write('<html><head><title>Vat Taxes Report</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                  printWindow.document.write('<style>tfoot tr td {border-right: 0;} tfoot {font-weight: 600;} table td:nth-child(2), table th:nth-child(2),td:nth-child(3), table th:nth-child(3), td:nth-child(4), table th:nth-child(4){width: 400px !important;}</style>');
                  printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Vat Taxes Report</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div>');
                  printWindow.document.write('<table><thead class="table_heading" style="background:#fff;"><tr><th style="border-right:none;">Input VAT</th><th style="border-right:none;"></th><th style="border-right:none;"></th><th style="border-right:none;"></th></tr></thead>');
                  printWindow.document.write(barcodeDiv.innerHTML);
                  printWindow.document.write('</table><table>');
                  printWindow.document.write(barcodeDiv2.innerHTML);
                  printWindow.document.write('</table><table><tfoot><tr><td>Total Amount VAT</td><td></td><td></td><td>' + $("#total_due").html() + '</td></tr></tfoot></table><table><tfoot><tr><td>Total Withholding Tax.</td><td></td><td></td><td>' + $("#total_with").html() + '</td></tr></tfoot></table><table><tfoot><tr><td>Deferred VAT</td><td></td><td></td><td>' + $("#total_deferred").html() + '</td></tr></tfoot></table><table><tfoot><tr><td>Total Due</td><td></td><td></td><td>' + $("#total_vat").html() + '</td></tr></tfoot></table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
                });


                function startupBalance3() {
                  var create_date_input = $('input#create-date-filter').val(); // Retrieve the value of the input field
                  var date = new Date(create_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var create_date = formatDate(date);
                  var end_date_input = $('input#end-date-filter').val(); // Retrieve the value of the input field
                  var date = new Date(end_date_input);
                  date.setMonth(date.getMonth() + 1);
                  var end_date = formatDate(date);



                  create_date = new Date(create_date).toISOString().substring(0, 10); // Convert to ISO string format
                  end_date = new Date(end_date).toISOString().substring(0, 10); // Convert to ISO string format
                  if ($('input#create-date-filter').val() === '') {
                    filtered = '';
                  } else {
                    var filtered = table4.column(2).data().filter(function(value, index) {
                      return value >= create_date && value <= end_date; // Filter the data based on the entered date
                    }).join("|");
                    var valuesToDraw = filtered.split("|");
                    var regex = valuesToDraw.map(function(value) {
                      return '^' + value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '$'; // Escape special characters and add start and end anchors
                    }).join('|');
                    table4.column(2).search(regex, true, false).draw();
                  }
                  $.ajax({
                    url: 'json/get_due_vat.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                      start_date: $('#create-date-filter').val(),
                      end_date: $('#end-date-filter').val(),
                    },
                    success: function(data) {
                      $("#total_deferred").html(data.def.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      total3 = parseFloat($("#total_due").html().replace(/,/g, ''));
                      $("#total_with").html(data.with.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                      var total_with = parseFloat($("#total_with").html().replace(/,/g, ''));
                      var total_due = total3 + data.due + total_with;
                      $("#total_vat").html(total_due.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }));
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });

                };

                setTimeout(startupBalance3, 500);
                $("#transactions_paginate").remove();
                $("#transactions_info").remove();
                $("#transactions_length").remove();
                $("#transactions_filter").remove();





              });
            </script>
          </div>
        </div>
      </div>
      <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2006) == 1) { ?>
        <div class="black_screen"></div>
        <div class="pay_payment_section share_payment">
          <div class="custome-head">
            <h3>New Payment</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" action="" method="POST" enctype="multipart/form-data">
            <div class="custom-form custom-item-form payment_form">
              <div class="inputs w100">
                <label for="amount_payment">Amount</label>
                <input type="number" name="amount_payment" id="amount_payment" min="0" value="0" step="0.01" required>
              </div>
              <div class="inputs w50">
                <label for="amount_payment_method">To/From Account</label>
                <select name="amount_payment_method" id="amount_payment_method" required>
                  <option value="cash">Treasury Cash</option>
                  <option value="bank">Bank Account</option>
                </select>
              </div>
              <div class="inputs amount_bank_choose w50">
                <label for="amount_bank_name">Bank Name</label>
                <select name="bank_name" id="amount_bank_name">
                  <?= get_banks() ?>
                </select>
              </div>
              <div class="inputs amount_bank_num_choose w100">
                <label for="amount_bank_number">Bank Account</label>
                <select name="bank_number" id="amount_bank_number">
                </select>
              </div>
              <div class="inputs w100">
                <label for="amount_cdate">Create Date</label>
                <input type="datetime-local" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d\TH:i") ?>" required>
              </div>
            </div>
            <input type="submit" name="pay" value="Pay">
          </form>
        </div>
      <?php } ?>
      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {
        $("#amount_payment_method").on("change", function() {
          if ($(this).val() == "cash") {
            $(".amount_bank_choose").css({
              "visibility": "hidden"
            });
            $(".amount_bank_num_choose").css({
              "display": "none"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight") - 70;
            $(".pay_payment_section").css({
              height: paymentHeight + "px",
            });
          } else {
            $(".amount_bank_choose").css({
              "visibility": "visible"
            });
            $(".amount_bank_num_choose").css({
              "display": "flex"
            });
            paymentHeight = $(".pay_payment_section").prop("scrollHeight");
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

        $("#ExportReporttoExcel").on("click", function() {
          table.button('.buttons-csv').trigger();
        });
        $("#ExportReporttoPdf").on("click", function() {
          table.button('.buttons-pdf').trigger();
        });

        $('.dataTables_filter').remove();

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