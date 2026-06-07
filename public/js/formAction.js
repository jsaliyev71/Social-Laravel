
document.addEventListener('submit', async (e) => {

    const form = e.target;
    const behaviour = form.dataset.behaviour;
    const method = form.dataset.method;

    
    if (
        form.classList.contains('js-form-action') &&
        (behaviour === 'createComment' ||
        behaviour === 'createReply')
    ) {
        e.preventDefault();

        const commentsSection = document.querySelector('.commentsSection');
        const url = commentsSection.dataset.url;

        const formData = new FormData(form);

        const parentId = formData.get('parent_comment_id');

        if (parentId === 'undefined' || parentId === '' || parentId === null) {
            formData.delete('parent_comment_id');
        }

        try {

            const data = await ajax(url, method, formData);

            if (data.status === 'error') {
                showAlert(data.message || 'Something went wrong.', data.status);
                return;
            }

            if(data.status === 'success') {
                showAlert(data.message || 'Success.', data.status);
                if(behaviour === 'remove') {
                    removePostElement(btn);
                }

                const comment = data.comment;
                const permissions = data.permissions;

                if(behaviour === 'createComment') {
                    const commentsList = document.querySelector('.js-comment-list');
                    const emtpyState = commentsList.querySelector('.emptyComments');

                    if(emtpyState) emtpyState.remove();

                    commentsList.insertAdjacentHTML('afterbegin', createCommentCard(comment, permissions));
                }

                if (behaviour === 'createReply') {

                    const parentComment = form.closest('.commentCard');
                    const parentDepth = Number(parentComment.dataset.depth);
                    const commentId = Number(parentComment.dataset.id);
                    const postId = Number(parentComment.dataset.postId);

                    if(parentDepth > 3) {
                        window.location.href = `posts/${postId}/comments/${commentId}`;
                        return;
                    }

                    const newDepth = parentDepth + 1;

                    if(parentComment) {
                        const repliesContainer = parentComment.querySelector('.commentReplies');

                        if(repliesContainer) {
                            repliesContainer.insertAdjacentHTML('afterbegin', createCommentCard(comment, permissions, newDepth));
                        }
                    }

                    let container = parentComment.querySelector('.commentReplyFormContainer');
                    container.innerHTML = '';
                }

                form.reset();
            }

        } catch (error) {
            console.error(error);
        }
    }
});