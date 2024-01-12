<?php
$pg_name = "Wonder - Job Types";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('job_types')) {
    if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(503) == 1) {
      $user_info = login_info();
      $info = info('job_types');
      delete_org("job_types", "job_type");
?>

      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Job Type: <?= $info['name'] ?></h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a>/ <a href="<?= $path . "job_types.php" ?>">Job Types</a> / Job Type: <?= $info['name'] ?></p>
          </div>

          <div class="btns">

          </div>

        </div>

        <div class="org-part">
          <h1>
            <?= $info['name'] ?>
          </h1>
          <h6><a href="<?= $path . "job_types.php" ?>">Job Types</a></h6>

          <div class="org-section">
            <ul class="alinks">
              <li class="active"><a href="job_type.php?uid=<?= $info['id'] ?>">Info</a></li>
              <?php
              if (check_user_role(1) == 1 ||  check_user_role(504) == 1) { ?>
                <li><a href="job_type_edit.php?uid=<?= $info['id'] ?>">Edit</a></li>
              <?php
              }
              ?>
              <?php if (check_user_role(1) == 1 ||  check_user_role(505) == 1) { ?>
                <li><a href="job_type_list.php?uid=<?= $info['id'] ?>">Employees
                    (
                    <?= get_num_org("job_type") ?>
                    )
                  </a></li>
              <?php } ?>
            </ul>
            <div class="org-contain">
              <h5>Details</h5>
              <div class="line-info">
                <div class="l-info">Name:</div>
                <div class="r-info">
                  <?= $info['name'] ?>
                </div>
              </div>
              <div class="line-info">
                <div class="l-info">Description:</div>
                <div class="r-info">
                  <?= $info['description'] ?>
                </div>
              </div>
              <div class="line-info">
                <div class="l-info">Status:</div>
                <div class="r-info">
                  <?php
                  if ($info['status'] == "1") {
                    echo "<span class='gn'>Active</span>";
                  } else {
                    echo "<span class='rd'>Inactive</span>";
                  }
                  ?>
                </div>
              </div>
              <div class="line-info">
                <div class="l-info">Number of Employees:</div>
                <div class="r-info">
                  <?= get_num_org("job_type") ?>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>


<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/job_types.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/job_types.php");
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