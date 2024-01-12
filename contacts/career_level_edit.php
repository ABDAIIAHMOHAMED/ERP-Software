<?php
$pg_name = "Wonder - Career Levels";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('career_levels')) {
    $user_info = login_info();
    $info = info('career_levels');
    if (check_user_role(1) == 1 || check_user_role(500) == 1 || check_user_role(504) == 1) {
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
          <form action="" method="POST">
            <h1>
              <?= $info['name'] ?>
            </h1>
            <h6><a href="<?= $path . "career_levels.php" ?>">Career Levels</a></h6>

            <div class="org-section">
              <ul class="alinks">
                <li><a href="career_level.php?uid=<?= $info['id'] ?>">Info</a></li>
                <?php
                if (check_user_role(1) == 1 ||  check_user_role(504) == 1) { ?>
                  <li class="active"><a href="career_level_edit.php?uid=<?= $info['id'] ?>">Edit</a></li>
                <?php
                }
                ?>
                <?php if (check_user_role(1) == 1 ||  check_user_role(505) == 1) { ?>
                  <li><a href="career_level_list.php?uid=<?= $info['id'] ?>">Employees
                      (
                      <?= get_num_org("career_level") ?>
                      )
                    </a></li>
                <?php } ?>
              </ul>
              <div class="org-contain">
                <h5>Edit Details</h5>
                <?php update_org("career_levels", "career_level"); ?>
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
                  <a href="career_level_edit.php?uid=<?= $info['id'] . '&del=1' ?>">Delete</a>
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