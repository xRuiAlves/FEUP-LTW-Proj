export default class StoriesRenderer{

    get STORY_TARGET_WIDTH() { return 620 }
    
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
                        <span class="n-replies"><span class="counter">${story.num_comments || 0}</span><i class="fas fa-comment"></i></span>
                        <span class="n-upvotes ${story.hasupvoted ? 'active' : ''}"><span class="counter">${story.upvotes || 0}</span><i class="fas fa-arrow-up"></i></span>
                        <span class="n-downvotes ${story.hasdownvoted ? 'active' : ''}"><span class="counter">${story.downvotes || 0}</span><i class="fas fa-arrow-down"></i></span>
                    </div>
                </footer>
            </div>`

        let upvotes = storyContainer.querySelector('.reactions .n-upvotes');
        let downvotes = storyContainer.querySelector('.reactions .n-downvotes');
        upvotes.addEventListener('click', () => this.voteEntity(story, upvotes, downvotes, true, 'story'));
        downvotes.addEventListener('click', () => this.voteEntity(story, upvotes, downvotes, false, 'story'));
        
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
            commentsWrapper.classList.add('comments');
            commentsWrapper.innerHTML = 'Comments';
            if(comments.length > 0){
                for(let comment of comments){
                    commentsWrapper.appendChild(this.generateCommentElement(comment));
                }
            }
            elem.appendChild(commentsWrapper);
            if(g_appState.user_username){
                elem.appendChild(this.generateCommentCreator(story.votable_entity_id, elem));
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
                <span class="n-replies"><span class="counter">${comment.num_comments || 0}</span> replies</span>
                <span class="n-upvotes ${comment.hasupvoted ? 'active' : ''}"><span class="counter">${comment.upvotes || 0}</span><i class="fas fa-arrow-up"></i></span>
                <span class="n-downvotes ${comment.hasdownvoted ? 'active' : ''}"><span class="counter">${comment.downvotes || 0}</span><i class="fas fa-arrow-down"></i></span>
            </div>
        `;
        commentContainer.querySelector('.username').textContent = comment.user_username;
        commentContainer.querySelector('.content').textContent = comment.comment_content;

        let upvotes = commentContainer.querySelector('.reactions .n-upvotes');
        let downvotes = commentContainer.querySelector('.reactions .n-downvotes');
        upvotes.addEventListener('click', () => this.voteEntity(comment, upvotes, downvotes, true, 'comment'));
        downvotes.addEventListener('click', () => this.voteEntity(comment, upvotes, downvotes, false, 'comment'));

        return commentContainer;
    }

    generateCommentCreator(storyId, storyDiv){
        let elem = document.createElement('DIV');
        elem.classList.add('comment-creator');
        elem.innerHTML = `
            <textarea placeholder="Write a comment!"></textarea>
            <button>Submit!</button>
        `
        elem.querySelector('button').addEventListener('click', () => {
            this.submitComment(storyId, elem.querySelector('textarea').value, storyDiv);
        });
        return elem;
    }

    async submitComment(parentId, content, storyDiv){
        let formdata = new FormData();
        formdata.append('parent_entity_id', parentId);
        formdata.append('comment_content', content);

        let response = await fetch('api/comment/create', {method:'POST', body: formdata}).then(
            res => ({code: res.status, result: res.json()})
        )
        response.result.then(data => {
            if(response.code == 201){
                storyDiv.querySelector('.comments').appendChild(this.generateCommentElement(data));
                storyDiv.querySelector('.comment-creator textarea').value = '';
            }else{
                console.log('Cannot comment. Please check your connection');
            }
        });
    }

    showFullStory(story){
        ModalHandler.show(this.generateFullStoryElem(story));
    }

    voteEntity(story, upvoteElement, downvoteElement, upvotingBtnBool, entityType){
        let url;
        let unvoting = false;
        let method = 'PUT';
        if((upvoteElement.classList.contains('active') && upvotingBtnBool) || (downvoteElement.classList.contains('active') && !upvotingBtnBool)){
            url = `/api/${entityType}/unvote`;
            method = 'DELETE';
            unvoting = true;
        }else if(upvotingBtnBool){
            url = `/api/${entityType}/upvote`;
        }else{
            url = `/api/${entityType}/downvote`;
        }

        fetch(url, {method: method, body: JSON.stringify({[entityType + '_id']: story.votable_entity_id})})
        .then((res) => {
            if(res.status == 200 || res.status == 201){
                if(unvoting){
                    upvoteElement.classList.remove('active');
                    downvoteElement.classList.remove('active');
                    if(upvotingBtnBool){
                        upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)-1;
                    }else{
                        downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)-1;
                    }
                }else if(upvotingBtnBool){
                    upvoteElement.classList.add('active');
                    upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)+1;
                    if(downvoteElement.classList.contains('active')){
                        downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)-1;
                    }
                    downvoteElement.classList.remove('active');
                }else{
                    downvoteElement.classList.add('active');
                    downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)+1;
                    if(upvoteElement.classList.contains('active')){
                        upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)-1;
                    }
                    upvoteElement.classList.remove('active');
                }
            }else{
                console.log('Unable to vote on entity')
            }
        })
    }
}