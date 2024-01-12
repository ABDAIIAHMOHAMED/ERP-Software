<?php
$pg_name = "Wonder - Cash";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3001) == 1) {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    $user_info = login_info();
    if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3005) == 1) {
      transfer_from_cash();
    }
?>
    <!-- #F1DDCA -->
    <!-- #AD6420-->
    <div class="att-part vat-part">
      <div class="title-head">
        <div class="headso">
          <h3>Treasury Cash
            <div class="inputs">
              <label for="create-date-filter">From Date </label>
              <input type="date" name="date" id="create-date-filter" value="<?= "2010-01-01" ?>">
            </div>
            <div class="inputs">
              <label for="end-date-filter">To </label>
              <input type="date" name="date" id="end-date-filter" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . " +1 day")) ?>">
            </div>
          </h3>
          <hr class="head-line">
          <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / Treasury Cash</p>
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
          <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3005) == 1) {
          ?>
            <button class="new-btn" id="payment-btn">Transfer Money</button>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="cash-container">
        <div class="cash-history">
          <h4>Treasury Statement</h4>
          <div class="resp-table">
            <table id="cashhistory" style="width:100% !important;">
              <thead>
                <tr>
                  <th>Statement</th>
                  <th>Created Date</th>
                  <th>Debit (E£)</th>
                  <th>Credit (E£)</th>
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

              var table = $('#cashhistory').DataTable({
                ajax: {
                  url: 'json/cash.php',
                  type: 'GET',
                  dataSrc: '',
                },
                buttons: [{
                    extend: 'csv',
                    charset: 'UTF-8',
                    bom: true,
                    exportOptions: {
                      encoding: 'UTF-8'
                    },
                  },

                ],
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

                  $("#total_withdrawals").html(total1.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }));
                  $("#total_deposits").html(total2.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }));
                  $("#total_cash").html(total3.toLocaleString('en-US', {
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
                    data: 'statement',
                  },
                  {
                    data: 'date',
                    width: "150px"
                  },
                  {
                    data: 'credit',
                    width: "150px"
                  },
                  {
                    data: 'debit',
                    width: "150px"
                  },
                ],
                autoWidth: false,
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
                var barcodeDiv = document.getElementById("cashhistory");
                var printWindow = window.open('', '');
                printWindow.document.write('<html><head><title>Treasury Cash</title><link rel="stylesheet" href="styles/print.css"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />');
                printWindow.document.write('<style>tbody tr td:first-child{display: flex;gap: 5px;} tfoot tr td {border-right: 0;} tfoot {font-weight: 600;} table td:nth-child(2), table th:nth-child(2),td:nth-child(3), table th:nth-child(3), td:nth-child(4), table th:nth-child(4){width: 400px !important;}</style>');
                printWindow.document.write('</head><body><div class="container"><div class="header_container"><div class="lt-head"><h3>Treasury Cash</h3><span class="dt-range">From <span class="bold">' + $("#create-date-filter").val() + '</span>  To <span class="bold">' + $("#end-date-filter").val() + '</span></span></div><div class="rt-head"><div class="logo_img"><img src="../images/logo.png" alt="Company_logo" /></div></div></div>');
                printWindow.document.write('<table>');
                printWindow.document.write(barcodeDiv.innerHTML);
                printWindow.document.write('</table><table><tfoot><tr><td>Total Deposits (E£)</td><td></td><td></td><td>' + $("#total_deposits").html() + '</td></tr></tfoot></table><table><tfoot><tr><td>Total Withdrawals (E£)</td><td></td><td></td><td>(' + $("#total_withdrawals").html() + ')</td></tr></tfoot></table><table><tfoot><tr><td>Total Balance (E£)</td><td></td><td></td><td>' + $("#total_cash").html() + '</td></tr></tfoot></table><div class="sub_header"><span>Report was created at ' + currentTime + '</span><span>By ' + userDate + '</span></div><div class="copyright-section">© 2023 All rights reserved. Powered by <img src="../images/icon.png" alt="">onder</div></div></body></html>');
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
                  console.log(create_date);
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
              $("#cashhistory_paginate").remove();
              $("#cashhistory_info").remove();
              $("#cashhistory_length").remove();
              $("#cashhistory_filter").remove();





            });
          </script>
        </div>
        <div class="cash-report">
          <div class="widget-bx cash-box w100">
            <div class="widget-txt">
              <div class="widget-head">Balance</div>
              <div class="widget-value"><?php if (get_total_cashes() < 0) {
                                          echo "- ";
                                        } ?><span class="w-value" id="total_cash" data-value="<?php if (get_total_cashes() < 0) {
                                                                                                echo -1 * get_total_cashes();
                                                                                              } else {
                                                                                                echo get_total_cashes();
                                                                                              } ?>">0</span> <span class="unit">E£</span></div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
              <g>
                <defs>
                  <clipPath id="a" clipPathUnits="userSpaceOnUse">
                    <path d="M0 512h512V0H0Z" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
                  </clipPath>
                </defs>
                <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                  <path d="M0 0h-421.173a7.449 7.449 0 0 0-7.448 7.448v248.166a7.448 7.448 0 0 0 7.448 7.448H0a7.447 7.447 0 0 0 7.448-7.448V7.448A7.448 7.448 0 0 0 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(436.121 97.04)" fill="#ffffff" data-original="#5cc45c" class="" opacity="1"></path>
                  <path d="M0 0h-421.173a7.448 7.448 0 0 1-7.448-7.448v-241.737H7.448V-7.448A7.448 7.448 0 0 1 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(436.121 360.1)" fill="#ffffff" data-original="#4ead4e" class="" opacity="1"></path>
                  <path d="M0 0h-421.173a7.447 7.447 0 0 0-7.448 7.448v248.165a7.448 7.448 0 0 0 7.448 7.449H0a7.449 7.449 0 0 0 7.448-7.449V7.448A7.448 7.448 0 0 0 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(465.588 123.47)" fill="#ffffff" data-original="#5cc45c" class="" opacity="1"></path>
                  <path d="M0 0h-421.173a7.448 7.448 0 0 1-7.448-7.448v-240.614H7.448V-7.448A7.449 7.449 0 0 1 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(465.588 386.532)" fill="#ffffff" data-original="#4ead4e" class="" opacity="1"></path>
                  <path d="M0 0h-421.173a7.447 7.447 0 0 0-7.448 7.447v248.166a7.448 7.448 0 0 0 7.448 7.449H0a7.449 7.449 0 0 0 7.448-7.449V7.447A7.448 7.448 0 0 0 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(497.052 151.9)" fill="#ffffff" data-original="#5cc45c" class="" opacity="1"></path>
                  <path d="M0 0h-46.415v-263.062H0a7.448 7.448 0 0 1 7.448 7.449V-7.448A7.448 7.448 0 0 1 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(497.052 414.96)" fill="#ffffff" data-original="#4ead4e" class="" opacity="1"></path>
                  <path d="M0 0c-1.574 15.968-14.313 28.706-30.28 30.28-.903.089-1.582.864-1.582 1.771v144.907c0 .907.679 1.682 1.582 1.771 15.967 1.574 28.706 14.312 30.28 30.28.089.902.863 1.582 1.771 1.582h317.915c.907 0 1.681-.68 1.77-1.582 1.574-15.968 14.313-28.706 30.28-30.28.903-.089 1.582-.864 1.582-1.771V32.051c0-.907-.679-1.682-1.582-1.771-15.967-1.574-28.706-14.312-30.28-30.28-.089-.902-.863-1.582-1.77-1.582H1.771C.863-1.582.089-.902 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(125.737 178.926)" fill="#ffffff" data-original="#a0e557" class="" opacity="1"></path>
                  <path d="M0 0c-15.968 1.574-28.706 14.313-30.28 30.279-.089.904-.864 1.582-1.771 1.582h-21.367v-212.172h21.367c.907 0 1.682.68 1.771 1.582 1.574 15.968 14.312 28.707 30.28 30.28.902.09 1.582.864 1.582 1.771V-1.771C1.582-.863.902-.089 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(477.474 357.654)" fill="#f1ddca" data-original="#93cc4a" class="" opacity="1"></path>
                  <path d="M0 0c0-39.745-32.22-71.965-71.965-71.965-39.745 0-71.965 32.22-71.965 71.965 0 39.745 32.22 71.965 71.965 71.965C-32.22 71.965 0 39.745 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(358.43 283.43)" fill="#ffffff" data-original="#f3e8d7" class="" opacity="1"></path>
                  <path d="M0 0a71.73 71.73 0 0 1-27.5-5.453c26.1-10.803 44.465-36.508 44.465-66.512 0-30.003-18.365-55.708-44.465-66.511A71.75 71.75 0 0 1 0-143.93c39.745 0 71.965 32.221 71.965 71.965C71.965-32.22 39.745 0 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(286.465 355.394)" fill="#f1ddca" data-original="#ddd1c3" class="" opacity="1"></path>
                  <path d="M0 0h-421.173a7.447 7.447 0 0 0-7.448 7.447v248.166a7.448 7.448 0 0 0 7.448 7.449H0a7.449 7.449 0 0 0 7.448-7.449V7.447A7.448 7.448 0 0 0 0 0Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(497.052 151.9)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0h137.812c.907 0 1.681-.68 1.77-1.582 1.574-15.968 14.313-28.706 30.28-30.28.903-.089 1.582-.864 1.582-1.771V-178.54c0-.907-.679-1.682-1.582-1.771-15.967-1.574-28.706-14.312-30.28-30.28-.089-.902-.863-1.582-1.77-1.582H-.111" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(307.611 389.517)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0h-145.159c-.907 0-1.682.68-1.771 1.582-1.574 15.968-14.312 28.706-30.28 30.28-.902.089-1.582.864-1.582 1.771V178.54c0 .907.68 1.682 1.582 1.771 15.968 1.574 28.706 14.312 30.28 30.28.089.902.864 1.582 1.771 1.582H.047" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(272.667 177.344)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0h-22.019a7.448 7.448 0 0 1-7.448-7.448v-248.165a7.448 7.448 0 0 1 7.448-7.449h421.173a7.448 7.448 0 0 1 7.449 7.449v18.983" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(36.967 360.1)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0h-24.016a7.448 7.448 0 0 1-7.448-7.448v-248.166a7.447 7.447 0 0 1 7.448-7.448h421.173a7.447 7.447 0 0 1 7.448 7.448v20.981" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(68.43 386.532)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0c0-39.745-32.22-71.965-71.965-71.965-39.745 0-71.965 32.22-71.965 71.965 0 39.745 32.22 71.965 71.965 71.965C-32.22 71.965 0 39.745 0 0Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(358.43 283.43)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                  <path d="M0 0v-24.207c6.195 1.147 10.096 4.818 10.096 11.357C10.096-5.622 5.622-2.409 0 0m-5.392 14.913v20.88c-6.424-.804-11.013-3.671-11.013-9.637 0-6.539 4.933-8.948 11.013-11.243m-.688-50.477c-14.226.229-23.862 7.916-23.862 13.537 0 2.754 2.409 6.54 5.277 6.54 3.786 0 6.884-8.032 18.585-8.949V2.523c-10.325 3.671-21.797 7.801-21.797 22.486 0 14.455 10.898 20.19 21.797 21.338v3.327c0 1.377 1.377 2.639 3.327 2.639 1.721 0 3.441-1.262 3.441-2.639v-3.098c7.801-.229 18.815-2.638 18.815-8.26 0-2.179-1.607-6.539-5.048-6.539-2.753 0-5.736 3.671-13.767 4.245V12.733c9.981-3.67 20.879-8.718 20.879-24.32 0-14.111-8.489-21.912-20.879-23.633v-3.9c0-1.377-1.72-2.639-3.441-2.639-1.95 0-3.327 1.262-3.327 2.639z" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(290.652 282.688)" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
                </g>
              </g>
            </svg>
          </div>
          <div class="widget-bx cash-box w50 cashin" style="animation-delay:0.16s">
            <div class="widget-txt">
              <div class="widget-head">Deposits</div>
              <div class="widget-value">+ <span class="w-value" id="total_deposits" data-value="<?= get_in_cashes() ?>">0</span> <span class="unit">E£</span></div>
            </div>
          </div>
          <div class="widget-bx cash-box w50 cashout" style="animation-delay:0.32s">
            <div class="widget-txt">
              <div class="widget-head">Withdrawals</div>
              <div class="widget-value">- <span class="w-value" id="total_withdrawals" data-value="<?= get_out_cashes() ?>">0</span> <span class="unit">E£</span></div>
            </div>
          </div>
        </div>
      </div>
      <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3005) == 1) {
      ?>
        <div class="black_screen"></div>
        <div class="pay_payment_section share_payment">
          <div class="custome-head">
            <h3>Transfer Money</h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <form class="" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="profile_id" name="supplier_id" value="<?= $info['id'] ?>">
            <div class="custom-form custom-item-form payment_form">
              <div class="inputs w100">
                <label for="amount_payment">Amount</label>
                <input type="number" name="amount_payment" id="amount_payment" value="0" step="0.01" required>
              </div>
              <div class="inputs w50">
                <label for="amount_payment_method">To</label>
                <select name="amount_payment_method" id="amount_payment_method">
                  <option value="bank">Bank Account</option>
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
                <label for="amount_cdate">Transfer Date</label>
                <input type="datetime-local" name="amount_cdate" id="amount_cdate" value="<?= date("Y-m-d\TH:i") ?>">
              </div>
            </div>
            <input type="submit" name="pay" value="Transfer">
          </form>
        </div>
      <?php
      }
      ?>
      <div class="mga"></div>
    </div>

    <script>
      $(document).ready(function() {
        let valueDisplays = document.querySelectorAll(".w-value");
        let totalDuration = 2000; // Total duration for all elements
        let duration = Math.floor(totalDuration / valueDisplays.length); // Duration for each element
        let startTimestamp = null;

        function formatNumber(number) {
          return number.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        }

        function step(timestamp) {
          if (!startTimestamp) startTimestamp = timestamp;
          let progress = timestamp - startTimestamp;

          valueDisplays.forEach((valueDisplay) => {
            let startValue = 0;
            let endValue = parseFloat(valueDisplay.getAttribute("data-value"));
            let currentValue = Math.floor((progress / duration) * (endValue + 1)); // Calculate the current value based on the progress and duration

            if (currentValue > endValue) {
              currentValue = endValue;
            }

            valueDisplay.textContent = formatNumber(currentValue);
          });

          if (progress < totalDuration) {
            window.requestAnimationFrame(step);
          }
        }

        window.requestAnimationFrame(step);

        if ($("#amount_payment_method").val() == "cash") {
          $(".amount_bank_choose").css({
            "visibility": "hidden"
          });
          $(".amount_bank_num_choose").css({
            "display": "none"
          });

        } else {
          $(".amount_bank_choose").css({
            "visibility": "visible"
          });
          $(".amount_bank_num_choose").css({
            "display": "flex"
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


      });
    </script>

<?php
  } else {
    header("location:" . $path . "/../login.php");
    exit();
  }
} else {
  header("location:" . $path . "/../login.php");
  exit();
}
include "includes/footer.inc";
?>