
async function follow(followed_id) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "followed_id": followed_id
    }

    const response = await fetch("/api/follow", {
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
async function unfollow(followed_id) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "followed_id": followed_id
    }

    const response = await fetch("/api/unfollow", {
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

function changeFrontBtn(btn, follower) {

    if (follower) {
        btn.classList.remove("follow");
        btn.classList.add("unfollow");
        btn.innerText = "Deixar de seguir"

    } else {
        btn.classList.remove("unfollow");
        btn.classList.add("follow");
        btn.innerText = "Seguir"

    }
}
async function isFollowed(followed_id) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "followed_id": followed_id
    }

    const response = await fetch("/api/isFollowed?is_followed=".concat(followed_id), {
        headers: {
            'Authorization': `Bearer ${token}`
        },
    })

    if (!response.ok) {

    }
    const data = await response.json()
    return data
}
