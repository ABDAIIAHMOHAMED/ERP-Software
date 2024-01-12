<?php ob_start();
$functions_route = "../";
$css_route = "../";
$image_route = "../";
$js_route = "../";
$path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$path .= $_SERVER["SERVER_NAME"] . rtrim(dirname($_SERVER["PHP_SELF"])) . "/";
include  $functions_route . "functions/general.php";
$user_info = login_info();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Faster way to communicate with your clients and sell your products in clear and easy way" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="theme-color" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="//db.onlinewebfonts.com/c/0016f77f50d636d6eb6336a8a9d5d3d5?family=Felix+Titling" rel="stylesheet" type="text/css" />
  <link href="../webfonts/felix.ttf" />
  <!-- End Fonts -->

  <link rel="stylesheet" href="<?= $css_route ?>styles/normalize.css" />
  <link rel="stylesheet" href="<?= $css_route ?>styles/all.min.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.css">
  <link rel="stylesheet" href="<?= $css_route ?>styles/media.css">
  <link rel="stylesheet" href="<?= $css_route ?>styles/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="<?= $css_route ?>styles/daterangepicker.css" />
  <link rel="stylesheet" href="<?= $css_route ?>styles/style.css">
  <link rel="stylesheet" href="<?= $css_route ?>styles/main.css" />
  <link rel="stylesheet" href="styles/style.css">



  <link rel="icon" type="image/png" href="<?= $image_route ?>images/icon.png">
  <script src="<?= $js_route ?>js/jquery-3.6.0.min.js"></script>
  <script src="<?= $js_route ?>js/moment.min.js"></script>
  <script src="<?= $js_route ?>js/daterangepicker.js"></script>
  <script src="<?= $js_route ?>js/main.js"></script>

  <script src="<?= $js_route ?>js/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.6/vivus.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
  <script src="js/papaparse.min.js"></script>
  <script src="<?= $js_route ?>js/jquery.dataTables.min.js"></script>
  <script src="<?= $js_route ?>js/dataTables.buttons.min.js"></script>
  <script src="<?= $js_route ?>js/buttons.html5.min.js"></script>
  <script src="<?= $js_route ?>js/buttons.print.min.js"></script>
  <script src="<?= $js_route ?>js/pdfmake.min.js"></script>
  <script src="<?= $js_route ?>js/vfs_fonts.js"></script>
  <script src="js/jquery.js"></script>
  <script src="<?= $js_route ?>js/chart.min.js"></script>
  <script src="js/JsBarcode.all.js"></script>

  <title>
    <?= $pg_name ?>
  </title>
</head>

