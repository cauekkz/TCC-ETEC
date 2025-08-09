
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
        body:JSON.stringify(body)  
    })

    if (!response.ok) {

    }
    const data = await response.json()
    return data
}