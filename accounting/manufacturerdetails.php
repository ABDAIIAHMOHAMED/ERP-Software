<?php
$pg_name = "Wonder - Manufacturers";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_id('manufacturers')) {
    $info = info('manufacturers');
    import_manufacure();
    edit_manufacturer_purchase();
    import_quick_manufacturer_payment();
?>

    <div class="att-part">
      <div class="title-head">
        <div class="headso">
          <h3>Manufacturer Profile</h3>
          <?php

          ?>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "manufacturers.php" ?>">Manufacturers</a>
            / Manufacturer Profile</p>
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
                <li class="trans-option" id="invoice-btn">Manufacturing Order</li>
                <li class="trans-option" id="payment-btn">Payment Order</li>
              </ul>
            </div>
            <div class="dues">
              <div class="due open-dues">
                <span class="due-value">E£
                  <?= get_manufacturing_due() ?>
                </span>
                <span class="due-title">DUE</span>
              </div>
              <div class="due over-dues">
                <span class="due-value">E£
                  <?= get_manufacturing_overdue() ?>
                </span>
                <span class="due-title">OVERDUE</span>
              </div>
            </div>
          </div>
        </div>
        <ul class="profile-lnks customer">
          <li class="details-lnk  active"><button id="details-lnk">Manufacturer Details</button></li>
          <li class="mony-lnk"><button id="mony-lnk">Account Statement</button></li>
          <li class="transaction-lnk"><button id="transaction-lnk">Orders</button></li>
          <li class="purchase-lnk"><button id="purchase-lnk">Manufactured Products</button></li>
        </ul>
        <div class="mony-list listo">
          <h4 class='submarin'>Manufacturer Account Statement</h4>
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
                  <label for="filter_refered">Refered Order</label>
                  <select name="filter_refered" id="filter_refered">
                    <option value="all">All</option>
                    <option value="Order">Refered Order</option>
                    <option value="-">Not Refered Order</option>
                  </select>
                </div>
                <div class="inputs">
                  <label for="create-date-filter-trans">Create Date</label>
                  <input type="date" name="create-date-filter-trans" id="create-date-filter-trans">
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
                ajax: {
                  url: 'json/manufacturertrans.php',
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
                <li class="option">
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
                <?= get_manufacturing_paid() ?>
              </div>
              <div class="jo">E£
                <?= get_manu_due() ?>
              </div>
              <div class="jo">E£
                <?= get_manufacturer_total() ?>
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
                  url: 'json/manufacturer_transactions.php',
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
                  url: 'json/get_manufacture_page.php',
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
                      $("#curr_started").prop('checked', false);
                      $("#curr_started").prop('disabled', false);
                    } else {
                      $("#curr_received").prop('checked', true);
                      $("#curr_received").prop('disabled', true);
                      $("#curr_started").prop('checked', true);
                      $("#curr_started").prop('disabled', true);
                    }

                    if (data.started == "0") {
                      $("#curr_started").prop('checked', false);
                      $("#curr_started").prop('disabled', false);
                    } else {
                      $("#curr_started").prop('checked', true);
                      $("#curr_started").prop('disabled', true);
                    }


                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });

                $(".add_new_item button.close").click(function() {
                  $(".comp-items").css({
                    "height": "0",
                    "overflow": "hidden"
                  });
                });
                $.ajax({
                  url: 'json/get_manufacture_list.php',
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

                      $('#inv-edit-list').append('<div class="request-row"><div></div><div><div class="val">' + value.item_name + '</div></div><div><div class="val">' + value.item_desc + '</div></div><div><div class="val">' + value.item_quantity + '</div></div><div><div class="val">' + value.item_unit + '</div></div><div></div></div><div class="request-row"><div></div><div><div class="val">Manufactuing Service Cost</div></div><div><div class="val"></div></div><div><div class="val"></div></div><div><div class="val">' + value.subtotal + '</div></div><div></div></div>');
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
                <div class="info-title">Manufacturer</div>
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
        <div class="purchase-list listo">








          <h4 class='submarin'>Manufactured Products</h4>
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
                  <label for="stock">Status</label>
                  <select name="stock" id="stock">
                    <option value="all">All</option>
                    <option value="on stock">On Stock</option>
                    <option value="out of">Out of Stock</option>
                  </select>
                </div>
                <div class="inputs">
                  <label for="store">Storable</label>
                  <select name="store" id="store">
                    <option value="all">All</option>
                    <option value="Warehouse">Storable</option>
                    <option value="Not Stored">Not Stored</option>
                  </select>
                </div>
                <div class="inputs">
                  <label for="create-date-filter-purch">Create Date</label>
                  <input type="date" name="create-date-filter-purch" id="create-date-filter-purch">
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
                  <th>Description</th>
                  <th>Rate (E£)</th>
                  <th>Quantity</th>
                  <th>Warehouse</th>
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

              var table3 = $('#supplierpurch').DataTable({
                ajax: {
                  url: 'json/supplier_inventory.php',
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
                    data: 'desc',
                    width: "350px"
                  },


                  {
                    data: 'rate',
                    width: "80px"
                  },
                  {
                    data: 'status'
                  },
                  {
                    data: 'storable'
                  },
                  {
                    data: 'date',
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
              $('select#stock').on('change', function() {
                var stock = $(this).val();
                if ($(this).val() === 'all') {
                  table3.column(5).search('').draw();
                } else {
                  table3.column(5).search(stock, true, false).draw();
                }
              });
              $('select#store').on('change', function() {
                var store = $(this).val();
                if ($(this).val() === 'all') {
                  table3.column(4).search('').draw();
                } else {
                  table3.column(4).search(store).draw();
                }
              });
              $('input#create-date-filter-purch').on('change', function() {
                var create_date3 = $(this).val();
                create_date3 = new Date(create_date3).toISOString().substring(0, 10); // Convert to ISO string format

                if ($(this).val() === '') {
                  table3.column(-2).search('').draw();
                } else {
                  table3.column(-2).search(create_date3).draw();
                }
              });

              $('input#create-date-filter-purch').on('blur', function() {
                if ($(this).val() === '') {
                  table2.column(-2).search('').draw();
                }
              });
              $('#search-filter-purch').on('keyup', function() {
                var searchValue2 = $(this).val();
                table3.search(searchValue2).draw();
              });

            });
          </script>










        </div>
      </div>
      <div class="black_screen"></div>
      <div class="add_new edit_supplo">
        <div class="custome-head">
          <h3>Edit Manufacturer</h3>
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
      <div class="add_new add_new_item">
        <div class="custome-head">
          <h3>Add Product</h3>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" id="new_item" action="" method="POST" enctype="multipart/form-data">
          <div class="custom-form custom-item-form">
            <div class="spectra">
              <label for="item_img_input">
                <div class="item_image">
                  <span class="edit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 492.493 492" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                      <g>
                        <path d="M304.14 82.473 33.165 353.469a10.799 10.799 0 0 0-2.816 4.949L.313 478.973a10.716 10.716 0 0 0 2.816 10.136 10.675 10.675 0 0 0 7.527 3.114 10.6 10.6 0 0 0 2.582-.32l120.555-30.04a10.655 10.655 0 0 0 4.95-2.812l271-270.977zM476.875 45.523 446.711 15.36c-20.16-20.16-55.297-20.14-75.434 0l-36.949 36.95 105.598 105.597 36.949-36.949c10.07-10.066 15.617-23.465 15.617-37.715s-5.547-27.648-15.617-37.719zm0 0" fill="#ad6420" data-original="#000000" class=""></path>
                      </g>
                    </svg>
                  </span>
                  <img src="../assets/items/no-photo.png" class="item-img" id="preview_item_img" alt="item_image">
                </div>
              </label>
              <input type="file" name="item_img" id="item_img_input" class="item_img_input" value="" accept="image/png,image/jpeg,image/jpg">
            </div>
            <div class="sectra item_sectra">
              <div class="form-section">
                <div class="inputs gd4">
                  <label for="name">Name <span>*</span></label>
                  <input type="text" class="" name="name" id="name" required>
                </div>
                <div class="inputs gd2">
                  <label for="code">Product Code</label>
                  <input type="number" class="" name="code" required>
                </div>
                <div class="inputs gd3">
                  <label for="unit">Unit <span>*</span></label>
                  <select name="unit" id="unit">
                    <optgroup label="">
                      <option value="Piece">Pieces</option>
                    </optgroup>
                    <optgroup label="Area Units">
                      <option value="mm">mm</option>
                      <option value="mm2">mm2</option>
                      <option value="cm">cm</option>
                      <option value="cm2">cm2</option>
                      <option value="m">m</option>
                      <option value="m2">m2</option>
                    </optgroup>
                    <optgroup label="Volume Units">
                      <option value="mm3">mm3</option>
                      <option value="cm3">cm3</option>
                      <option value="m3">m3</option>
                      <option value="mL">mL</option>
                      <option value="L">L</option>
                    </optgroup>
                    <optgroup label="Weight Units">
                      <option value="mg">mg</option>
                      <option value="g">g</option>
                      <option value="kg">kg</option>
                      <option value="ton">ton</option>
                    </optgroup>
                  </select>
                </div>
                <div class="inputs gd3">
                  <label for="rate">Est. Cost (E£)</label>
                  <input type="number" value="0" class="" min="0" name="rate" id="rate" step="0.01" required>
                </div>
                <div class="inputs gd6">
                  <label for="supplier_list">Prefered Manufacturer</label>
                  <select name="supplier_list" id="supplier_list">
                    <option value=""></option>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM `manufacturers`");
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
                        foreach ($row as $supp) {
                          if ($supp['is_company'] == "0") {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['first_name'] . " " . $supp['middle_name'] . " " . $supp['last_name'] . "</option>";
                          } else {
                            echo "<option value='" . $supp['id'] . "'>" . $supp['company_name'] . "</option>";
                          }
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="inputs gd6">
                  <label for="description">Description</label>
                  <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>
                <div class="inputs gd6">
                  <label for="description">Composite Product</label>
                  <input type="checkbox" name="is_composite" class="comp_check">
                </div>
                <div class="comp-items gd6">
                  <hr class="hr_form">
                  <div class="employee-section request-section invoice-list subcomp-list">
                    <div class="request-list">
                      <div class="request-row request-head-list">
                        <div>Item</div>
                        <div>Qty</div>
                        <div>Unit</div>
                        <div>Cost/Unit (E£)</div>
                        <div>Total Cost (E£)</div>
                        <div></div>
                      </div>
                      <div class="request-body-list" id="sub-list">
                        <div class='request-row' id="row1">
                          <div>
                            <input type="text" class="item_name subitem_name1" name="p[1][name]">
                            <input type="text" class="subitem_id1 hidden" name="p[1][id]">
                            <ul class="subsuggestion subsuggestion1"></ul>
                          </div>
                          <div><input type="number" class="subitem_quantity1" name="p[1][quantity]" value="0" step="0.01" min="0"><span class="subitem_limit subitem_limit1" data-limit="0">/ -</span></div>
                          <div><input type="text" class="subitem_unit1" name="p[1][unit]" disabled></div>
                          <div><input type="number" class="subitem_amount1" name="p[1][amount]" value="0" min="0" step="0.01" disabled></div>
                          <div><input type="number" class="subitem_total subitem_total1" name="p[1][total]" value="0" min="0" step="0.01" disabled></div>
                          <div></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button id="add-line-sub"><i class="fa-solid fa-plus"></i> Add Line</button>
                </div>
              </div>
            </div>
          </div>

          <hr class="hr_form">
          <div class="loadings"><i class=""></i></div>
          <input type="hidden" name="add_item" value="Save">
          <input type="submit" class="add" value="Add">
        </form>
      </div>
      <div class="invoice-page">
        <form action="" method="POST" class="inv-body" enctype="multipart/form-data">
          <div class="inv-head">
            <h2 class="inv-title">Manufacturing Order #
              <input type="text" class="inv_number" name="inv_number" value=<?= get_manufacturer_order_number() ?> />
            </h2>
            <button id="close-btn" class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>

          <div class="top-form">

            <div class="form-section">
              <div class="inputs gd3">
                <label for="supploer">Manufacturer</label>
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
                  <option value="dueonreceipt">Due on receipt</option>
                  <option value="15">Net 15</option>
                  <option value="30">Net 30</option>
                  <option value="60">Net 60</option>
                </select>
              </div>
              <div class="inputs gd1">
                <label for="inv_type">Invoice Type</label>
                <select name="inv_type" id="inv_type">
                  <option value="1">Non-tax</option>
                  <option value="2">Tax(1%)</option>
                  <option value="3" selected>Tax(3%)</option>
                </select>
              </div>
              <div class="inputs gd1 vat">
                <label for="vat">VAT(14%)</label>
                <input type="number" name="vat" id="vat" min="0" value="0" step="0.01">
              </div>
              <div class="inputs gd3">
                <label for="payment_m">Payment Method</label>
                <select name="payment_m" id="payment_m" required>
                  <option value="cash">Cash</option>
                  <option value="bank">Bank Account</option>
                  <option value="notes payable">Notes Payable</option>
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
                <label for="started">Started?</label>
                <input type="checkbox" name="started" id="started">
              </div>
              <div class="inputs gd1">
                <label for="received">Completed?</label>
                <input type="checkbox" name="received" id="received">
              </div>
              <div class="inputs gd1">
                <label for="storable">Storable?</label>
                <input type="checkbox" name="storable" id="storable">
              </div>
              <div class="inputs gd3 warehouse_input">
                <label for="warehouse">Warehouse</label>
                <select name="warehouse" id="warehouse">
                  <?= get_warehouses_option() ?>
                </select>
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
                  <div>Cost/Unit (E£)</div>
                  <div>Total Cost (E£)</div>
                  <div></div>
                </div>
                <div class="request-body-list" id="inv-list">
                  <div class='request-row' id="row1">
                    <div></div>
                    <div>
                      <input type="text" class="item_name item_name1" name="p[1][name]">
                      <input type="number" class="item_id1 hidden" name="p[1][id]">
                      <ul class="suggestion suggestion1"></ul>
                    </div>
                    <div><input type="text" name="p[1][description]"></div>
                    <div><input type="number" class="item_quantity1" name="p[1][quantity]" value="0" min="0" step="0.01"></div>
                    <div><input type="text" class="item_unit1" name="p[1][unit]" step="0.01" disabled></div>
                    <div><input type="number" class="item_amount1" name="p[1][amount]" value="0" min="0" step="0.01"></div>
                    <div><input type="number" class="item_total item_total1" name="p[1][total]" value="0" min="0" step="0.01" disabled>
                    </div>
                    <div></div>
                  </div>
                  <div class='request-row'>
                    <div></div>
                    <div>Manufacturing Service Cost</div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div><input type="number" class="serv_cost" name="serv_cost" value="0" min="0" step="0.01">
                    </div>
                    <div></div>
                  </div>
                </div>
              </div>
              <div class="bottom-list">
                <div class="lt">
                  <div class="form-section">
                    <div class="inputs gd6">
                      <label for="mg-invoice">Hardcopy Invoice [Optional]</label>
                      <input type="file" name="hardcopy" class="hardcopy" id="mg-invoice">
                    </div>
                    <div class="inputs gd6">
                      <label for="statement">Statement</label>
                      <textarea name="statement" id="statement">فاتوره تصنيع مع تسليم خامات</textarea>
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
                    <div class="total-title">Withholing Tax (3%)</div>
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
                    <div class="total-title">Advance Payment</div>
                    <div class="total-value">E£
                      <input type="number" name="paid" id="paid" value="0" step="0.01">
                      <input type="hidden" name="due_balance" id="due_balance" value="0">
                      <input type="hidden" name="subtotal" id="subtotal_service" value="0">
                      <input type="hidden" name="subtotal_purchase" id="subtotal_purchase" value="0">
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
                <label for="supploer">Supplier</label>
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
                <label for="storable">Storable?</label>
                <input type="checkbox" id="curr_storable" disabled>
              </div>
              <div class="inputs gd3">
                <label for="warehouse">Warehouse</label>
                <div class="curr curr_warehouse"><a href="#">-</a></div>
              </div>
              <div class="inputs gd1">
                <label for="curr_started">Started?</label>
                <input type="checkbox" name="started" id="curr_started">
                <input type="hidden" name="order_id" class="order_edit_id">
                <input type="hidden" name="supplier_id" class="order_edit_supplier_id">
              </div>
              <div class="inputs gd2">
                <label for="received">Completed?</label>
                <input type="checkbox" name="received" id="curr_received">
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
            <div class="employee-section request-section invoice-list edit_manue_invy">
              <div class="request-list">
                <div class="request-row request-head-list">
                  <div></div>
                  <div>Item</div>
                  <div>Description</div>
                  <div>Qty</div>
                  <div>Unit</div>
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
          <h3>Payment Order</h3>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="profile_id" name="supplier_id" value="<?= $info['id'] ?>">
          <div class="custom-form custom-item-form payment_form">
            <div class="inputs w50">
              <label for="refer_order">Refered Order</label>
              <select name="order_id" id="refer_order">
                <option value="custom">Custom</option>
                <?= get_manu_orders_option() ?>
              </select>
            </div>
            <div class="inputs w50">
              <label for="amount_payment">Amount</label>
              <input type="number" name="amount_payment" id="amount_payment" min="0" value="0" step="0.01">
            </div>
            <div class="inputs w50">
              <label for="amount_payment_method">Payment Mehtod</label>
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
              <textarea name="amount_statement" id="amount_statement" cols="30" rows="10">اذن صرف نقديه</textarea>
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



        var taxFactor = 0.03;
        withholdingTitle = "Withholing Tax (1%)";
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
          var total = parseFloat($("#subtotal_service").val());
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
          $("#subtotal_service").val(total);
          $("#total_purchase").val(total_amount);


        });









        $("#received").on("change", function() {
          if ($(this).is(":checked")) {
            $('#started').prop("checked", true);
          }
        });
        $("#curr_received").on("change", function() {
          if ($(this).is(":checked")) {
            $('#curr_started').prop("checked", true);
          }
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



        $("#supplierpurch").on("click", ".re_order_btn", function() {


          $.ajax({
            url: 'json/re_order_product.php',
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
            url: 'json/get_manufacture_page.php',
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
                $("#curr_started").prop('checked', false);
                $("#curr_started").prop('disabled', false);
              } else {
                $("#curr_received").prop('checked', true);
                $("#curr_received").prop('disabled', true);
                $("#curr_started").prop('checked', true);
                $("#curr_started").prop('disabled', true);
              }

              if (data.started == "0") {
                $("#curr_started").prop('checked', false);
                $("#curr_started").prop('disabled', false);
              } else {
                $("#curr_started").prop('checked', true);
                $("#curr_started").prop('disabled', true);
              }
            },
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
          });


          $.ajax({
            url: 'json/get_manufacture_list.php',
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
                console.log("hi");
                $('#inv-edit-list').append('<div class="request-row"><div></div><div><div class="val">' + value.item_name + '</div></div><div><div class="val">' + value.item_desc + '</div></div><div><div class="val">' + value.item_quantity + '</div></div><div><div class="val">' + value.item_unit + '</div></div><div><div class="val"></div></div><div></div></div><div class="request-row"><div></div><div><div class="val">Manufactuing Service Cost</div></div><div><div class="val"></div></div><div><div class="val"></div></div><div><div class="val"></div></div><div><div class="val">' + value.subtotal + '</div></div><div></div></div>');
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






        $(".comp-items #add-line-sub").on("click", function() {
          event.preventDefault();

          var randomNumber =
            Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;

          $(".subcomp-list .request-body-list").append(
            '<div class="request-row" id="' +
            randomNumber +
            '"><div><input type="text" class="subitem_name subitem_name' + randomNumber + '" name="p[' + randomNumber + '][name]"><input type="number" class="subitem_id' + randomNumber + ' hidden" name="p[' + randomNumber + '][id]"><ul class="subsuggestion subsuggestion' + randomNumber + '"></ul></div><div><input type="number" class="subitem_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" min="0" step="0.01"><span class="subitem_limit subitem_limit' + randomNumber + '" data-limit="0">/ -</span></div><div><input type="text" class="subitem_unit' + randomNumber + '" name="p[' + randomNumber + '][unit]" disabled></div><div><input type="number" class="subitem_amount' + randomNumber + '" name="p[' + randomNumber + '][amount]" value="0" min="0" step="0.01" disabled></div><div><input type="number" class="subitem_total subitem_total' + randomNumber + '" name="p[' + randomNumber + '][total]" value="0" min="0" step="0.01" disabled></div><div><button class="delete_row" data-row="' +
            randomNumber +
            '"><i class="fa-solid fa-trash"></i></button></div></div>'
          );

          $(".subitem_quantity" + randomNumber).on("input", function() {
            var new_amount = $(this).val() * $(".subitem_amount" + randomNumber).val();
            $(".subitem_total" + randomNumber)
              .val(new_amount)
              .trigger("change");
          });
          $(".subitem_amount" + randomNumber).on("input", function() {
            var new_amount = $(this).val() * $(".subitem_quantity" + randomNumber).val();
            $(".subitem_total" + randomNumber)
              .val(new_amount)
              .trigger("change");
          });



          $(".subsuggestion" + randomNumber).on("click", ".sug", function() {
            $.ajax({
              type: "POST",
              url: "functions/core/import_subitem_details.php",
              data: {
                data_id: $(this).attr("data-id"),
              },
              dataType: "json",
              success: function(data) {
                var name = data.name;
                var amount = data.amount;
                var id = data.id;
                var unit = data.unit;
                var limit = data.limit;
                $(".subitem_name" + randomNumber).val(name);
                $(".subitem_amount" + randomNumber).val(amount);
                $(".subitem_id" + randomNumber).val(id);
                $(".subitem_unit" + randomNumber).val(unit);
                $(".subitem_quantity" + randomNumber).val(1);
                $(".subitem_limit" + randomNumber).html("/ " + limit);
                $(".subitem_limit" + randomNumber).attr("data-limit", limit);
                $(".subitem_total" + randomNumber)
                  .val(amount)
                  .trigger("change");
              },
            });
          });

          $(".subitem_name" + randomNumber).focus(function() {
            if ($("ul.subsuggestion" + randomNumber).css("height") == "0px") {
              $("ul.subsuggestion" + randomNumber).css({
                height: "auto",
                border: "1px solid #cfcfcf",
              });
            } else {
              $("ul.subsuggestion" + randomNumber).css({
                height: "0",
                border: "0px solid #cfcfcf",
              });
            }
          });

          $(".subitem_quantity" + randomNumber).on("change", function() {
            var limit = $(".subitem_limit" + randomNumber).attr("data-limit");
            if ($(".subitem_quantity" + randomNumber).val() > Number(limit)) {
              $(".subitem_quantity" + randomNumber).val(limit).trigger("input");
            }

          });
          $(".subitem_name" + randomNumber).blur(function() {
            if ($(".subitem_id" + randomNumber) !== "") {
              $(this).val("");
              $(".subitem_id" + randomNumber).val("");
              $(".subitem_quantity" + randomNumber).val(0);
              $(".subitem_amount" + randomNumber).val(0);
              $(".subitem_unit" + randomNumber).val("");
              $(".subitem_total" + randomNumber).val(0).trigger("change");
              $(".subitem_limit" + randomNumber).html("/ -");
              $(".subitem_limit" + randomNumber).attr("data-limit", 0);
            }
            $("ul.subsuggestion" + randomNumber).css({
              height: "0",
              border: "0px solid #cfcfcf",
            });
          });

          $(".subitem_name" + randomNumber).on("input", function() {
            $.ajax({
              type: "POST",
              url: "functions/core/subitem-search.php",
              data: {
                item_search: $(this).val(),
              },
              success: function(data) {
                $(".subsuggestion" + randomNumber).html(data);
              },
            });
          });

          $(".delete_row").click(function(event) {
            event.preventDefault();
            var rowNumber = $(this).attr("data-row");
            $(".subitem_total" + rowNumber)
              .val(0)
              .trigger("change");
            var row_id = $(this).attr("data-row");
            var selectedrow = document.getElementById(row_id);
            selectedrow.remove();
          });
        });






        $(".subitem_quantity1").on("change", function() {
          var limit = $(".subitem_limit1").attr("data-limit");
          if ($(this).val() > Number(limit)) {
            $(this).val(limit).trigger("input");
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
              url: "json/order_payment_manu_details.php",
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
              type: 'manufacturers',
            },
            success: function(data) {
              $(".notes-cont").html(data);
              $(".qknote").html(data);
            },
          });
        });



        $(".comp_check").change(function() {
          var subHeight = $(".comp-items").prop("scrollHeight") + 10;
          if ($(this).is(":checked")) {
            $(".subitem_name1").prop("required", true);
            $(".subitem_id1").prop("required", true);
            $(".subitem_unit1").prop("required", true);
            $(".subitem_amount1").prop("required", true);
            $(".subitem_total1").prop("required", true);
            $(".subitem_quantity1").prop("required", true);
            $(".comp-items").css({
              "height": "auto",
              "overflow": "visible",
            });
            var total_subs = 0;
            $("#sub-list .subitem_total").each(function() {
              var value = parseFloat($(this).val());
              total_subs += value;
            });
            $("#rate").val(total_subs);
          } else {
            $(".subitem_name1").prop("required", false);
            $(".subitem_id1").prop("required", false);
            $(".subitem_unit1").prop("required", false);
            $(".subitem_amount1").prop("required", false);
            $(".subitem_total1").prop("required", false);
            $(".subitem_quantity1").prop("required", false);
            $(".comp-items").css({
              "height": "0px",
              "overflow": "hidden",
            });
            $("#rate").val(0);
          }
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

        $(".subitem_quantity1").on("input", function() {
          var sub_new_amount = $(this).val() * $(".subitem_amount1").val();
          $(".subitem_total1").val(sub_new_amount).trigger("change");
        });
        $(".subitem_amount1").on("input", function() {
          var sub_new_amount = $(this).val() * $(".subitem_quantity1").val();
          $(".subitem_total1").val(sub_new_amount).trigger("change");
        });

        $(".item_name1").on("input", function() {
          $.ajax({
            type: 'POST',
            url: 'functions/core/final-item-search.php',
            data: {
              item_search: $(this).val(),
            },
            success: function(data) {
              $(".suggestion1").html(data);
            },
          });

        });

        $(".subitem_name1").focus(function() {
          if ($("ul.subsuggestion").css("height") == "0px") {
            $("ul.subsuggestion1").css({
              height: "auto",
              border: "1px solid #cfcfcf",
            });
          } else {
            $("ul.subsuggestion1").css({
              height: "0",
              border: "0px solid #cfcfcf",
            });
          }
        });

        $(".subitem_name1").blur(function() {
          if ($(".subitem_id1") !== "") {
            $(this).val("");
            $(".subitem_id1").val("");
            $(".subitem_quantity1").val(0);
            $(".subitem_amount1").val(0);
            $(".subitem_unit1").val("");
            $(".subitem_total1").val(0).trigger("change");
            $(".subitem_limit1").html("/ -");
            $(".subitem_limit1").attr("data-limit", 0);
          }
          $("ul.subsuggestion1").css({
            height: "0",
            border: "0px solid #cfcfcf",
          });
        });

        $(".subitem_name1").on("input", function() {
          $.ajax({
            type: 'POST',
            url: 'functions/core/subitem-search.php',
            data: {
              item_search: $(this).val(),
            },
            success: function(data) {
              $(".subsuggestion1").html(data);
            },
          });

        });


        $(".subsuggestion1").on("click", ".sug", function() {
          $.ajax({
            type: "POST",
            url: "functions/core/import_subitem_details.php",
            data: {
              data_id: $(this).attr("data-id"),
            },
            dataType: "json",
            success: function(data) {
              var name = data.name;
              var amount = data.amount;
              var id = data.id;
              var limit = data.limit;
              var unit = data.unit;
              $(".subitem_name1").val(name);
              $(".subitem_amount1").val(amount);
              $(".subitem_unit1").val(unit);
              $(".subitem_limit1").html("/ " + limit);
              $(".subitem_limit1").attr("data-limit", limit);
              $(".subitem_id1").val(id);
              $(".subitem_quantity1").val(1);
              $(".subitem_total1").val(amount).trigger("change");
            },
          });

        });

        $(".suggestion1").on("click", ".sug", function() {
          $.ajax({
            type: "POST",
            url: "functions/core/import_final_item_details.php",
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

        $("#sub-list").on("change", ".subitem_total", function() {
          var total_subs = 0;
          $("#sub-list .subitem_total").each(function() {
            var value = parseFloat($(this).val());
            total_subs += value;
          });
          if ($(".comp_check").is(":checked")) {
            $("#rate").val(total_subs);
          } else {
            $("#rate").val(0);
          }

        });


        $("#inv-list").on("change", ".item_total", function() {
          var total = 0;
          $("#inv-list .item_total").each(function() {
            var value = parseFloat($(this).val());
            total += value;
          });
          $("#subtotal_purchase").val(total);
        });


        $("#discount").on("change", function() {
          var paid = $("#paid").val();
          var vat_perc = $("#vat").val() / 100;
          var discount = $("#discount").val();
          var total = parseFloat($("#subtotal_service").val());
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
          $("#subtotal_service").val(total);
          $("#total_purchase").val(total_amount);

        });


        $(".serv_cost").on("change", function() {
          var total = parseFloat($(".serv_cost").val());
          console.log(total);
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
          $("#subtotal_service").val(total);
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

        $("#vat").on("change", function() {
          var vat_perc = $(this).val() / 100;
          var total = parseFloat($("#subtotal_service").val());
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
          $("#subtotal_service").val(total);
          $("#withholding").val(withholding_tax);
          $("#total_purchase").val(total_amount);
        });

        $('#new_item').submit(function(event) {
          event.preventDefault(); // prevent default form submission
          $("#new_item input").prop("disabled", false);
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: 'functions/core/add-final-item.php',
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
            url: 'functions/core/edit-manufacturer.php',
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

        // $("#prnt_barcode").on("click", function() {
        //   event.preventDefault();
        //   var barcodeDiv = document.getElementById("barcodediv");
        //   var printWindow = window.open('', '');
        //   printWindow.document.write('<html><head><title>Barcode</title>');
        //   printWindow.document.write('<style> @page { size: A4 landscape; margin: 0; } img#barcode_img { width: 100%;}</style>');
        //   printWindow.document.write('</head><body>');
        //   printWindow.document.write(barcodeDiv.innerHTML);
        //   printWindow.document.write('</body></html>');
        //   printWindow.document.close();
        //   printWindow.focus();
        //   printWindow.print();
        //   printWindow.close();
        // });


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
    header("location:" . $path . "/manufacturers.php");
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