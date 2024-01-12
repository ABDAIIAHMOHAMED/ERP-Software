<?php
$pg_name = "Wonder - Employees";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {
  if (check_id('users')) {
    $user_info = login_info();
    $info = info('users');
    if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(403) == 1 || $user_info['id'] == $info['id']) {
?>


      <div class="att-part">
        <div class="title-head">
          <div class="headso">
            <h3>Employee Profile</h3>
            <hr class="head-line">
            <p class="navigator"><a href="<?= $path ?>">Dashboard</a> / <a href="<?= $path . "employees.php" ?>">Employees</a>
              / Employee Profile</p>
          </div>
        </div>
        <div class="main-prof">

          <div class="l-main-prof">
            <div class="l-main-prof-img">
              <img src="../images/ur-img/<?= $info['picture'] ?>" alt="">
            </div>
            <div class="l-main-prof-info">
              <h2><?= ucfirst($info['name']) ?><span>( <?= ucfirst($info['type']) ?> )</span></h2>
              <span>#<?= ucfirst($info['id']) ?></span>
            </div>
          </div>

          <div class="r-main-prof">
            <div class="r-main-prof-part">
              <div class="r-main-prof-icon"><i class="fa-solid fa-phone"></i></div>
              <div class="r-main-prof-value">+20 <?= ucfirst($info['mobile']) ?></div>
            </div>
            <div class="r-main-prof-part">
              <div class="r-main-prof-icon"><i class="fa-solid fa-envelope"></i></div>
              <div class="r-main-prof-value"><?= ucfirst($info['personal_email']) ?></div>
            </div>
            <?php
            if ($user_info['id'] !== $info['id'] && $info['type'] == 'user' && $info['status'] == '1') {
              if (check_user_role(1) == 1) {
                log_as();
            ?>
                <div class="r-main-prof-part">

                  <form action="" method="POST"><input type="submit" name="log-as" value="Login"></form>
                  <div class="r-main-prof-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
                  <div class="r-main-prof-value">Login as <?= ucfirst($info['name']) ?></div>

                </div>
            <?php
              }
            }
            ?>
          </div>

        </div>

        <div class="prof-tools">

          <?php if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(404) == 1) { ?>

            <button class="edit_emp_btn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>

            <?php
            if ($user_info['id'] !== $info['id']) {

            ?>
              <?php
              if ($info['status'] == '1') {
              ?>
                <a href="?dis=1&uid=<?= $info['id'] ?>"><i class="fa-solid fa-circle-xmark"></i>Disbale</a>
              <?php
              } else {
              ?>
                <a href="?act=1&uid=<?= $info['id'] ?>"><i class="fa-solid fa-check"></i>Activate</a>
              <?php
              }
              ?>
            <?php
            }
            ?>
          <?php } ?>
          <?php
          if ($user_info['id'] == $info['id']) {
          ?>
            <a href="change-password.php?uid=<?= ucfirst($info['id']) ?>"><i class="fa-solid fa-lock"></i>Change Password</a>
          <?php
          }
          ?>
          <?php
          if ($user_info['id'] !== $info['id']) {
            if (check_user_role(1) == 1 || check_user_role(400) == 1 || check_user_role(404) == 1) {
          ?>
              <a href="?uid=<?= $info['id'] ?>&del=1" class="del-warn"><i class="fa-solid fa-trash"></i>Delete</a>
          <?php
            }
          }
          ?>

          <?php
          dis_employee();
          act_employee();
          del_employee();
          ?>
        </div>

        <div class="prof-details-box">
          <h6>
            <a href="" class="active">Details</a>
            <!-- <a href="#">Contract</a> -->
            <!-- <a href="#">Logs</a> -->
          </h6>

          <div class="prof-details-section">
            <div class="prof-details-title">Employee Information</div>
            <div class="prof-infos">


              <div class="prof-r-info">
                <div class="prof-ex">
                  <h5>Phone Number:</h5>
                  <span>+20 <?= ucfirst($info['mobile']) ?></span>
                </div>
                <div class="prof-ex">
                  <h5>Current Address:</h5>
                  <span><?= ucfirst($info['street']) ?></span>
                  <span><?= ucfirst($info['city']) ?></span>
                  <span><?= ucfirst($info['postal']) ?> <?= ucfirst($info['state']) ?> , <?= ucfirst($info['country']) ?></span>
                  <span></span>
                </div>

              </div>

              <div class="prof-l-info">
                <div class="prof-ex">
                  <h5>Personal Email:</h5>
                  <span><?= $info['personal_email'] ?></span>
                </div>
                <div class="prof-ex">
                  <h5>Gender:</h5>
                  <span><?= ucfirst($info['gender']) ?></span>
                </div>

              </div>


            </div>
            <div class="prof-details-title">Account Information</div>

            <div class="prof-infos">


              <div class="prof-r-info">

                <div class="prof-ex">
                  <h5>Email:</h5>
                  <span><?= $info['email'] ?></span>
                </div>

                <div class="prof-ex">
                  <h5>Job Title:</h5>
                  <span><a href="job_title.php?uid=<?= $info['job_title'] ?>" target="_blank"><?= get_type_name('job_titles', $info['job_title']) ?></a></span>
                </div>
                <div class="prof-ex">
                  <h5>Department:</h5>
                  <span><a href="category.php?uid=<?= $info['category'] ?>" target="_blank"><?= get_type_name('categories', $info['category']) ?></a></span>
                </div>
                <div class="prof-ex">
                  <h5>Career Level:</h5>
                  <span><a href="career_level.php?uid=<?= $info['career_level'] ?>" target="_blank"><?= get_type_name('career_levels', $info['career_level']) ?></a></span>
                </div>

                <div class="prof-ex">
                  <h5>Joining Date:</h5>
                  <span><?php $timestamp = strtotime($info['created_time']);
                        $formattedDate = date("M d, Y", $timestamp);
                        echo $formattedDate; ?></span>
                </div>
              </div>

              <div class="prof-l-info">
                <div class="prof-ex">
                  <h5>Job Role:</h5>
                  <span><a href="role.php?uid=<?= $info['role'] ?>" target="_blank"><?= get_type_name('user_roles', $info['role']) ?></a></span>
                </div>
                <div class="prof-ex">
                  <h5>Type of Job:</h5>
                  <span><a href="job_type.php?uid=<?= $info['job_type'] ?>" target="_blank"><?= get_type_name('job_types', $info['job_type']) ?></a></span>
                </div>
                <div class="prof-ex">
                  <h5>Status:</h5>
                  <span><span class="<?php if ($info['status'] == '1') {
                                        echo "gn";
                                      } else {
                                        echo "rd";
                                      } ?>"><?php if ($info['status'] == '1') {
                                              echo "Active";
                                            } else {
                                              echo "Inactive";
                                            } ?></span></span>
                </div>
                <div class="prof-ex">
                  <h5>Notes:</h5>
                  <span><?= $info['notes'] ?></span>
                </div>
                <?php if (check_user_role(1) == 1 || check_user_role(405) == 1 || $user_info['id'] == $info['id']) { ?>
                  <div class="prof-ex">
                    <h5>Net Salary:</h5>
                    <span><?= number_format($info['net_salary'], 2, '.', ',') ?> E£</span>
                  </div>
                <?php } ?>
              </div>


            </div>
          </div>

        </div>

      </div>
      <div class="add_new edit_supplo">
        <div class="custome-head">
          <h3 style='margin:0;'>Edit Employee</h3>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form class="" id="edit_supplier" action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $info['id'] ?>">
          <div class="custom-form">
            <div class="sectra">
              <span class="sm-head">General info</span>
              <div class="form-section">
                <div class="inputs gd2">
                  <label for="fname">First Name</label>
                  <input type="text" value="<?= $info['fname'] ?>" class="" name="fname" id="fname" required>

                </div>
                <div class="inputs gd2">
                  <label for="mname">Middle Name</label>
                  <input type="text" value="<?= $info['mname'] ?>" class="" name="mname" id="mname">

                </div>
                <div class="inputs gd2">
                  <label for="lname">Last Name</label>
                  <input type="text" value="<?= $info['lname'] ?>" class="" name="lname" id="lname">

                </div>
                <div class="inputs gd6">
                  <label for="profile-pic">Profile Picture</label>
                  <input type="file" name="profile-pic" id="profile-pic" accept="image/png,image/jpeg,image/jpg" onchange="previewFile(this);" value="<?php if ($info['picture'] == "profile3.png") {
                                                                                                                                                      } else {
                                                                                                                                                        echo  $info['picture'];
                                                                                                                                                      } ?>">
                  <div class="drag-file ">
                    <div class="none-file" style="<?php if ($info['picture'] == "profile3.png") {
                                                  } else {
                                                    echo "display:none;";
                                                  } ?>">
                      <img src="../images/upload.png ?>" alt=""> Drag picture here or <span>&nbsp;choose from your device</span>
                    </div>
                    <div class="exist-file" style="<?php if ($info['picture'] == "profile3.png") {
                                                    } else {
                                                      echo "display:flex;";
                                                    } ?>">
                      <div class="pic-frame">
                        <img class="preview-avatar" src="<?php if ($info['picture'] == "profile3.png") {
                                                          } else {
                                                            echo  "../images/ur-img/" . $info['picture'];
                                                          } ?>" alt="">
                      </div>
                      <div class="remove-pic">X</div>
                    </div>
                  </div>

                </div>
                <div class="inputs gd3">
                  <label for="mobile">Mobile</label>
                  <input type="number" value="<?= $info['mobile'] ?>" class="" name="mobile" id="mobile" min="0" max="1999999999">

                </div>
                <div class="inputs gd3">
                  <label for="personal_email">Personal Email</label>
                  <input type="text" value="<?= $info['personal_email'] ?>" class="" name="personal_email" id="personal_email">

                </div>
                <div class="inputs gd2">
                  <label for="job_title">Job Title</label>
                  <select name="job_title" id="job_title" class="">
                    <?= get_org_option('job_titles', $info['job_title']) ?>
                  </select>

                </div>
                <div class="inputs gd2">
                  <label for="category">Department</label>
                  <select name="category" id="category" class="">
                    <?= get_org_option('categories', $info['category']) ?>
                  </select>

                </div>
                <div class="inputs gd2">
                  <label for="jobtype">Type of Job</label>
                  <select name="jobtype" id="jobtype" class="">
                    <?= get_org_option('job_types', $info['job_type']) ?>
                  </select>

                </div>
                <div class="inputs gd2">
                  <label for="careerlevel">Career Level</label>
                  <select name="careerlevel" id="careerlevel" class="">
                    <?= get_org_option('career_levels', $info['career_level']) ?>
                  </select>

                </div>
                <div class="inputs gd4">
                  <label for="salary">Net Salary</label>
                  <input type="number" value="<?= $info['net_salary'] ?>" class="" name="salary" id="salary" min="0" placeholder="0">

                </div>
                <?php if ($info['type'] == 'user') { ?>
                  <div class="inputs gd4 ">
                    <label for="email">Email</label>
                    <input type="text" value="<?= $info['email'] ?>" class="" name="email" id="email">
                  </div>
                  <div class="inputs gd2">
                    <label for="role">Role</label>
                    <select name="role" id="role">
                      <?php if (check_user_role(1) == 1) {
                        echo '<option value="1">Admin</option>';
                      }
                      ?>
                      <?= get_org_option('user_roles', $info['role']) ?>
                    </select>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="sectra">
              <span class="sm-head">Personal Info</span>
              <div class="form-section">
                <div class="inputs gd6">
                  <label for="gender">Gender</label>
                  <select name="gender" id="gender">
                    <option value="male" <?php if ($info['gender'] == "male") {
                                            echo "selected";
                                          } ?>>Male</option>
                    <option value="female" <?php if ($info['gender'] == "female") {
                                              echo "selected";
                                            } ?>>Female</option>
                  </select>

                </div>
                <div class="inputs gd6">
                  <label for="note">Notes</label>
                  <textarea name="notes" id="note" cols="30" rows="10"><?= $info['notes'] ?></textarea>

                </div>
              </div>
              <span class="sm-head">Address</span>
              <div class="form-section">
                <div class="inputs gd6">
                  <label for="street">Street</label>
                  <textarea name="street" id="street" cols="30" rows="10"><?= $info['street'] ?></textarea>

                </div>
                <div class="inputs gd3">
                  <label for="city">City/Town</label>
                  <input type="text" id="city" value="<?= $info['city'] ?>" class="" name="city">

                </div>
                <div class="inputs gd3">
                  <label for="state">State</label>
                  <input type="text" id="state" value="<?= $info['state'] ?>" class="" name="state">

                </div>
                <div class="inputs gd3">
                  <label for="postal">Postal Code</label>
                  <input type="number" value="<?= $info['postal'] ?>" class="" name="postal" id="postal" min="0">
                  <span class=" error-field"></span>
                </div>
                <div class="inputs gd3">
                  <label for="country">Country</label>
                  <?php $mycountry = ip_info($_SERVER['REMOTE_ADDR'], "Country"); ?>
                  <select name="country" id="country" class='' required>
                    <?php
                    $countries = countries();
                    foreach ($countries as $key => $country) {
                      echo "<option value='$country'";
                      if (isset($_POST['country']) && $_POST['country'] == $country) {
                        echo "selected";
                      } elseif ($country == $info['country']) {
                        echo "selected";
                      }
                      echo ">$country</option>";
                    }
                    ?>
                  </select>

                </div>
              </div>
            </div>
          </div>
          <hr class="hr_form">
          <div class="loadings"><i class=""></i></div>
          <input type="hidden" name="id" value="<?= $info['id'] ?>">
          <input type="hidden" name="edit" value="Save">
          <input type="submit" class="add" value="Save" style='border:none;cursor:pointer;'>
        </form>
      </div>
      <div class="black_screen"></div>
      <div class="mga"></div>
      <script>
        $(document).ready(function() {

          $("button.edit_emp_btn").click(function() {
            var exportHeight = $(".edit_supplo").prop("scrollHeight") + 70;
            $(".edit_supplo").css({
              height: exportHeight + "px",
              padding: "20px 25px",
              border: "1px solid #cfcfcf",
            });
            $(".black_screen").fadeIn(200);
          });

          $('#edit_supplier').submit(function(event) {
            event.preventDefault(); // prevent default form submission
            var formData = new FormData(this);
            $.ajax({
              type: 'POST',
              url: 'functions/core/edit-employee.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function(data) {
                $(".black_screen").fadeOut(200);
                $(".add_new").css({
                  "height": '0px',
                  "padding": "0px",
                  "border": "0px solid #cfcfcf"
                });
                $(".mga").html(data);
                setTimeout(function() {
                  location.reload();
                }, 1000);
              },
            });
          });
        });
      </script>

<?php
    } else {
      $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
      header("location:" . $path . "/employees.php");
      exit();
    }
  } else {
    $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
    header("location:" . $path . "/employees.php");
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