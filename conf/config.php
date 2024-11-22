<?php
    $dbuser = "root";
    $dbpass = "";
    $dbname = "crud";
    $con = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);

    @session_start();

    $app_name = "CrudAppGanteng";
    $app_desc = "Aplikasi Belajar CRUD";
?>