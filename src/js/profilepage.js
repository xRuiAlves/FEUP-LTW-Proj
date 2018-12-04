import { generic_story_fetch } from './storyfetchers.js';

let url = new URL(window.location.href);
url.searchParams.get("username");

//fetch user info from username

generic_story_fetch('latest-stories', 'api/story/recent');
document.getElementById('btn-load-latest').addEventListener('click', 
e => generic_story_fetch('latest-stories', 'api/story/recent', e.target));