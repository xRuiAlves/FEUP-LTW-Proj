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
        
        <div class="input-profile-pic-box">
            <input type="file" id="file" class="input-profile-pic" onchange='uploadFile(this)'>
            <label for="file">
                <span id="file-name" class="file-box"></span>
                <span class="file-button">
                    Select File
                </span>
            </label>
        </div>

        <button class="submitSignUp">Create Account</button>
        <div class="notification warning"></div>`;
        
        let nameDOM = form.querySelector('input[type="text"].name');
        
        form.querySelector('button.submitSignUp').addEventListener('click', () => submitSignUp(form, resolve));

        ModalHandler.show(form);

        nameDOM.focus();
    });
}

function uploadFile(target) {
    document.getElementById("file-name").innerHTML = target.files[0].name;
}

async function submitSignUp(form, resolve){
    let passwordDOM = form.querySelector('input[type="password"].password');
    let confirmPasswordDOM = form.querySelector('input[type="password"].confirmPassword');

    if (!(passwordDOM.value == confirmPasswordDOM.value)) {
        form.querySelector('.notification').innerText = 'Your passwords do not match';
        return;
    }

    let requestBody = {
        user_username: form.querySelector('input[type="text"].username').value,
        user_realname: form.querySelector('input[type="text"].name').value,
        user_password: passwordDOM.value,
        user_bio: form.querySelector('input[type="text"].Bio'),
        user_img: form.querySelector('input[type="file"]').files[0]
    }
    
    request({url: 'api/user/create', method: "POST", content: requestBody})
    .then(data => {
        ModalHandler.hide();
        userLoggedIn(data);
        resolve();
    }).catch(data => form.querySelector('.notification').innerText = 'Could not sign up: ' + data.error)
}