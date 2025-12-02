async function getRootComments(postId, page = 1) {
    const token = localStorage.getItem("jwt_token");
    
    if (token) {
        try {
            const url = `/api/getPostRootComments?id_post=${postId}`;
            
            const response = await fetch(url, {
                method: "GET",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Page': page,
                    'X-Limit': 20
                }
            });
            
            if (!response.ok) {
                console.error('Response não ok:', response.status, response.statusText);
                throw new Error("Erro ao buscar comentários");
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro em getRootComments:', error);
            throw error;
        }
    }
}

// Função para buscar comentários root de um post específico
async function getComments(postId, page = 1) {
    const token = localStorage.getItem("jwt_token");
    
    if (token) {
        try {
            const url = `/api/getComments?id_post=${postId}`;
            
            const response = await fetch(url, {
                method: "GET",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Page': page,
                    'X-Limit': 20
                }
            });
            
            if (!response.ok) {
                console.error('Response não ok:', response.status, response.statusText);
                throw new Error("Erro ao buscar comentários");
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro em getComments:', error);
            throw error;
        }
    }
}

async function addComment(postId, content, parentCommentId = null) {
    const token = localStorage.getItem("jwt_token");

    const body = {
        id_post: postId,
        content: content
    };

    if (parentCommentId !== null) {
        body.id_parent_comment = parentCommentId;
    }

    const response = await fetch("/api/addComment", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    if (!response.ok) {
        throw new Error("Erro ao adicionar comentário");
    }

    const data = await response.json();
    return data;
}
async function updateComment(commentId, content) {
    const token = localStorage.getItem("jwt_token");

    const body = {
        id_comment: commentId,
        content: content
    };

    const response = await fetch("/api/updateComment", {
        method: "PUT",
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    if (!response.ok) {
        throw new Error("Erro ao atualizar comentário");
    }

    const data = await response.json();
    return data;
}
async function deleteComment(commentId) {
    const token = localStorage.getItem("jwt_token");

    const body = {
        id_comment: commentId
    };

    const response = await fetch("/api/deleteComment", {
        method: "DELETE",
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    if (!response.ok) {
        throw new Error("Erro ao deletar comentário");
    }

    const data = await response.json();
    return data;
}
async function getReplies(commentRootId, page = 1) {
    const token = localStorage.getItem("jwt_token");

    try {
        const url = `/api/getRootComments?comment_root_id=${commentRootId}`;
        
        const response = await fetch(url, {
            method: "GET",
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Page': page,
                'X-Limit': 20
            }
        });
        
        if (!response.ok) {
            throw new Error("Erro ao buscar respostas");
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro em getReplies:', error);
        return { status: 'error', data: [] };
    }
}
