<?php
session_start();
session_destroy();
header("Location: ES_C-Welcome.php");
exit;
?>
