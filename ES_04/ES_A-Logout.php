<?php
session_start();
session_destroy();
header("Location: ES_A-Welcome.php");
exit;
?>