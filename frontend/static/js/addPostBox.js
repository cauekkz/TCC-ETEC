function addPostBox(postInfo) {
    console.log(postInfo)
    const post = document.createElement("div")

    const authorName = postInfo.author_name ?? "usuario"
    const authorRole = postInfo.role ?? "user"
    const roleColor = (authorRole == "student") ? "#D32F2F" : "#2f32d3ff"
    const author_id = postInfo.id_author
    const profilePath = postInfo?.profile_photo_path ??null;

    const color = (profilePath) ? "transparent" : roleColor
    const url = (profilePath) ? `url("${profilePath}")` : "none"
    const userPhotoText = (profilePath) ? "" : getProfileLetter(authorName)

    const content = postInfo.content
    const total_likes = postInfo.total_likes
    const id = postInfo.id
    const post_time = formatTimeAgo(postInfo.created_at)

    post.dataset.postId = id
    post.dataset.authorId = author_id



    post.classList.add("post")

    post.innerHTML = `
    
            <div class="post-icon-div">
                <div class="user-photo-post" style='background-color:${color}; background-image:${url};'>
                    ${userPhotoText}
                </div>
            </div>
            <div class="post-info-div">
                <div class="post-sec-1">
                    <span class="post-username">${authorName}</span>
                    <span class="post-role" style='background:${roleColor}'>${authorRole}</span>

                    <span class="post-etec"> ETEC</span>
                    <span class="post-content">${content}</span>
                </div>

                <div class="post-sec-2">
                    <div>
                        <span class="post-like-icon">&#9825; ${total_likes} </span>
                        <span class="post-comments-icon"> comments-icon</span>
                    </div>

                    <span class="post-time">${post_time}</span>
                </div>
            </div>
    
    `

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

function getProfileLetter(str) {
    const words = str.trim().split(/\s+/);
    const firts = words[0][0];

    if (words.length === 1) {
        return firts.toUpperCase();
    }

    const last = words[words.length - 1][0];
    return (firts + last).toUpperCase();

}
