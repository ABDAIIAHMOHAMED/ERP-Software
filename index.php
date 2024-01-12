<?php
$pg_name = "Wonder Softwares";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  $user_info = login_info();
  header("location:contacts/");
  exit();
?>
  <div class="container">
    <div class="softwares">
      <a href="<?= $path . "operations/" ?>" class="software-bx not_active">
        <div class="software-icon" style="background:#904b88;">
          <img src="images/operations.png" alt="">
        </div>
        <div class="software-name">Operations</div>
      </a>
      <a href="<?= $path . "inventory/" ?>" class="software-bx">
        <div class="software-icon" style="background:#4b9089;">
          <img src="images/inventory.png" alt="">
        </div>
        <div class="software-name">Inventory</div>
      </a>
      <a href="<?= $path . "accounting/" ?>" class="software-bx">
        <div class="software-icon" style="background: #904b4b;">
          <img src="images/accounting.png" alt="">
        </div>
        <div class="software-name">Accounting</div>
      </a>
      <a href="<?= $path . "contacts/" ?>" class="software-bx">
        <div class="software-icon" style="background:#4b6090;">
          <img src="images/contacts.png" alt="">
        </div>
        <div class="software-name">Contacts</div>
      </a>
      <!-- <a href="<?= $path . "/" ?>" class="software-bx not_active">
        <div class="software-icon" style="background:#126db4;">
          <img src="images/intergrations.png" alt="">
        </div>
        <div class="software-name">Integrations</div>
      </a> -->
      <a href="<?= $path . "settings/" ?>" class="software-bx">
        <div class="software-icon" style="background:#7d7d7d;">
          <img src="images/settings.png" alt="">
        </div>
        <div class="software-name">Settings</div>
      </a>
    </div>
  </div>

<?php
} else {
  header("location:login.php");
  exit();
}
include "includes/footer.inc";
?>