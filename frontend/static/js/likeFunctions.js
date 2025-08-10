
async function addLike(content_type, content_id) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "content_type": content_type,
        "content_id": content_id
    }

    const response = await fetch("/api/addLike", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(body)
    })

    if (!response.ok) {

    }
    const data = await response.json()
    return data
}

async function deleteLike(content_type, content_id) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "content_type": content_type,
        "content_id": content_id
    }

    const response = await fetch("/api/deleteLike", {
        method: "DELETE",
        headers: {
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(body)
    })

    if (!response.ok) {

    }
    const data = await response.json()
    return data
}

function changeFrontLike(post, liked) {
    const formatter = new Intl.NumberFormat('pt-BR', { notation: 'compact' });

    const total_likes = parseInt(post.dataset.total_likes)
    if (liked) {
        const likenum = total_likes + 1
        post.querySelector(".total_likes").innerText = formatter.format(likenum).replace(/\s+/g, '')
        post.dataset.total_likes = likenum
        post.dataset.user_liked = 1
        post.querySelector(".like_icon").innerHTML = `  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D32F2F" viewBox="0 0 16 16">
    <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
  </svg>`

    } else {
        const likenum = total_likes - 1
        post.querySelector(".total_likes").innerText = formatter.format(likenum).replace(/\s+/g, '')
        post.dataset.total_likes = likenum

        post.dataset.user_liked = 0
        post.querySelector(".like_icon").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
     fill="none" stroke="currentColor" stroke-width="1" 
     viewBox="0 0 16 16">
  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 
           1.4 3.053c-.523 1.023-.641 2.5.314 
           4.385.92 1.815 2.834 3.989 6.286 
           6.357 3.452-2.368 5.365-4.542 
           6.286-6.357.955-1.886.838-3.362.314-4.385
           C13.486.878 10.4.28 8.717 2.01z"/>
</svg>`
    }

}