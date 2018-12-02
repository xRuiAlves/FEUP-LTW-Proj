function showSignUpForm(){
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Sign Up</h1>
        <input type="text" placeholder="Name"/> 
        <input type="text" placeholder="Username"/>
        <input type="text" placeholder="Short Bio"/>
        <input type="password" placeholder="Password"/>
        <input type="file" name="pic" accept="image/*"/>
        <button>Create Account</button>
        <div class="notification warning"></div>`;
        
        let nameDOM = form.querySelector('input[type="text"]');
        let usernameDOM = form.querySelector('input[type="text"]');
        let bioDOM = form.querySelector('input[type="text"]');
        let passwordDOM = form.querySelector('input[type="password"]');
        let profilePicDOM = form.querySelector('input[type="file"]');

        passwordDOM.addEventListener('keydown', (e) => {
            if (e.keyCode === 13) submitSignUp(form, resolve);
        });
        
        form.querySelector('button').addEventListener('click', () => submitSignUp(form, resolve));

        ModalHandler.show(form);

        usernameDOM.focus();
    });
}

function submitSignUp(form, resolve){
    let nameDOM = form.querySelector('input[type="text"]');
    let usernameDOM = form.querySelector('input[type="text"]');
    let bioDOM = form.querySelector('input[type="text"]');
    let passwordDOM = form.querySelector('input[type="password"]');
    let profilePicDOM = form.querySelector('input[type="file"]');

    let formData = new FormData();
    formData.append('user_username', usernameDOM.value);
    formData.append('user_realname', nameDOM.value);
    formData.append('user_password', passwordDOM.value);
    formData.append('user_bio', bioDOM.value);
    formData.append('usr_img', profilePicDOM.value);
    
    fetch('api/user/create', 
            {method: "POST",
            body: formData})
    .then(res => {
        if(res.status === 200){
            ModalHandler.hide();
            return res.json();
        }else{
            form.querySelector('.notification').innerText = 'Could not register your account. \nPlease try again';
        }
    })
    /* .then((data) => {
        console.log(data)
        document.querySelector('#topbar #login_slider > .slider_text div.left').innerText = data.user_username;
        resolve();
    })
    .catch((res) => {
        form.querySelector('.notification').innerText = 'Could not login: ' + res.statusText;
    }) */    
}