</div>
</div>
<div class="copyright-section">&copy;
  <?= date("Y") ?> All rights reserved. Powered by <img src="<?= $image_route ?>images/icon.png" alt="">onder
</div>
</div>
<script>
  function sendData() {
    $.ajax({
      url: "json/update_active_user.php",
      method: "POST",
      data: {
        user_id: '<?= $user_info['id'] ?>',
      },
    });
  }
  sendData();
  setInterval(sendData, 20000);
</script>
</body>

</html>
<?php ob_end_flush(); ?>