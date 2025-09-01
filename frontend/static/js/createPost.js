// Função para criar post (sempre usa FormData)
async function createPost(content, serverId, media = []) {
    const token = localStorage.getItem("jwt_token");

    // Criar FormData para enviar dados multipart
    const formData = new FormData();
    formData.append("content", content);
    formData.append("server_id", serverId);

    // Adicionar mídia ao FormData (imagens e vídeos)
    media.forEach((file, index) => {
        formData.append("media[]", file);
    });

    const response = await fetch("/api/addPost", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`
        },
        body: formData
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();

    return result;

}

// Exemplo de uso:
// 
// 1. Para criar post sem mídia:
// createPost("Conteúdo do post", 1);
//
// 2. Para criar post com mídia (imagens e vídeos):
// const fileInput = document.getElementById('media-input');
// const media = Array.from(fileInput.files);
// createPost("Conteúdo do post com mídia", 1, media);
//
// 3. HTML para input de mídia:
// <input type="file" id="media-input" multiple accept="image/*,video/*">
