import { user_story_fetch } from './storyfetchers.js';

let url = new URL(window.location.href);
let externalProfileId = url.searchParams.get("id");

g_appState.addEventListener('load', (data) => {
    if(!data.user_username && !externalProfileId) {
        openHomePage();
        return;
    }

    if(!externalProfileId || externalProfileId === data.user_id){
        document.querySelector('.card.profile-info .pic').setAttribute('src', g_root_path + data.user_img_big);
        document.querySelector('.card.profile-info .name').textContent = data.user_username;
        document.querySelector('.card.profile-info .bio').textContent = data.user_bio;
        document.querySelector('.card.profile-info .points').textContent = data.points;
    }else{
        request({url: 'api/user/info', content:{id: externalProfileId}}).then(data => {
            document.querySelector('.card.profile-info .pic').setAttribute('src', g_root_path + data.user_img_big);
            document.querySelector('.card.profile-info .name').textContent = data.user_username;
            document.querySelector('.card.profile-info .bio').textContent = data.user_bio;
            document.querySelector('.card.profile-info .points').textContent = data.points;
            document.querySelector('.card.profile-info .edit-picture').classList.add('invisible');
            document.querySelector('.card.profile-info .cog-wheel').classList.add('invisible');
            document.querySelector('.card.profile-info .bio').classList.add('non-editable');
        }).catch(openHomePage);
    }

    user_story_fetch('latest-stories', 'api/story/recentuser', externalProfileId || data.user_id, document.getElementById('btn-load-latest'));
    document.getElementById('btn-load-latest').addEventListener('click', 
    e => user_story_fetch('latest-stories', 'api/story/recentuser', data.user_id, e.target));

    user_story_fetch('upvoted-stories', 'api/story/mostupvoteduser', externalProfileId || data.user_id, document.getElementById('btn-load-most-upvoted'));
    document.getElementById('btn-load-most-upvoted').addEventListener('click', 
    e => user_story_fetch('upvoted-stories', 'api/story/mostupvoteduser', data.user_id, e.target));
})
