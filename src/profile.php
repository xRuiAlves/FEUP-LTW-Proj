<?php include('./templates/header.php'); ?>

<link rel="stylesheet" href="css/profilepage.css">

<script src="js/profilepage.js" defer type="module"></script>


<div class="card profile-info">
    <img class="pic">
    <p class="name"></p>
    <p class="bio"></p>
    <p class="points"></p>
</div>

<div class="profile-content">
    <div class="page-divider"> Latest stories <hr></div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">Load more stories</div>
    <!-- stories containers go here -->
</div>


<?php include('./templates/footer.php') ?>