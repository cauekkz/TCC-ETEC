let token = localStorage.getItem("jwt_token")

async function sendMessage(receiver_id, content, fileObjectOrInput, media_type) { 
    const token = localStorage.getItem("jwt_token")
    const formData = new FormData()

    let fileToSend = null;
    if (fileObjectOrInput) {
        if (fileObjectOrInput instanceof FileList && fileObjectOrInput.length > 0) {
            fileToSend = fileObjectOrInput[0];
        } 
        
        else if (fileObjectOrInput instanceof File) {
            fileToSend = fileObjectOrInput;
        }
    }

    if (fileToSend) {
        formData.append("media_file", fileToSend); 
        console.log(`Attaching file: ${fileToSend.name}`);
    }

    const messageContent = content.trim() || "ㅤ"; 

    formData.append("content", messageContent)
    formData.append("receiver_id", receiver_id)
    formData.append("media_type", media_type || "");

    const response = await fetch("/api/addMessage", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
        },
        body: formData
    })

    if (!response.ok) {
        console.error("HTTP error sending message:", response.status, await response.text());
        throw new Error(`Falha no envio da mensagem. Status: ${response.status}`);
    }

    const data = await response.json()
    return data
}