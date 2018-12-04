function showSignUpForm(){
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Sign Up</h1>
        <input type="text" placeholder="Name" class="Name"/> 
        <input type="text" placeholder="Username" class="Username"/>
        <input type="text" placeholder="Short Bio" class="Bio"/>
        <input type="password" placeholder="Password"/>
        <input type="file" name="pic" accept="image/*"/>
        <button>Create Account</button>
        <div class="notification warning"></div>`;
        
        let nameDOM = form.querySelector('input[type="text"].Name');
        
        form.querySelector('button').addEventListener('click', () => submitSignUp(form, resolve));

        ModalHandler.show(form);

        nameDOM.focus();
    });
}

async function submitSignUp(form, resolve){
    let usernameDOM = form.querySelector('input[type="text"].Username');
    let nameDOM = form.querySelector('input[type="text"].Name');
    let passwordDOM = form.querySelector('input[type="password"]');
    let bioDOM = form.querySelector('input[type="text"].Bio');
    let profilePicDOM = form.querySelector('input[type="file"]');

    let formData = new FormData();
    formData.append('user_username', usernameDOM.value);
    formData.append('user_realname', nameDOM.value);
    formData.append('user_password', passwordDOM.value);
    formData.append('user_bio', bioDOM.value);
    formData.append('user_img', profilePicDOM.files[0]); 
    
    let response = await fetch('api/user/create', {method: "POST", body: formData})
    .then(res => {
        return {status: res.status, result: res.json()};
    })
    
    response.result.then((data) => {
        if(response.status == 201){
            ModalHandler.hide();
            userLoggedIn(data);
            resolve();
        }else{
            form.querySelector('.notification').innerText = 'Could not sign up: ' + data.error;
        }
    })
}