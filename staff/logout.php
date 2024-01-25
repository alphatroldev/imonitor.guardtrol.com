<?php
session_start();
unset($_SESSION['STAFF_LOGIN']);
header("Location: ./");
?>