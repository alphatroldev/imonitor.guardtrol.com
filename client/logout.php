<?php
session_start();
unset($_SESSION['CLIENT_LOGIN']);
header("Location: ./client");
?>