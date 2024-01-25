<?php
session_start();
unset($_SESSION['SUPERVISOR_LOGIN']);
header("Location: ./supervisor");
?>