import { generic_story_fetch } from './storyfetchers.js';

let url = new URL(window.location.href);
url.searchParams.get("username");

g_appState.addEventListener('load', (data) => {
    console.log(data);
    if(!data.user_username) {
        window.location.href = '/';
        return;
    }
    document.querySelector('.card.profile-info .pic').setAttribute('src', data.user_img_big);
    document.querySelector('.card.profile-info .name').textContent = data.user_username;
    document.querySelector('.card.profile-info .bio').textContent = data.user_bio;
    document.querySelector('.card.profile-info .points').textContent = data.points;
})

generic_story_fetch('latest-stories', 'api/story/recent');
document.getElementById('btn-load-latest').addEventListener('click', 
e => generic_story_fetch('latest-stories', 'api/story/recent', e.target));