let login_slider = document.getElementById('login_slider');
let hamburguer = document.getElementById('side-menu-hamburguer');
let side_menu = document.querySelector('#topbar .page-side-menu');
let page_content = document.getElementById('page-content');
login_slider.addEventListener("click", () => {
    if(login_slider.classList.contains('active')){
        openUserProfile();
    }else{
        showLoginForm();
    }
    
});
hamburguer.addEventListener("click", () => 
    side_menu.classList.toggle('active')
);
page_content.addEventListener("click", () => 
    side_menu.classList.remove('active')
);

g_appState.addEventListener('load', (state) => {
    document.querySelector('#login_slider > img').setAttribute('src', state.user_img_small ? (g_root_path + state.user_img_small) : (g_root_path + 'images/default_profile.png'));
    if(state.user_username){
        document.querySelector('#floatingActionButton').classList.remove('hidden');
    }
});

function openUserProfile(id){
    if(!id){
        window.location.href=g_root_path + "profile.php";
    }else{
        window.location.href=g_root_path + "profile.php?id=" + id;
    }
}

function openHomePage(){
    window.location.href=g_root_path + "index.php";
}