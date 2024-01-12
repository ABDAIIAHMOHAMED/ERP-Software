<?php
// session_start();
// session_unset();
// session_destroy();
setcookie("urid", "" , time() + (-360400 * 30), "/");
header("location:index.php");
exit();

?>