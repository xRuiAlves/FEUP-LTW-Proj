function updateBio() {
    let requestBody = {
        user_bio: document.querySelector('textarea.bio').value
    }
    
    request({url: 'api/index.php/user/updatebio', method: "PUT", content: requestBody})
    .then(data => {
        resolve();
    })
    .catch(data => {});
}