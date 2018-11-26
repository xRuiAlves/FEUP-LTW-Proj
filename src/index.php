<?php include('./templates/header.php') ?>
<div class="page-divider"> 
    Latest stories
    <hr>
</div>
<div id="latest-stories" class="stories-container"></div>
<button onclick="load_more()">
    asdf
</button>


<script>
    let storiesRenderer = new StoriesRenderer();
    window.addEventListener('load', () => {
        storiesRenderer.displayStories([{...sampleStory, title:'1'},
                    {...sampleStory, title:'2', image: undefined},
                    {...sampleStory, title:'3'},
                    {...sampleStory, title:'4', image: undefined},
                    {...sampleStory, title:'5'},
                    {...sampleStory, title:'6'},
                    {...sampleStory, title:'7'},
                    {...sampleStory, title:'8', image: undefined},
                    {...sampleStory, title:'9', image: undefined},
                    {...sampleStory, title:'10'},
                    {...sampleStory, title:'11'},
                    {...sampleStory, title:'12'}], "latest-stories");
    });

    function load_more(){
        storiesRenderer.displayStories([{...sampleStory, title:'1'},
                    {...sampleStory, title:'2', image: undefined},
                    {...sampleStory, title:'3'},
                    {...sampleStory, title:'4', image: undefined},
                    {...sampleStory, title:'5'},
                    {...sampleStory, title:'6'},
                    {...sampleStory, title:'7'},
                    {...sampleStory, title:'8', image: undefined},
                    {...sampleStory, title:'9', image: undefined},
                    {...sampleStory, title:'10'},
                    {...sampleStory, title:'11'},
                    {...sampleStory, title:'12'}], "latest-stories");
    }

</script>

<?php include('./templates/footer.php') ?>