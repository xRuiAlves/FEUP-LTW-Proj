document.getElementById('floatingActionButton').addEventListener('click', createNewStory);

function createNewStory(){
    let container = document.createElement('DIV');
    container.classList.add('story-creator');
    container.classList.add('card');
    container.classList.add('modal-box');

    container.innerHTML = `
    <input type="text" name="title" class="title" placeholder="Story Title"/>
    <textarea name="content" placeholder="Write your story here!"></textarea>
    ${getFileUploaderHTML()}
    <div class="notification warning"></div>
    <button>Submit</button>
    `;

    container.querySelector('button').addEventListener('click', () => {
        let title = container.querySelector('input.title').value;
        let content = container.querySelector('textarea').value;
        let file = container.querySelector('input[type="file"]').files[0];
        submitNewStory(title, content, file, container.querySelector('.notification'))
    });

    ModalHandler.show(container);
}

function submitNewStory(title, content, file, notificationForm){
    let body = {story_title: title, story_content: content};
    if(file){
        body.story_img = file;
    }

    request({url: 'api/index.php/story/create', method: 'POST', content: body})
    .then(() => {
        openUserProfile();
    })
    .catch((data) => {
        notificationForm.innerText = 'Could not create story: ' + data.error;
    })
}