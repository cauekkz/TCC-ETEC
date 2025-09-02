const tab = document.querySelector(".tab");
const leftArrow = document.querySelector("#left-arrow");
const rightArrow = document.querySelector("#right-arrow");
const leftArrowInfo = document.querySelector("#left-arrow-infos");
const rightArrowInfo = document.querySelector("#right-arrow-infos");
const img = document.querySelector(".img-logo");
const cardProfile = document.querySelector(".row-profile");
const tabInfo = document.querySelector(".tab-infos");
const tabContainer = document.querySelector(".tab-container");
let textTabLeft = document.querySelectorAll(".col > p");
let textTabRight = document.querySelectorAll(".suggested-friends > p");
const centerContent = document.querySelector(
    ".col-6.flex-grow-1.overflow-auto"
);


/* leftArrow.addEventListener("click", () => {
  leftArrow.classList.add("d-none");
  rightArrow.classList.remove("d-none");
  tab.style.width = "2rem";
  tab.classList.remove("px-3");
  tab.classList.add("px-1");
  textTabLeft.forEach((text) => text.classList.add("d-none"));
  document.querySelector("#home").classList.add("d-none");
  cardProfile.classList.add("d-none");
  img.classList.add("d-none");
  setTimeout(() => {}, 400);
});


rightArrow.addEventListener("click", () => {
  rightArrow.classList.add("d-none");
  leftArrow.classList.remove("d-none");
  tab.style.width = "12rem";
  tab.classList.remove("px-1");
  tab.classList.add("px-3");
  document.querySelector("#home").classList.remove("d-none");
  img.classList.remove("d-none");
  textTabLeft.forEach((text) => text.classList.remove("d-none"));
  cardProfile.classList.remove("d-none");
}); */







const btnCreate = document.querySelector("#btnCreate");
const containerCreate = document.querySelector(".container-create");


btnCreate.addEventListener("click", () => {
    containerCreate.classList.remove("d-none");
});


containerCreate.addEventListener("click", (e) => {
    const conteudo = document.querySelector(".create-card");
    if (!conteudo.contains(e.target)) {
        containerCreate.classList.add("d-none");
    }
});


document.querySelector(".like-post").addEventListener("click", (e) => {
    e.stopPropagation();
});


// Variáveis para o formulário de criação de post
const formCreatePost = document.querySelector("#formCreatePost");
const textareaCreate = document.querySelector("#textareaCreate");
const btnPublish = document.querySelector("#btnPublish");
const btnCancel = document.querySelector("#btnCancel");
const btnAddMedia = document.querySelector("#btnAddMedia");
const mediaInput = document.querySelector("#mediaInput");
const mediaPreview = document.querySelector("#mediaPreview");
const previewContainer = document.querySelector("#previewContainer");

// Variáveis para controle de estado
let selectedFiles = [];
let userInfo = null;
let userRole = null;

