<?php
    session_start();

    include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/env.php');

    $sideMenuEntries = [
        (object) ['text' => 'Add new story', 'icon' => 'fa-plus', 'onclick' => '#'],
        (object) ['text' => 'Profile', 'icon' => 'fa-user', 'onclick' => '#'],
        (object) ['text' => 'Settings', 'icon' => 'fa-cog', 'onclick' => '#'],
        (object) ['text' => 'Log out', 'icon' => 'fa-sign-out-alt', 'onclick' => 'showLogOutModal()']
    ]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
    <!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    --><link rel="stylesheet" href="css/style.css">
    <script src="js/navbar.js"></script>
    <script src="js/storiesRenderer.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/login.js"></script>
    <title><?=$_env_website_name?></title>
</head>
<body>
    <div id="modal-container"></div>
    <nav id="topbar">
        <h1><?=$_env_website_name?></h1>
        <ul class="page-side-menu">
            <?php foreach($sideMenuEntries as $entry){ ?>
                        <li><div onclick="<?=$entry->onclick?>"><?=$entry->text?><i class="fas <?=$entry->icon?>"></i></div></li>
            <?php } ?>
        </ul>
        <div class="nav-bar-right-section">
            <div id="login_slider" class="<?=isset($_SESSION['username']) ? 'active' : '' ?>">
                <div class="slider_text">
                    <div class="left"><?=$_env_login?></div>
                    <div class="right"><?=$_SESSION['username']?></div>
                </div>
                <img src="<?=$_env_default_profile_img ?>"/>
            </div>
            <div id="side-menu-hamburguer">
                <div class="side-menu-hamburguer-bar"></div>
            </div>
        </div>
    </nav>
    <section id="page-content">