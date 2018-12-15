<?php include('./templates/header.php') ?>

<link rel="stylesheet" href="<?=$_env_root_path?>css/homepage.css">

<script src="<?=$_env_root_path?>js/homepage.js" defer type="module"></script>

<div id="banner">
    <img src="<?=$_env_root_path?>images/banner-light.png"/>
</div>
<div id="search-bar"><input type="text" placeholder="Search travelling stories!"/><i class="fas fa-search"></i></div>

<div id="floatingActionButton" class="hidden"><span>+</span><i class="fas fa-pen"></i></div>

<div>
    <div class="page-divider">Latest stories<i class="fas fa-search"></i></div>
    <div id="latest-stories" class="stories-container"></div>
    <button id="btn-load-latest">
        Load More Recent Stories!
    </button>
</div>

<div>
    <div class="page-divider">Most Upvoted stories<i class="fas fa-search"></i></div>
    <div id="most-upvoted-stories" class="stories-container"></div>
    <button id="btn-load-most-upvoted">
        Load More Stories!
    </button>
</div>

<?php include('./templates/footer.php') ?>