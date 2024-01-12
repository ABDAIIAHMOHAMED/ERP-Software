<?php
require "../../functions/connect.php"; // Connect to database file
if (isset($_POST['search_name'])) {
  if (isset($_POST['uid'])) {
    if (!empty($_POST['uid'])) {
      $r = $_POST['type'];
      $cid = filter_var($_POST['uid'], FILTER_SANITIZE_STRING);
      $stmt = $con->prepare("SELECT * FROM `users` WHERE `$r` = '$cid' AND `name` LIKE '" . $_POST['search_name'] . "%'");
      $stmt->execute();
      $count = $stmt->rowCount(); // Check if the id from GET exist in database
      if ($count > 0) { // If GET is exist 
        while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) { // Loop for queries
          foreach ($row as $employe) {

            $stmt54 = $con->prepare("SELECT * FROM `categories` WHERE id = '" . $employe['category'] . "'");
            $stmt54->execute();
            $count54 = $stmt54->rowCount();
            $row54 = $stmt54->fetch(PDO::FETCH_ASSOC);


            $stmt55 = $con->prepare("SELECT * FROM `job_titles` WHERE id = '" . $employe['job_title'] . "'");
            $stmt55->execute();
            $count55 = $stmt55->rowCount();
            $row55 = $stmt55->fetch(PDO::FETCH_ASSOC);

            $stmt56 = $con->prepare("SELECT * FROM `career_levels` WHERE id = '" . $employe['career_level'] . "'");
            $stmt56->execute();
            $count56 = $stmt56->rowCount();
            $row56 = $stmt56->fetch(PDO::FETCH_ASSOC);


            echo '<div class="card-contain">
            <div class="card">
              <div class="imgBx">
                <img src="../images/ur-img/' . $employe['picture'] . '" alt="">
              </div>
              <div class="content">
                <div class="details">
                  <h2>' . ucfirst($employe['fname']) . ' ' . ucfirst($employe['mname']) . '<span>#1</span></h2>
                  <div class="card-info">
                    <div class="l-info">Phone Number:</div>
                    <div class="r-info">+2 ' . $employe['mobile'] . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Department:</div>
                    <div class="r-info">' . ucfirst($row54['name']) . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Job Title:</div>
                    <div class="r-info">' . ucfirst($row55['name']) . '</div>
                  </div>
                  <div class="card-info">
                    <div class="l-info">Career Level:</div>
                    <div class="r-info">' . ucfirst($row56['name']) . '</div>
                  </div>
                  <div class="actionBtn">
                  <a href="employeedetails.php?uid=' . $employe['id'] . '" target="_blank"><i class="fa-solid fa-eye"></i> View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>';
          }
        }
      } else {
        echo "<div class='no-res'>No Results</div>";
      }
    }
  }
}
