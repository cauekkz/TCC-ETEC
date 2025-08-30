// Função para criar elemento de comentário igual ao estático do home
function createCommentElement(comment) {
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment-box p-3 my-2 shadow-sm border rounded';
    const roleColor = comment.user_role === 'estudante' ? '#D32F2F' : '#2f32d3ff';
    console.log(comment)
    // Lógica para foto do usuário (igual ao addPostBox.js)
    const profilePath = comment?.profile_photo_path ?? null;
    const color = (profilePath) ? "transparent" : roleColor;
    const url = (profilePath) ? `url('${profilePath}')` : "none";
    const userPhotoText = (profilePath) ? "" : getProfileLetter(comment.user_name);
    const author_id = comment.id_author
    commentDiv.innerHTML = `
        <div class="d-flex align-items-center pt-3">
            <div class="d-flex">
                <div class="img-profile-post me-2" style="background-color: ${color}; background-image: ${url}; background-size: cover; background-position: center; background-repeat: no-repeat; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;cursor:pointer;">
                    ${userPhotoText}
                </div>
                <div class="flex-column">
                    <p class="name-text mb-0"><strong>${comment.user_name}</strong></p>
                    <span class="badge" style="background-color: ${roleColor}">${comment.user_role === 'estudante' ? 'Aluno' : 'Professor'}</span>
                </div>
            </div>
        </div>
        <p>${comment.content}</p>
    `;
    commentDiv.querySelector(".img-profile-post").addEventListener("click", () => {
        window.location.href = "/profile?profile=" + author_id

    })
    return commentDiv;
}

// Função auxiliar para obter a primeira letra do nome para o avatar
function getProfileLetter(name) {
    return name ? name.charAt(0).toUpperCase() : '?';
}
