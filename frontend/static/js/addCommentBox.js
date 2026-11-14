// Função para criar elemento de comentário estilo YouTube
function createCommentElement(comment, isReply = false) {
    const commentDiv = document.createElement('div');
    commentDiv.className = `comment-item ${isReply ? 'comment-reply' : ''}`;
    commentDiv.dataset.commentId = comment.id;
    commentDiv.dataset.authorId = comment.id_author || comment.author_id;
    
    const roleColor = (comment.user_role === 'estudante' || comment.role === 'estudante') ? '#E11D48' : '#2563EB';
    const profilePath = comment?.profile_photo_path ?? null;
    const color = (profilePath) ? "transparent" : roleColor;
    const url = (profilePath) ? `url('${profilePath}')` : "none";
    const userPhotoText = (profilePath) ? "" : getProfileLetter(comment.user_name || comment.author_name);
    const author_id = comment.id_author || comment.author_id;
    const userName = comment.user_name || comment.author_name || 'Usuário';
    const userRole = comment.user_role || comment.role || 'user';
    const createdAt = comment.created_at;
    const totalLikes = comment.total_likes || 0;
    const userLiked = comment.user_liked || 0;
    
    // Formatar data
    const timeAgo = formatTimeAgo(createdAt);
    
    // Contador de replies (será atualizado quando carregar)
    const replyCount = comment.reply_count || 0;
    
    commentDiv.innerHTML = `
        <div class="comment-avatar">
            <div class="comment-avatar-img" style="background-color: ${color}; background-image: ${url};" onclick="window.location.href='/profile?profile=${author_id}'">
                ${userPhotoText}
            </div>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author-name" onclick="window.location.href='/profile?profile=${author_id}'">${userName}</span>
                <span class="comment-badge" style="background-color: ${roleColor}">${userRole === 'estudante' ? 'estudante' : 'Professor'}</span>
                <span class="comment-time">${timeAgo}</span>
            </div>
            <div class="comment-text">${escapeHtml(comment.content)}</div>
            <div class="comment-actions">
                <button class="comment-action-btn comment-like-btn ${userLiked ? 'liked' : ''}" data-comment-id="${comment.id}" data-liked="${userLiked}" data-total-likes="${totalLikes}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.534 4.736 3.562-3.248 8 1.314c4.438-4.562 15.534 3.578 8 13.686"/>
                    </svg>
                    <span class="comment-like-count">${formatNumber(totalLikes)}</span>
                </button>
                ${!isReply ? `
                    <button class="comment-action-btn comment-reply-btn" data-comment-id="${comment.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zM6 5.04 4.312 6.39A.5.5 0 0 1 4 6.5H2v3h2a.5.5 0 0 1 .312.11L6 10.96zm7.854.854a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 5.5H8.5a.5.5 0 0 0 0 1h3.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                        <span>Responder</span>
                    </button>
                    ${replyCount > 0 ? `
                        <button class="comment-action-btn comment-show-replies-btn" data-comment-id="${comment.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                            </svg>
                            <span class="reply-count-text">${replyCount} ${replyCount === 1 ? 'resposta' : 'respostas'}</span>
                        </button>
                    ` : ''}
                ` : ''}
            </div>
            ${!isReply ? `
                <div class="comment-replies-container" data-comment-id="${comment.id}" style="display: none;"></div>
                <div class="comment-reply-form-container" data-comment-id="${comment.id}" style="display: none;">
                    <div class="comment-reply-form">
                        <input type="text" class="comment-reply-input" placeholder="Adicione uma resposta..." data-parent-id="${comment.id}">
                        <div class="comment-reply-actions">
                            <button class="comment-reply-cancel" data-parent-id="${comment.id}">Cancelar</button>
                            <button class="comment-reply-submit" data-parent-id="${comment.id}">Responder</button>
                        </div>
                    </div>
                </div>
            ` : ''}
        </div>
    `;
    
    // Adicionar eventos de like
    const likeBtn = commentDiv.querySelector('.comment-like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', handleCommentLike);
    }
    
    // Adicionar eventos de reply
    const replyBtn = commentDiv.querySelector('.comment-reply-btn');
    if (replyBtn) {
        replyBtn.addEventListener('click', handleShowReplyForm);
    }
    
    // Adicionar eventos para mostrar replies
    const showRepliesBtn = commentDiv.querySelector('.comment-show-replies-btn');
    if (showRepliesBtn) {
        showRepliesBtn.addEventListener('click', handleToggleReplies);
    }
    
    // Adicionar eventos do formulário de reply
    const replySubmitBtn = commentDiv.querySelector('.comment-reply-submit');
    if (replySubmitBtn) {
        replySubmitBtn.addEventListener('click', handleSubmitReply);
    }
    
    const replyCancelBtn = commentDiv.querySelector('.comment-reply-cancel');
    if (replyCancelBtn) {
        replyCancelBtn.addEventListener('click', handleCancelReply);
    }
    
    const replyInput = commentDiv.querySelector('.comment-reply-input');
    if (replyInput) {
        replyInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSubmitReply(e);
            }
        });
    }
    
    return commentDiv;
}

