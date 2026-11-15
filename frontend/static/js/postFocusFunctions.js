// Adds a click handler to the loaded posts
function addPostClickEvent(postElement, postInfo) {
    postElement.addEventListener('click', (e) => {
        // Don't open it if an interaction button was clicked
        if (e.target.closest('.interactive')) {
            return;
        }

        // Open the post focus view
        const postFocus = document.querySelector('.container-post-focus');
        if (postFocus) {
            postFocus.classList.remove('d-none');

            // Load the post's info into the focus view
            loadPostInFocus(postInfo.id);
        }
    });
}

// Fetches a post by ID
async function getPostById(postId) {
    try {
        const token = localStorage.getItem("jwt_token");
        if (!token) {
            console.error("Token not found");
            return null;
        }

        const response = await fetch(`/api/getPostById?post_id=${postId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            console.error("Request error:", response.status);
            return null;
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error fetching post:", error);
        return null;
    }
}

// Loads the post's info into the focus container
async function loadPostInFocus(postId) {
    try {
        const result = await executeWithRefresh(getPostById, postId);

        if (result && result.status === "success") {
            document.querySelector(".container-post-focus").dataset.postId = result.data.id
            // Update the post focus content
            updatePostFocusContent(result.data);
        } else {
            console.error("Error loading post:", result);
        }
    } catch (error) {
        console.error("Post request error:", error);
    }
}

// Updates the post focus content
function updatePostFocusContent(postData) {
    // Update the author's name
    const nameElement = document.querySelector('.post-focus .name-text strong');
    if (nameElement) {
        nameElement.textContent = postData.author_name || 'Usuário';
    }

    // Update the author's role
    const roleElement = document.querySelector('.post-focus .badge');
    if (roleElement) {
        const roleText = postData.role === 'estudante' ? 'Aluno' : 'Professor';
        roleElement.textContent = roleText;
        const roleColor = postData.role === 'estudante' ? '#9F2A20' : '#1F4FB8';
        roleElement.style.backgroundColor = roleColor;
    }

    // Atualizar ETEC
    const etecElement = document.querySelector('.post-focus .sub-text');
    if (etecElement && postData.campus && postData.campus.length > 0) {
        etecElement.textContent = postData.campus[0].name || 'ETEC';
    }

    // Update the post content
    const contentElement = document.querySelector('.post-focus #textPost');
    if (contentElement) {
        contentElement.textContent = postData.content || 'Conteúdo não disponível';
    }

    // Update the post media
    updatePostFocusMedia(postData.media || []);

    // Atualizar contadores
    const likeCountElement = document.querySelector('.post-focus #qntLikes');
    if (likeCountElement) {
        likeCountElement.textContent = postData.total_likes || 0;
    }

    const commentCountElement = document.querySelector('.post-focus #qntComments');
    if (commentCountElement) {
        commentCountElement.textContent = postData.comments_count || 0;
    }

    // Update the profile picture
    updatePostFocusProfilePhoto(postData);

    // Set up likes in the post focus view
    setupPostFocusLike(postData);

    // Load the post's comments
    loadCommentsForPost(postData.id);
}

// Updates the profile picture in the post focus view
function updatePostFocusProfilePhoto(postData) {
    console.log("updatePostFocusProfilePhoto")
    console.log(postData)
    const profilePhoto = document.querySelector('#profile-photo-post-focus');
    if (!profilePhoto) return;

    const profilePath = postData.profile_photo_path;
    const authorName = postData.author_name || 'Usuário';
    const roleColor = postData.role === 'estudante' ? '#9F2A20' : '#1F4FB8';

    if (profilePath) {
        profilePhoto.style.backgroundImage = `url(${profilePath})`;
        profilePhoto.style.backgroundColor = 'transparent';
        profilePhoto.style.backgroundSize = 'cover';
        profilePhoto.style.backgroundPosition = 'center';
        profilePhoto.style.backgroundRepeat = 'no-repeat';
    } else {
        profilePhoto.style.backgroundColor = roleColor;
        profilePhoto.textContent = getProfileLetter(authorName);
        profilePhoto.style.color = 'white';
        profilePhoto.style.display = 'flex';
        profilePhoto.style.alignItems = 'center';
        profilePhoto.style.justifyContent = 'center';
        profilePhoto.style.fontWeight = 'bold';
        profilePhoto.style.fontSize = '16px';
    }
}



// Closes the post focus view
function closePostFocus() {
    const container = document.querySelector('.container-post-focus');
    if (container) {
        container.classList.add('d-none');
    }
}

function setupPostFocusLike(postData) {
    const likeBtn = document.querySelector('.post-focus .like-post');
    if (!likeBtn) {
        console.error('Like button not found in the post focus view');
        return;
    }

    // Add a dataset with the post's info
    likeBtn.dataset.postId = postData.id;
    likeBtn.dataset.totalLikes = postData.total_likes || 0;
    likeBtn.dataset.userLiked = postData.user_liked || 0;

    // Set the like's initial visual state
    updatePostFocusLikeUI(postData.user_liked === 1);

    // Add a click handler to the like button
    likeBtn.addEventListener('click', handlePostFocusLike);
}

// Updates the like UI in the post focus view
function updatePostFocusLikeUI(isLiked) {
    const likeBtn = document.querySelector('.post-focus .like-post');
    if (!likeBtn) return;

    if (isLiked) {
        // Post curtido - SVG preenchido
        likeBtn.classList.add('liked');
        likeBtn.innerHTML = `
            <svg xmlns="http://http://www.w3.org/2000/svg" width="16" height="16" fill="#9F2A20" viewBox="0 0 16 16">
                <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
            </svg>
            <span id="qntLikes">${likeBtn.dataset.totalLikes || 0}</span>
        `;
        likeBtn.dataset.userLiked = '1';
    } else {
        // Post not liked - empty SVG
        likeBtn.classList.remove('liked');
        likeBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
            </svg>
            <span id="qntLikes">${likeBtn.dataset.totalLikes || 0}</span>
        `;
        likeBtn.dataset.userLiked = '0';
    }
}

// Handles the like in the post focus view
async function handlePostFocusLike(e) {
    e.preventDefault();
    e.stopPropagation();

    const likeBtn = e.currentTarget;
    const postId = likeBtn.dataset.postId;
    const isLiked = likeBtn.dataset.userLiked === '1';
    const postContainer = document.querySelector(`.post[data-post-id='${postId}']`);

    if (!postId) return;

    try {
        if (isLiked) {
            // Remover like
            const result = await executeWithRefresh(deleteLike, 'post', postId);
            if (result.status === 'success') {
                // Atualizar UI
                updatePostFocusLikeUI(false);

                // Atualizar contador
                const currentCount = parseInt(likeBtn.dataset.totalLikes);
                const newCount = Math.max(0, currentCount - 1);
                likeBtn.dataset.totalLikes = newCount;
                changeFrontLike(postContainer, false);
                const likeCountElement = document.querySelector('.post-focus #qntLikes');
                if (likeCountElement) {
                    likeCountElement.textContent = newCount;
                }


            }
        } else {
            // Adicionar like
            const result = await executeWithRefresh(addLike, 'post', postId);
            if (result.status === 'success') {
                // Atualizar UI
                updatePostFocusLikeUI(true);
                changeFrontLike(postContainer, true);
                // Atualizar contador
                const currentCount = parseInt(likeBtn.dataset.totalLikes);
                const newCount = currentCount + 1;
                likeBtn.dataset.totalLikes = newCount;

                const likeCountElement = document.querySelector('.post-focus #qntLikes');
                if (likeCountElement) {
                    likeCountElement.textContent = newCount;
                }


            }
        }
    } catch (error) {
        console.error('Error handling like:', error);
    }
}

// Updates the media in the post focus view
function updatePostFocusMedia(mediaArray) {
    const mediaContainer = document.querySelector('#postFocusMedia');
    const mediaContent = document.querySelector('#postFocusMediaContainer');

    if (!mediaContainer || !mediaContent) return;

    // Clear the previous media
    mediaContent.innerHTML = '';

    if (mediaArray && mediaArray.length > 0) {
        // Show the media container
        mediaContainer.classList.remove('d-none');

        // Add each media item
        mediaArray.forEach(media => {
            if (media.media_type === 'video') {
                const videoElement = document.createElement('video');
                videoElement.src = media.media_url;
                videoElement.controls = true;
                videoElement.className = 'post-focus-video';
                mediaContent.appendChild(videoElement);
            } else {
                const imgElement = document.createElement('img');
                imgElement.src = media.media_url;
                imgElement.alt = 'Post media';
                imgElement.className = 'post-focus-image';
                imgElement.onclick = () => openImageModal(media.media_url);
                mediaContent.appendChild(imgElement);
            }
        });
    } else {
        // Hide the container if there's no media
        mediaContainer.classList.add('d-none');
    }
}

// Opens/closes comments in the post focus view
function toggleCommentsFocus() {
    const commentsSection = document.querySelector('.post-focus .comment');
    if (commentsSection) {
        if (commentsSection.style.display === 'none') {
            commentsSection.style.display = 'block';
        } else {
            commentsSection.style.display = 'none';
        }
    }
}

// Opens the comments-only modal
function openCommentsOnly(postId) {
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.dataset.postId = postId;
        commentsModal.classList.remove('d-none');
        loadCommentsOnly(postId);
    }
}

