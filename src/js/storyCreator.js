document.getElementById('floatingActionButton').addEventListener('click', () => {
    let container = document.createElement('DIV');
    container.classList.add('story-creator');
    container.classList.add('card');

    container.innerHTML = `
    <input type="text" name="title" class="title" placeholder="Story Title"/>
    <textarea name="content" placeholder="Write your story here!"></textarea>
    ${getFileUploaderHTML()}
    <button>Submit</button>
    `;

    container.querySelector('button').addEventListener('click', () => {
        let title = container.querySelector('input.title').value;
        let content = container.querySelector('textarea').value;
        let file = container.querySelector('input[type="file"]').files[0];
        submitNewStory(title, content, file)
    });

    ModalHandler.show(container);
});

function submitNewStory(title, content, file){
    let body = {story_title: title, story_content: content};
    if(file){
        body.story_img = file;
    }

    request({url: 'api/story/create', method: 'POST', content: body})
    .then(() => {
        window.location.href = 'profile.php'
    })
    .catch(() => {
        console.log('could not create story');
    })
}