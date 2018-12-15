<?php
    session_start();

    include_once('./templates/env.php');

    $sideMenuEntries = [
        (object) ['text' => 'Add new story', 'icon' => 'fa-plus', 'onclick' => 'createNewStory()'],
        (object) ['text' => 'Profile', 'icon' => 'fa-user', 'onclick' => 'openUserProfile()'],
        (object) ['text' => 'Log out', 'icon' => 'fa-sign-out-alt', 'onclick' => 'showLogOutModal()']
    ]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"-->
    <link rel="icon" type="image/png" href="<?=$_env_root_path?>images/favicon.png">
    <link rel="stylesheet" href="<?=$_env_root_path?>css/style.css">
    <script src="<?=$_env_root_path?>js/env.js" ></script>
    <script src="<?=$_env_root_path?>js/network.js" ></script>
    <script src="<?=$_env_root_path?>js/appstate.js" ></script>
    <script src="<?=$_env_root_path?>js/widgets.js" ></script>
    <script src="<?=$_env_root_path?>js/navbar.js" defer></script>
    <script src="<?=$_env_root_path?>js/modal.js" defer></script>
    <script src="<?=$_env_root_path?>js/login.js" defer></script>
    <script src="<?=$_env_root_path?>js/signUp.js" defer></script>
    <script src="<?=$_env_root_path?>js/passwordChange.js" defer></script>
    <script src="<?=$_env_root_path?>js/profilePictureChange.js" defer></script>
    <script src="<?=$_env_root_path?>js/updateBio.js" defer></script>
    <script src="<?=$_env_root_path?>js/storyfetchers.js" type="module"></script>
    <script src="<?=$_env_root_path?>js/storyCreator.js" defer></script>
    <title><?=$_env_website_name?></title>
</head>
<body>
    <div id="modal-container"></div>
    <nav id="topbar">
        <div class="logo" onclick="window.location.href='<?=$_env_root_path?>'">
            <img src="<?=$_env_root_path?>images/logo_simple.png" />
            <h1><?=$_env_website_name?></h1>
        </div>
        <ul class="page-side-menu">
            <?php foreach($sideMenuEntries as $entry){ ?>
                        <li><div onclick="<?=$entry->onclick?>"><?=$entry->text?><i class="fas <?=$entry->icon?>"></i></div></li>
            <?php } ?>
        </ul>
        <div class="nav-bar-right-section">
            <div id="login_slider" class="<?=isset($_SESSION['username']) ? 'active' : '' ?>">
                <div class="slider_text">
                    <div class="left"><?=$_SESSION['username']?></div>
                    <div class="right"><?=$_env_login?></div>
                </div>
                <img src="<?=$_env_root_path?>/images/default_profile.png"/>
            </div>
            <div id="side-menu-hamburguer">
                <div class="side-menu-hamburguer-bar"></div>
            </div>
        </div>
    </nav>
    <section id="page-content">