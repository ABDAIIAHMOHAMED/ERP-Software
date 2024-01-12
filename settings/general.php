<?php
$pg_name = "Wonder - General Settings";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
?>

  <div class="att-part">
    <div class="title-head">
      <div class="headso">
        <h3>General Settings</h3>
        <hr class="head-line">
      </div>
    </div>
    <div class="setting-section">

      <h5>Company Settings</h5>

      <form action="" method="POST">
        <div class="org">
          <label for="cname">Company Name</label>
          <input id="cname" type="text" name="cname" value="Orgasafe">
        </div>
        <div class="org logo-div">
          <label for="clogo">Company Logo<img src="../images/logo.png" alt=""></label>
          <input id="clogo" type="file" name="clogo">
        </div>
        <div class="org">
          <label for="address">Address</label>
          <textarea name="address" id="address" cols="30" rows="10" placeholder="Ex. 123 Street 1 , Second District , Cairo , Egypt"></textarea>
        </div>
        <div class="org">
          <label for="phone">Phone Number</label>
          <input id="phone" type="number" name="phone" value="" min="0" placeholder="Ex. 01094432940">
        </div>
        <div class="org">
          <label for="reg_num">Registration Number</label>
          <input id="reg_num" type="number" name="reg_num" value="" placeholder="Ex. 68293849320">
        </div>
        <input type="submit" class="change-general-s" name="change-general-s" value="Apply">
      </form>
    </div>




  </div>

  <script>
    $(document).ready(function() {


    });
  </script>

<?php
} else {
  $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
  header("location:" . $path . "/../login.php");
  exit();
}
include "includes/footer.inc";
?>