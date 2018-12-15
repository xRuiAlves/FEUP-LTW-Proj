import { generic_story_fetch } from './storyfetchers.js';

generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', document.getElementById('btn-load-latest'));
document.getElementById('btn-load-latest').addEventListener('click', 
e => generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', e.target));

generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', document.getElementById('btn-load-most-upvoted'));
document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', e.target));


window.addEventListener("scroll", (e) => {
    document.querySelector('#banner img').style.transformOrigin = '50% ' + (50 - (Math.min((document.documentElement.scrollTop / document.querySelector('#banner').offsetHeight)*300, 300))) + '%';
});

document.querySelectorAll('.page-divider i').forEach(
    elem => elem.addEventListener('click', 
    () => document.querySelector('#search-bar').scrollIntoView(
        {behavior: "smooth", block: "center", inline: "nearest"}
        )
    )
);