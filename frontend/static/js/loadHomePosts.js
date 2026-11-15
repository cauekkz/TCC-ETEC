async function loadHomePosts(page = 1) {
    const token = localStorage.getItem("jwt_token");
    if (!token) {
        console.error("Token not found");
        return;
    }
    const serverId = localStorage.getItem("selectedServer") ?? null;
    try {
        const response = await fetch(`/api/getPosts?server_id=${serverId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Page': page.toString(),
                'X-Limit': '10'
            }
        });

        if (!response.ok) {
            console.error("Request error:", response.status);
            return null;
        }

        const data = await response.json();

        return data;
    } catch (error) {
        console.error("Error loading posts:", error);
        return null;
    }
}
let hasPost = true
// Renders posts on the home page
async function renderHomePosts(page = 1) {
    try {
        const result = await executeWithRefresh(loadHomePosts, page);

        if (result && result.status === "success") {
            // Renderizar posts usando addPostBox
            const postsContainer = document.querySelector(".posts");

            if (postsContainer && result.data) {

                result.data.forEach((postInfo) => {
                    const postElement = addPostBox(postInfo);
                    postsContainer.appendChild(postElement);
                    addPostClickEvent(postElement, postInfo);

                });
                // Add like functionality to the loaded posts
                addLikeFunctionalityToPosts();
            } else {
                hasPost = false
            }
        } else {
            console.error("Error loading posts:", result);
        }
    } catch (error) {
        console.error("Posts request error:", error);
    }
}

// Load posts when the page loads

document.addEventListener('DOMContentLoaded', function () {
    let page = 1;
    renderHomePosts(page);
    const postsContainer = document.querySelector("#posts-feed");
    const loadingIcon = document.querySelector("#loadingPostIcon")
    postsContainer.addEventListener("scroll", () => {
        const scrollHeight = postsContainer.scrollHeight
        const scrollTop = postsContainer.scrollTop
        const clientHeight = postsContainer.clientHeight
        const isAtEnd = scrollTop + clientHeight >= scrollHeight - 1;
        if (isAtEnd && hasPost) {
            loadingIcon.style.display = "block"
            page++

            renderHomePosts(page);

            loadingIcon.style.display = "none"

        }

        if (!hasPost) {
            document.querySelector("#end-of-feed").style.display = "flex"
            console.log("info")
        }
    })
});