<?php
$pg_name = "Wonder - Roles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_role() == 1) {
    if (check_user_role(1) == 1) {
      $role_info = role_info();
      if ($role_info['id'] !== 1) {
        $user_info = login_info();
?>

        <div class="att-part">
          <div class="org-part">
            <form action="" method="POST">
              <div class="headso">
                <h3>New Role</h3>
                <hr class="head-line">
                <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "roles.php" ?>">User Roles</a> / New Role</p>
              </div>
              <div class="org-section">
                <form action="" method="POST">
                  <div class="org-contain role-contain">
                    <?php edit_role();
                    del_role(); ?>
                    <div class="line-info">
                      <div class="l-info">Name<span> *</span>:</div>
                      <div class="r-info">
                        <input type="text" name="name" value="<?= $role_info['name'] ?>" style="font-size: 14px !important;margin-top:5px;" required>
                      </div>
                    </div>
                    <div id="not_admin">
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin100">
                            <input type="checkbox" name="role[]" value="100" id="plugin100" <?php if (check_role_id(100)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Customers</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin101">
                            <input type="checkbox" name="role[]" value="101" id="plugin101" <?php if (check_role_id(101)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Customers List</span>
                          </label>
                          <label for="plugin102">
                            <input type="checkbox" name="role[]" value="102" id="plugin102" <?php if (check_role_id(102)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Customer</span>
                          </label>
                          <label for="plugin103">
                            <input type="checkbox" name="role[]" value="103" id="plugin103" <?php if (check_role_id(103)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>View Customer Profile</span>
                          </label>
                          <label for="plugin104">
                            <input type="checkbox" name="role[]" value="104" id="plugin104" <?php if (check_role_id(104)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Customer Profile</span>
                          </label>
                          <label for="plugin105">
                            <input type="checkbox" name="role[]" value="105" id="plugin105" <?php if (check_role_id(105)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Customer's Account Statement</span>
                          </label>
                          <label for="plugin106">
                            <input type="checkbox" name="role[]" value="106" id="plugin106" <?php if (check_role_id(106)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Customer's Orders</span>
                          </label>
                          <label for="plugin107">
                            <input type="checkbox" name="role[]" value="107" id="plugin107" <?php if (check_role_id(107)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Sale Invoice</span>
                          </label>
                          <label for="plugin108">
                            <input type="checkbox" name="role[]" value="108" id="plugin108" <?php if (check_role_id(108)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Receive Money</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin200">
                            <input type="checkbox" name="role[]" value="200" id="plugin200" <?php if (check_role_id(200)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Suppliers</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin201">
                            <input type="checkbox" name="role[]" value="201" id="plugin201" <?php if (check_role_id(201)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Suppliers List</span>
                          </label>
                          <label for="plugin202">
                            <input type="checkbox" name="role[]" value="202" id="plugin202" <?php if (check_role_id(202)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Supplier</span>
                          </label>
                          <label for="plugin203">
                            <input type="checkbox" name="role[]" value="203" id="plugin203" <?php if (check_role_id(203)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>View Supplier Profile</span>
                          </label>
                          <label for="plugin204">
                            <input type="checkbox" name="role[]" value="204" id="plugin204" <?php if (check_role_id(204)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Supplier Profile</span>
                          </label>
                          <label for="plugin205">
                            <input type="checkbox" name="role[]" value="205" id="plugin205" <?php if (check_role_id(205)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Supplier's Account Statement</span>
                          </label>
                          <label for="plugin206">
                            <input type="checkbox" name="role[]" value="206" id="plugin206" <?php if (check_role_id(206)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Supplier's Orders</span>
                          </label>
                          <label for="plugin207">
                            <input type="checkbox" name="role[]" value="207" id="plugin207" <?php if (check_role_id(207)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Suppliers's Purchases</span>
                          </label>
                          <label for="plugin208">
                            <input type="checkbox" name="role[]" value="208" id="plugin208" <?php if (check_role_id(208)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Purchase Order</span>
                          </label>
                          <label for="plugin209">
                            <input type="checkbox" name="role[]" value="209" id="plugin209" <?php if (check_role_id(209)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Payment Order</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin300">
                            <input type="checkbox" name="role[]" value="300" id="plugin300" <?php if (check_role_id(300)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturers</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin301">
                            <input type="checkbox" name="role[]" value="301" id="plugin301" <?php if (check_role_id(301)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturers List</span>
                          </label>
                          <label for="plugin302">
                            <input type="checkbox" name="role[]" value="302" id="plugin302" <?php if (check_role_id(302)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Manufacturer</span>
                          </label>
                          <label for="plugin303">
                            <input type="checkbox" name="role[]" value="303" id="plugin303" <?php if (check_role_id(303)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>View Manufacturer Profile</span>
                          </label>
                          <label for="plugin304">
                            <input type="checkbox" name="role[]" value="304" id="plugin304" <?php if (check_role_id(304)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Manufacturer Profile</span>
                          </label>
                          <label for="plugin305">
                            <input type="checkbox" name="role[]" value="305" id="plugin305" <?php if (check_role_id(305)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturer's Account Statement</span>
                          </label>
                          <label for="plugin306">
                            <input type="checkbox" name="role[]" value="306" id="plugin306" <?php if (check_role_id(306)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturer's Orders</span>
                          </label>
                          <label for="plugin307">
                            <input type="checkbox" name="role[]" value="307" id="plugin307" <?php if (check_role_id(307)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturers's Purchases</span>
                          </label>
                          <label for="plugin308">
                            <input type="checkbox" name="role[]" value="308" id="plugin308" <?php if (check_role_id(308)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Manufacturing Order</span>
                          </label>
                          <label for="plugin309">
                            <input type="checkbox" name="role[]" value="309" id="plugin309" <?php if (check_role_id(309)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Payment Order</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin400">
                            <input type="checkbox" name="role[]" value="400" id="plugin400" <?php if (check_role_id(400)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Users</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin401">
                            <input type="checkbox" name="role[]" value="401" id="plugin401" <?php if (check_role_id(401)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Users List</span>
                          </label>
                          <label for="plugin402">
                            <input type="checkbox" name="role[]" value="402" id="plugin402" <?php if (check_role_id(402)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add User</span>
                          </label>
                          <label for="plugin403">
                            <input type="checkbox" name="role[]" value="403" id="plugin403" <?php if (check_role_id(403)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>View User Profile</span>
                          </label>
                          <label for="plugin404">
                            <input type="checkbox" name="role[]" value="404" id="plugin404" <?php if (check_role_id(404)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit User Profile</span>
                          </label>
                          <label for="plugin405">
                            <input type="checkbox" name="role[]" value="405" id="plugin405" <?php if (check_role_id(405)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Net Salary</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin500">
                            <input type="checkbox" name="role[]" value="500" id="plugin500" <?php if (check_role_id(500)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Organizational Structure</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin501">
                            <input type="checkbox" name="role[]" value="501" id="plugin501" <?php if (check_role_id(501)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Lists</span>
                          </label>
                          <label for="plugin502">
                            <input type="checkbox" name="role[]" value="502" id="plugin502" <?php if (check_role_id(502)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Category</span>
                          </label>
                          <label for="plugin503">
                            <input type="checkbox" name="role[]" value="503" id="plugin503" <?php if (check_role_id(503)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Category</span>
                          </label>
                          <label for="plugin504">
                            <input type="checkbox" name="role[]" value="504" id="plugin504" <?php if (check_role_id(504)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Category</span>
                          </label>
                          <label for="plugin505">
                            <input type="checkbox" name="role[]" value="505" id="plugin505" <?php if (check_role_id(505)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Employee List</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin600">
                            <input type="checkbox" name="role[]" value="600" id="plugin600" <?php if (check_role_id(600)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Warehouses / Inventory</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin601">
                            <input type="checkbox" name="role[]" value="601" id="plugin601" <?php if (check_role_id(601)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Warehouses List</span>
                          </label>
                          <label for="plugin602">
                            <input type="checkbox" name="role[]" value="602" id="plugin602" <?php if (check_role_id(602)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Warehouse</span>
                          </label>
                          <label for="plugin603">
                            <input type="checkbox" name="role[]" value="603" id="plugin603" <?php if (check_role_id(603)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>View Warehouse</span>
                          </label>
                          <label for="plugin604">
                            <input type="checkbox" name="role[]" value="604" id="plugin604" <?php if (check_role_id(604)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Warehouse</span>
                          </label>
                          <label for="plugin605">
                            <input type="checkbox" name="role[]" value="605" id="plugin605" <?php if (check_role_id(605)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Transfers</span>
                          </label>
                          <label for="plugin606">
                            <input type="checkbox" name="role[]" value="606" id="plugin606" <?php if (check_role_id(606)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Inventory</span>
                          </label>
                          <label for="plugin607">
                            <input type="checkbox" name="role[]" value="607" id="plugin607" <?php if (check_role_id(607)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Transfer Request</span>
                          </label>
                          <label for="plugin608">
                            <input type="checkbox" name="role[]" value="608" id="plugin608" <?php if (check_role_id(608)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Edit Product</span>
                          </label>
                          <label for="plugin609">
                            <input type="checkbox" name="role[]" value="609" id="plugin609" <?php if (check_role_id(609)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Product Transfers</span>
                          </label>
                          <label for="plugin610">
                            <input type="checkbox" name="role[]" value="610" id="plugin610" <?php if (check_role_id(610)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Product History</span>
                          </label>
                          <label for="plugin611">
                            <input type="checkbox" name="role[]" value="611" id="plugin611" <?php if (check_role_id(611)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Product Sales</span>
                          </label>
                          <label for="plugin612">
                            <input type="checkbox" name="role[]" value="612" id="plugin612" <?php if (check_role_id(612)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Product Cost</span>
                          </label>
                          <label for="plugin613">
                            <input type="checkbox" name="role[]" value="613" id="plugin613" <?php if (check_role_id(613)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Reg. Products</span>
                          </label>
                          <label for="plugin614">
                            <input type="checkbox" name="role[]" value="614" id="plugin614" <?php if (check_role_id(614)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Material</span>
                          </label>
                          <label for="plugin615">
                            <input type="checkbox" name="role[]" value="615" id="plugin615" <?php if (check_role_id(615)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Final Product</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin700">
                            <input type="checkbox" name="role[]" value="700" id="plugin700" <?php if (check_role_id(700)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>General Reports</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin701">
                            <input type="checkbox" name="role[]" value="701" id="plugin701" <?php if (check_role_id(701)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Purchases</span>
                          </label>
                          <label for="plugin702">
                            <input type="checkbox" name="role[]" value="702" id="plugin702" <?php if (check_role_id(702)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Manufacturing</span>
                          </label>
                          <label for="plugin703">
                            <input type="checkbox" name="role[]" value="703" id="plugin703" <?php if (check_role_id(703)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Sales</span>
                          </label>
                          <label for="plugin704">
                            <input type="checkbox" name="role[]" value="704" id="plugin704" <?php if (check_role_id(704)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Transfers</span>
                          </label>
                          <label for="plugin705">
                            <input type="checkbox" name="role[]" value="705" id="plugin705" <?php if (check_role_id(705)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Customer's Returns</span>
                          </label>
                          <label for="plugin706">
                            <input type="checkbox" name="role[]" value="706" id="plugin706" <?php if (check_role_id(706)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Supplier's Returns</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin800">
                            <input type="checkbox" name="role[]" value="800" id="plugin800" <?php if (check_role_id(800)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Expenses</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin801">
                            <input type="checkbox" name="role[]" value="801" id="plugin801" <?php if (check_role_id(801)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Expenses List</span>
                          </label>
                          <label for="plugin802">
                            <input type="checkbox" name="role[]" value="802" id="plugin802" <?php if (check_role_id(802)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Expense</span>
                          </label>
                          <label for="plugin803">
                            <input type="checkbox" name="role[]" value="803" id="plugin803" <?php if (check_role_id(803)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Remove Expense</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin900">
                            <input type="checkbox" name="role[]" value="900" id="plugin900" <?php if (check_role_id(900)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Assets</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin901">
                            <input type="checkbox" name="role[]" value="901" id="plugin901" <?php if (check_role_id(901)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Assets List</span>
                          </label>
                          <label for="plugin902">
                            <input type="checkbox" name="role[]" value="902" id="plugin902" <?php if (check_role_id(902)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add Asset Category</span>
                          </label>
                          <label for="plugin903">
                            <input type="checkbox" name="role[]" value="903" id="plugin903" <?php if (check_role_id(903)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Remove Asset Category</span>
                          </label>
                          <label for="plugin904">
                            <input type="checkbox" name="role[]" value="904" id="plugin904" <?php if (check_role_id(904)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Add New Asset</span>
                          </label>
                          <label for="plugin905">
                            <input type="checkbox" name="role[]" value="905" id="plugin905" <?php if (check_role_id(905)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Asset Profile</span>
                          </label>
                          <label for="plugin906">
                            <input type="checkbox" name="role[]" value="906" id="plugin906" <?php if (check_role_id(906)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Sell Asset</span>
                          </label>
                          <label for="plugin907">
                            <input type="checkbox" name="role[]" value="907" id="plugin907" <?php if (check_role_id(907)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Remove Asset</span>
                          </label>
                          <label for="plugin908">
                            <input type="checkbox" name="role[]" value="908" id="plugin908" <?php if (check_role_id(908)) {
                                                                                              echo "checked";
                                                                                            } ?>>
                            <span>Show Asset Revenues</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin1000">
                            <input type="checkbox" name="role[]" value="1000" id="plugin1000" <?php if (check_role_id(1000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Trial Balance</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin1001">
                            <input type="checkbox" name="role[]" value="1001" id="plugin1001" <?php if (check_role_id(1001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Customers Trial Balance</span>
                          </label>
                          <label for="plugin1002">
                            <input type="checkbox" name="role[]" value="1002" id="plugin1002" <?php if (check_role_id(1002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Suppliers Trial Balance</span>
                          </label>
                          <label for="plugin1003">
                            <input type="checkbox" name="role[]" value="1003" id="plugin1003" <?php if (check_role_id(1003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Manufacturers Trial Balance</span>
                          </label>
                          <label for="plugin1004">
                            <input type="checkbox" name="role[]" value="1004" id="plugin1004" <?php if (check_role_id(1004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Purchases Trial Balance</span>
                          </label>
                          <label for="plugin1005">
                            <input type="checkbox" name="role[]" value="1005" id="plugin1005" <?php if (check_role_id(1005)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Sales Trial Balance</span>
                          </label>

                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin2000">
                            <input type="checkbox" name="role[]" value="2000" id="plugin2000" <?php if (check_role_id(2000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Accounting Reports</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin2001">
                            <input type="checkbox" name="role[]" value="2001" id="plugin2001" <?php if (check_role_id(2001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>General Ledger</span>
                          </label>
                          <label for="plugin2002">
                            <input type="checkbox" name="role[]" value="2002" id="plugin2002" <?php if (check_role_id(2002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Income Statement (Profit/Loss)</span>
                          </label>
                          <label for="plugin2003">
                            <input type="checkbox" name="role[]" value="2003" id="plugin2003" <?php if (check_role_id(2003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Edit Income Tax</span>
                          </label>
                          <label for="plugin2004">
                            <input type="checkbox" name="role[]" value="2004" id="plugin2004" <?php if (check_role_id(2004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Balance Sheet</span>
                          </label>
                          <label for="plugin2005">
                            <input type="checkbox" name="role[]" value="2005" id="plugin2005" <?php if (check_role_id(2005)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>VAT Tax. Report</span>
                          </label>
                          <label for="plugin2006">
                            <input type="checkbox" name="role[]" value="2006" id="plugin2006" <?php if (check_role_id(2006)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Tax Payment</span>
                          </label>
                          <label for="plugin2007">
                            <input type="checkbox" name="role[]" value="2007" id="plugin2007" <?php if (check_role_id(2007)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Withholding Tax. Report</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin3000">
                            <input type="checkbox" name="role[]" value="3000" id="plugin3000" <?php if (check_role_id(3000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Cash / Bank</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin3001">
                            <input type="checkbox" name="role[]" value="3001" id="plugin3001" <?php if (check_role_id(3001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Treasury Cash</span>
                          </label>
                          <label for="plugin3002">
                            <input type="checkbox" name="role[]" value="3002" id="plugin3002" <?php if (check_role_id(3002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Bank Accounts List</span>
                          </label>
                          <label for="plugin3003">
                            <input type="checkbox" name="role[]" value="3003" id="plugin3003" <?php if (check_role_id(3003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>View Bank Account</span>
                          </label>
                          <label for="plugin3004">
                            <input type="checkbox" name="role[]" value="3004" id="plugin3004" <?php if (check_role_id(3004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Bank Account</span>
                          </label>
                          <label for="plugin3005">
                            <input type="checkbox" name="role[]" value="3005" id="plugin3005" <?php if (check_role_id(3005)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Transfer Money</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin4000">
                            <input type="checkbox" name="role[]" value="4000" id="plugin4000" <?php if (check_role_id(4000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Share Capital</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin4001">
                            <input type="checkbox" name="role[]" value="4001" id="plugin4001" <?php if (check_role_id(4001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Share Capital Account</span>
                          </label>
                          <label for="plugin4002">
                            <input type="checkbox" name="role[]" value="4002" id="plugin4002" <?php if (check_role_id(4002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Account</span>
                          </label>
                          <label for="plugin4003">
                            <input type="checkbox" name="role[]" value="4003" id="plugin4003" <?php if (check_role_id(4003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Show Account</span>
                          </label>
                          <label for="plugin4004">
                            <input type="checkbox" name="role[]" value="4004" id="plugin4004" <?php if (check_role_id(4004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Transaction</span>
                          </label>
                          <label for="plugin4005">
                            <input type="checkbox" name="role[]" value="4005" id="plugin4005" <?php if (check_role_id(4005)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Remove Transaction</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin5000">
                            <input type="checkbox" name="role[]" value="5000" id="plugin5000" <?php if (check_role_id(5000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Exchange Difference</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin5001">
                            <input type="checkbox" name="role[]" value="5001" id="plugin5001" <?php if (check_role_id(5001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Exchange Difference List</span>
                          </label>
                          <label for="plugin5002">
                            <input type="checkbox" name="role[]" value="5002" id="plugin5002" <?php if (check_role_id(5002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Exchange Difference</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin6000">
                            <input type="checkbox" name="role[]" value="6000" id="plugin6000" <?php if (check_role_id(6000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Loans</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin6001">
                            <input type="checkbox" name="role[]" value="6001" id="plugin6001" <?php if (check_role_id(6001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Loans List</span>
                          </label>
                          <label for="plugin6002">
                            <input type="checkbox" name="role[]" value="6002" id="plugin6002" <?php if (check_role_id(6002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add New Loan</span>
                          </label>
                          <label for="plugin6003">
                            <input type="checkbox" name="role[]" value="6003" id="plugin6003" <?php if (check_role_id(6003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Show Loan Account</span>
                          </label>
                          <label for="plugin6004">
                            <input type="checkbox" name="role[]" value="6004" id="plugin6004" <?php if (check_role_id(6004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Loan Transaction</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin7000">
                            <input type="checkbox" name="role[]" value="7000" id="plugin7000" <?php if (check_role_id(7000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Oher Balances</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin7001">
                            <input type="checkbox" name="role[]" value="7001" id="plugin7001" <?php if (check_role_id(7001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Credit/Debit Balances List</span>
                          </label>
                          <label for="plugin7002">
                            <input type="checkbox" name="role[]" value="7002" id="plugin7002" <?php if (check_role_id(7002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Balance</span>
                          </label>
                          <label for="plugin7003">
                            <input type="checkbox" name="role[]" value="7003" id="plugin7003" <?php if (check_role_id(7003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Show Balance</span>
                          </label>
                          <label for="plugin7004">
                            <input type="checkbox" name="role[]" value="7004" id="plugin7004" <?php if (check_role_id(7004)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Remove Balance</span>
                          </label>
                          <label for="plugin7005">
                            <input type="checkbox" name="role[]" value="7005" id="plugin7005" <?php if (check_role_id(7005)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Balance Transaction</span>
                          </label>
                          <label for="plugin7006">
                            <input type="checkbox" name="role[]" value="7006" id="plugin7006" <?php if (check_role_id(7006)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Remove Transaction</span>
                          </label>
                        </div>
                      </div>
                      <div class="not_section">
                        <div class="head">
                          <label for="plugin8000">
                            <input type="checkbox" name="role[]" value="8000" id="plugin8000" <?php if (check_role_id(8000)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Oher Revenues</span>
                          </label>
                        </div>
                        <div class="sec_body">
                          <label for="plugin8001">
                            <input type="checkbox" name="role[]" value="8001" id="plugin8001" <?php if (check_role_id(8001)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Revenues List</span>
                          </label>
                          <label for="plugin8002">
                            <input type="checkbox" name="role[]" value="8002" id="plugin8002" <?php if (check_role_id(8002)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Add Revenue</span>
                          </label>
                          <label for="plugin8003">
                            <input type="checkbox" name="role[]" value="8003" id="plugin8003" <?php if (check_role_id(8003)) {
                                                                                                echo "checked";
                                                                                              } ?>>
                            <span>Remove Revenue</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <input type="submit" name="edit" value="Update">
                  </div>
                </form>
              </div>
            </form>
          </div>
        </div>
        <script src="<?= $js_route ?>js/checks.js"></script>
<?php
      } else {
        $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
        header("location:" . $path . "/roles.php");
        exit();
      }
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/roles.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/roles.php");
    exit();
  }
} else {
  $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
  header("location:" . $path . "/../login.php");
  exit();
}
include "../includes/footer.inc";
?>