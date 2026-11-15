/**
 * Updates a post
 * @param {number} id_post - ID of the post to update
 * @param {string} content - New post content
 * @returns {Promise<Object>} - API response
 */
async function updatePost(id_post, content) {
    const token = localStorage.getItem("jwt_token");
    
    if (!token) {
        return {
            status: "error",
            error_message: "Token não encontrado"
        };
    }

    if (!content || content.trim().length < 5) {
        return {
            status: "error",
            error_message: "O conteúdo precisa ter pelo menos 5 caracteres"
        };
    }

    const body = {
        id_post: id_post,
        content: content.trim()
    };

    try {
        const response = await fetch("/api/updatePost", {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(body)
        });

        if (!response.ok) {
            const errorData = await response.json();
            return errorData;
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error updating post:', error);
        return {
            status: "error",
            error_message: "Erro ao atualizar post. Tente novamente."
        };
    }
}


