import { generic_story_fetch } from './storyfetchers.js';

generic_story_fetch('latest-stories', 'api/story/recent', document.getElementById('btn-load-latest'));
document.getElementById('btn-load-latest').addEventListener('click', 
e => generic_story_fetch('latest-stories', 'api/story/recent', e.target));

generic_story_fetch('most-upvoted-stories', 'api/story/mostupvoted', document.getElementById('btn-load-most-upvoted'));
document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => generic_story_fetch('most-upvoted-stories', 'api/story/mostupvoted', e.target));

