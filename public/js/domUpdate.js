function removePostElement(btn) {
    const post = btn.closest('.removeCard');
    if (!post) return;

    post.classList.add('removing');

    setTimeout(() => {
        post.remove();
    }, 400);
}

function updateReactionButtons(btn, data) {

    const container = btn.closest('.cardReactions');

    if (!container) return;

    const likeBtn = container.querySelector('[data-reaction-type="like"]');
    const dislikeBtn = container.querySelector('[data-reaction-type="dislike"]');

    const likeIcon = likeBtn.querySelector('i');
    const dislikeIcon = dislikeBtn.querySelector('i');

    const likeCount = likeBtn.querySelector('.js-like-count');
    const dislikeCount = dislikeBtn.querySelector('.js-dislike-count');

    likeIcon.className = 'fa-regular fa-thumbs-up';
    dislikeIcon.className = 'fa-regular fa-thumbs-down';

    if (data.current_reaction === 'like') {
        likeIcon.className = 'fa-solid fa-thumbs-up';
    }

    if (data.current_reaction === 'dislike') {
        dislikeIcon.className = 'fa-solid fa-thumbs-down';
    }

    likeCount.textContent = data.likes_count;
    dislikeCount.textContent = data.dislikes_count;
}

function updateFollowButton(btn, status) {
    let text = 'Follow';
    let action = 'follow';

    if (status === 'active') {
        text = 'Unfollow';
        action = 'unfollow';
    }

    else if (status === 'request') {
        text = 'Requested';
        action = 'unfollow';
    }

    else if (status === 'left' || status === 'cancelled' || status === 'none') {
        text = 'Follow';
        action = 'follow';
    }

    btn.textContent = text;
    btn.dataset.action = action;
}

function updatePinButton(btn, isPinned) {

    const icon = btn.querySelector('i');
    const text = btn.querySelector('span');

    if (isPinned) {

        text.textContent = 'Unpin';

        icon.classList.remove('fa-thumbtack');
        icon.classList.add('fa-thumbtack-slash');

        btn.dataset.url = btn.dataset.unpinUrl;

    } else {

        text.textContent = 'Pin';

        icon.classList.remove('fa-thumbtack-slash');
        icon.classList.add('fa-thumbtack');

        btn.dataset.url = btn.dataset.pinUrl;
    }
}

function updateBanButton(btn, wasBanned) {

    const icon = btn.querySelector('i');
    const text = btn.querySelector('span');

    const isNowBanned = !wasBanned;

    btn.dataset.isBanned = isNowBanned ? "1" : "0";

    if (isNowBanned) {
        
        icon.className = 'fa-solid fa-user-check';
        text.textContent = 'Unban User';

        btn.dataset.url = btn.dataset.url.replace('/ban', '/unban');

    } else {
        icon.className = 'fa-solid fa-user-slash';
        text.textContent = 'Ban User';

        btn.dataset.url = btn.dataset.url.replace('/unban', '/ban');
    }
}

function createReplyForm(commentId) {

    return `
        <form class="commentForm js-form-action"
            data-method="POST"
            data-behaviour="createReply">

            <input type="hidden" name="parent_comment_id" value="${commentId}">

            <textarea name="content" class="textareaField"
                placeholder="Write a reply..."></textarea>

            <div class="formActions">
                <button type="submit" class="primaryBtn">
                    Reply
                </button>
            </div>

        </form>
    `;
}

