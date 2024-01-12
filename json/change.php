<?php
if (isset($_POST['lang']) && !empty($_POST['lang'])) {
  if ($_POST['lang'] == $_COOKIE['wonder_language']) {
    echo "same";
  } else {
    $selectedLanguage = $_POST['lang'];
    setcookie('wonder_language', $selectedLanguage, time() + (360400 * 30), "/");
    echo "change";
  }
}
