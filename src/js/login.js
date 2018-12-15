function showLoginForm(){  
    let form = document.createElement('DIV');
    form.classList.add('modal-box');
    form.innerHTML = 
    `
    <h1>Login</h1> 
    <input type="text" placeholder="Username"/>
    <input type="password" placeholder="Password"/>
    <button class="login">Login</button>
    <button class="register">Register</button>
    <div class="notification warning"></div>`;
    
    let passwordDOM = form.querySelector('input[type="password"]');
    let usernameDOM = form.querySelector('input[type="text"]');

    passwordDOM.addEventListener('keydown', (e) => {
        if (e.keyCode === 13) submitLogin(form);
    });
    
    form.querySelector('button.login').addEventListener('click', () => submitLogin(form));
    form.querySelector('button.register').addEventListener('click', () => showSignUpForm());

    ModalHandler.show(form);

    usernameDOM.focus();
}

async function submitLogin(form){

    let usernameDOM = form.querySelector('input[type="text"]');
    let passwordDOM = form.querySelector('input[type="password"]');
    
    request({url: 'api/user/login',
            method: "POST",
            content: {user_username: usernameDOM.value,
                      user_password: passwordDOM.value}})
    .then(data => {
        ModalHandler.hide();
        userLoggedIn(data);
    })
    .catch((data) => {
        form.querySelector('.notification').innerText = 'Could not login: ' + data.error;
    })
}

function showLogOutModal(){
    
    let form = document.createElement('DIV');
    form.classList.add('modal-box');
    form.innerHTML = 
    `
    <p>You are about to log out. Are you sure?</p> 
    <button class="cancel">Cancel</button>
    <button class="confirm">Log out</button>
    </div>`;
    
    let cancelDOM = form.querySelector('button.cancel');
    let confirmDOM = form.querySelector('button.confirm');

    form.addEventListener('keydown', (e) => {
        if (e.keyCode === 13){ submitLogOut();}
    });
    
    confirmDOM.addEventListener('click', () => { submitLogOut();});

    cancelDOM.addEventListener('click', () => {
        ModalHandler.hide();
    })

    ModalHandler.show(form);
}

function submitLogOut(){
    request({url: 'api/user/logout', 
            method: "DELETE"})
    .then(data => {
        ModalHandler.hide();
        userLoggedOut();
        if (window.location.pathname === g_root_path + "profile.php") {
            openHomePage();
        }
    })
    .catch(() => {
        ModalHandler.hide();
    })
}

function userLoggedIn(data){
    localStorage.setItem('CSRF-TOKEN', data.csrf_token);
    document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = data.user_username;
    document.getElementById('login_slider').classList.add('active');
    g_appState = {...g_appState, ...data};
    g_appState.triggerOnLoads();
    document.querySelector('#login_slider > img').setAttribute('src', g_root_path + data.user_img_small);
}

function userLoggedOut(){
    document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = '';
    document.getElementById('login_slider').classList.remove('active');
    document.querySelector('#topbar .page-side-menu').classList.remove('active');
    document.querySelector('#login_slider > img').setAttribute('src', g_root_path + 'images/default_profile.png');
    g_appState.user_username = undefined;
    g_appState.user_id = undefined;
    openHomePage();
}