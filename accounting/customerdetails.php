t<?php
  $pg_name = "Wonder - Customers";
  session_start();
  include "includes/header.inc";
  if (login_redirect() == 1) {
    $user_info = login_info();
    if (check_id('customers')) {
      $info = info('customers');
      import_customer_purchase();
      edit_supplier_purchase();
      import_quick_payment();
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
          <button class="edit edit-btn">Edit</button>
          <button class="transactions">New <i class="fa-solid fa-caret-down"></i></button>
          <ul class="transactions-list">
            <li class="trans-option" id="invoice-btn">Sell Order</li>
            <li class="trans-option" id="payment-btn">Receive Money</li>
            <li class="trans-option" id="return-btn">Return Order</li>
          </ul>
        </div>
        <div class="dues">
          <div class="due open-dues">
            <span class="due-value">E£
              <?= get_purchase_due() ?>
            </span>
            <span class="due-title">DUE</span>
          </div>
          <div class="due over-dues">
            <span class="due-value">E£
              <?= get_purchase_overdue() ?>
            </span>
            <span class="due-title">OVERDUE</span>
          </div>
        </div>
      </div>
    </div>
    <ul class="profile-lnks customer">
      <li class="details-lnk  active"><button id="details-lnk">Customer Details</button></li>
      <li class="mony-lnk"><button id="mony-lnk">Account Statement</button></li>
      <li class="transaction-lnk"><button id="transaction-lnk">Orders</button></li>
    </ul>
    <div class="mony-list listo">
      <h4 class='submarin'>Customer Account Statement</h4>
      <div class="btns">
        <button class="filter"><i class="fa-solid fa-filter"></i></button>
        <button class="export"><i class="fa-solid fa-download"></i>
          <ul class="export-options">
            <li class="option">
              <div><i class="fa-solid fa-print"></i> Print List</div>
            </li>
            <li class="option">
              <div><i class="fa-solid fa-file-csv"></i> Excel Sheet</div>
            </li>
          </ul>
        </button>
      </div>
      <div class="request-section filter-section">
        <form action="">
          <h6 class="fhead">Filteration</h6>
          <div class="inputs inputs-grid">

            <div class="inputs">
              <label for="start-date-filter-trans">Start Date</label>
              <input type="date" name="start-date-filter-trans" id="start-date-filter-trans" value="<?= $info['created_time'] ?>">
            </div>
            <div class="inputs">
              <label for="end-date-filter-trans">End Date</label>
              <input type="date" name="end-date-filter-trans" id="end-date-filter-trans">
            </div>
            <div class="inputs">
              <label for="filter_payment_m">Payment Method</label>
              <select name="filter_payment_m" id="filter_payment_m">
                <option value="all">All</option>
                <option value="Bank Account">Bank Account</option>
                <option value="Cash">Cash</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="resp-table">
        <div class="serch">
          <input type="text" id="search-filter-trans" value="" placeholder="Search...">
        </div>
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
            'createdRow': function(row, data, dataIndex) {
              $('td', row).css('min-width', '200px');
            },
            ajax: {
              url: 'json/suppliertrans.php',
              type: 'GET',
              dataSrc: '',
              data: {
                uid: $('#profile_id').val()
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





              var total = api.column(colIndex, {
                page: 'current'
              }).data().sum();
              var total2 = api.column(colIndex2, {
                page: 'current'
              }).data().sum();
              var lastValue = 'E£ ' + (total2 - total).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              });

              var footer = api.column(colIndex).footer();
              var footer2 = api.column(colIndex2).footer();
              $(api.column(colIndex3).footer()).html(lastValue);
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
              {
                targets: 8,
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
              {
                data: 'action'
              },
            ],
            autoWidth: false,
            responsive: true,
          });






          $('select#filter_refered').on('change', function() {
            var refered = $(this).val();
            if ($(this).val() === 'all') {
              table2.column(3).search('').draw();
            } else {
              table2.column(3).search(refered, true, false).draw();
            }
          });
          $('input#create-date-filter-trans').on('change', function() {
            var create_date2 = $(this).val();
            create_date2 = new Date(create_date2).toISOString().substring(0, 10); // Convert to ISO string format

            if ($(this).val() === '') {
              table2.column(2).search('').draw();
            } else {
              table2.column(2).search(create_date2).draw();
            }
          });

          $('input#create-date-filter-trans').on('blur', function() {
            if ($(this).val() === '') {
              table2.column(2).search('').draw();
            }
          });
          $('#search-filter-trans').on('keyup', function() {
            var searchValue = $(this).val();
            table2.search(searchValue).draw();
          });



        });
      </script>

    </div>
    <div class="transaction-list listo">
      <h4 class='submarin'>Orders</h4>
      <div class="btns">
        <button class="filter"><i class="fa-solid fa-filter"></i></button>
        <button class="export"><i class="fa-solid fa-download"></i>
          <ul class="export-options">
            <li class="option">
              <div><i class="fa-solid fa-print"></i> Print List</div>
            </li>
            <li class="option" id="export_order_btn">
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
            <?= get_purchase_paid() ?>
          </div>
          <div class="jo">E£
            <?= get_due() ?>
          </div>
          <div class="jo">E£
            <?= get_purchase_total() ?>
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
            'createdRow': function(row, data, dataIndex) {
              $('td:eq(3)', row).css('min-width', '200px');
            },
            ajax: {
              url: 'json/supplier_transactions.php',
              type: 'GET',
              dataSrc: '',
              data: {
                uid: $('#profile_id').val()
              },
            },
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


          // $('#export_order_btn').on('click', function() {
          //   // Get the table data
          //   var table = [];
          //   var $tableRows = $('table thead tr');

          //   // Iterate over each row in the table
          //   $tableRows.each(function() {
          //     var rowData = [];
          //     var $cells = $(this).find('th');

          //     // Iterate over each cell in the row
          //     $cells.each(function() {
          //       rowData.push($(this).text());
          //     });

          //     // Add the row data to the tableData array
          //     table.push(rowData);
          //   });

          //   // Convert the data to CSV format
          //   var csv = Papa.unparse(table);

          //   // Create a download link
          //   var link = $('<a></a>');
          //   link.attr('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv));
          //   link.attr('download', 'table_data.csv');

          //   // Trigger the download
          //   link[0].click();
          // });

          $('.dataTables_filter').remove();
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

          $(".edit-invoice-page #close-btn").click(function() {
            $(".edit-invoice-page").css({
              height: "0px",
              padding: "0",
              "border-bottom": "0px solid #cfcfcf",
            });

            $(".inv-edit-body")[0].reset();
          });
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
  <div class="black_screen"></div>
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
  <div class="black_screen"></div>
  <div class="invoice-page">
    <form action="" method="POST" class="inv-body" enctype="multipart/form-data">
      <div class="inv-head">
        <h2 class="inv-title">Sell Order #
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
          <div class="inputs gd1">
            <label for="terms">Terms</label>
            <select name="terms" id="terms">
              <option value="dueonreceipt">On delivery</option>
              <option value="15">Net 15</option>
              <option value="30">Net 30</option>
              <option value="60">Net 60</option>
            </select>
          </div>
          <div class="inputs gd1">
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
                <div><input type="number" class="item_quantity1" name="p[1][quantity]" value="0" min="0" step="0.01"></div>
                <div><input type="text" class="item_unit1" name="p[1][unit]" disabled></div>
                <div><input type="number" class="item_amount1" name="p[1][amount]" value="0" min="0" step="0.01"></div>
                <div><input type="number" class="item_total item_total1" name="p[1][total]" value="0" min="0" step="0.01" disabled></div>
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
                  <label for="mg-invoice">Hardcopy Invoice [Optional]</label>
                  <input type="file" name="hardcopy" class="hardcopy" id="mg-invoice">
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
                <div class="total-value minus">E£ - <input type="number" name="discount" id="discount" value="0" step="0.01"></div>
              </div>
              <div class="total-gd">
                <div class="total-title withholding_title">Withholing Tax (0%)</div>
                <div class="total-value withholding-amount minus">E£ - 0.00</div>
              </div>
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
          <button class="save-btn" name="save_order_purchase"><i class="fa-solid fa-floppy-disk"></i> Save</button>
        </div>
      </div>
    </form>
  </div>
  <div class="edit-invoice-page">
    <div class="inv-head">
      <h2 class="inv-title" id="order_title">Purchase Order #..</h2>
      <button id="close-btn" class="close"><i class="fa-solid fa-xmark"></i></button>
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
          <div class="inputs gd1">
            <label for="">Withholding Tax(%)</label>
            <div class="curr curr_with_perc"></div>
          </div>
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
                  <label for="mg-invoice">Hardcopy Invoice</label>
                  <div class="mg-invoice-go"></div>
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
              <div class="total-gd">
                <div class="total-title">Withholding Tax</div>
                <div class="total-value curr_withholding_amount">E£ - 0.00</div>
              </div>
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
            <?= get_orders_option() ?>
          </select>
        </div>
        <div class="inputs w50">
          <label for="amount_payment">Amount</label>
          <input type="number" name="amount_payment" id="amount_payment" min="0" value="0" step="0.01">
        </div>
        <div class="inputs w50">
          <label for="amount_payment_method">Receiving Payment Mehtod</label>
          <select name="amount_payment_method" id="amount_payment_method">
            <option value="cash">Cash</option>
            <option value="bank">Bank Account</option>
          </select>
        </div>
        <div class="inputs amount_bank_choose w50">
          <label for="amount_bank_name">Bank Name</label>
          <select name="amount_bank_name" id="amount_bank_name">
            <?= get_banks() ?>
            <!-- <option value="البنك الأهلى المصرى">البنك الأهلى المصرى</option>
                <option value="بنك الإسكندرية">بنك الإسكندرية</option>
                <option value="بنك ابو ظبي التجاري – مصر">بنك ابو ظبي التجاري – مصر</option>
                <option value="مصرف أبو ظبي الإسلامي">مصرف أبو ظبي الإسلامي</option>
                <option value="البنك الأهلي المتحد - مصر">البنك الأهلي المتحد - مصر</option>
                <option value="البنك العربي الافريقي">البنك العربي الافريفي</option>
                <option value="البنك العربي">البنك العربي</option>
                <option value="المصرف العربي الدولي">المصرف العربي الدولي</option>
                <option value="بنك التجاري وفا">بنك التجاري وفا</option>
                <option value="بنك القاهرة">بنك القاهرة</option>
                <option value="بنك مصر">بنك مصر</option>
                <option value="البنك المركزي المصري">البنك المركزي المصري</option>
                <option value="سيتي بنك">سيتي بنك</option>
                <option value="البنك التجاري الدولي">البنك التجاري الدولي</option>
                <option value="بنك كريدي أجريكول مصر">بنك كريدي أجريكول مصر</option>
                <option value="البنك العقاري المصري العربي">البنك العقاري المصري العربي</option>
                <option value="البنك المصري الخليجي">البنك المصري الخليجي</option>
                <option value="بنك الإمارات دبي الوطني مصر">بنك الإمارات دبي الوطني مصر</option>
                <option value="Export Development Bank of Egypt">Export Development Bank of Egypt</option>
                <option value="بنك فيصل الاسلامى">بنك فيصل الاسلامى</option>
                <option value="HSBC Bank Egypt S.A.E">HSBC Bank Egypt S.A.E</option>
                <option value="بنك التعمير والإسكان">بنك التعمير والإسكان</option>
                <option value="بنك المشرق">بنك المشرق</option>
                <option value="بنك الكويت الوطني">بنك الكويت الوطني</option>
                <option value="QNB ALAHLI">QNB ALAHLI</option>
                <option value="Societe Arabe Internationale De Banque">Societe Arabe Internationale De Banque</option>
                <option value="بنك قناة السويس">بنك قناة السويس</option>
                <option value="المصرف المتحد">المصرف المتحد</option>
                <option value="aiBANK">aiBANK</option>
                <option value="بنك البركة">بنك لبركة</option> -->
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





    $(".invoice-page #add-line-y").on("click", function() {
      event.preventDefault();

      var randomNumber = Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;

      $(".invoice-list .request-body-list").append('<div class="request-row" id="' + randomNumber + '"><div class="handle"><i class="fa-solid fa-ellipsis"></i></div><div><input type="text" class="item_name item_name' + randomNumber + '" name="p[' + randomNumber + '][name]" value=""><input type="number" class="hidden item_id' + randomNumber + '" name="p[' + randomNumber + '][id]" value=""><ul class="suggestion suggestion' + randomNumber + '"></ul></div><div><input type="text" name="p[' + randomNumber + '][description]" value=""></div><div><input type="number" class="item_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" min="0" step="0.01"></div><div><input type="text" class="item_unit' + randomNumber + '" name="p[' + randomNumber + '][unit]" value="" min="0" disabled></div><div><input type="number" class="item_amount' + randomNumber + '" name="p[' + randomNumber + '][amount]" value="0" min="0" step="0.01"></div><div><input type="number" class="item_total item_total' + randomNumber + '" name="p[' + randomNumber + '][total]" value="0" min="0" step="0.01"  disabled></div><div><button class="delete_row" data-row="' + randomNumber + '"><i class="fa-solid fa-trash"></i></button></div><div class="hidden"><input type="hidden" class="item_idy item_idy' + randomNumber + '" name="p[' + randomNumber + '][idy]" disabled></div></div>');

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
            $(".item_name" + randomNumber).val(name);
            $(".item_amount" + randomNumber).val(amount);
            $(".item_id" + randomNumber).val(id);
            $(".item_unit" + randomNumber).val(unit);
            $(".item_idy" + randomNumber).val(data.idy);
            $(".item_quantity" + randomNumber).val(1);
            $(".item_total" + randomNumber)
              .val(amount)
              .trigger("change");
          },
        });
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
          $(".item_quantity1").val(1);
          $(".item_amount1").val(data.rate);
          $(".item_total1").val(data.rate);
          $("#due_balance").val(data.rate);
          $(".subtotal-amount").html("E£ " + rate_format);
          $(".total-amount").html("E£ " + finalRate);
          $(".due-balance strong").html("E£ " + finalRate);
          $("#subtotal_purchase").val(data.rate);
          $("#withholding").val(finalWith);
          $(".withholding-amount").html("E£ - " + finalWith);
          $("#total_purchase").val(finalRate);
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
          $(".mg-invoice-go").html(data.hardcopy);
          $(".curr_discount_amount").html("E£ - " + data.discount);
          $(".curr_old_paid").html("E£ " + data.paid.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }));
          $(".curr_withholding_amount").html("E£ - " + data.withholding);
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

          $(".item_name1").val(name);
          $(".item_amount1").val(amount);
          $(".item_unit1").val(unit);
          $(".item_idy1").val(data.idy);
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
      if ($(this).val() == "cash") {
        $(".bank_choose").css({
          "visibility": "hidden"
        });



      } else {
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
        url: 'functions/core/edit-supplier.php',
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
    } else if (window.localStorage["active-menu"] == "purchase") {
      $("li.purchase-lnk").addClass("active");
      $("li.details-lnk").removeClass("active");
      $("li.transaction-lnk").removeClass("active");
      $("li.mony-lnk").removeClass("active");
      $(".purchase-list").show();
      $(".transaction-list").hide();
      $(".details-list").hide();
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
    header("location:" . $path . "/../login.php");
    exit();
  }
  include "includes/footer.inc";
?>