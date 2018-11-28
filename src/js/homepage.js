import StoriesRenderer from './storiesRenderer.js';

let storiesRenderer = new StoriesRenderer();

load_latest_stories();



function load_latest_stories(){

    fetch('api/story/recent?offset=0&num_stories=12')
    .then(res => res.json())
    .then(data => storiesRenderer.displayStories(data, "latest-stories"))
    .catch(err => console.error(err))
    
}
