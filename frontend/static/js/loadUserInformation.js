async function loadUserInformation(id) {
    const token = localStorage.getItem("jwt_token")
    const response = await fetch(`/api/getUserInformation?user_id=${id}`, {
        method: 'GET', // or 'POST', 'PUT', etc.
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

