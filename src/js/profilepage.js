import { user_story_fetch } from './storyfetchers.js';

let url = new URL(window.location.href);
let externalProfileId = url.searchParams.get("id");

g_appState.addEventListener('load', (data) => {
    if(!data.user_username) {
        openHomePage();
        return;
    }

    if(!externalProfileId){
        document.querySelector('.card.profile-info .pic').setAttribute('src', data.user_img_big);
        document.querySelector('.card.profile-info .name').textContent = data.user_username;
        document.querySelector('.card.profile-info .bio').textContent = data.user_bio;
        document.querySelector('.card.profile-info .points').textContent = data.points;
    }else{
        request({url: 'api/user/info', content:{id: externalProfileId}}).then(data => {
            document.querySelector('.card.profile-info .pic').setAttribute('src', data.user_img_big);
            document.querySelector('.card.profile-info .name').textContent = data.user_username;
            document.querySelector('.card.profile-info .bio').textContent = data.user_bio;
            document.querySelector('.card.profile-info .points').textContent = data.points;
        }).catch(openHomePage);
    }

    user_story_fetch('latest-stories', 'api/story/recentuser', externalProfileId || data.user_id);
    document.getElementById('btn-load-latest').addEventListener('click', 
    e => user_story_fetch('latest-stories', 'api/story/recentuser', data.user_id, e.target));

    user_story_fetch('upvoted-stories', 'api/story/mostupvoteduser', externalProfileId || data.user_id);
    document.getElementById('btn-load-upvoted').addEventListener('click', 
    e => user_story_fetch('upvoted-stories', 'api/story/mostupvoteduser', data.user_id, e.target));
})
