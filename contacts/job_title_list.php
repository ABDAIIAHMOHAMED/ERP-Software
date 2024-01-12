<?php
$pg_name = "Wonder - Job Titles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('job_titles')) {
    $user_info = login_info();
    $info = info('job_titles');
    if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(505) == 1) {
      delete_org("job_titles", "job_title");
?>

      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Job Title: <?= $info['name'] ?></h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a>/ <a href="<?= $path . "job_titles.php" ?>">Job Titles</a> / Job Title: <?= $info['name'] ?></p>
          </div>

          <div class="btns">

          </div>

        </div>

        <div class="org-part">
          <h1>
            <?= $info['name'] ?>
          </h1>
          <h6><a href="job_titles.php">Job Titles</a></h6>
          <div class="org-section">
            <ul class="alinks">
              <li><a href="job_title.php?uid=<?= $info['id'] ?>">Info</a></li>
              <?php
              if (check_user_role(1) == 1 ||  check_user_role(504) == 1) {  ?>
                <li><a href="job_title_edit.php?uid=<?= $info['id'] ?>">Edit</a></li>
              <?php
              }
              ?>
              <?php if (check_user_role(1) == 1 ||  check_user_role(505) == 1) { ?>
                <li class="active"><a href="job_title_list.php?uid=<?= $info['id'] ?>">Employees
                    (
                    <?= get_num_org("job_title") ?>
                    )
                  </a></li>
              <?php } ?>
            </ul>
            <div class="org-contain">
              <div class="heads">
                <h5>Employees list</h5>
                <input type="text" name="search_name" id="search_name" placeholder="Search by name">
                <input type="hidden" name="cid" id="cid" value="<?= $info['id'] ?>">
                <input type="hidden" name="type" id="type" value="job_title">
              </div>
              <div class="profile-cards">



                <?php
                get_org_list("job_title");
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
      header("location:" . $path . "/job_title.php?uid=" . $info['id']);
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/job_titles.php");
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