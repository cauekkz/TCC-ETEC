// Função para criar post (sempre usa FormData)
async function createPost(content, serverId, media = []) {
    const token = localStorage.getItem("jwt_token");
    
    console.log("Criando post com:", { content, serverId, mediaCount: media.length });
    
    // Criar FormData para enviar dados multipart
    const formData = new FormData();
    formData.append("content", content);
    formData.append("server_id", serverId);
    
    // Adicionar mídia ao FormData (imagens e vídeos)
    media.forEach((file, index) => {
        formData.append("media[]", file);
        console.log("Adicionando arquivo:", file.name, file.type, file.size);
    });
    
    try {
        console.log("Enviando requisição para /api/addPost");
        const response = await fetch("/api/addPost", {
            method: "POST",
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });
        
        console.log("Resposta recebida:", response.status, response.statusText);
        const result = await response.json();
        console.log("Resultado:", result);
        
        if (result.status === "success") {
            console.log("Post criado com sucesso!", result);
            return result;
        } else {
            console.error("Erro ao criar post:", result);
            throw new Error(result.error_message || "Erro desconhecido");
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
        throw error;
    }
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