function createCommentCard(comment, permissions, depth = 0) {

    return `
        <article 
            class="commentCard"
            data-id="${comment.id}"
            data-post-id="${comment.post_id}"
            data-depth="${depth}">
            <div class="commentTop">
                    <a href="/profile/${comment.user.username}">
                        <img
                            class="postImage"
                            src="/storage/uploads/${comment.user.profile_pic}"
                            alt="">
                    </a>

                    <div class="commentMeta">

                        <a
                            href="/profile/${comment.user.username}"
                            class="commentUsername">

                            u/${comment.user.username}

                            ${permissions?.op ? `
                                <span class="commentOp">OP</span>
                                ` : ''}

                        </a>

                        <span class="cardDate">
                            just now
                        </span>

                    </div>

            </div>

            <div class="commentBottom">
                <div class="commentContent">

                    ${comment.content}

                </div>



                <div class="commentActions cardReactions">

                    <button type="button" class="commentActionBtn js-fetch-action"
                        data-method="POST"
                        data-url="/comments/${comment.id}/react"
                        data-behaviour="reactionToggle"
                        data-reaction-type="like">
                        <i class="fa-regular fa-thumbs-up"></i>
                        <span class="js-like-count">0</span>
                    </button>

                    <button class="commentActionBtn js-fetch-action"
                        data-method="POST"
                        data-url="/comments/${comment.id}/react"
                        data-behaviour="reactionToggle"
                        data-reaction-type="dislike">
                        <i class="fa-regular fa-thumbs-down"></i>
                        <span class="js-dislike-count">0</span>
                    </button>

                    <button
                        class="commentActionBtn js-comment-action" data-behaviour="toggleReply"
                        data-comment-id="${comment.id}">

                        <i class="fa-solid fa-reply"></i>
                        <span>Reply</span>

                    </button>

                                    ${
                        permissions?.delete_user ||
                        permissions?.delete_admin
                        ?
                        `
                            <div class="dropdownContainer">

                                <button class="dropdown-btn buttonReset dropdown-btnDesign">
                                    ⋯
                                </button>

                                <div class="dropdownMenu">

                                    ${
                                        permissions?.delete_user
                                        ?
                                        `
                                            <button
                                                type="button"
                                                class="dropdownItem buttonReset js-comment-action" data-behaviour="openEdit"
                                                data-url="/comments/${comment.id}/update"
                                                data-method="PATCH">

                                                <i class="fa-regular fa-pen-to-square"></i>
                                                <span>Edit</span>

                                            </button>

                                            <button
                                                type="button"
                                                class="dropdownItem buttonReset js-fetch-action"
                                                data-url="/comments/${comment.id}/delete"
                                                data-method="DELETE"
                                                data-delete-type="user"
                                                data-behaviour="deleteComment">

                                                <i class="fa-regular fa-trash-can"></i>
                                                <span>Delete</span>

                                            </button>
                                        `
                                        :
                                        ''
                                    }

                                    ${
                                        permissions?.delete_admin
                                        ?
                                        `
                                            <button
                                                type="button"
                                                class="dropdownItem buttonReset js-fetch-action"
                                                data-url="/comments/${comment.id}/delete"
                                                data-method="DELETE"
                                                data-delete-type="admin"
                                                data-behaviour="deleteComment">

                                                <i class="fa-regular fa-trash-can"></i>
                                                <span>Remove</span>

                                            </button>
                                        `
                                        :
                                        ''
                                    }

                                </div>

                            </div>
                        `
                        :
                        ''
                    }

                </div>
            <div

            <div class="commentReplyFormContainer"></div>

            <div class="commentReplies"></div>

        </article>

    `;
}

function deleteComment(btn, data) {

    const commentCard = btn.closest('.commentCard');
    const dropdown = btn
    
    if (!commentCard) return;

    const content = commentCard.querySelector('.commentContent');

    content.innerHTML = `
        <p class="commentDeleted">
            ${data.delete_type == 'admin' ? '[ removed by admin ]' : '[ deleted by user ]'}
        </p>
    `;

    const openMenu = btn.closest('.dropdownMenu.show');

    if (openMenu) {
        openMenu.classList.remove('show');
    }

}

function editComment(content, updateUrl) {

    return `
        <textarea class="textareaField js-edit-textarea">${content}</textarea>

        <div class="formActions">

            <button
                type="button"
                class="primaryBtn js-fetch-action"
                data-url="${updateUrl}"
                data-method="PATCH"
                data-behaviour="updateComment">

                Save

            </button>

            <button
                type="button"
                class="primaryBtn js-comment-action" data-behaviour="cancelEdit">

                Cancel

            </button>

        </div>
    `;
}

function showAlert(message, status = 'error') {
    const container = document.getElementById('jsAlertContainer');

    container.innerHTML = `
        <div class="alert_animation alert_messages alert_${status}">
            ${message}
        </div>
    `;

    setTimeout(() => {
        container.innerHTML = '';
    }, 4000);
}