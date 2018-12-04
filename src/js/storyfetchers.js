import StoriesRenderer from './storiesRenderer.js';

const AMOUNT_OF_STORIES_PER_FETCH = 6;

let storiesRenderer = new StoriesRenderer();

export function generic_story_fetch(destinationDOMId, requestPath, loadMoreButton){
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