<?php
include $_SERVER['DOCUMENT_ROOT'].'/workout/settings.php';
unset($_SESSION); 
session_unset();
header('Location: /admin/login/');
?>