// Função para lidar com like em comentário
async function handleCommentLike(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const commentId = btn.dataset.commentId;
    const isLiked = btn.dataset.liked === '1';
    const totalLikes = parseInt(btn.dataset.totalLikes) || 0;
    
    try {
        let result;
        if (isLiked) {
            result = await executeWithRefresh(deleteLike, 'comment', commentId);
        } else {
            result = await executeWithRefresh(addLike, 'comment', commentId);
        }
        
        if (result && result.status === 'success') {
            const newLiked = !isLiked;
            const newTotalLikes = newLiked ? totalLikes + 1 : Math.max(0, totalLikes - 1);
            
            btn.dataset.liked = newLiked ? '1' : '0';
            btn.dataset.totalLikes = newTotalLikes;
            btn.classList.toggle('liked', newLiked);
            btn.querySelector('.comment-like-count').textContent = formatNumber(newTotalLikes);
            
            // Atualizar ícone
            const svg = btn.querySelector('svg');
            if (newLiked) {
                svg.innerHTML = '<path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>';
                svg.setAttribute('fill', '#E11D48');
            } else {
                svg.innerHTML = '<path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.534 4.736 3.562-3.248 8 1.314c4.438-4.562 15.534 3.578 8 13.686"/>';
                svg.setAttribute('fill', 'currentColor');
            }
        }
    } catch (error) {
        console.error('Erro ao curtir comentário:', error);
    }
}

// Função para mostrar formulário de reply
function handleShowReplyForm(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const commentId = btn.dataset.commentId;
    const commentDiv = btn.closest('.comment-item');
    const formContainer = commentDiv.querySelector('.comment-reply-form-container');
    
    if (formContainer) {
        formContainer.style.display = 'block';
        const input = formContainer.querySelector('.comment-reply-input');
        if (input) {
            input.focus();
        }
    }
}

// Função para cancelar reply
function handleCancelReply(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const parentId = btn.dataset.parentId;
    const commentDiv = btn.closest('.comment-item');
    const formContainer = commentDiv.querySelector('.comment-reply-form-container');
    
    if (formContainer) {
        formContainer.style.display = 'none';
        const input = formContainer.querySelector('.comment-reply-input');
        if (input) {
            input.value = '';
        }
    }
}

// Função para enviar reply
async function handleSubmitReply(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const parentId = btn.dataset.parentId;
    const commentDiv = btn.closest('.comment-item');
    const formContainer = commentDiv.querySelector('.comment-reply-form-container');
    const input = formContainer.querySelector('.comment-reply-input');
    const content = input.value.trim();
    
    if (!content) return;
    
    // Obter postId do contexto (pode precisar ajustar dependendo de onde está sendo usado)
    const postId = getCurrentPostId();
    if (!postId) {
        console.error('Post ID não encontrado');
        return;
    }
    
    try {
        btn.disabled = true;
        const result = await executeWithRefresh(addComment, postId, content, parentId);
        
        if (result && result.status === 'success') {
            input.value = '';
            formContainer.style.display = 'none';
            
            // Recarregar replies
            await loadRepliesForComment(parentId);
        }
    } catch (error) {
        console.error('Erro ao enviar resposta:', error);
    } finally {
        btn.disabled = false;
    }
}

