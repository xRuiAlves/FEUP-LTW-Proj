import { generic_story_fetch } from './storyfetchers.js';

fetchStories();

let lastMatch = '';
let searchBarInput = document.querySelector('#search-bar input');

//Inteval for story search
setInterval(() => {
    if(searchBarInput.value !== lastMatch){
        lastMatch = searchBarInput.value;
        fetchStories();
    }
}, 300);


//add click listeners for "load more stories" buttons
document.getElementById('btn-load-latest').addEventListener('click', 
    e => generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', e.target, getMatch));

document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', e.target, getMatch));


//Homepage banner parallax effect
window.addEventListener("scroll", (e) => {
    document.querySelector('#banner img').style.transformOrigin = '50% ' + (50 - (Math.min((document.documentElement.scrollTop / document.querySelector('#banner').offsetHeight)*300, 300))) + '%';
});


//Clicking on the search icon scrolls up to search bar
document.querySelectorAll('.page-divider i').forEach(
    elem => elem.addEventListener('click', 
    () => {
        let x = window.scrollX, y = window.scrollY;
        searchBarInput.focus();
        window.scrollTo(x, y);
        document.querySelector('#search-bar').scrollIntoView(
            {behavior: "smooth", block: "center", inline: "nearest"}
            )
        
        }
    )
);


function fetchStories(){
    generic_story_fetch('latest-stories', g_root_path + 'api/index.php/story/recent', document.getElementById('btn-load-latest'), getMatch, true);
    generic_story_fetch('most-upvoted-stories', g_root_path + 'api/index.php/story/mostupvoted', document.getElementById('btn-load-most-upvoted'), getMatch, true);
}

function getMatch(){
    return {match: document.querySelector('#search-bar input').value || ''};
}