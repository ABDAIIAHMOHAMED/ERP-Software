<?php
$pg_name = "Wonder - Roles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  if (check_user_role(1) == 1) {
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
                <?php add_role() ?>
                <div class="line-info">
                  <div class="l-info">Name<span> *</span>:</div>
                  <div class="r-info">
                    <input type="text" name="name" value="" style="font-size: 14px !important;margin-top:5px;" required>
                  </div>
                </div>
                <div id="not_admin">
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin100">
                        <input type="checkbox" name="role[]" value="100" id="plugin100">
                        <span>Customers</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin101">
                        <input type="checkbox" name="role[]" value="101" id="plugin101">
                        <span>Customers List</span>
                      </label>
                      <label for="plugin102">
                        <input type="checkbox" name="role[]" value="102" id="plugin102">
                        <span>Add Customer</span>
                      </label>
                      <label for="plugin103">
                        <input type="checkbox" name="role[]" value="103" id="plugin103">
                        <span>View Customer Profile</span>
                      </label>
                      <label for="plugin104">
                        <input type="checkbox" name="role[]" value="104" id="plugin104">
                        <span>Edit Customer Profile</span>
                      </label>
                      <label for="plugin105">
                        <input type="checkbox" name="role[]" value="105" id="plugin105">
                        <span>Customer's Account Statement</span>
                      </label>
                      <label for="plugin106">
                        <input type="checkbox" name="role[]" value="106" id="plugin106">
                        <span>Customer's Orders</span>
                      </label>
                      <label for="plugin107">
                        <input type="checkbox" name="role[]" value="107" id="plugin107">
                        <span>Add Sale Invoice</span>
                      </label>
                      <label for="plugin108">
                        <input type="checkbox" name="role[]" value="108" id="plugin108">
                        <span>Receive Money</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin200">
                        <input type="checkbox" name="role[]" value="200" id="plugin200">
                        <span>Suppliers</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin201">
                        <input type="checkbox" name="role[]" value="201" id="plugin201">
                        <span>Suppliers List</span>
                      </label>
                      <label for="plugin202">
                        <input type="checkbox" name="role[]" value="202" id="plugin202">
                        <span>Add Supplier</span>
                      </label>
                      <label for="plugin203">
                        <input type="checkbox" name="role[]" value="203" id="plugin203">
                        <span>View Supplier Profile</span>
                      </label>
                      <label for="plugin204">
                        <input type="checkbox" name="role[]" value="204" id="plugin204">
                        <span>Edit Supplier Profile</span>
                      </label>
                      <label for="plugin205">
                        <input type="checkbox" name="role[]" value="205" id="plugin205">
                        <span>Supplier's Account Statement</span>
                      </label>
                      <label for="plugin206">
                        <input type="checkbox" name="role[]" value="206" id="plugin206">
                        <span>Supplier's Orders</span>
                      </label>
                      <label for="plugin207">
                        <input type="checkbox" name="role[]" value="207" id="plugin207">
                        <span>Suppliers's Purchases</span>
                      </label>
                      <label for="plugin208">
                        <input type="checkbox" name="role[]" value="208" id="plugin208">
                        <span>Add Purchase Order</span>
                      </label>
                      <label for="plugin209">
                        <input type="checkbox" name="role[]" value="209" id="plugin209">
                        <span>Add Payment Order</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin300">
                        <input type="checkbox" name="role[]" value="300" id="plugin300">
                        <span>Manufacturers</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin301">
                        <input type="checkbox" name="role[]" value="301" id="plugin301">
                        <span>Manufacturers List</span>
                      </label>
                      <label for="plugin302">
                        <input type="checkbox" name="role[]" value="302" id="plugin302">
                        <span>Add Manufacturer</span>
                      </label>
                      <label for="plugin303">
                        <input type="checkbox" name="role[]" value="303" id="plugin303">
                        <span>View Manufacturer Profile</span>
                      </label>
                      <label for="plugin304">
                        <input type="checkbox" name="role[]" value="304" id="plugin304">
                        <span>Edit Manufacturer Profile</span>
                      </label>
                      <label for="plugin305">
                        <input type="checkbox" name="role[]" value="305" id="plugin305">
                        <span>Manufacturer's Account Statement</span>
                      </label>
                      <label for="plugin306">
                        <input type="checkbox" name="role[]" value="306" id="plugin306">
                        <span>Manufacturer's Orders</span>
                      </label>
                      <label for="plugin307">
                        <input type="checkbox" name="role[]" value="307" id="plugin307">
                        <span>Manufacturers's Purchases</span>
                      </label>
                      <label for="plugin308">
                        <input type="checkbox" name="role[]" value="308" id="plugin308">
                        <span>Add Manufacturing Order</span>
                      </label>
                      <label for="plugin309">
                        <input type="checkbox" name="role[]" value="309" id="plugin309">
                        <span>Add Payment Order</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin400">
                        <input type="checkbox" name="role[]" value="400" id="plugin400">
                        <span>Users</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin401">
                        <input type="checkbox" name="role[]" value="401" id="plugin401">
                        <span>Users List</span>
                      </label>
                      <label for="plugin402">
                        <input type="checkbox" name="role[]" value="402" id="plugin402">
                        <span>Add User</span>
                      </label>
                      <label for="plugin403">
                        <input type="checkbox" name="role[]" value="403" id="plugin403">
                        <span>View User Profile</span>
                      </label>
                      <label for="plugin404">
                        <input type="checkbox" name="role[]" value="404" id="plugin404">
                        <span>Edit User Profile</span>
                      </label>
                      <label for="plugin405">
                        <input type="checkbox" name="role[]" value="405" id="plugin405">
                        <span>Show Net Salary</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin500">
                        <input type="checkbox" name="role[]" value="500" id="plugin500">
                        <span>Organizational Structure</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin501">
                        <input type="checkbox" name="role[]" value="501" id="plugin501">
                        <span>Show Lists</span>
                      </label>
                      <label for="plugin502">
                        <input type="checkbox" name="role[]" value="502" id="plugin502">
                        <span>Add Category</span>
                      </label>
                      <label for="plugin503">
                        <input type="checkbox" name="role[]" value="503" id="plugin503">
                        <span>Show Category</span>
                      </label>
                      <label for="plugin504">
                        <input type="checkbox" name="role[]" value="504" id="plugin504">
                        <span>Edit Category</span>
                      </label>
                      <label for="plugin505">
                        <input type="checkbox" name="role[]" value="505" id="plugin505">
                        <span>Show Employee List</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin600">
                        <input type="checkbox" name="role[]" value="600" id="plugin600">
                        <span>Warehouses / Inventory</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin601">
                        <input type="checkbox" name="role[]" value="601" id="plugin601">
                        <span>Warehouses List</span>
                      </label>
                      <label for="plugin602">
                        <input type="checkbox" name="role[]" value="602" id="plugin602">
                        <span>Add Warehouse</span>
                      </label>
                      <label for="plugin603">
                        <input type="checkbox" name="role[]" value="603" id="plugin603">
                        <span>View Warehouse</span>
                      </label>
                      <label for="plugin604">
                        <input type="checkbox" name="role[]" value="604" id="plugin604">
                        <span>Edit Warehouse</span>
                      </label>
                      <label for="plugin605">
                        <input type="checkbox" name="role[]" value="605" id="plugin605">
                        <span>Show Transfers</span>
                      </label>
                      <label for="plugin606">
                        <input type="checkbox" name="role[]" value="606" id="plugin606">
                        <span>Show Inventory</span>
                      </label>
                      <label for="plugin607">
                        <input type="checkbox" name="role[]" value="607" id="plugin607">
                        <span>Transfer Request</span>
                      </label>
                      <label for="plugin608">
                        <input type="checkbox" name="role[]" value="608" id="plugin608">
                        <span>Edit Product</span>
                      </label>
                      <label for="plugin609">
                        <input type="checkbox" name="role[]" value="609" id="plugin609">
                        <span>Show Product Transfers</span>
                      </label>
                      <label for="plugin610">
                        <input type="checkbox" name="role[]" value="610" id="plugin610">
                        <span>Show Product History</span>
                      </label>
                      <label for="plugin611">
                        <input type="checkbox" name="role[]" value="611" id="plugin611">
                        <span>Show Product Sales</span>
                      </label>
                      <label for="plugin612">
                        <input type="checkbox" name="role[]" value="612" id="plugin612">
                        <span>Show Product Cost</span>
                      </label>
                      <label for="plugin613">
                        <input type="checkbox" name="role[]" value="613" id="plugin613">
                        <span>Show Reg. Products</span>
                      </label>
                      <label for="plugin614">
                        <input type="checkbox" name="role[]" value="614" id="plugin614">
                        <span>Add Material</span>
                      </label>
                      <label for="plugin615">
                        <input type="checkbox" name="role[]" value="615" id="plugin615">
                        <span>Add Final Product</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin700">
                        <input type="checkbox" name="role[]" value="700" id="plugin700">
                        <span>General Reports</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin701">
                        <input type="checkbox" name="role[]" value="701" id="plugin701">
                        <span>Purchases</span>
                      </label>
                      <label for="plugin702">
                        <input type="checkbox" name="role[]" value="702" id="plugin702">
                        <span>Manufacturing</span>
                      </label>
                      <label for="plugin703">
                        <input type="checkbox" name="role[]" value="703" id="plugin703">
                        <span>Sales</span>
                      </label>
                      <label for="plugin704">
                        <input type="checkbox" name="role[]" value="704" id="plugin704">
                        <span>Transfers</span>
                      </label>
                      <label for="plugin705">
                        <input type="checkbox" name="role[]" value="705" id="plugin705">
                        <span>Customer's Returns</span>
                      </label>
                      <label for="plugin706">
                        <input type="checkbox" name="role[]" value="706" id="plugin706">
                        <span>Supplier's Returns</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin800">
                        <input type="checkbox" name="role[]" value="800" id="plugin800">
                        <span>Expenses</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin801">
                        <input type="checkbox" name="role[]" value="801" id="plugin801">
                        <span>Expenses List</span>
                      </label>
                      <label for="plugin802">
                        <input type="checkbox" name="role[]" value="802" id="plugin802">
                        <span>Add Expense</span>
                      </label>
                      <label for="plugin803">
                        <input type="checkbox" name="role[]" value="803" id="plugin803">
                        <span>Remove Expense</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin900">
                        <input type="checkbox" name="role[]" value="900" id="plugin900">
                        <span>Assets</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin901">
                        <input type="checkbox" name="role[]" value="901" id="plugin901">
                        <span>Assets List</span>
                      </label>
                      <label for="plugin902">
                        <input type="checkbox" name="role[]" value="902" id="plugin902">
                        <span>Add Asset Category</span>
                      </label>
                      <label for="plugin903">
                        <input type="checkbox" name="role[]" value="903" id="plugin903">
                        <span>Remove Asset Category</span>
                      </label>
                      <label for="plugin904">
                        <input type="checkbox" name="role[]" value="904" id="plugin904">
                        <span>Add New Asset</span>
                      </label>
                      <label for="plugin905">
                        <input type="checkbox" name="role[]" value="905" id="plugin905">
                        <span>Show Asset Profile</span>
                      </label>
                      <label for="plugin906">
                        <input type="checkbox" name="role[]" value="906" id="plugin906">
                        <span>Sell Asset</span>
                      </label>
                      <label for="plugin907">
                        <input type="checkbox" name="role[]" value="907" id="plugin907">
                        <span>Remove Asset</span>
                      </label>
                      <label for="plugin908">
                        <input type="checkbox" name="role[]" value="908" id="plugin908">
                        <span>Show Asset Revenues</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin1000">
                        <input type="checkbox" name="role[]" value="1000" id="plugin1000">
                        <span>Trial Balance</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin1001">
                        <input type="checkbox" name="role[]" value="1001" id="plugin1001">
                        <span>Customers Trial Balance</span>
                      </label>
                      <label for="plugin1002">
                        <input type="checkbox" name="role[]" value="1002" id="plugin1002">
                        <span>Suppliers Trial Balance</span>
                      </label>
                      <label for="plugin1003">
                        <input type="checkbox" name="role[]" value="1003" id="plugin1003">
                        <span>Manufacturers Trial Balance</span>
                      </label>
                      <label for="plugin1004">
                        <input type="checkbox" name="role[]" value="1004" id="plugin1004">
                        <span>Purchases Trial Balance</span>
                      </label>
                      <label for="plugin1005">
                        <input type="checkbox" name="role[]" value="1005" id="plugin1005">
                        <span>Sales Trial Balance</span>
                      </label>

                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin2000">
                        <input type="checkbox" name="role[]" value="2000" id="plugin2000">
                        <span>Accounting Reports</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin2001">
                        <input type="checkbox" name="role[]" value="2001" id="plugin2001">
                        <span>General Ledger</span>
                      </label>
                      <label for="plugin2002">
                        <input type="checkbox" name="role[]" value="2002" id="plugin2002">
                        <span>Income Statement (Profit/Loss)</span>
                      </label>
                      <label for="plugin2003">
                        <input type="checkbox" name="role[]" value="2003" id="plugin2003">
                        <span>Edit Income Tax</span>
                      </label>
                      <label for="plugin2004">
                        <input type="checkbox" name="role[]" value="2004" id="plugin2004">
                        <span>Balance Sheet</span>
                      </label>
                      <label for="plugin2005">
                        <input type="checkbox" name="role[]" value="2005" id="plugin2005">
                        <span>VAT Tax. Report</span>
                      </label>
                      <label for="plugin2006">
                        <input type="checkbox" name="role[]" value="2006" id="plugin2006">
                        <span>Add Tax Payment</span>
                      </label>
                      <label for="plugin2007">
                        <input type="checkbox" name="role[]" value="2007" id="plugin2007">
                        <span>Withholding Tax. Report</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin3000">
                        <input type="checkbox" name="role[]" value="3000" id="plugin3000">
                        <span>Cash / Bank</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin3001">
                        <input type="checkbox" name="role[]" value="3001" id="plugin3001">
                        <span>Treasury Cash</span>
                      </label>
                      <label for="plugin3002">
                        <input type="checkbox" name="role[]" value="3002" id="plugin3002">
                        <span>Bank Accounts List</span>
                      </label>
                      <label for="plugin3003">
                        <input type="checkbox" name="role[]" value="3003" id="plugin3003">
                        <span>View Bank Account</span>
                      </label>
                      <label for="plugin3004">
                        <input type="checkbox" name="role[]" value="3004" id="plugin3004">
                        <span>Add Bank Account</span>
                      </label>
                      <label for="plugin3005">
                        <input type="checkbox" name="role[]" value="3005" id="plugin3005">
                        <span>Transfer Money</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin4000">
                        <input type="checkbox" name="role[]" value="4000" id="plugin4000">
                        <span>Share Capital</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin4001">
                        <input type="checkbox" name="role[]" value="4001" id="plugin4001">
                        <span>Share Capital Account</span>
                      </label>
                      <label for="plugin4002">
                        <input type="checkbox" name="role[]" value="4002" id="plugin4002">
                        <span>Add Account</span>
                      </label>
                      <label for="plugin4003">
                        <input type="checkbox" name="role[]" value="4003" id="plugin4003">
                        <span>Show Account</span>
                      </label>
                      <label for="plugin4004">
                        <input type="checkbox" name="role[]" value="4004" id="plugin4004">
                        <span>Add Transaction</span>
                      </label>
                      <label for="plugin4005">
                        <input type="checkbox" name="role[]" value="4005" id="plugin4005">
                        <span>Remove Transaction</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin5000">
                        <input type="checkbox" name="role[]" value="5000" id="plugin5000">
                        <span>Exchange Difference</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin5001">
                        <input type="checkbox" name="role[]" value="5001" id="plugin5001">
                        <span>Exchange Difference List</span>
                      </label>
                      <label for="plugin5002">
                        <input type="checkbox" name="role[]" value="5002" id="plugin5002">
                        <span>Add Exchange Difference</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin6000">
                        <input type="checkbox" name="role[]" value="6000" id="plugin6000">
                        <span>Loans</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin6001">
                        <input type="checkbox" name="role[]" value="6001" id="plugin6001">
                        <span>Loans List</span>
                      </label>
                      <label for="plugin6002">
                        <input type="checkbox" name="role[]" value="6002" id="plugin6002">
                        <span>Add New Loan</span>
                      </label>
                      <label for="plugin6003">
                        <input type="checkbox" name="role[]" value="6003" id="plugin6003">
                        <span>Show Loan Account</span>
                      </label>
                      <label for="plugin6004">
                        <input type="checkbox" name="role[]" value="6004" id="plugin6004">
                        <span>Add Loan Transaction</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin7000">
                        <input type="checkbox" name="role[]" value="7000" id="plugin7000">
                        <span>Oher Balances</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin7001">
                        <input type="checkbox" name="role[]" value="7001" id="plugin7001">
                        <span>Credit/Debit Balances List</span>
                      </label>
                      <label for="plugin7002">
                        <input type="checkbox" name="role[]" value="7002" id="plugin7002">
                        <span>Add Balance</span>
                      </label>
                      <label for="plugin7003">
                        <input type="checkbox" name="role[]" value="7003" id="plugin7003">
                        <span>Show Balance</span>
                      </label>
                      <label for="plugin7004">
                        <input type="checkbox" name="role[]" value="7004" id="plugin7004">
                        <span>Remove Balance</span>
                      </label>
                      <label for="plugin7005">
                        <input type="checkbox" name="role[]" value="7005" id="plugin7005">
                        <span>Add Balance Transaction</span>
                      </label>
                      <label for="plugin7006">
                        <input type="checkbox" name="role[]" value="7006" id="plugin7006">
                        <span>Remove Transaction</span>
                      </label>
                    </div>
                  </div>
                  <div class="not_section">
                    <div class="head">
                      <label for="plugin8000">
                        <input type="checkbox" name="role[]" value="8000" id="plugin8000">
                        <span>Oher Revenues</span>
                      </label>
                    </div>
                    <div class="sec_body">
                      <label for="plugin7001">
                        <input type="checkbox" name="role[]" value="8001" id="plugin8001">
                        <span>Revenues List</span>
                      </label>
                      <label for="plugin7002">
                        <input type="checkbox" name="role[]" value="8002" id="plugin8002">
                        <span>Add Revenue</span>
                      </label>
                      <label for="plugin7003">
                        <input type="checkbox" name="role[]" value="8003" id="plugin8003">
                        <span>Remove Revenue</span>
                      </label>
                    </div>
                  </div>
                </div>
                <input type="submit" name="add" value="Add">
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
    header("location:" . $path . "/../login.php");
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