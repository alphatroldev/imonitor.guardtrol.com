<?php
session_start();
unset($_SESSION['COMPANY_LOGIN']);
header("Location: ./");
?>