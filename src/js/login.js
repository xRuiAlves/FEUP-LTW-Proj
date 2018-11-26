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
        if(res.status === 200){
            ModalHandler.hide();
            resolve();
        }else{
            form.querySelector('.notification').innerText = 'Could not login. Check your credentials and try again';
        }
    })
    .catch(() => {
        form.querySelector('.notification').innerText = 'Could not login: ' + res.statusText;
    })    
}