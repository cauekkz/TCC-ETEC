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


const cardPost = document.querySelectorAll(".card-post");
const postFocus = document.querySelector(".container-post-focus");


cardPost.forEach((cards) => {
  // Passar os values por aq, img, nome, etec, 'função'
  cards.addEventListener("click", () => {
    postFocus.classList.remove("d-none");
  });
});


postFocus.addEventListener("click", (e) => {
  const conteudo = document.querySelector(".post-focus");
  if (!conteudo.contains(e.target)) {
    postFocus.classList.add("d-none");
  }
});


const btnSendComment = document.querySelector("#btnSend");
const form = document.querySelector(".form-comment");


btnSendComment.addEventListener("click", () => {
  if (!form.comment.value) {
    return;
  }


  // manda pra API, só arruma bgl de cada post antes
});


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
            userRole = userInfo.role;
            
            console.log("Role do usuário:", userRole); // Debug
            
            // Mostrar/ocultar botão de criar post baseado no role
            if (userRole === "teacher") {
                btnCreate.style.display = "block";
                console.log("Botão de criar post mostrado para professor");
            } else {
                btnCreate.style.display = "none";
                console.log("Botão de criar post ocultado para não-professor");
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

// Função para carregar posts
async function loadPosts() {
    try {
        const token = localStorage.getItem("jwt_token");
        if (!token) {
            console.error("Token não encontrado");
            return;
        }

        const response = await fetch("/api/getPosts?server_id=1", {
            method: "GET",
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Page': '1',
                'X-Limit': '10'
            }
        });

        const result = await response.json();
        
        if (result.status === "success") {
            console.log("Posts carregados com sucesso:", result.data);
            
            // Renderizar posts usando addPostBox
            const postsContainer = document.querySelector(".posts");
            console.log("Container de posts encontrado:", postsContainer);
            
            if (postsContainer && result.data.results) {
                console.log("Número de posts:", result.data.results.length);
                
                // Limpar posts existentes
                postsContainer.innerHTML = "";
                
                // Adicionar novos posts
                result.data.results.forEach((postInfo, index) => {
                    console.log(`Criando post ${index + 1}:`, postInfo);
                    const postElement = addPostBox(postInfo);
                    postsContainer.appendChild(postElement);
                });
            } else {
                console.log("Container não encontrado ou sem resultados");
            }
        } else {
            console.error("Erro ao carregar posts:", result);
        }
    } catch (error) {
        console.error("Erro na requisição de posts:", error);
    }
}

// Carregar posts ao iniciar
loadPosts();

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
        removeBtn.onclick = () => removeFile(index);
        
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
