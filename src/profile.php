<?php include('./templates/header.php'); ?>

<link rel="stylesheet" href="css/profilepage.css">

<script src="js/profilepage.js" defer type="module"></script>


<div class="card profile-info">
    <img class="pic">
    <p class="name"></p>
    <p class="bio"></p>
    <span class="pointsTitle" title="Sum of the votes in this user's posts">User Points: </span>
    <span class="points"></span>
</div>

<div class="profile-content">
    <div class="page-divider"> Latest stories <hr></div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">Load more stories</div>
    <!-- stories containers go here -->
</div>


<?php include('./templates/footer.php') ?>