<body>
  <div class="loading">
    <svg id="mysvg" width="150" viewBox="0 0 247 308" fill="#f2751a" xmlns="http://www.w3.org/2000/svg">
      <path d="M2.28181 245.791L2.3703 1.62248H60.7576V304.267L2.28181 245.791Z" stroke="#F2751A" stroke-width="3" />
      <path d="M79.4969 211.283L124.217 166.563L162.732 205.078L79.4969 288.758V211.283Z" stroke="#F2751A" stroke-width="3" />
      <path d="M137.27 257.504L175.93 218.472L224.474 267.016L185.628 305.862L137.27 257.504ZM245.481 246.401L237.866 254.016L187.03 203.18L187.146 1.62387H245.481V246.401Z" stroke="#F2751A" stroke-width="3" />
    </svg>

    <script>
      new Vivus('mysvg', {
        type: 'sync',
        duration: 30,
        animTimingFunction: Vivus.LINEAR
      }, function(obj) {
        obj.el.classList.add("finished");
      });
    </script>
  </div>

  <div class="contain">

    <div class="lside">
      <div class="logo">
        <img src="<?= $image_route ?>images/icon.png" alt="">
        <div class="slogan">onder<span>Softwares</span></div>

      </div>
      <div class="sidebar">
        <ul>
          <li class="">
            <a href="<?= $path . "../contacts/" ?>" class="<?php if ($pg_name == 'Wonder - Dashboard') {
                                                              echo 'active-menu';
                                                            } ?>" title="Dashboard">
              <span><i class="fa-solid fa-house"></i><span class="title">Dashboard</span></span>
            </a>
          </li>
          <?php
          if (check_user_role(1) == 1 || check_user_role(100) == 1 || check_user_role(101) == 1) {
          ?>
            <li class="">
              <a href="<?= $path . "../contacts/customers.php" ?>" class="
              <?php if ($pg_name == 'Wonder - Customers') {
                echo 'active-menu';
              } ?>" title="Customers">
                <span><i class="fa-solid fa-address-book"></i><span class="title">Customers</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(200) == 1 || check_user_role(201) == 1) { ?>
            <li class="">
              <a href="<?= $path . "../contacts/suppliers.php" ?>" class="<?php if ($pg_name == 'Wonder - Suppliers') {
                                                                            echo 'active-menu';
                                                                          } ?>" title="Suppliers">
                <span><i class="fa-solid fa-users-gear"></i><span class="title">Suppliers</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(300) == 1 || check_user_role(301) == 1) { ?>
            <li class="">
              <a href="<?= $path . "../contacts/manufacturers.php" ?>" class="<?php if ($pg_name == 'Wonder - Manufacturers') {
                                                                                echo 'active-menu';
                                                                              } ?>" title="Manufacturers">
                <span><i class="fa-solid fa-building-user"></i><span class="title">Manufacturers</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(401) == 1) { ?>
            <li class="">
              <a href="<?= $path . "../contacts/employees.php" ?>" class="<?php if ($pg_name == 'Wonder - Employees') {
                                                                            echo 'active-menu';
                                                                          } ?>" title="Employeees">
                <span><i class="fa-solid fa-users"></i><span class="title">Employeees</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(501) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-7" title="Org. Structural">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Job Titles' || $pg_name == 'Wonder - Job Types' || $pg_name == 'Wonder - Departments' || $pg_name == 'Wonder - Career Levels') {
                echo 'active-menu';
              } ?>" title="Org. Structural">
                  <span><i class="fa-solid fa-sitemap"></i><span class="title">Org. Structural</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-7">
                <li class="">
                  <a href="<?= $path . "../contacts/job_titles.php" ?>" title="Job Titles" class="s-menus <?php if ($pg_name == 'Wonder - Job Titles') {
                                                                                                            echo 'active-sup';
                                                                                                          } ?>">
                    <span class="s-menus">Job Titles</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= $path . "../contacts/job_types.php" ?>" title="Job Types" class="s-menus <?php if ($pg_name == 'Wonder - Job Types') {
                                                                                                          echo 'active-sup';
                                                                                                        } ?>">
                    <span class="s-menus">Job Types</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= $path . "../contacts/categories.php" ?>" title="Departments" class="s-menus <?php if ($pg_name == 'Wonder - Departments') {
                                                                                                              echo 'active-sup';
                                                                                                            } ?>">
                    <span class="s-menus">Departments</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= $path . "../contacts/career_levels.php" ?>" title="Career Levels" class="s-menus <?php if ($pg_name == 'Wonder - Career Levels') {
                                                                                                                  echo 'active-sup';
                                                                                                                } ?>">
                    <span class="s-menus">Career Levels</span>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(601) == 1) { ?>
            <li class="">
              <a href="<?= $path . "../inventory/warehouses.php" ?>" class="
              <?php if ($pg_name == 'Wonder - Warehouses') {
                echo 'active-menu';
              } ?>" title="Warehouses">
                <span><i class="fa-solid fa-warehouse"></i><span class="title">Warehouses</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(606) == 1) { ?>
            <li class="">
              <a href="<?= $path . "../inventory/inventory.php" ?>" class="<?php if ($pg_name == 'Wonder - Inventory') {
                                                                              echo 'active-menu';
                                                                            } ?>" title="Inventory">
                <span><i class="fa-solid fa-boxes-stacked"></i><span class="title">Inventory</span></span>
              </a>
            </li>
            <?php if (check_user_role(1) == 1 || check_user_role(600) == 1 || check_user_role(613) == 1) { ?>
              <li class="">
                <a href="<?= $path . "../inventory/productsreg.php" ?>" class="<?php if ($pg_name == 'Wonder - Product Registeration') {
                                                                                  echo 'active-menu';
                                                                                } ?>" title="Product Registeration">
                  <span><i class="fa-solid fa-truck-ramp-box"></i><span class="title">Product Registeration</span></span>
                </a>
              </li>
            <?php } ?>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(701) == 1 || check_user_role(702) == 1 || check_user_role(703) == 1 || check_user_role(704) == 1 || check_user_role(705) == 1 || check_user_role(706) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-5" title="General Reports">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Purchases' || $pg_name == 'Wonder - Manufacturing' || $pg_name == 'Wonder - Sales' || $pg_name == 'Wonder - Transfers' || $pg_name == 'Wonder - Customer Returns' || $pg_name == 'Wonder - Supplier Returns') {
                echo 'active-menu';
              } ?>" title="General Reports">
                  <span><i class="fa-solid fa-flag"></i><span class="title">General Reports</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-5">
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(701) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/purchases.php" ?>" title="Purchases" class="s-menus <?php if ($pg_name == 'Wonder - Purchases') {
                                                                                                            echo 'active-sup';
                                                                                                          } ?>">
                      <span class="s-menus">Purchases</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(702) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/manufacturing.php" ?>" title="Manufacturing" class="s-menus <?php if ($pg_name == 'Wonder - Manufacturing') {
                                                                                                                    echo 'active-sup';
                                                                                                                  } ?>">
                      <span class="s-menus">Manufacturing</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(703) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/sales.php" ?>" title="Sales" class="s-menus <?php if ($pg_name == 'Wonder - Sales') {
                                                                                                    echo 'active-sup';
                                                                                                  } ?>">
                      <span class="s-menus">Sales</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(704) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/transfers.php" ?>" title="Transfers" class="s-menus <?php if ($pg_name == 'Wonder - Transfers') {
                                                                                                            echo 'active-sup';
                                                                                                          } ?>">
                      <span class="s-menus">Transfers</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(705) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/creturns.php" ?>" title="Customer Returns" class="s-menus <?php if ($pg_name == 'Wonder - Customer Returns') {
                                                                                                                  echo 'active-sup';
                                                                                                                } ?>">
                      <span class="s-menus">Customer Returns</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(700) == 1 || check_user_role(706) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "../contacts/sreturns.php" ?>" title="Supplier Returns" class="s-menus <?php if ($pg_name == 'Wonder - Supplier Returns') {
                                                                                                                  echo 'active-sup';
                                                                                                                } ?>">
                      <span class="s-menus">Supplier Returns</span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(800) == 1 || check_user_role(801) == 1) { ?>
            <li class="">
              <a href="<?= $path . "expenses.php" ?>" class="<?php if ($pg_name == 'Wonder - Expenses') {
                                                                echo 'active-menu';
                                                              } ?>" title="Expenses">
                <span><i class="fa-solid fa-money-bill-trend-up"></i><span class="title">Expenses</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(8000) == 1 || check_user_role(8001) == 1) { ?>
            <li class="">
              <a href="<?= $path . "revenues.php" ?>" class="<?php if ($pg_name == 'Wonder - Revenues') {
                                                                echo 'active-menu';
                                                              } ?>" title="Revenues">
                <span><i class="fa-solid fa-cart-shopping"></i><span class="title">Other Revenues</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(900) == 1 || check_user_role(901) == 1) { ?>
            <li class="">
              <a href="<?= $path . "fassets.php" ?>" class="<?php if ($pg_name == 'Wonder - Fixed Assets') {
                                                              echo 'active-menu';
                                                            } ?>" title="Fixed Assets">
                <span><i class="fa-solid fa-boxes-stacked"></i><span class="title">Fixed Assets</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1001) == 1 || check_user_role(1002) == 1 || check_user_role(1003) == 1 || check_user_role(1004) == 1 || check_user_role(1005) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-1" title="Trial Balance">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Customers Trial Balance' || $pg_name == 'Wonder - Suppliers Trial Balance' || $pg_name == 'Wonder - Manufacturers Trial Balance' || $pg_name == 'Wonder - Purchases Trial Balance' || $pg_name == 'Wonder - Sales Trial Balance') {
                echo 'active-menu';
              } ?>" title="Trial Balance">
                  <span><i class="fa-solid fa-scale-balanced"></i><span class="title">Trial Balance</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-1">
                <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1001) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "customers.php" ?>" title="Customers Trial Balance" class="s-menus <?php if ($pg_name == 'Wonder - Customers Trial Balance') {
                                                                                                              echo 'active-sup';
                                                                                                            } ?>">
                      <span class="s-menus">Customers</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1002) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "suppliers.php" ?>" title="Suppliers Trial Balance" class="s-menus <?php if ($pg_name == 'Wonder - Suppliers Trial Balance') {
                                                                                                              echo 'active-sup';
                                                                                                            } ?>">
                      <span class="s-menus">Suppliers</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1002) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "manufacturers.php" ?>" title="Manufacturers Trial Balance" class="s-menus <?php if ($pg_name == 'Wonder - Manufacturers Trial Balance') {
                                                                                                                      echo 'active-sup';
                                                                                                                    } ?>">
                      <span class="s-menus">Manufacturers</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1004) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "purchases.php" ?>" title="Purchases Trial Balance" class="s-menus <?php if ($pg_name == 'Wonder - Purchases Trial Balance') {
                                                                                                              echo 'active-sup';
                                                                                                            } ?>">
                      <span class="s-menus">Purchases</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(1000) == 1 || check_user_role(1005) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "sales.php" ?>" title="Sales Trial Balance" class="s-menus <?php if ($pg_name == 'Wonder - Sales Trial Balance') {
                                                                                                      echo 'active-sup';
                                                                                                    } ?>">
                      <span class="s-menus">Sales</span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2001) == 1) { ?>
            <li class="">
              <a href="<?= $path . "generalledger.php" ?>" class="<?php if ($pg_name == 'Wonder - General Ledger') {
                                                                    echo 'active-menu';
                                                                  } ?>" title="General Ledger">
                <span><i class="fa-solid fa-stamp"></i><span class="title">General Ledger</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2002) == 1) { ?>
            <li class="">
              <a href="<?= $path . "incomestatement.php" ?>" class="<?php if ($pg_name == 'Wonder - Income Statement') {
                                                                      echo 'active-menu';
                                                                    } ?>" title="Income Statement">
                <span><i class="fa-solid fa-hand-holding-dollar"></i><span class="title">Income Statement</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2004) == 1) { ?>
            <li class="">
              <a href="<?= $path . "balancesheet.php" ?>" class="<?php if ($pg_name == 'Wonder - Balance Sheet') {
                                                                    echo 'active-menu';
                                                                  } ?>" title="Balance Sheet">
                <span><i class="fa-solid fa-coins"></i><span class="title">Balance Sheet</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2005) == 1 || check_user_role(2007) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-4" title="Tax. Report">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - VAT Taxes Report' || $pg_name == 'Wonder - Withholding Taxes Report') {
                echo 'active-menu';
              } ?>" title="Tax. Report">
                  <span><i class="fa-solid fa-receipt"></i><span class="title">Taxes Report</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-4">
                <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2005) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "vtax.php" ?>" title="VAT Report" class="s-menus <?php if ($pg_name == 'Wonder - VAT Taxes Report') {
                                                                                            echo 'active-sup';
                                                                                          } ?>">
                      <span class="s-menus">VAT Taxes Report</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(2000) == 1 || check_user_role(2007) == 1) { ?>
                  <!-- <li class="">
                    <a href="<?= $path . "wtax.php" ?>" title="Withholdig Tax Report" class="s-menus <?php if ($pg_name == 'Wonder - Withholding Taxes Report') {
                                                                                                        echo 'active-sup';
                                                                                                      } ?>">
                      <span class="s-menus">Witholding Taxes Report</span>
                    </a>
                  </li> -->
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3001) == 1 || check_user_role(3002) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-2" title="Cash & Equiv.">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Cash' || $pg_name == 'Wonder - Bank Accounts') {
                echo 'active-menu';
              } ?>" title="Cash & Equiv.">
                  <span><i class="fa-solid fa-money-bills"></i><span class="title">Cash & Equiv.</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-2">
                <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3001) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "cash.php" ?>" title="Cash" class="s-menus <?php if ($pg_name == 'Wonder - Cash') {
                                                                                      echo 'active-sup';
                                                                                    } ?>">
                      <span class="s-menus">Cash</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (check_user_role(1) == 1 || check_user_role(3000) == 1 || check_user_role(3002) == 1) { ?>
                  <li class="">
                    <a href="<?= $path . "banks.php" ?>" title="Bank Accounts" class="s-menus <?php if ($pg_name == 'Wonder - Bank Accounts') {
                                                                                                echo 'active-sup';
                                                                                              } ?>">
                      <span class="s-menus">Bank Accounts</span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(4000) == 1 || check_user_role(4001) == 1) { ?>
            <li class="">
              <a href="<?= $path . "capital.php" ?>" class="<?php if ($pg_name == 'Wonder - Share Capital') {
                                                              echo 'active-menu';
                                                            } ?>" title="Share Capital">
                <span><i class="fa-solid fa-building"></i><span class="title">Share Capital</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(5000) == 1 || check_user_role(5001) == 1) { ?>
            <li class="">
              <a href="<?= $path . "exchange.php" ?>" class="<?php if ($pg_name == 'Wonder - Exchange Difference') {
                                                                echo 'active-menu';
                                                              } ?>" title="Exchange Difference">
                <span><i class="fa-solid fa-money-bill-transfer"></i><span class="title">Exchange Difference</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(6000) == 1 || check_user_role(6001) == 1) { ?>
            <li class="">
              <a href="<?= $path . "loans.php" ?>" class="<?php if ($pg_name == 'Wonder - Loans') {
                                                            echo 'active-menu';
                                                          } ?>" title="Loans">
                <span><i class="fa-solid fa-building-columns"></i><span class="title">Loans</span></span>
              </a>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1 || check_user_role(7000) == 1 || check_user_role(7001) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-3" title="Other Balances">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Credit Balances' || $pg_name == 'Wonder - Debit Balances') {
                echo 'active-menu';
              } ?>" title="Other Balances">
                  <span><i class="fa-solid fa-circle-dollar-to-slot"></i><span class="title">Other Balances</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-3">
                <li class="">
                  <a href="<?= $path . "dbalances.php" ?>" title="Debit Balances" class="s-menus <?php if ($pg_name == 'Wonder - Debit Balances') {
                                                                                                    echo 'active-sup';
                                                                                                  } ?>">
                    <span class="s-menus">Debit Balances</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= $path . "cbalances.php" ?>" title="Credit Balances" class="s-menus <?php if ($pg_name == 'Wonder - Credit Balances') {
                                                                                                    echo 'active-sup';
                                                                                                  } ?>">
                    <span class="s-menus">Credit Balances</span>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <?php if (check_user_role(1) == 1) { ?>
            <li class="">
              <div class="drop-down drop-down-6" title="Trial Balance">
                <a href="<?= $path ?>" class="disable_a 
              <?php if ($pg_name == 'Wonder - Roles'  || $pg_name == 'Wonder - General Settings') {
                echo 'active-menu';
              } ?>" title="Trial Balance">
                  <span><i class="fa-solid fa-gear"></i><span class="title">Configurations</span></span>
                  <span class="arrow">
                    <i class="fa-solid fa-chevron-down"></i>
                  </span>
                </a>
              </div>
              <ul class="drop-down-menu drop-down-menu-6">

                <!-- <li class="">
                  <a href="<?= $path . "../settings/general.php" ?>" title="General Settings" class="s-menus <?php if ($pg_name == 'Wonder - General Settings') {
                                                                                                                echo 'active-sup';
                                                                                                              } ?>">
                    <span class="s-menus">General Settings</span>
                  </a>
                </li> -->
                <li class="">
                  <a href="<?= $path . "../settings/roles.php" ?>" title="User Roles" class="s-menus <?php if ($pg_name == 'Wonder - Roles') {
                                                                                                        echo 'active-sup';
                                                                                                      } ?>">
                    <span class="s-menus">User Roles</span>
                  </a>
                </li>


              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>

    <div class="rside">
      <div class="header">
        <!-- <div class="lhead">
          <a href="<?= $path . "../" ?>" class="back">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 240.823 240.823" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
              <g>
                <path d="M57.633 129.007 165.93 237.268c4.752 4.74 12.451 4.74 17.215 0 4.752-4.74 4.752-12.439 0-17.179l-99.707-99.671 99.695-99.671c4.752-4.74 4.752-12.439 0-17.191-4.752-4.74-12.463-4.74-17.215 0L57.621 111.816c-4.679 4.691-4.679 12.511.012 17.191z" fill="#332f2a" data-original="#000000" class=""></path>
              </g>
            </svg>
          </a>
        </div> -->
        <div class="rhead">
          <form action="search.php" method="get" class="searchform">
            <input type="text" name="q" placeholder="Search">
            <input type="submit" value="">
          </form>
          <div class="log-btn" title="Connected">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
              <g>
                <circle cx="256" cy="403.113" r="47.692" fill="#63c667" transform="rotate(-80.8 255.93 403.135)" data-original="#000000" class=""></circle>
                <path d="M497.765 161.344C429.036 92.616 340.65 61.195 256 61.195S82.964 92.616 14.235 161.344c-18.994 19.016-18.907 48.462-.177 67.271 23.39 23.65 54.014 14.236 67.727.064 46.554-46.492 108.419-72.096 174.215-72.096s127.661 25.604 174.215 72.096c13.713 14.172 44.337 23.586 67.727-.064 18.73-18.809 18.817-48.255-.177-67.271z" fill="#63c667" data-original="#000000" class=""></path>
                <path d="M256 208.303c-47.421 0-98.304 17.63-137.733 57.05-19.237 19.236-18.854 48.818.192 67.663 18.911 18.782 48.334 18.703 67.24-.203 18.778-18.777 43.744-29.118 70.3-29.118s51.522 10.341 70.3 29.118c18.906 18.906 48.33 18.985 67.24.203 19.046-18.845 19.429-48.427.192-67.663-39.427-39.419-90.31-57.05-137.731-57.05z" fill="#63c667" data-original="#000000" class=""></path>
              </g>
            </svg>
          </div>


          <div class="profile">

            <div class="flex">
              <div class="profile-img">
                <img src="<?= $image_route ?>images/ur-img/<?= $user_info['picture'] ?>" alt="">
              </div>
              <div class="profile-info">
                <h5>
                  <?= ucfirst($user_info['fname']) . " " . ucfirst($user_info['mname']) ?>
                </h5>
                <?php

                $stmt43 = $con->prepare("SELECT * FROM `user_roles` WHERE id = '" . $user_info['role'] . "'");
                $stmt43->execute();
                $count43 = $stmt43->rowCount();
                $row43 = $stmt43->fetch(PDO::FETCH_ASSOC);

                ?>
                <p>
                  <?= ucfirst($row43['name']) ?>
                </p>
              </div>
            </div>
            <span class="arrow">
              <img src="<?= $image_route ?>images/down.png" alt="">
            </span>
            <ul>
              <li><a href="<?= $path . "../contacts/employeedetails.php?uid=" . $user_info['id'] ?>"><i class="fa-solid fa-user"></i>Profile</a></li>
              <li><a href="<?= $path . "../logout.php" ?>"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="logs-part">
        <div class="black-screen"></div>
        <div class="logs-section">
          <h4>Current Logs</h4>
          <div class="listing-logs">

            <?php
            if (check_user_role(1) == 1 || check_user_role(17) == 1) {
              get_logs();
            }
            ?>
          </div>
        </div>
      </div>

      <div class="body">