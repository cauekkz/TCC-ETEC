function addPostBox(postInfo) {
    const formatter = new Intl.NumberFormat('pt-BR', { notation: 'compact' });

    const post = document.createElement("div")

    const authorName = postInfo.author_name ?? "usuario"
    const authorRole = postInfo.role ?? "user"
    const roleColor = (authorRole == "estudante") ? "#D32F2F" : "#2f32d3ff"
    const author_id = postInfo.id_author
    const profilePath = postInfo?.profile_photo_path ?? null;

    const color = (profilePath) ? "transparent" : roleColor
    const url = (profilePath) ? `url("${profilePath}")` : "none"
    const userPhotoText = (profilePath) ? "" : getProfileLetter(authorName)

    const content = postInfo.content

    const total_likes = formatter.format(postInfo.total_likes).replace(/\s+/g, '')
    const id = postInfo.id
    const post_time = formatTimeAgo(postInfo.created_at)

    let etecSpans = ""
    postInfo.campus.forEach(campus => {
        etecSpans += `<span class="post-etec"> ${campus.name}. </span> `
    });

    const likeIcon = (parseInt(postInfo.user_liked) === 1) ? `
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D32F2F" viewBox="0 0 16 16">
    <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
  </svg>
`: `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
     fill="none" stroke="currentColor" stroke-width="1" 
     viewBox="0 0 16 16">
  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 
            1.4 3.053c-.523 1.023-.641 2.5.314 
            4.385.92 1.815 2.834 3.989 6.286 
            6.357 3.452-2.368 5.365-4.542 
            6.286-6.357.955-1.886.838-3.362.314-4.385
            C13.486.878 10.4.28 8.717 2.01z"/>
</svg>`
    post.classList.add("post")
    post.dataset.postId = id
    post.dataset.authorId = author_id
    post.dataset.user_liked = postInfo.user_liked
    post.dataset.total_likes = postInfo.total_likes

    post.innerHTML = `  
            <div class="post-icon-div">
                <div class="user-photo-post interactive" style='background-color:${color}; background-image:${url};'>
                    ${userPhotoText}
                </div>

            </div>
            <div class="post-info-div">
                <div class="post-sec-1">
                    <div class="post-sec-1">
                        <div class="author-name-div" style="display:flex;justify-content:space-between;width:100%">
                        <span class="post-username">${authorName}</span>
                        
                        </div>
                        <span class="post-role" style='background:${roleColor}'>${authorRole}</span>
                        <div class="satan" style="display:flex;gap:0.2rem">
                        ${etecSpans}
                        </div>
                        <span class="post-content">${content}</span>
                        ${postInfo.media && postInfo.media.length > 0 ? `
                            <div class="post-media interactive">
                                ${postInfo.media.map(media => {
        if (media.media_type === 'video') {
            return `<video src="${media.media_url}" controls class="post-video" onclick="openVideoModal('${media.media_url}')"></video>`;
        } else {
            return `<img src="${media.media_url}" alt="Post media" class="post-image" onclick="openImageModal('${media.media_url}')">`;
        }
    }).join('')}
                            </div>
                        ` : ''}
                    </div>

                <div class="post-sec-2">
                    <div>
                        <span class="post-like-icon interactive"><span class="like_icon ">${likeIcon}</span> <span class="total_likes">${total_likes} </span>
                        </span>

                        <span class="post-comments-icon interactive" onclick="openCommentsOnly(${id})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                <path
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                            </svg>
                        </span>
                    </div>

                    <span class="post-time">${post_time}</span>
                </div>
            </div>
    
    `

    const userphoto = post.querySelector(".user-photo-post")
    userphoto.addEventListener("click", () => {
        window.location.href = "/profile?profile=" + author_id
    })
    return post
}

function formatTimeAgo(created_at) {
    const createdDate = new Date(created_at.replace(" ", "T"));
    const now = new Date();

    const diffMs = now - createdDate;
    const diffSec = Math.floor(diffMs / 1000);
    const diffMin = Math.floor(diffSec / 60);
    const diffHrs = Math.floor(diffMin / 60);
    const diffDays = Math.floor(diffHrs / 24);
    const diffMonths = Math.floor(diffDays / 30);
    const diffYears = Math.floor(diffMonths / 12);

    if (diffYears > 0) return `${diffYears}y`;
    if (diffMonths > 0) return `${diffMonths}m`;
    if (diffDays > 0) return `${diffDays}d`;
    if (diffHrs > 0) return `${diffHrs}h`;
    if (diffMin > 0) return `${diffMin}min`;
    return `${diffSec}s`;
}



// Função para abrir modal de imagem
function openImageModal(imageUrl) {
    // Criar modal se não existir
    let modal = document.getElementById('image-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'image-modal';
        modal.className = 'image-modal';
        modal.innerHTML = `
            <span class="close-image-modal">&times;</span>
            <img class="image-modal-content" id="modal-image">
        `;
        document.body.appendChild(modal);

        // Event listener para fechar modal
        modal.querySelector('.close-image-modal').onclick = function () {
            modal.style.display = 'none';
        };

        // Fechar modal ao clicar fora da imagem
        modal.onclick = function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };
    }

    // Mostrar imagem
    document.getElementById('modal-image').src = imageUrl;
    modal.style.display = 'block';
}

// Função para abrir modal de vídeo
function openVideoModal(videoUrl) {
    // Criar modal se não existir
    let modal = document.getElementById('video-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'video-modal';
        modal.className = 'video-modal';
        modal.innerHTML = `
            <span class="close-video-modal">&times;</span>
            <video class="video-modal-content" id="modal-video" controls>
                <source src="" type="video/mp4">
                Seu navegador não suporta vídeos.
            </video>
        `;
        document.body.appendChild(modal);

        // Event listener para fechar modal
        modal.querySelector('.close-video-modal').onclick = function () {
            modal.style.display = 'none';
            document.getElementById('modal-video').pause();
        };

        // Fechar modal ao clicar fora do vídeo
        modal.onclick = function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.getElementById('modal-video').pause();
            }
        };
    }

    // Mostrar vídeo
    const video = document.getElementById('modal-video');
    video.src = videoUrl;
    modal.style.display = 'block';
}
