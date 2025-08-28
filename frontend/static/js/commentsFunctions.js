async function getComments(postId, page = 1) {
    console.log('=== getComments INICIADO ===');
    console.log('postId:', postId, 'page:', page);
    
    const token = localStorage.getItem("jwt_token");
    console.log('Token encontrado:', !!token);
    if (token) {
        console.log('Token (primeiros 20 chars):', token.substring(0, 20) + '...');
    }

    try {
        const url = `/api/getComments?id_post=${postId}`;
        console.log('Fazendo requisição para:', url);
        
        const response = await fetch(url, {
            method: "GET",
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Page': page,
                'X-Limit': 20
            }
        });
        
        console.log('Response recebida:', response.status, response.statusText);
        
        if (!response.ok) {
            console.error('Response não ok:', response.status, response.statusText);
            throw new Error("Erro ao buscar comentários");
        }

        const data = await response.json();
        console.log('Response data:', data);
        console.log('=== getComments FINALIZADO ===');
        return data;
    } catch (error) {
        console.error('Erro em getComments:', error);
        console.log('=== getComments COM ERRO ===');
        throw error;
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

    const response = await fetch(`/api/getRepliesByCommentRoot?comment_root_id=${commentRootId}`, {
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
}
