<?php
$pg_name = "Wonder - General Settings";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  header("location:" . $path . "/../contacts/index.php");
  exit();
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
          <label for="whours">Working Hours <span>(hrs/day)</span></label>
          <input id="whours" type="number" name="working_hours" value="8" min="1" max="12">
        </div>
        <div class="org">
          <label for="whours">Weekly Holidays</label>
          <ul>
            <li>
              <label for="saturday">Saturday
                <input type="checkbox" name="holiday[]" id="saturday" value="Saturday" checked="">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="friday">Friday
                <input type="checkbox" name="holiday[]" id="friday" value="Friday" checked="">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="sunday">Sunday
                <input type="checkbox" name="holiday[]" id="sunday" value="Sunday">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="monday">Monday
                <input type="checkbox" name="holiday[]" id="monday" value="Monday">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="tuesday">Tuesday
                <input type="checkbox" name="holiday[]" id="tuesday" value="Tuesday">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="wednesday">Wednesday
                <input type="checkbox" name="holiday[]" id="wednesday" value="Wednesday">
                <span class="check"></span>
              </label>
            </li>
            <li>
              <label for="thursday">Thursday
                <input type="checkbox" name="holiday[]" id="thursday" value="Thursday">
                <span class="check"></span>
              </label>
            </li>
          </ul>
        </div>
        <input type="submit" class="change-general-s" name="change-general-s" value="Apply">
      </form>
    </div>



    <div class="setting-section">
      <form action="" method="POST">
        <h5>Privacy Settings</h5>
        <input type="submit" name="change-privacy-s" value="Apply">
        <div class="org">
          <label for="whours">Clear Logs</label>
          <input id="c_log" type="submit" name="clear_logs" value="Clear Logs">
        </div>
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