<?php include('./templates/header.php'); ?>

<link rel="stylesheet" href="css/profilepage.css">

<script src="js/profilepage.js" defer type="module"></script>

<div id="floatingActionButton" class="hidden"><span>&#43;</span></div>
<div class="card profile-info">
    <img class="pic">
    <div class="edit-picture">
        <i class="fas fa-edit edit-picture-icon"></i>
    </div>
    <p class="name"></p>
    <p class="bio"></p>
    <div class="footer">
        <div class="user-points-div">
            <span class="pointsTitle" title="Sum of the votes in this user's posts">User Points: </span>
            <span class="points"></span>
        </div>
        <i class="fas fa-cog cog-wheel" onclick="showChangePasswordForm()" title="Change password"></i>
    </div>
</div>

<div class="profile-content">
    <div class="page-divider"> Latest stories <hr></div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">
        Load more stories
    </button>
    
    <div class="page-divider"> Most Upvoted stories <hr></div>
    <div id="upvoted-stories" class="stories-container"></div>
    <button id="btn-load-upvoted">
        Load more stories
    </button>
</div>


<?php include('./templates/footer.php') ?>