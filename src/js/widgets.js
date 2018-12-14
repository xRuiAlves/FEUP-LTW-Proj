function getFileUploaderHTML(){
    return `
    <div class="input-pic-box">
        <label for="file">
            <p class="file-button">
                Upload an image
            </p>
            <p class="file-box">No image selected</p>
        </label>
        <input type="file" id="file" class="input-pic" onchange='uploadFile(this)'>
    </div>`
}

function uploadFile(target) {
    target.parentElement.querySelector(".file-box").innerHTML = 'Image selected!';
}