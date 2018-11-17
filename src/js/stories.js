var sampleStory = {
    image: 'https://images.pexels.com/photos/33109/fall-autumn-red-season.jpg?cs=srgb&dl=road-nature-forest-33109.jpg&fm=jpg',
    title: 'Yo listen up here\'s the story about a little guy that lives in a blue world',
    text: 'And all day and all night and everything he sees is just blue like him, inside and outside. Blue his house with a blue little window and a blue Corvette and everything is blue for him and himself and everybody around cause he ain\'t got nobody to listen',
    author: 'Eiffel 65',
    comments: '100',
    upvotes: '12',
    downvotes: '3',
    authorImage: './images/default_profile.png'
}

function displayStories(stories, targetElementId){
    var targetDOM = document.getElementById(targetElementId);
    for(let story of stories){
        targetDOM.appendChild(generateStoryElem(story));
    }
}

function generateStoryElem(story){
    var storyContainer = document.createElement('DIV');
    storyContainer.className = 'story-container';
    storyContainer.innerHTML = `
        ${story.image ? `<img class="banner" src="${story.image}"/> ` : ''}
        <div class="content">
            <p class="title">${story.title}<p>
            <p class="text">${story.text}<p>
            <footer class="story-details">
                <div class="author">
                    <img class="profile-image" src="${story.authorImage}"/>
                    <span class="author-name">${story.author}</span>
                </div>
                <div class="reactions">
                    <span class="reaction-amount">${story.comments}</span>
                    <span class="reaction-name">comments</span>
                    <span class="reaction-amount">${story.upvotes}</span>
                    <span class="reaction-name">upvotes</span>
                    <span class="reaction-amount">${story.downvotes}</span>
                    <span class="reaction-name">downvotes</span>
                </div>
            </footer>
        </div>`
    return storyContainer;
}