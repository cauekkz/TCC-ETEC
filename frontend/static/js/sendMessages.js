// check if have one endpoint about send message
// check if the message is "correct" to send
// send the message and try to read the messages with the file readMessages.js

let token = localStorage.getItem("jwt_token")
// certo
// console.log(token, userData)
async function sendMessage(receiver_id, content, media = [], media_type) { 
    const token = localStorage.getItem("jwt_token")
    const formData = new FormData()
    
    if (media.length > 0) {
        formData.append("media_file", media[0]); 
    }
    
    formData.append("content", content)
    formData.append("receiver_id", receiver_id)
    formData.append("media_type", media_type) 

    const response = await fetch("/api/addMessage", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
        },
        body: formData
    })

    if (!response.ok) {
        console.error("Erro HTTP ao enviar mensagem:", response.status, await response.text());
        throw new Error(`Falha no envio da mensagem. Status: ${response.status}`);
    }

    const data = await response.json()
    return data
}