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

    ModalHandler.show(container);
});