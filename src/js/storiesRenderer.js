export default class StoriesRenderer{

    get STORY_TARGET_WIDTH() { return 650 }
    
    constructor(){
        this.DOMColumns = {};
        this.displayedStories = {};

        window.addEventListener('resize', this.rerenderStories.bind(this));
    }

    rerenderStories(){
        for(let targetElementId in this.displayedStories){
            this.displayStories(this.displayedStories[targetElementId], targetElementId, true);
        }
    }

    displayStories(stories, targetElementId, rerendering){

        if(this.DOMColumns[targetElementId] === undefined){
            this.DOMColumns[targetElementId] = [];
            this.displayedStories[targetElementId] = [];
        }

        if(!rerendering){
            this.displayedStories[targetElementId].push(...stories);
        }

        let targetDOM = document.getElementById(targetElementId);
        let columnAmount = Math.ceil(targetDOM.offsetWidth / this.STORY_TARGET_WIDTH);

        if(rerendering && columnAmount === this.DOMColumns[targetElementId].length){
            return;
        }

        if(columnAmount !== this.DOMColumns[targetElementId].length){
            this.DOMColumns[targetElementId] = [];
            while (targetDOM.firstChild) {
                targetDOM.removeChild(targetDOM.firstChild);
            }
            for(let c = 0; c < columnAmount; c++){
                let column = document.createElement('DIV');
                column.className = 'masonry-col';
                column.style.width = (100/columnAmount) + "%";
                targetDOM.appendChild(column);
                this.DOMColumns[targetElementId].push(column);
            }
        }

        for(let story of stories){
            let elem = this.generateStoryElem(story);
            elem.addEventListener('click', () => this.showFullStory(story));
            this.getMinimumSizedDOMColumn(this.DOMColumns[targetElementId]).appendChild(elem);
        }
    }

    getMinimumSizedDOMColumn(columns){
        let minSize = columns[0].offsetHeight;
        let minColumn = columns[0];
        for(let column of columns){
            if(column.offsetHeight < minSize){
                minSize = column.offsetHeight;
                minColumn = column;
            }
        }
        return minColumn;
    }

    generateStoryElem(story){
        var storyContainer = document.createElement('DIV');
        storyContainer.className = 'card story-container';
        storyContainer.innerHTML = `
            ${story.image ? `<img class="banner" src="${story.image}"/> ` : ''}
            <div class="content">
                <p class="title">${story.story_title}<p>
                <p class="text">${story.story_content}<p>
                <footer class="story-details">
                    <div class="author">
                        <img class="profile-image" src="${story.authorImage}"/>
                        <span class="author-name">${story.author}</span>
                    </div>
                    <div class="reactions">
                        <span class="reaction-amount">${story.comments || 0}</span>
                        <span class="reaction-name"><i class="fas fa-comment"></i></span>
                        <span class="reaction-amount">${story.upvotes || 0}</span>
                        <span class="reaction-name"><i class="fas fa-arrow-up"></i></i></span>
                        <span class="reaction-amount">${story.downvotes || 0}</span>
                        <span class="reaction-name"><i class="fas fa-arrow-down"></i></span>
                    </div>
                </footer>
            </div>`
        return storyContainer;
    }

    showFullStory(story){
        ModalHandler.show(this.generateStoryElem(story));
    }
}