function showSignUpForm(){
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Sign Up</h1>
        <input type="text" placeholder="Name" class="name"/> 
        <input type="text" placeholder="Username" class="username"/>
        <input type="text" placeholder="Short Bio" class="bio"/>
        <input type="password" placeholder="Password" class="password"/>
        <input type="password" placeholder="Confirm Password" class="confirmPassword"/>
        <input type="file" name="pic" accept="image/*"/>
        <button class="submitSignUp">Create Account</button>
        <div class="notification warning"></div>`;
        
        let nameDOM = form.querySelector('input[type="text"].name');
        let usernameDOM = form.querySelector('input[type="text"].username');
        let bioDOM = form.querySelector('input[type="text"].bio');
        let passwordDOM = form.querySelector('input[type="password"].password');
        let confirmPasswordDOM = form.querySelector('input[type="password"].confirmPassword');
        let profilePicDOM = form.querySelector('input[type="file"]');
        
        form.querySelector('button.submitSignUp').addEventListener('click', () => submitSignUp(form, resolve));

        ModalHandler.show(form);

        nameDOM.focus();
    });
}

function submitSignUp(form, resolve){
    let usernameDOM = form.querySelector('input[type="text"].username');
    let nameDOM = form.querySelector('input[type="text"].name');
    let passwordDOM = form.querySelector('input[type="password"].password');
    let confirmPasswordDOM = form.querySelector('input[type="password"].confirmPassword');
    let bioDOM = form.querySelector('input[type="text"].bio');
    let profilePicDOM = form.querySelector('input[type="file"]');

    if (!(passwordDOM.value == confirmPasswordDOM.value)) {
        form.querySelector('.notification').innerText = 'Your passwords do not match';
        return;
    }

    let formData = new FormData();
    formData.append('user_username', usernameDOM.value);
    formData.append('user_realname', nameDOM.value);
    formData.append('user_password', passwordDOM.value);
    formData.append('user_bio', bioDOM.value);
    formData.append('user_img', profilePicDOM.files[0]);
    
    fetch('api/user/create', 
            {method: "POST",
            body: formData})
    .then(res => {
        if(res.status === 201){
            ModalHandler.hide();
            return res.json();
        } else {
            form.querySelector('.notification').innerText = 'Could not register your account. \nPlease try again';
        }
    })   
}