// Verificar se o usuário é professor ao carregar a página
async function checkUserRole() {
    try {
        const token = localStorage.getItem("jwt_token");
        if (!token) {
            console.error("Token não encontrado");
            return;
        }

        const response = await fetch("/api/getUserInformation?user_id=mine", {
            method: "GET",
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const result = await response.json();

        if (result.status === "success") {
            userInfo = result.data.user;
            const userRole = userInfo?.role ?? null
            const campusInfo = result?.data?.campus ?? null

            if (userRole === "professor") {
                const serverID = parseInt(localStorage.getItem("selectedServer"))
                console.log("serverid")
                console.log(serverID)
                if (serverID == 1 || campusInfo.some(info => info.id == serverID - 1)) {
                    btnCreate.style.display = "block";

                } else {
                    btnCreate.style.display = "none";
                }


            } else {
                console.log("Usuário não é professor");
                btnCreate.style.display = "none";
            }
        } else {
            console.error("Erro ao obter informações do usuário:", result);
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
    }
}

// Carregar informações do usuário ao iniciar
checkUserRole();




// Função para adicionar funcionalidade de like aos posts
function addLikeFunctionalityToPosts() {
    const posts = document.querySelectorAll('.post');

    posts.forEach(post => {
        const likeBtn = post.querySelector('.post-like-icon');
        if (likeBtn) {
            // Remover event listeners antigos para evitar duplicação
            const newLikeBtn = likeBtn.cloneNode(true);
            likeBtn.parentNode.replaceChild(newLikeBtn, likeBtn);

            newLikeBtn.addEventListener('click', async () => {
                const postId = post.dataset.postId;

                if (post.dataset.user_liked == 0) {
                    const data = await executeWithRefresh(addLike, 'post', postId);
                    changeFrontLike(post, true);
                    post.dataset.user_liked = 1;
                } else {
                    const data = await executeWithRefresh(deleteLike, 'post', postId);
                    changeFrontLike(post, false);
                    post.dataset.user_liked = 0;
                }
            });
        }
    });
}

// Adicionar funcionalidade de like quando posts são carregados
// Removido pois já é chamado no loadHomePosts.js

// Controle do botão de publicar
textareaCreate.addEventListener("input", () => {
    const textCreate = textareaCreate.value.trim();

    if (textCreate === "") {
        btnPublish.disabled = true;
    } else {
        btnPublish.disabled = false;
    }
});

// Botão de adicionar mídia
btnAddMedia.addEventListener("click", () => {
    mediaInput.click();
});

// Input de mídia
mediaInput.addEventListener("change", (e) => {
    const files = Array.from(e.target.files);
    selectedFiles = files;

    if (files.length > 0) {
        showMediaPreview(files);
    } else {
        hideMediaPreview();
    }
});

// Mostrar preview das mídias
function showMediaPreview(files) {
    mediaPreview.classList.remove("d-none");
    previewContainer.innerHTML = "";

    files.forEach((file, index) => {
        const previewDiv = document.createElement("div");
        previewDiv.className = "position-relative";
        previewDiv.style.width = "100px";
        previewDiv.style.height = "100px";

        const removeBtn = document.createElement("button");
        removeBtn.className = "btn btn-sm btn-danger position-absolute";
        removeBtn.style.top = "5px";
        removeBtn.style.right = "5px";
        removeBtn.style.zIndex = "10";
        removeBtn.innerHTML = "×";
        removeBtn.onclick = (e) => {
            e.stopPropagation(); // <-- isso evita que o clique feche o form
            removeFile(index);
        };

        if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.className = "img-fluid";
            img.style.width = "100px";
            img.style.height = "100px";
            img.style.objectFit = "cover";
            img.style.borderRadius = "8px";

            previewDiv.appendChild(img);
        } else if (file.type.startsWith("video/")) {
            const video = document.createElement("video");
            video.src = URL.createObjectURL(file);
            video.className = "img-fluid";
            video.style.width = "100px";
            video.style.height = "100px";
            video.style.objectFit = "cover";
            video.style.borderRadius = "8px";
            video.muted = true;

            previewDiv.appendChild(video);
        }

        previewDiv.appendChild(removeBtn);
        previewContainer.appendChild(previewDiv);
    });
}

// Remover arquivo do preview
function removeFile(index) {
    selectedFiles.splice(index, 1);

    if (selectedFiles.length > 0) {
        showMediaPreview(selectedFiles);
    } else {
        hideMediaPreview();
    }
}

// Ocultar preview
function hideMediaPreview() {
    mediaPreview.classList.add("d-none");
    previewContainer.innerHTML = "";
}

// Botão cancelar
btnCancel.addEventListener("click", () => {
    containerCreate.classList.add("d-none");
    resetForm();
});

// Resetar formulário
function resetForm() {
    textareaCreate.value = "";
    selectedFiles = [];
    hideMediaPreview();
    btnPublish.disabled = true;
    mediaInput.value = "";
}

// Submissão do formulário
