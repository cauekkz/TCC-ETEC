async function deletePost(id_post) {
    const token = localStorage.getItem("jwt_token")
    const body = {
        "id_post": id_post
    }

    const response = await fetch("/api/deletePost", {
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