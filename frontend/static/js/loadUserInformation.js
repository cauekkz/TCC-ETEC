async function loadUserInformation(id) {
    const token = localStorage.getItem("jwt_token")
    const response = await fetch(`/api/getuserinformation?user_id=${id}`, {
        method: 'GET', // ou 'POST', 'PUT', etc.
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