// Função para carregar replies de um comentário
async function loadRepliesForComment(commentId) {
    const commentDiv = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
    if (!commentDiv) return;
    
    const repliesContainer = commentDiv.querySelector('.comment-replies-container');
    if (!repliesContainer) return;
    
    try {
        const result = await executeWithRefresh(getReplies, commentId, 1);
        
        if (result && result.status === 'success' && result.data) {
            repliesContainer.innerHTML = '';
            if (result.data.length > 0) {
                result.data.forEach(reply => {
                    const replyElement = createCommentElement(reply, true);
                    repliesContainer.appendChild(replyElement);
                });
            }
        }
    } catch (error) {
        console.error('Erro ao carregar respostas:', error);
    }
}

// Função para mostrar/ocultar replies
async function handleToggleReplies(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const commentId = btn.dataset.commentId;
    const commentDiv = btn.closest('.comment-item');
    const repliesContainer = commentDiv.querySelector('.comment-replies-container');
    
    if (!repliesContainer) return;
    
    const isVisible = repliesContainer.style.display !== 'none';
    
    if (!isVisible) {
        // Carregar replies se ainda não foram carregados
        if (repliesContainer.children.length === 0) {
            await loadRepliesForComment(commentId);
        }
        repliesContainer.style.display = 'block';
        btn.classList.add('expanded');
    } else {
        repliesContainer.style.display = 'none';
        btn.classList.remove('expanded');
    }
}

// Função auxiliar para obter o ID do post atual
function getCurrentPostId() {
    // Tentar vários locais onde o postId pode estar
    const postFocus = document.querySelector('.post-focus[data-post-id]');
    if (postFocus) return postFocus.dataset.postId;
    
    const post = document.querySelector('.post[data-post-id]');
    if (post) return post.dataset.postId;
    
    const commentContainer = document.querySelector('.comment-list[data-post-id]');
    if (commentContainer && commentContainer.dataset.postId) return commentContainer.dataset.postId;
    
    // Tentar encontrar no contexto do comentário clicado
    const activeForm = document.activeElement?.closest('.comment-item');
    if (activeForm) {
        const container = activeForm.closest('.comment-list');
        if (container && container.dataset.postId) return container.dataset.postId;
    }
    
    // Tentar encontrar pelo container de replies
    const repliesContainer = document.activeElement?.closest('.comment-replies-container');
    if (repliesContainer) {
        const commentItem = repliesContainer.closest('.comment-item');
        if (commentItem) {
            const allComments = document.querySelectorAll('.comment-item');
            // Encontrar o comentário pai e buscar o postId do contexto
            for (let comment of allComments) {
                if (comment.dataset.commentId) {
                    const container = comment.closest('.comment-list');
                    if (container && container.dataset.postId) return container.dataset.postId;
                }
            }
        }
    }
    
    return null;
}

// Função auxiliar para formatar número
function formatNumber(num) {
    if (num === 0) return '';
    if (num < 1000) return num.toString();
    if (num < 1000000) return (num / 1000).toFixed(1).replace('.0', '') + 'k';
    return (num / 1000000).toFixed(1).replace('.0', '') + 'M';
}

// Função auxiliar para obter a primeira letra do nome para o avatar
function getProfileLetter(name) {
    return name ? name.charAt(0).toUpperCase() : '?';
}

// Função para escapar HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Função para formatar tempo (usar a mesma função dos posts)
function formatTimeAgo(created_at) {
    if (!created_at) return '';
    
    const now = new Date();
    const past = new Date(created_at);
    const diffInSeconds = Math.floor((now - past) / 1000);
    
    if (diffInSeconds < 60) return 'agora';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}min`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)}d`;
    if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 604800)}sem`;
    if (diffInSeconds < 31536000) return `${Math.floor(diffInSeconds / 2592000)}mês`;
    return `${Math.floor(diffInSeconds / 31536000)}ano`;
}