// Closes the comments modal
function closeCommentsOnly() {
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.classList.add('d-none');
    }
}

// Loads comments into the modal using getRootComments
async function loadCommentsOnly(postId) {
    try {
        const result = await getRootComments(postId, 1);

        if (result && result.status === "success") {
            const commentsContainer = document.querySelector('#commentsOnlyContainer');
            if (commentsContainer) {
                commentsContainer.dataset.postId = postId;
                commentsContainer.innerHTML = '';

                if (result.data && result.data.length > 0) {
                    result.data.forEach(comment => {
                        const commentElement = createCommentElement(comment);
                        commentsContainer.appendChild(commentElement);
                    });
                } else {
                    commentsContainer.innerHTML = '<p class="text-muted">Nenhum comentário ainda.</p>';
                }
            } else {
                console.error('Modal comments container not found');
            }
        } else {
            console.error('Error in modal result:', result);
        }
    } catch (error) {
        console.error('Error loading comments in the modal:', error);
    }
}

// Loads the post focus comments using getRootComments
async function loadCommentsForPost(postId) {
    try {
        const result = await getRootComments(postId, 1);

        if (result && result.status === "success") {
            const commentsContainer = document.querySelector('.post-focus .comment .comment-list');
            if (commentsContainer) {
                commentsContainer.dataset.postId = postId;
                commentsContainer.innerHTML = '';

                if (result.data && result.data.length > 0) {
                    result.data.forEach(comment => {
                        const commentElement = createCommentElement(comment);
                        commentsContainer.appendChild(commentElement);
                    });
                } else {
                    commentsContainer.innerHTML = '<p class="text-muted">Nenhum comentário ainda.</p>';
                }
            } else {
                console.error('Comments container not found');
            }
        } else {
            console.error('Error in result:', result);
        }
    } catch (error) {
        console.error('Error loading comments:', error);
    }
}

