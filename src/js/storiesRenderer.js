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
            
            ${story.story_img ? `<img class="banner" src="${story.story_img}"/> ` : ''}
            <div class="content">
                <p class="title">${story.story_title}<p>
                <p class="text">${story.story_content}<p>
                <footer class="story-details">
                    <div class="author">
                        <img class="profile-image" src="${story.user_img}"/>
                        <span class="author-name">${story.user_username}</span>
                    </div>
                    <div class="reactions">
                        <span class="reaction-amount">${story.num_comments || 0}</span>
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

    generateFullStoryElem(story){
        let elem = this.generateStoryElem(story);

        fetch('api/story/info?id=' + story.votable_entity_id)
        .then(res => res.json()).then(fullStory => {
            elem.querySelector('p.text').textContent = fullStory.story_content;
            this.appendCommentsDiv(fullStory, elem);
        })
        .catch(info => console.error(info));

        return elem;
    }

    appendCommentsDiv(story, elem){
        fetch('api/story/comments?id=' + story.votable_entity_id)
        .then(res => res.json()).then(comments => {
            if(comments.length > 0){
                let commentsWrapper = document.createElement('DIV');
                commentsWrapper.classList.add('comments');
                commentsWrapper.innerHTML = 'Comments';
                for(let comment of comments){
                    commentsWrapper.appendChild(this.generateCommentElement(comment));
                }
                elem.appendChild(commentsWrapper);
            }
            elem.appendChild(this.generateCommentCreator());
        })
        .catch(info => console.error(info));
    }

    generateCommentElement(comment){
        let commentContainer = document.createElement('DIV');
        commentContainer.classList.add('comment-container');
        commentContainer.innerHTML = `
            <img src="">
            <div class="comment">
                <p class="username"></p>
                <p class="content"></p>
            </div>
            <div class="reactions">
                <span class="n-replies">${comment.num_comments || 0} replies</span>
                <span class="n-upvotes">${comment.upvotes || 0}<i class="fas fa-arrow-up"></i></span>
                <span class="n-downvotes">${comment.downvotes || 0}<i class="fas fa-arrow-down"></i></span>
            </div>
        `;
        commentContainer.querySelector('.username').textContent = comment.user_username;
        commentContainer.querySelector('.content').textContent = comment.comment_content;
        return commentContainer;
    }

    generateCommentCreator(storyId){
        let elem = document.createElement('DIV');
        elem.classList.add('comment-creator');
        elem.innerHTML = `
            <textarea placeholder="Write a comment!"></textarea>
            <button>Submit!</button>
        `
        elem.querySelector('button').addEventListener('click', () => {
            //send comment creation request with storyId
        });
        return elem;
    }

    showFullStory(story){
        ModalHandler.show(this.generateFullStoryElem(story));
    }
}