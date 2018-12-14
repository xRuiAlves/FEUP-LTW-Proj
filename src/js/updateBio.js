function updateBio() {

    console.log(document.querySelector('textarea.bio').value);

    let requestBody = {
        user_bio: document.querySelector('textarea.bio').value
    }
    
    request({url: 'api/user/updatebio', method: "PUT", content: requestBody})
    .then(data => {
        resolve();
    }).catch(data => form.querySelector('.notification').innerText = 'Could not update bio: ' + data.error)
}