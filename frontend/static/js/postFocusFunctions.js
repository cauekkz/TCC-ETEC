// Função para adicionar evento de clique nos posts carregados
function addPostClickEvent(postElement, postInfo) {
    postElement.addEventListener('click', (e) => {
        // Não abrir se clicou em botões de interação
        if (e.target.closest('.post-like-icon') || e.target.closest('.post-comments-icon')) {
            return;
        }
        
        // Abrir o post focus
        const postFocus = document.querySelector('.container-post-focus');
        if (postFocus) {
            postFocus.classList.remove('d-none');
            
            // Carregar informações do post no focus
            loadPostInFocus(postInfo.id);
        }
    });
}

// Função para buscar post por ID
async function getPostById(postId) {
    try {
        const token = localStorage.getItem("jwt_token");
        if (!token) {
            console.error("Token não encontrado");
            return null;
        }

        const response = await fetch(`/api/getPostById?post_id=${postId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            console.error("Erro na requisição:", response.status);
            return null;
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Erro ao buscar post:", error);
        return null;
    }
}

// Função para carregar informações do post no container focus
async function loadPostInFocus(postId) {
    try {
        const result = await executeWithRefresh(getPostById, postId);
        
        if (result && result.status === "success") {
            console.log("Post carregado com sucesso:", result.data);
            document.querySelector(".container-post-focus").dataset.postId= result.data.id
            // Atualizar o conteúdo do post focus
            updatePostFocusContent(result.data);
        } else {
            console.error("Erro ao carregar post:", result);
        }
    } catch (error) {
        console.error("Erro na requisição de post:", error);
    }
}

// Função para atualizar o conteúdo do post focus
function updatePostFocusContent(postData) {
    // Atualizar nome do autor
    const nameElement = document.querySelector('.post-focus .name-text strong');
    if (nameElement) {
        nameElement.textContent = postData.author_name || 'Usuário';
    }
    
    // Atualizar role do autor
    const roleElement = document.querySelector('.post-focus .badge');
    if (roleElement) {
        const roleText = postData.role === 'student' ? 'Aluno' : 'Professor';
        roleElement.textContent = roleText;
        const roleColor = postData.role === 'student' ? '#D32F2F' : '#2f32d3ff';
        roleElement.style.backgroundColor = roleColor;
    }
    
    // Atualizar ETEC
    const etecElement = document.querySelector('.post-focus .sub-text');
    if (etecElement && postData.campus && postData.campus.length > 0) {
        etecElement.textContent = postData.campus[0].name || 'ETEC';
    }
    
    // Atualizar conteúdo do post
    const contentElement = document.querySelector('.post-focus #textPost');
    if (contentElement) {
        contentElement.textContent = postData.content || 'Conteúdo não disponível';
    }
    
    // Atualizar mídia do post
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
    
    // Atualizar foto do perfil
    updatePostFocusProfilePhoto(postData);
    
    // Configurar funcionalidade de like no post focus
    setupPostFocusLike(postData);
    
    // Carregar comentários do post
    loadCommentsForPost(postData.id);
}

// Função para atualizar a foto do perfil no post focus
function updatePostFocusProfilePhoto(postData) {
    const profilePhoto = document.querySelector('.post-focus .img-profile-post');
    if (!profilePhoto) return;
    
    const profilePath = postData.profile_photo_path;
    const authorName = postData.author_name || 'Usuário';
    const roleColor = postData.role === 'student' ? '#D32F2F' : '#2f32d3ff';
    
    if (profilePath) {
        profilePhoto.src = profilePath;
        profilePhoto.style.backgroundColor = 'transparent';
    } else {
        profilePhoto.src = '';
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



// Função para fechar o post focus
function closePostFocus() {
    const container = document.querySelector('.container-post-focus');
    if (container) {
        container.classList.add('d-none');
    }
}

// Função para configurar funcionalidade de like no post focus
function setupPostFocusLike(postData) {
    console.log('Configurando like para post:', postData.id);
    
    const likeBtn = document.querySelector('.post-focus .like-post');
    if (!likeBtn) {
        console.error('Botão de like não encontrado no post focus');
        return;
    }
    
    // Adicionar dataset com informações do post
    likeBtn.dataset.postId = postData.id;
    likeBtn.dataset.totalLikes = postData.total_likes || 0;
    likeBtn.dataset.userLiked = postData.user_liked || 0;
    
    console.log('Dataset configurado:', {
        postId: likeBtn.dataset.postId,
        totalLikes: likeBtn.dataset.totalLikes,
        userLiked: likeBtn.dataset.userLiked
    });
    
    // Configurar estado visual inicial do like
    updatePostFocusLikeUI(postData.user_liked === 1);
    
    // Adicionar evento de clique no botão de like
    likeBtn.addEventListener('click', handlePostFocusLike);
    
    console.log('Evento de like configurado com sucesso');
}

// Função para atualizar a UI do like no post focus
function updatePostFocusLikeUI(isLiked) {
    const likeBtn = document.querySelector('.post-focus .like-post');
    if (!likeBtn) return;
    
    if (isLiked) {
        // Post curtido - SVG preenchido
        likeBtn.classList.add('liked');
        likeBtn.innerHTML = `
            <svg xmlns="http://http://www.w3.org/2000/svg" width="16" height="16" fill="#D32F2F" viewBox="0 0 16 16">
                <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
            </svg>
            <span id="qntLikes">${likeBtn.dataset.totalLikes || 0}</span>
        `;
        likeBtn.dataset.userLiked = '1';
    } else {
        // Post não curtido - SVG vazio
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

// Função para manipular o like no post focus
async function handlePostFocusLike(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const likeBtn = e.currentTarget;
    const postId = likeBtn.dataset.postId;
    const isLiked = likeBtn.dataset.userLiked === '1';
    
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
                
                const likeCountElement = document.querySelector('.post-focus #qntLikes');
                if (likeCountElement) {
                    likeCountElement.textContent = newCount;
                }
                
                console.log('Like removido com sucesso');
            }
        } else {
            // Adicionar like
            const result = await executeWithRefresh(addLike, 'post', postId);
            if (result.status === 'success') {
                // Atualizar UI
                updatePostFocusLikeUI(true);
                
                // Atualizar contador
                const currentCount = parseInt(likeBtn.dataset.totalLikes);
                const newCount = currentCount + 1;
                likeBtn.dataset.totalLikes = newCount;
                
                const likeCountElement = document.querySelector('.post-focus #qntLikes');
                if (likeCountElement) {
                    likeCountElement.textContent = newCount;
                }
                
                console.log('Like adicionado com sucesso');
            }
        }
    } catch (error) {
        console.error('Erro ao manipular like:', error);
    }
}

// Função para atualizar mídia no post focus
function updatePostFocusMedia(mediaArray) {
    const mediaContainer = document.querySelector('#postFocusMedia');
    const mediaContent = document.querySelector('#postFocusMediaContainer');
    
    if (!mediaContainer || !mediaContent) return;
    
    // Limpar mídia anterior
    mediaContent.innerHTML = '';
    
    if (mediaArray && mediaArray.length > 0) {
        // Mostrar container de mídia
        mediaContainer.classList.remove('d-none');
        
        // Adicionar cada item de mídia
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
        // Esconder container se não há mídia
        mediaContainer.classList.add('d-none');
    }
}

// Função para abrir/fechar comentários no post focus
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

// Função para abrir modal apenas de comentários
function openCommentsOnly(postId) {
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.dataset.postId = postId;
        commentsModal.classList.remove('d-none');
        loadCommentsOnly(postId);
    }
}

// Função para fechar modal de comentários
function closeCommentsOnly() {
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.classList.add('d-none');
    }
}

// Função para carregar comentários no modal usando getComments
async function loadCommentsOnly(postId) {
    try {
        console.log('Carregando comentários para modal, post:', postId);
        const result = await getComments(postId, 1);
        console.log('Resultado getComments modal:', result);
        
        if (result && result.status === "success") {
            const commentsContainer = document.querySelector('#commentsOnlyContainer');
            if (commentsContainer) {
                commentsContainer.innerHTML = '';
                
                if (result.data && result.data.length > 0) {
                    console.log('Comentários encontrados no modal:', result.data.length);
                    result.data.forEach(comment => {
                        const commentElement = createCommentElement(comment);
                        commentsContainer.appendChild(commentElement);
                    });
                } else {
                    console.log('Nenhum comentário encontrado no modal');
                    commentsContainer.innerHTML = '<p class="text-muted">Nenhum comentário ainda.</p>';
                }
            } else {
                console.error('Container de comentários do modal não encontrado');
            }
        } else {
            console.error('Erro no resultado do modal:', result);
        }
    } catch (error) {
        console.error('Erro ao carregar comentários no modal:', error);
    }
}

// Função para carregar comentários do post focus usando getComments
async function loadCommentsForPost(postId) {
    try {
        console.log('Carregando comentários para post:', postId);
        const result = await getComments(postId, 1);
        console.log('Resultado getComments:', result);
        
        if (result && result.status === "success") {
            const commentsContainer = document.querySelector('.post-focus .comment .comment-list');
            if (commentsContainer) {
                commentsContainer.innerHTML = '';
                
                if (result.data && result.data.length > 0) {
                    console.log('Comentários encontrados:', result.data.length);
                    result.data.forEach(comment => {
                        const commentElement = createCommentElement(comment);
                        commentsContainer.appendChild(commentElement);
                    });
                } else {
                    console.log('Nenhum comentário encontrado');
                    commentsContainer.innerHTML = '<p class="text-muted">Nenhum comentário ainda.</p>';
                }
            } else {
                console.error('Container de comentários não encontrado');
            }
        } else {
            console.error('Erro no resultado:', result);
        }
    } catch (error) {
        console.error('Erro ao carregar comentários:', error);
    }
}

// Configurar evento para fechar o post focus ao clicar fora
document.addEventListener('DOMContentLoaded', () => {
    const postFocus = document.querySelector('.container-post-focus');
    if (postFocus) {
        postFocus.addEventListener('click', (e) => {
            const conteudo = document.querySelector('.post-focus');
            if (!conteudo.contains(e.target)) {
                postFocus.classList.add('d-none');
            }
        });
    }
    
    // Configurar evento para fechar modal de comentários ao clicar fora
    const commentsModal = document.querySelector('.container-comments-only');
    if (commentsModal) {
        commentsModal.addEventListener('click', (e) => {
            const conteudo = document.querySelector('.comments-only-modal');
            if (!conteudo.contains(e.target)) {
                commentsModal.classList.add('d-none');
            }
        });
    }

    // Event listener para o form de comentários do modal apenas
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
                await loadCommentsOnly(postId); // Recarrega comentários
            } catch (error) {
                console.error("Erro ao adicionar comentário:", error);
            }
        });
    }

    // Event listener para o botão de enviar comentários do modal
    const btnSendCommentsOnly = document.querySelector(".container-comments-only #btnSendCommentsOnly");
    if (btnSendCommentsOnly) {
        btnSendCommentsOnly.addEventListener("click", () => {
            const form = btnSendCommentsOnly.closest(".form-comment");
            if (form) {
                form.dispatchEvent(new Event('submit'));
            }
        });
    }

    // Event listener para o form de comentários do post focus
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
                await loadCommentsForPost(postId); // Recarrega comentários
            } catch (error) {
                console.error("Erro ao adicionar comentário:", error);
            }
        });
    }

    // Event listener para o botão de enviar comentários do post focus
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