// Close the post focus view when clicking outside
document.addEventListener('DOMContentLoaded', () => {
    const postFocus = document.querySelector('.container-post-focus');
    if (postFocus) {
        postFocus.addEventListener('click', (e) => {
            const content = document.querySelector('.post-focus');
            if (!content.contains(e.target)) {
                postFocus.classList.add('d-none');
            }
        });
    }

    // Close the comments modal when clicking outside
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.addEventListener('click', (e) => {
            const content = document.querySelector('.comments-only-modal');
            if (!content.contains(e.target)) {
                commentsModal.classList.add('d-none');
            }
        });
    }

    // Event listener for the comments-only modal form
    const commentModalForm = document.querySelector(".container-comments-only .form-comment");
    if (commentModalForm) {
        commentModalForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const input = commentModalForm.querySelector("input[name='comment']");
            const commentText = input.value.trim();
            if (!commentText) return;

            try {
                const postId = document.querySelector(".container-comments-only").dataset.postId;
                await executeWithRefresh(addComment, postId, commentText);
                input.value = "";
                await loadCommentsOnly(postId); // Reload comments
            } catch (error) {
                console.error("Error adding comment:", error);
            }
        });
    }

    // Event listener for the modal's send comment button
    const btnSendCommentsOnly = document.querySelector(".container-comments-only #btnSendCommentsOnly");
    if (btnSendCommentsOnly) {
        btnSendCommentsOnly.addEventListener("click", () => {
            const form = btnSendCommentsOnly.closest(".form-comment");
            if (form) {
                form.dispatchEvent(new Event('submit'));
            }
        });
    }

    // Event listener for the post focus comment form
    const commentForm = document.querySelector(".post-focus .form-comment");
    if (commentForm) {
        commentForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const input = commentForm.querySelector("input[name='comment']");
            const commentText = input.value.trim();
            if (!commentText) return;

            try {
                const postId = document.querySelector(".container-post-focus").dataset.postId;
                await executeWithRefresh(addComment, postId, commentText);
                input.value = "";
                await loadCommentsForPost(postId); // Reload comments
            } catch (error) {
                console.error("Error adding comment:", error);
            }
        });
    }

    // Event listener for the post focus send comment button
    const btnSend = document.querySelector(".post-focus #btnSend");
    if (btnSend) {
        btnSend.addEventListener("click", () => {
            const form = btnSend.closest(".form-comment");
            if (form) {
                form.dispatchEvent(new Event('submit'));
            }
        });
    }

});
