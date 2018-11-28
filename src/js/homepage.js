import StoriesRenderer from './storiesRenderer.js';

let storiesRenderer = new StoriesRenderer();

const AMOUNT_OF_STORIES_PER_FETCH = 10;

generic_story_fetch('latest-stories', 'api/story/recent');
generic_story_fetch('most-upvoted-stories', 'api/story/mostupvoted');

document.getElementById('btn-load-latest').addEventListener('click', 
    e => generic_story_fetch('latest-stories', 'api/story/recent', e.target));

document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => generic_story_fetch('most-upvoted-stories', 'api/story/mostupvoted', e.target));


function generic_story_fetch(destinationDOMId, requestPath, loadMoreButton){
    let offset;
    if(storiesRenderer.displayedStories[destinationDOMId]){
        offset = storiesRenderer.displayedStories[destinationDOMId].length;
    }else{
        offset = 0;
    }

    fetch(`${requestPath}?offset=${offset}&num_stories=${AMOUNT_OF_STORIES_PER_FETCH}`)
    .then(res => res.json())
    .then(data => {
        storiesRenderer.displayStories(data, destinationDOMId);
        if(data.length < AMOUNT_OF_STORIES_PER_FETCH){
            loadMoreButton.parentNode.removeChild(loadMoreButton);
        }
    })
    .catch(err => console.log('Could not load stories'));
}