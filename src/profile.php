<?php include('./templates/header.php'); ?>

<link rel="stylesheet" href="css/profilepage.css">

<script src="js/profilepage.js" defer type="module"></script>


<div class="card profile-info">
    <img src="https://static1.squarespace.com/static/54f74f23e4b0952b4e0011c0/t/5ad5431e88251baeaac75f49/1523925845937/chris+hanna+bb.jpg">
    <p class="name">John Doe</p>
    <p>My motto is live life travelling</p>
</div>

<div class="profile-content">
    <div class="page-divider"> Latest stories <hr></div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">Load more stories</div>
    <!-- stories containers go here -->
</div>


<?php include('./templates/footer.php') ?>