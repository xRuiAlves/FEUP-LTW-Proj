function showLoginForm(){
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Login</h1> 
        <input type="text" placeholder="Username"/>
        <input type="password" placeholder="Password"/>
        <button>Login</button>
        <button class="Register">Register</button>
        <div class="notification warning"></div>`;
        
        let passwordDOM = form.querySelector('input[type="password"]');
        let usernameDOM = form.querySelector('input[type="text"]');

        passwordDOM.addEventListener('keydown', (e) => {
            if (e.keyCode === 13) submitLogin(form, resolve);
        });
        
        form.querySelector('button').addEventListener('click', () => submitLogin(form, resolve));
        form.querySelector('button.Register').addEventListener('click', () => showSignUpForm());

        ModalHandler.show(form);

        usernameDOM.focus();
    });
}

async function submitLogin(form, resolve){

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
            document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = data.user_username;
            resolve();
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
            document.getElementById('login_slider').classList.remove('active');
            document.querySelector('#topbar .page-side-menu').classList.remove('active');
        }
    })
    .catch(() => {
        ModalHandler.hide();
    })
}