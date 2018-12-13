let changePasswordButton = document.querySelector('.change-password-button');

function showChangePasswordForm(){
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Change Password</h1>
        <input type="password" placeholder="Password" class="currentPassword"/>
        <input type="password" placeholder="Password" class="password"/>
        <input type="password" placeholder="Confirm Password" class="confirmPassword"/>
        <button class="submitChange">Submit Changes</button>
        <button class="cancel">Cancel</button>
        <div class="notification warning"></div>`;
        
        let currentPasswordDOM = form.querySelector('input[type="password"].currentPassword');
        let passwordDOM = form.querySelector('input[type="password"].password');
        let confirmPasswordDOM = form.querySelector('input[type="password"].confirmPassword');

        let cancelDOM = form.querySelector('button.cancel');
        let confirmDOM = form.querySelector('button.submitChange');
        
        confirmDOM.addEventListener('click', () => { submitChanges(form);});

        cancelDOM.addEventListener('click', () => {
            ModalHandler.hide();
        })

        ModalHandler.show(form);

        currentPasswordDOM.focus();
    });
}

async function submitChanges(form) {
    let currentPasswordDOM = form.querySelector('input[type="password"].currentPassword');
    let passwordDOM = form.querySelector('input[type="password"].password');
    let confirmPasswordDOM = form.querySelector('input[type="password"].confirmPassword');
    
    if (!(passwordDOM.value == confirmPasswordDOM.value)) {
        form.querySelector('.notification').innerText = 'Your passwords do not match';
        return;
    }

    let formData = new FormData();
    formData.append('user_username', g_appState.user_username);
    formData.append('user_old_password', currentPasswordDOM.value);
    formData.append('user_new_password', passwordDOM.value);

    let response = await fetch('api/user/updatepassword', {method: "PUT", body: formData})
    .then(res => {
        return {status: res.status, result: res.json()};
    })
    .catch((res) => {
        form.querySelector('.notification').innerText = 'Could not login: ' + res.statusText;
    })

}

changePasswordButton.addEventListener("click", () => 
    showChangePasswordForm()
);