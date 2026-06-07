document.addEventListener('click', async (e) => {

    const clickedBtn = e.target.closest('.js-fetch-action');
    if (clickedBtn) {
        e.preventDefault();
        await handleAction(clickedBtn);
        return;
    }




    const commentBtn = e.target.closest('.js-comment-action');
    if (commentBtn) {
        const commentCard = commentBtn.closest('.commentCard');
        const behaviour = commentBtn.dataset.behaviour;

        
        if(behaviour == 'closeCommentBody') {
            const commentBottom = commentCard.querySelector('.commentBottom');
            const commentImage = commentCard.querySelector('.commentImageContainer');

            commentBottom.classList.toggle('isHidden');
            commentImage.classList.toggle('nonVisible');
            commentCard.classList.toggle('openComment');
            
        }

        if(behaviour == 'toggleReply') {

            const commentId = Number(commentCard.dataset.id);
            const postId = Number(commentCard.dataset.postId);

            const commentDepth = Number(commentCard.dataset.depth);

            if(commentDepth > 3) {
                window.location.href = `/posts/${postId}/comments/${commentId}`;
                return;
            }

            let container = commentCard.querySelector('.commentReplyFormContainer');

            if (container.querySelector('form')) {
                container.innerHTML = '';
                return;
            };

            container.innerHTML = createReplyForm(commentId);
        }

        if(behaviour === 'openEdit') {
            const content = commentCard.querySelector('.commentContent');
            const oldContent = content.textContent.trim();

            commentCard.dataset.oldContent = oldContent;

            const updateUrl = commentBtn.dataset.url;

            content.innerHTML = editComment(oldContent, updateUrl);

            const comActions = commentCard.querySelector('.commentActions');

            if (comActions) {
                comActions.classList.add('isHidden');
            }
        }

        if (behaviour === 'cancelEdit') {
            const oldContent = commentCard.dataset.oldContent;

            const contentElement = commentCard.querySelector('.commentContent');

            contentElement.innerHTML = oldContent;

            const replies = commentCard.querySelector('.commentActions');

            if (replies) {
                replies.classList.remove('isHidden');
            }
        }
    };



    const pinnedBtn = e.target.closest('.pinnedBtn');
    if(pinnedBtn) {
        const pinnedPostContainer = pinnedBtn.closest('.pinnedPostsContainer');
        const pinnedContent = pinnedPostContainer.querySelector('.pinnedPosts');

        pinnedContent.classList.toggle('isHidden');
        pinnedBtn.classList.toggle('openPinned');
    }




    if (e.target.classList.contains('js-reveal-btn')) {
        const postCard = e.target.closest('.postCard');

        postCard.classList.remove('is-sensitive');

        const overlay = postCard.querySelector('.js-sensitive-overlay');
        if (overlay) overlay.remove();

        const content = postCard.querySelector('.js-post-content');
        if (content) {
            content.style.filter = 'none';
            content.style.pointerEvents = 'auto';
            content.style.userSelect = 'auto';
        }
    }
});




async function handleAction(btn) {

    const url = btn.dataset.url;
    const method = btn.dataset.method;
    const behaviour = btn.dataset.behaviour;

    btn.disabled = true;

    try {

        const payload = {};

        if (btn.dataset.action) {
            payload.action = btn.dataset.action;
        }

        if (btn.dataset.reactionType) {
            payload.reaction_type = btn.dataset.reactionType;
        }

        if (btn.dataset.deleteType) {
            payload.delete_type = btn.dataset.deleteType;
        }

        if (behaviour === 'updateComment') {

            const commentCard = btn.closest('.commentCard');

            const textarea =
                commentCard.querySelector('.js-edit-textarea');

            const content = textarea.value.trim();

            payload.content = content;
        }

        const data = await ajax(url, method, payload);

        if (data.status === 'error') {
            showAlert(data.message || 'Something went wrong.', data.status);
            return;
        }

        if (data.status === 'success') {
            showAlert(data.message || 'Success.', data.status);
            if(behaviour === 'remove') {
                removePostElement(btn);
            }

            if(behaviour === 'deleteComment') {
                deleteComment(btn, data);
            }

            if (behaviour === 'reactionToggle') {
                updateReactionButtons(btn, data);
            }

            if(behaviour === 'followButton') {
                updateFollowButton(btn, data.button_status);
            }

            if(behaviour === 'pinToggle') {
                updatePinButton(btn, data.is_pinned);
            }

            if (behaviour === 'banToggle') {
                updateBanButton(btn, btn.dataset.isBanned === "1");
            }

            if(behaviour === 'updateComment') {
                const commentCard = btn.closest('.commentCard');
                if (commentCard) {
                    const contentEl = commentCard.querySelector('.commentContent');

                    contentEl.innerHTML = data.comment.content;

                    const actions = commentCard.querySelector('.commentActions');

                    actions?.classList.remove('isHidden');
                };
            }
        }
    } catch (err) {
        console.error(err);
        alert(err.message);
    } finally {
        btn.disabled = false;
    }
}




async function ajax(url, method = 'GET', data = null) {

    const options = {
        method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    };

    if (data instanceof FormData) {
        options.body = data; 
    } else {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(data);
    }

    const response = await fetch(url, options);
    const result = await response.json();

    return result;
}


