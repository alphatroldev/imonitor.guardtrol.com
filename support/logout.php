<?php
    session_start();
    unset($_SESSION['SUPPORT_LOGIN']);
    header("Location: ./support");
?>