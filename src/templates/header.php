<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/env.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?=$_env_website_name?></title>
</head>
<body>
    <header>

        <nav id="topbar">
            <h1><?=$_env_website_name?></h1>
            <div id="login_slider">
                <div class="slider_text">
                    <div class="left"><?=$_env_login?></div>
                    <div class="right">Henrique</div>
                </div>
                <img src="<?=$_env_default_profile_img ?>"/>

                <ul>
                    <li><?=$_env_profile?></li>
                    <li><?=$_env_settings?></li>
                    <li><?=$_env_logout?></li>
                </ul>
            <div>
        </nav>


    </header>