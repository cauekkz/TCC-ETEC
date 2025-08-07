async function getUserPosts(id) {
    const token = localStorage.getItem("jwt_token")
    const response = await fetch(`/api/getUserPosts?user_id=${id}`, {
        method: 'GET', 
        headers: {
            'Authorization': `Bearer ${token}` 
        }
    })

    if (!response.ok) {
        //500
    }
    const data = await response.json()
    return data

}

