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
        <div class="notification warning"></div>`;
        
        let passwordDOM = form.querySelector('input[type="password"]');

        passwordDOM.addEventListener('keydown', (e) => {
            if (e.keyCode === 13) submitLogin(form, resolve);
        });
        
        form.querySelector('button').addEventListener('click', () => submitLogin(form, resolve));

        ModalHandler.show(form);
    });
}

function submitLogin(form, resolve){
    let usernameDOM = form.querySelector('input[type="text"]');
    let passwordDOM = form.querySelector('input[type="password"]');

    let formData = new FormData();
    formData.append('user_username', usernameDOM.value);
    formData.append('user_password', passwordDOM.value);
    
    fetch('api/user/login', 
            {method: "POST",
            body: formData})
    .then(res => {
        console.log(res)
        return res.json()
        /*
        if(res.status === 200){
            ModalHandler.hide();
            console.log('asd')
            return res.json();
        }else{
            form.querySelector('.notification').innerText = 'Could not login. Check your credentials and try again';
        }*/
    })
    .then((data) => {
        console.log(data);
        document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = data.user_username;
    })
    .catch((res) => {
        form.querySelector('.notification').innerText = 'Could not login: ' + res.statusText;
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
            {method: "POST",
            body: formData})
    .then(res => {
        if(res.status === 200){
            ModalHandler.hide();
            document.getElementById('login_slider').classList.remove('active');
            document.querySelector('#topbar .page-side-menu').classList.remove('active');
        }else{
            ModalHandler.hide();
        }
    })
    .catch(() => {
        ModalHandler.hide();
    })
}