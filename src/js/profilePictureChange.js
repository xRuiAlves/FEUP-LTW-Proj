function showProfilePictureChangeForm() {
    return new Promise((resolve, reject) => {   
        let form = document.createElement('DIV');
        form.classList.add('modal-box');
        form.innerHTML = 
        `
        <h1>Change Profile Picture</h1>
        ${getFileUploaderHTML()}
        <button class="submitChange">Submit Changes</button>
        <button class="cancel">Cancel</button>
        <div class="notification warning"></div>`;

        let cancelDOM = form.querySelector('button.cancel');
        let confirmDOM = form.querySelector('button.submitChange');
        
        confirmDOM.addEventListener('click', () => { submitPictureChanges(form, resolve);});

        cancelDOM.addEventListener('click', () => {
            ModalHandler.hide();
        })

        ModalHandler.show(form);
    });
}

function submitPictureChanges(form, resolve) {
    request({url: 'api/index.php/user/updateimage', 
            method: "POST", 
            content: {
                 user_img: form.querySelector('input[type="file"]').files[0]
            }
    })
    .then(data => {
        ModalHandler.hide();
        location.reload();
        resolve();
    }).catch(data => { 
        form.querySelector('.notification').innerText = 'Could not change picture: ' + data.error
    })
}