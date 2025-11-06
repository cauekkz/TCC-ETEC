// check if have one endpoint about send message
// check if the message is "correct" to send
// send the message and try to read the messages with the file readMessages.js

let token = localStorage.getItem("jwt_token")
// certo
// console.log(token, userData)

async function sendMessage(receiver_id, content, mediafile = null, mediatype = null) {
    const token = localStorage.getItem("jwt_token")
    const formData = new FormData()
    formData.append("content", content)
    formData.append("receiver_id", receiver_id)
    formData.append("media_type", mediatype)

    if (mediafile) {
        formData.append("media_file", mediafile)
    }

    const response = await fetch("/api/addMessage", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
        },
        body: formData
    })

    console.log("Receiver ID:", receiver_id)

    const data = await response.json()
    return data
}
