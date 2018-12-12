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
    let usernameDOM = form.querySelector('input[type="text"].Username');
    let nameDOM = form.querySelector('input[type="text"].Name');
    let passwordDOM = form.querySelector('input[type="password"]');
    let bioDOM = form.querySelector('input[type="text"].Bio');
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