// Creates a post (always uses FormData)
async function createPost(content, serverId, media = []) {
    const token = localStorage.getItem("jwt_token");

    // Build FormData to send multipart data
    const formData = new FormData();
    formData.append("content", content);
    formData.append("server_id", serverId);

    // Add media to the FormData (images and videos)
    media.forEach((file, index) => {
        formData.append("media[]", file);
    });

    const response = await fetch("/api/addPost", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`
        },
        body: formData
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();

    return result;

}

// Usage example:
// 
// 1. To create a post without media:
// createPost("Post content", 1);
//
// 2. To create a post with media (images and videos):
// const fileInput = document.getElementById('media-input');
// const media = Array.from(fileInput.files);
// createPost("Post content with media", 1, media);
//
// 3. HTML for the media input:
// <input type="file" id="media-input" multiple accept="image/*,video/*">
