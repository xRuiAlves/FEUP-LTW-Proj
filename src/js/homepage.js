import StoriesRenderer from './storiesRenderer.js';

let storiesRenderer = new StoriesRenderer();

const AMOUNT_OF_STORIES_PER_FETCH = 3;

load_latest_stories();
document.getElementById('btn-load-latest').addEventListener('click', load_latest_stories);


function load_latest_stories(){
    let offset;
    if(storiesRenderer.displayedStories['latest-stories']){
        offset = storiesRenderer.displayedStories['latest-stories'].length;
    }else{
        offset = 0;
    }

    fetch(`api/story/recent?offset=${offset}&num_stories=${AMOUNT_OF_STORIES_PER_FETCH}`)
    .then(res => res.json())
    .then(data => {
        storiesRenderer.displayStories(data, "latest-stories");
        if(data.length < AMOUNT_OF_STORIES_PER_FETCH){
            let btnLoadLatest = document.getElementById('btn-load-latest')
            btnLoadLatest.parentNode.removeChild(btnLoadLatest);
        }
    })
    .catch(err => console.log('Could not load latest stories'));
}
