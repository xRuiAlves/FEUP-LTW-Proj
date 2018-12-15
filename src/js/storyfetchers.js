import StoriesRenderer from './storiesRenderer.js';

const AMOUNT_OF_STORIES_PER_FETCH = 6;

let storiesRenderer = new StoriesRenderer();

export function generic_story_fetch(destinationDOMId, requestPath, loadMoreButton, propertiesGetter){
    let offset;
    if(storiesRenderer.displayedStories[destinationDOMId]){
        offset = storiesRenderer.displayedStories[destinationDOMId].length;
    }else{
        offset = 0;
    }

    request({url: requestPath, content: {
        ...(propertiesGetter()),
        offset: offset,
        num_stories: AMOUNT_OF_STORIES_PER_FETCH
    }})
    .then(data => {
        storiesRenderer.displayStories(data, destinationDOMId);
        if(data.length < AMOUNT_OF_STORIES_PER_FETCH && loadMoreButton){
            loadMoreButton.style.visibility = 'hidden';
        }else{
            loadMoreButton.style.visibility = 'visible';
        }
    })
    .catch(err => console.log('Could not load stories'));
}

export function user_story_fetch(destinationDOMId, requestPath, user_id, loadMoreButton){
    let offset;
    if(storiesRenderer.displayedStories[destinationDOMId]){
        offset = storiesRenderer.displayedStories[destinationDOMId].length;
    }else{
        offset = 0; 
    }

    request({url: requestPath, content: {offset: offset, num_stories: AMOUNT_OF_STORIES_PER_FETCH, user_id: user_id}})
    .then(data => {
        if(data.length === 0 && offset === 0){
            document.getElementById(destinationDOMId).parentElement.parentElement.innerText = 'No stories to show';
        }else{
            storiesRenderer.displayStories(data, destinationDOMId);
            if(data.length < AMOUNT_OF_STORIES_PER_FETCH && loadMoreButton){
                loadMoreButton.style.visibility = 'hidden';
            }else{
                loadMoreButton.style.visibility = 'visible';
            }
        }
    })
    .catch(err => console.log('Could not load stories', err));
}

export function clearStories(){
    storiesRenderer.clear();
}