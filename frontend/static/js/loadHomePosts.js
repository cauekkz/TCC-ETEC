async function loadHomePosts(page = 1) {
    const token = localStorage.getItem("jwt_token");
    if (!token) {
        console.error("Token não encontrado");
        return;
    }

    try {
        const response = await fetch(`/api/getPosts?server_id=1`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Page': page.toString(),
                'X-Limit': '10'
            }
        });

        if (!response.ok) {
            console.error("Erro na requisição:", response.status);
            return null;
        }

        const data = await response.json();

        return data;
    } catch (error) {
        console.error("Erro ao carregar posts:", error);
        return null;
    }
}

// Função para renderizar posts no home
async function renderHomePosts() {
    try {
        const result = await executeWithRefresh(loadHomePosts, 1); // Sempre página 1 por enquanto

        if (result && result.status === "success") {
            // Renderizar posts usando addPostBox
            const postsContainer = document.querySelector(".posts");

            if (postsContainer && result.data) {
                // Limpar posts existentes
                postsContainer.innerHTML = "";
                // Adicionar novos posts
                result.data.forEach((postInfo) => {
                    const postElement = addPostBox(postInfo);
                    postsContainer.appendChild(postElement);
                    // Adicionar evento de clique para abrir post focus
                    addPostClickEvent(postElement, postInfo);

                });

                // Adicionar funcionalidade de like aos posts carregados
                addLikeFunctionalityToPosts();
            } else {
                console.warn("Container não encontrado ou sem resultados");
            }
        } else {
            console.error("Erro ao carregar posts:", result);
        }
    } catch (error) {
        console.error("Erro na requisição de posts:", error);
    }
}

// Carregar posts quando a página carregar
document.addEventListener('DOMContentLoaded', function () {
    renderHomePosts();
});
