<?php
$pg_name = "Wonder - Job Titles";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('job_titles')) {
    $user_info = login_info();
    $info = info('job_titles');
    if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(504) == 1) {
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
          <form action="" method="POST">
            <h1>
              <?= $info['name'] ?>
            </h1>
            <h6><a href="<?= $path . "job_titles.php" ?>">Job Titles</a></h6>

            <div class="org-section">
              <ul class="alinks">
                <li><a href="job_title.php?uid=<?= $info['id'] ?>">Info</a></li>
                <?php
                if (check_user_role(1) == 1 ||  check_user_role(504) == 1) {  ?>
                  <li class="active"><a href="job_title_edit.php?uid=<?= $info['id'] ?>">Edit</a></li>
                <?php
                }
                ?>
                <?php if (check_user_role(1) == 1 ||  check_user_role(505) == 1) { ?>
                  <li><a href="job_title_list.php?uid=<?= $info['id'] ?>">Employees
                      (
                      <?= get_num_org("job_title") ?>
                      )
                    </a></li>
                <?php } ?>
              </ul>
              <div class="org-contain">
                <h5>Edit Details</h5>
                <?php update_org("job_titles", "job_title"); ?>
                <div class="line-info">
                  <div class="l-info">Name<span> *</span>:</div>
                  <div class="r-info">
                    <input type="text" name="name" value="<?= $info['name'] ?>">
                  </div>
                </div>
                <div class="line-info">
                  <div class="l-info">Description :</div>
                  <div class="r-info">
                    <textarea name="des" cols="30" rows="10"><?= $info['description'] ?></textarea>
                    <span><span class="n-char">200</span> Characters left</span>
                  </div>
                </div>
                <div class="line-info">
                  <div class="l-info">Status<span> *</span>:</div>
                  <div class="r-info">
                    <select name="status" id="">
                      <option value="1" <?php if ($info['status'] == "1") {
                                          echo "selected";
                                        } ?>>Active</option>
                      <option value="0" <?php if ($info['status'] == "0") {
                                          echo "selected";
                                        } ?>>Deactive</option>
                    </select>
                  </div>
                </div>
                <div class="line-info">
                  <div class="l-info">Make Default :</div>
                  <div class="r-info">
                    <input type="checkbox" id="default" name="default" value="mk_default" <?php if (
                                                                                            $info['def'] == "1"
                                                                                          ) {
                                                                                            echo "checked";
                                                                                          } ?>>
                  </div>
                </div>
                <input type="submit" name="update" value="Save">
                <?php
                if ($info['def'] == "0") {
                ?>
                  <a href="job_title_edit.php?uid=<?= $info['id'] . '&del=1' ?>">Delete</a>
                <?php
                }
                ?>


              </div>
            </div>
          </form>
        </div>


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