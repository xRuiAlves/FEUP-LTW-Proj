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
            
            ${story.story_img ? `<img class="banner" src="${story.story_img}" width="${story.story_img_width}" height="${story.story_img_height}"/> ` : ''}
            <div class="content">
                <p class="title">${story.story_title}<p>
                <p class="text">${story.story_content}<p>
                <footer class="story-details">
                    <div class="author">
                        <img class="profile-image" src="${story.user_img_small}"/>
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
            let commentsWrapper = document.createElement('DIV');
            if(comments.length > 0){
                commentsWrapper.classList.add('comments');
                commentsWrapper.innerHTML = 'Comments';
                for(let comment of comments){
                    commentsWrapper.appendChild(this.generateCommentElement(comment));
                }
                elem.appendChild(commentsWrapper);
            }
            if(g_appState.user_username){
                elem.appendChild(this.generateCommentCreator(story.votable_entity_id, commentsWrapper));
            }
        })
        .catch(info => console.error(info));
    }

    generateCommentElement(comment){
        let commentContainer = document.createElement('DIV');
        commentContainer.classList.add('comment-container');
        commentContainer.innerHTML = `
            <img src="${comment.user_img_small}">
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

    generateCommentCreator(storyId, commentsWrapperDiv){
        let elem = document.createElement('DIV');
        elem.classList.add('comment-creator');
        elem.innerHTML = `
            <textarea placeholder="Write a comment!"></textarea>
            <button>Submit!</button>
        `
        elem.querySelector('button').addEventListener('click', () => {
            this.submitComment(storyId, elem.querySelector('textarea').value, commentsWrapperDiv);
        });
        return elem;
    }

    async submitComment(parentId, content, commentsWrapperDiv){
        let formdata = new FormData();
        formdata.append('parent_entity_id', parentId);
        formdata.append('comment_content', content);

        let response = await fetch('api/comment/create', {method:'POST', body: formdata}).then(
            res => ({code: res.status == 201, result: res.json()})
        )
        response.result.then(data => {
            commentsWrapperDiv.appendChild(this.generateCommentElement(data))
        });
    }

    showFullStory(story){
        ModalHandler.show(this.generateFullStoryElem(story));
    }
}