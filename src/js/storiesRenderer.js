export default class StoriesRenderer{

    get STORY_TARGET_WIDTH() { return 620 }
    
    constructor(){
        this.DOMColumns = {};
        this.displayedStories = {};

        window.addEventListener('resize', this.rerenderStories.bind(this));
    }

    clear(){
        this.DOMColumns = {};
        for(let parentElement of Object.keys(this.displayedStories)){
            this.displayedStories[parentElement] = [];
        }
    }

    rerenderStories(force){
        for(let targetElementId in this.displayedStories){
            this.displayStories(this.displayedStories[targetElementId], targetElementId, true, force);
        }
    }

    displayStories(stories, targetElementId, rerendering, forceRerender){

        if(this.DOMColumns[targetElementId] === undefined){
            this.DOMColumns[targetElementId] = [];
            this.displayedStories[targetElementId] = [];
        }

        if(!rerendering){
            this.displayedStories[targetElementId].push(...stories);
        }

        let targetDOM = document.getElementById(targetElementId);
        let columnAmount = Math.ceil(targetDOM.offsetWidth / this.STORY_TARGET_WIDTH);

        if(rerendering && columnAmount === this.DOMColumns[targetElementId].length && !forceRerender){
            return;
        }

        if(columnAmount !== this.DOMColumns[targetElementId].length || forceRerender){
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
            elem.addEventListener('click', (e) => {this.showFullStory(story)});
            this.getMinimumSizedDOMColumn(this.DOMColumns[targetElementId]).appendChild(elem);

            let banner;
            if(banner = elem.querySelector('img.banner')){
                banner.style.height = banner.offsetWidth * (story.story_img_height/story.story_img_width) + "px";
            }    
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
        let storyContainer = document.createElement('DIV');
        storyContainer.className = 'card story-container';
        storyContainer.innerHTML = `
            
            ${story.story_img ? `<img class="banner" alt="Story picture" src="${g_root_path + story.story_img}"/> ` : ''}
            <div class="content">
                <p class="title"></p>
                <p class="date">${this.getStringFromDate(story.votable_entity_creation_date)}</p>
                <p class="text"></p>
                <footer class="story-details">
                    <div class="author">
                        <img class="profile-image" src="${g_root_path + story.user_img_small}" alt="Creator user picture"/>
                        <span class="author-name">${story.user_username}</span>
                    </div>
                    <div class="reactions">
                        <span class="n-replies"><span class="counter">${story.num_comments || 0}</span><i class="fas fa-comment"></i></span>
                        <span class="n-upvotes ${story.hasupvoted ? 'active' : ''}"><span class="counter">${story.upvotes || 0}</span><i class="fas fa-arrow-up"></i></span>
                        <span class="n-downvotes ${story.hasdownvoted ? 'active' : ''}"><span class="counter">${story.downvotes || 0}</span><i class="fas fa-arrow-down"></i></span>
                    </div>
                </footer>
            </div>`

        storyContainer.querySelector('.title').textContent = story.story_title;
        storyContainer.querySelector('.text').textContent = story.story_content;

        let upvotes = storyContainer.querySelector('.reactions .n-upvotes');
        let downvotes = storyContainer.querySelector('.reactions .n-downvotes');
        let author = storyContainer.querySelector('.story-details .author');
        upvotes.addEventListener('click', (e) => {e.stopPropagation(); this.voteEntity(story, upvotes, downvotes, true, 'story')});
        downvotes.addEventListener('click', (e) => {e.stopPropagation(); this.voteEntity(story, upvotes, downvotes, false, 'story')});
        author.addEventListener('click', (e) => {e.stopPropagation(); openUserProfile(story.user_id)});
        return storyContainer;
    }

    generateFullStoryElem(story){
        let elem = this.generateStoryElem(story);

        request({url:'api/index.php/story/info',
            content: {id: story.votable_entity_id}
        }).then(fullStory => {
            elem.querySelector('p.text').textContent = fullStory.story_content;
            this.appendCommentsDiv(fullStory, elem, story);
        }).catch(info => console.error(info));

        return elem;
    }

    appendCommentsDiv(story, elem, storyPreview, isComment){
        request({url: `api/index.php/${isComment ? 'comment' : 'story'}/comments`, content: {id: story.votable_entity_id}})
        .then(comments => {
            let commentsWrapper = document.createElement('DIV');
            commentsWrapper.classList.add('comments');
            for(let c = comments.length - 1; c >= 0; c--){
                commentsWrapper.appendChild(this.generateCommentElement(comments[c], isComment));
            }
            elem.appendChild(commentsWrapper);
            if(g_appState.user_username){
                elem.appendChild(this.generateCommentCreator(story.votable_entity_id, elem, storyPreview, isComment));
            }
        })
        .catch(info => console.error(info));
    }

    generateCommentElement(comment, hideReplies){
        let commentContainer = document.createElement('DIV');
        commentContainer.classList.add('comment-container');
        commentContainer.innerHTML = `
            <div class="comment">
                <img src="${g_root_path + comment.user_img_small}" alt="Creator user picture">
                <p class="username"></p>
                <p class="content"></p>
            </div>
            <div class="reactions">
                ${hideReplies ? '' : `<span class="n-replies"><span class="counter">${comment.num_comments || 0}</span> replies</span>`}
                <span class="n-upvotes ${comment.hasupvoted ? 'active' : ''}"><span class="counter">${comment.upvotes || 0}</span><i class="fas fa-arrow-up"></i></span>
                <span class="n-downvotes ${comment.hasdownvoted ? 'active' : ''}"><span class="counter">${comment.downvotes || 0}</span><i class="fas fa-arrow-down"></i></span>
                <span class="date">${this.getStringFromDate(comment.votable_entity_creation_date)}</span>
            </div>
        `;
        commentContainer.querySelector('.username').textContent = comment.user_username;
        commentContainer.querySelector('.content').textContent = comment.comment_content;

        let upvotes = commentContainer.querySelector('.reactions .n-upvotes');
        let downvotes = commentContainer.querySelector('.reactions .n-downvotes');
        let authorImg = commentContainer.querySelector('.comment img');
        let authorUsername = commentContainer.querySelector('.comment .username');
        upvotes.addEventListener('click', () => this.voteEntity(comment, upvotes, downvotes, true, 'comment'));
        downvotes.addEventListener('click', () => this.voteEntity(comment, upvotes, downvotes, false, 'comment'));
        authorImg.addEventListener('click', () => openUserProfile(comment.user_id));
        authorUsername.addEventListener('click', () => openUserProfile(comment.user_id));
        if(!hideReplies) {
            let replies = commentContainer.querySelector('.reactions .n-replies');
            replies.addEventListener('click', () => {
                replies.style.pointerEvents = 'none';
                this.appendCommentsDiv(comment, commentContainer, null, true);
            });
        }

        return commentContainer;
    }

    generateCommentCreator(storyId, storyDiv, storyPreview, hideReplies){
        let elem = document.createElement('DIV');
        elem.classList.add('comment-creator');
        elem.innerHTML = `
            <textarea placeholder="Write a comment!"></textarea>
            <button>Submit!</button>
        `
        elem.querySelector('button').addEventListener('click', () => {
            this.submitComment(storyId, elem.querySelector('textarea').value, storyDiv, storyPreview, hideReplies);
        });
        return elem;
    }

    async submitComment(parentId, content, storyDiv, storyPreview, hideReplies){
        let body = {
            ['parent_entity_id']: parentId,
            ['comment_content']: content
        }

        request({url:'api/index.php/comment/create',
                method:'POST',
                content: body})
        .then(data => {
                storyDiv.querySelector('.comments').appendChild(this.generateCommentElement(data, hideReplies));
                storyDiv.querySelector('.comment-creator textarea').value = '';
                storyDiv.querySelector('.reactions .n-replies span.counter').textContent = parseInt(storyDiv.querySelector('.reactions .n-replies span.counter').textContent) + 1;
                if(storyPreview){
                    storyPreview.num_comments = parseInt(storyPreview.num_comments) + 1;
                    this.rerenderStories(true);
                }
            })
        .catch(() => console.log('Cannot comment. Please check your connection'))
            
    }

    showFullStory(story){
        ModalHandler.show(this.generateFullStoryElem(story));
    }

    voteEntity(story, upvoteElement, downvoteElement, upvotingBtnBool, entityType){

        if(!g_appState.user_username){
            showLoginForm();
            return;
        }

        let url;
        let unvoting = false;
        let method = 'PUT';
        if((upvoteElement.classList.contains('active') && upvotingBtnBool) || (downvoteElement.classList.contains('active') && !upvotingBtnBool)){
            url = `api/index.php/${entityType}/unvote`;
            method = 'DELETE';
            unvoting = true;
        }else if(upvotingBtnBool){
            url = `api/index.php/${entityType}/upvote`;
        }else{
            url = `api/index.php/${entityType}/downvote`;
        }

        request({url: url, method: method, content: {[entityType + '_id']: story.votable_entity_id}})
        .then(() => {
                if(unvoting){
                    upvoteElement.classList.remove('active');
                    downvoteElement.classList.remove('active');
                    if(upvotingBtnBool){
                        upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)-1;
                        story.hasupvoted = false;
                        story.upvotes--;
                    }else{
                        downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)-1;
                        story.hasdownvoted = false;
                        story.downvotes--;
                    }
                }else if(upvotingBtnBool){
                    upvoteElement.classList.add('active');
                    upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)+1;
                    story.upvotes++;
                    story.hasupvoted = true;
                    if(downvoteElement.classList.contains('active')){
                        downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)-1;
                        story.hasdownvoted = false;
                        story.downvotes--;
                    }
                    downvoteElement.classList.remove('active');
                }else{
                    downvoteElement.classList.add('active');
                    downvoteElement.querySelector('span.counter').textContent = parseInt(downvoteElement.textContent)+1;
                    story.downvotes++;
                    story.hasdownvoted = true;
                    if(upvoteElement.classList.contains('active')){
                        upvoteElement.querySelector('span.counter').textContent = parseInt(upvoteElement.textContent)-1;
                        story.upvotes--
                        story.hasupvoted = false;
                    }
                    upvoteElement.classList.remove('active');
                }
                this.rerenderStories(true);
            })
        .catch(() => console.log('Could not vote. Please check your connection'))
    }

    getStringFromDate(epochTime){
        let date = new Date(0);
        date.setUTCSeconds(epochTime);
        return date.toISOString().substring(0, 16).replace('T', ', ');
    }
}