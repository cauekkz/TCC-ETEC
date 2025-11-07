// this file will see te messages and update for each 2 sec

const userData = sessionStorage.getItem("userData")

async function seeMessages(idUser){
    const response = await fetch('/api/getMessages?contact_id=' + idUser, {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`
        },
    })

    if (!response.ok) {

    }

    const data = await response.json()
    return data
}