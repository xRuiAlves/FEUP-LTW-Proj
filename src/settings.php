<?php include('./templates/header.php'); ?>

<link rel="stylesheet" href="css/settingspage.css">

<script src="js/settingspage.js" defer type="module"></script>

<div class="card change-settings" id="change-settings">
    <p>Change Account Settings</p>
</div>

<div class="card change-password">
    <p class="change-password-title">Change Account Password</p>
    <button class="change-password-button">Change Password</button>
</div>

<div class="card change-bio">
    <p class="change-bio-title">Change Your Bio</p>
    <input type="text" id="change-bio" placeholder="Bio" class="bio"/> 
</div>

<?php include('./templates/footer.php') ?>