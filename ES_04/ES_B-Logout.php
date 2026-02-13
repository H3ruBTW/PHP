<?php
session_start();
session_destroy();
header("Location: ES_B-Welcome.php");
exit;
?>