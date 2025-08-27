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

// Função para obter a primeira letra do nome para o avatar
function getProfileLetter(name) {
    if (!name) return "?";
    const words = name.trim().split(/\s+/);
    const first = words[0][0];
    
    if (words.length === 1) {
        return first.toUpperCase();
    }
    
    const last = words[words.length - 1][0];
    return (first + last).toUpperCase();
}
