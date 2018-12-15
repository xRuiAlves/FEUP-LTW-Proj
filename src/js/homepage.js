import { generic_story_fetch, clearStories } from './storyfetchers.js';

fetchStories();

document.getElementById('btn-load-latest').addEventListener('click', 
    e => generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', e.target, getMatch));

document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', e.target, getMatch));


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

document.querySelector('#search-bar').addEventListener('input', e => {
    clearStories();
    fetchStories();
});


function fetchStories(){
    generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', document.getElementById('btn-load-latest'), getMatch);
    generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', document.getElementById('btn-load-most-upvoted'), getMatch);
}

function getMatch(){
    return {match: document.querySelector('#search-bar input').value || ''};
}