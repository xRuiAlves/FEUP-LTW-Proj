document.getElementById('floatingActionButton').addEventListener('click', () => {
    let container = document.createElement('DIV');
    container.classList.add('story-container');
    container.classList.add('card');

    container.innerHTML = `
        <input type="file" name="banner">
        <input type="text" name="title"/>
        <textarea name="content">
    `

    ModalHandler.show(container);
});