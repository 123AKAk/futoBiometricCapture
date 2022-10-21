<?php
    session_start();
    $loggedin = false;
    require "assets/db.php";
    require "assets/varnames.php";
    require 'assets/sharedComponents.php';
    $components = new SharedComponents();

    if (isset($_SESSION["admin_blunt_blog_user_loggedin_"])){
        $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->unprotect($_SESSION["admin_blunt_blog_user_loggedin_"]);
        if ($_SESSION["admin_blunt_blog_user_loggedin_"] == true && isset($_SESSION["blunt_blog_user_status_"])){
            $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->protect($_SESSION["admin_blunt_blog_user_loggedin_"]);
            $adid = $components->unprotect($_SESSION["blunt_blog_user_status_"]);
            $type = $components->checkuser($adid, $pdo);
            $username = $components->returnname($adid, $pdo);
            if($type >= 1)
            {
                $loggedin = true;
            }
            else{
                header("location: logout.php");
                exit;
            }
        }
        else{
            header("location: adminlogin.php");
        }
    }
    else{
        header("location: adminlogin.php");
    }
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--<![endif]-->
<!-- Begin Head -->

<head>
    <title>FUTO | Admin</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="MobileOptimized" content="320">
    <!--Start Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/icofont.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" id="theme-change" type="text/css" href="#">
    <!-- Favicon Link -->
    <link rel="shortcut icon" type="image/png" href="assets/futo.png">

    <link rel="stylesheet" type="text/css" href="assets/css/theme.css">

    <link rel="stylesheet" type="text/css" href="assets/css/auth.css">
    <!-- alertify -->
    <link href="assets/js/alertify/themes/alertify.core.css" rel="stylesheet">
    <link href="assets/js/alertify/themes/alertify.default.css" rel="stylesheet">

    <style>
        /* *&* */
        /* feedback alert styling */
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            opacity: 1;
            transition: opacity 0.6s;
            margin-bottom: 15px;
            margin: auto;
            display: block;
            width: 100%;
            border-radius: 0;
        }
        
        .alert.success {background-color: #04AA6D;}
        .alert.info {background-color: #2196F3;}
        .alert.warning {background-color: #e76c63;}
        
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .closebtn:hover {
            color: black;
        }
        .alert p{
            color: white;
        }
        /* *&* */

    </style>

    <!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">    -->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
    <script src="assets/js/jquery.min.js"></script>
    <!--<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>-->
    <link rel="stylesheet" href="assets/js/DataTables/datatables.min.css"></style>
    <link rel="stylesheet" href="assets/js/DataTables/datatables.css"></style>
    <script src="assets/js/DataTables/datatables.js"></script>
    <script src="assets/js/DataTables/datatables.min.js"></script>
    
    <!--<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>-->
    <!--<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
</head>