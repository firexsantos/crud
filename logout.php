<?php
    include"conf/config.php";
    @session_destroy();
    header("Location: index.php");
?>