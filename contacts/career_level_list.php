<?php
$pg_name = "Wonder - Career Levels";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('career_levels')) {
    $user_info = login_info();
    $info = info('career_levels');
    if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(505) == 1) {
      delete_org("career_levels", "career_level");
?>

      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Career Level: <?= $info['name'] ?></h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a>/ <a href="<?= $path . "career_levels.php" ?>">Career Levels</a> / Career Level: <?= $info['name'] ?></p>
          </div>

          <div class="btns">

          </div>

        </div>

        <div class="org-part">
          <h1>
            <?= $info['name'] ?>
          </h1>
          <h6><a href="career_levels.php">Career Levels</a></h6>
          <div class="org-section">
            <ul class="alinks">
              <li><a href="career_level.php?uid=<?= $info['id'] ?>">Info</a></li>
              <?php
              if (check_user_role(1) == 1 ||  check_user_role(504) == 1) { ?>
                <li><a href="career_level_edit.php?uid=<?= $info['id'] ?>">Edit</a></li>
              <?php
              }
              ?>
              <?php if (check_user_role(1) == 1 ||  check_user_role(505) == 1) { ?>
                <li class="active"><a href="career_level_list.php?uid=<?= $info['id'] ?>">Employees
                    (
                    <?= get_num_org("career_level") ?>
                    )
                  </a></li>
              <?php } ?>
            </ul>
            <div class="org-contain">
              <div class="heads">
                <h5>Employees list</h5>
                <input type="text" name="search_name" id="search_name" placeholder="Search by name">
                <input type="hidden" name="cid" id="cid" value="<?= $info['id'] ?>">
                <input type="hidden" name="type" id="type" value="career_level">
              </div>
              <div class="profile-cards">



                <?php
                get_org_list("career_level");
                ?>

              </div>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            $("#search_name").keyup(function() {
              $.ajax({
                type: 'POST',
                url: 'json/listsearch.php',
                data: {
                  search_name: $("#search_name").val(),
                  uid: $("#cid").val(),
                  type: $("#type").val(),
                },
                success: function(data) {
                  $(".profile-cards").html(data);
                }
              });
            });
          });
        </script>


      </div>


<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/career_level.php?uid=" . $info['id']);
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/career_levels.php");
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