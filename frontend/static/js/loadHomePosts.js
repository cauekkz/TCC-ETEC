async function loadHomePosts(page = 1) {
    const token = localStorage.getItem("jwt_token");
    if (!token) {
        console.error("Token não encontrado");
        return;
    }
    const serverId = localStorage.getItem("selectedServer") ?? null;
    try {
        const response = await fetch(`/api/getPosts?server_id=${serverId}`, {
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
let hasPost = true
// Função para renderizar posts no home
async function renderHomePosts(page = 1) {
    try {
        const result = await executeWithRefresh(loadHomePosts, page);

        if (result && result.status === "success") {
            // Renderizar posts usando addPostBox
            const postsContainer = document.querySelector(".posts");

            if (postsContainer && result.data) {

                result.data.forEach((postInfo) => {
                    const postElement = addPostBox(postInfo);
                    postsContainer.appendChild(postElement);
                    addPostClickEvent(postElement, postInfo);

                });

                // Adicionar funcionalidade de like aos posts carregados
                addLikeFunctionalityToPosts();
            } else {
                hasPost = false
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
    let page = 1;
    renderHomePosts(page);
    const postsContainer = document.querySelector("#borboleta");
    const loadingIcon = document.querySelector("#loadingPostIcon")
    postsContainer.addEventListener("scroll", () => {
        const pumoes = postsContainer.scrollHeight
        const chorar = postsContainer.scrollTop
        const oni = postsContainer.clientHeight
        const isAtEnd = chorar + oni >= pumoes - 1;
        if (isAtEnd && hasPost) {
            console.log('akaza-dono')
            loadingIcon.style.display = "block"
            page++

            renderHomePosts(page);
            loadingIcon.style.display = "none"


        }
        if (!hasPost && isAtEnd ) {
            showInfo("que ruim")
        }
    })
});