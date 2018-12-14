<?php include('./templates/header.php') ?>

<link rel="stylesheet" href="css/homepage.css">

<script src="js/homepage.js" defer type="module"></script>

<div id="banner">
    <img src="images/banner-light.png"/>
</div>
<div id="floatingActionButton" class="hidden"><span>+</span><i class="fas fa-pen"></i></div>

<div>
    <div class="page-divider"> Latest stories</div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">
        Load More Recent Stories!
    </button>
</div>

<div>
    <div class="page-divider">Most Upvoted stories</div>
    <div id="most-upvoted-stories" class="stories-container"></div>
    <button id="btn-load-most-upvoted">
        Load More Stories!
    </button>
</div>

<?php include('./templates/footer.php') ?>