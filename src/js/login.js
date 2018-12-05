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

    let formData = new FormData();
    formData.append('user_username', usernameDOM.value);
    formData.append('user_password', passwordDOM.value);
    
    let response = await fetch('api/user/login', {method: "POST", body: formData})
    .then(res => {
        return {status: res.status, result: res.json()};
    })
    .catch((res) => {
        form.querySelector('.notification').innerText = 'Could not login: ' + res.statusText;
    })
    
    response.result.then((data) => {
        if(response.status == 200){
            ModalHandler.hide();
            userLoggedIn(data);
        }else{
            form.querySelector('.notification').innerText = 'Could not login: ' + data.error;
        }
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

function submitLogOut(resolve, reject){
    fetch('api/user/logout', 
            {method: "DELETE"})
    .then(res => {
        ModalHandler.hide();
        if(res.status === 200){
            userLoggedOut();
        }
    })
    .catch(() => {
        ModalHandler.hide();
    })
}

function userLoggedIn(data){
    document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = data.user_username;
    document.getElementById('login_slider').classList.add('active');
    g_appState.username = data.user_username;
    g_appState.userId = data.user_id;
}

function userLoggedOut(){
    document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = '';
    document.getElementById('login_slider').classList.remove('active');
    document.querySelector('#topbar .page-side-menu').classList.remove('active');
    g_appState.username = undefined;
    g_appState.userId = undefined;
}