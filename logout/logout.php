<?php
    require_once("../config-function/function.php");

    session_close();

    header("Location: ../login/login.php");
    exit;
?>