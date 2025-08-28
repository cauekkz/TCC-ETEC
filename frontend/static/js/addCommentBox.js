// Função para criar elemento de comentário igual ao estático do home
function createCommentElement(comment) {
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment-box p-3 my-2 shadow-sm border rounded';
    
    const roleColor = comment.user_role === 'student' ? '#D32F2F' : '#2f32d3ff';
    
    commentDiv.innerHTML = `
        <div class="d-flex align-items-center pt-3">
            <div class="d-flex">
                <div class="img-profile-post me-2" style="background-color: ${roleColor}; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                    ${getProfileLetter(comment.user_name)}
                </div>
                <div class="flex-column">
                    <p class="name-text mb-0"><strong>${comment.user_name}</strong></p>
                    <span class="badge" style="background-color: ${roleColor}">${comment.user_role === 'student' ? 'Aluno' : 'Professor'}</span>
                </div>
            </div>
        </div>
        <p>${comment.content}</p>
    `;
    
    return commentDiv;
}

// Função auxiliar para obter a primeira letra do nome para o avatar
function getProfileLetter(name) {
    return name ? name.charAt(0).toUpperCase() : '?';
}
