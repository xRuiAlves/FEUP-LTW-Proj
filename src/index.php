<?php include('./templates/header.php') ?>

<div id="latest-stories" class="stories-container"></div>

<script>
    window.addEventListener('load', () => {
        displayStories([sampleStory,{...sampleStory, image:undefined},sampleStory,sampleStory,sampleStory,sampleStory,sampleStory,sampleStory,sampleStory,sampleStory,sampleStory,sampleStory], "latest-stories")
    });
</script>

<?php include('./templates/footer.php') ?>