<header>
    <img id="btnBack" src="frontend/static/img/left-arrow.png" alt="icon de voltar a pagina"> <span id="aberração" style="font-size: 1.3rem;">Perfil</span>

    <div class="col d-flex justify-content-end align-items-center">

        <div class="light-dark px-3 mt-2">
            <div class="moon p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                    <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286" />
                </svg>
            </div>

            <div class="sun p-1 d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                </svg>
            </div>
        </div>
    </div>
</header>
<?php
if (!isset($_GET['profile'])) {
    header("Location: /");
    exit;
}
$profile_id = $_GET['profile'];
?>

<section>
    <div id="profile-div">
        <div id="profile-box">
            <div id="user-infos">
                <div id="user-photo">

                </div>
                <span id="username"></span>
                <span id="user-role"></span>
                <span class="user-etec"></span>
            </div>

            <div id="perfil-icon-div">
                <span>
                    <img class="perfil-icon" src="frontend/static/img/loca-icon.png" alt="icon de localização">
                    <span id="perfil-address"></span>
                </span>
                <span>
                    <img class="perfil-icon" src="frontend/static/img/calendar-icon.png" alt="icon de calendário">
                    <span id="perfil-created">Membro desde março de 2025</span>
                </span>
            </div>
            <div id="social-info-div">

                <div id="post-qtn-div">
                    <span id="post-qtn"></span>
                    <span>Posts</span>
                </div>
                <div class="simoh" data-type="following">
                    <span id="following_count"></span>
                    <span>Seguindo</span>
                </div>
                <div class="simoh" data-type="followers">
                    <span id="followers_count"></span>
                    <span>Seguidores</span>
                </div>

            </div>
            <?php if ($profile_id === "mine"): ?>

                <button class="perfil-button loki" id="edit-profile-button">
                    Editar perfil
                </button>
                <button class="perfil-button loki" id="leave-account-button">
                    Sair da conta
                </button>
            <?php else: ?>
                <button class="perfil-button" id="follower-button" data-follower="0">

                </button>
                <button class="perfil-button loki" id="chat-button">
                    Chat
                </button>
            <?php endif; ?>

        </div>

    </div>

    <div id="posts-div">
        <?php if ($profile_id === "mine"): ?>

            <dialog id="post-modal">
                <ul>
                    <li id="edit-post-li">
                        <span id="icon-edit" class="icon bi bi-pencil-fill"></span>

                        <span class="text">Editar</span>

                    </li>
                    <li id="delete-post-li">
                        <span id="icon-delete" class="icon bi bi-trash-fill"></span>

                        <span class="text">Excluir</span>

                    </li>
                </ul>
            </dialog>

            <!-- Modal de Edição de Post -->
            <dialog id="edit-post-modal">
                <div class="edit-post-modal-content">
                    <div class="edit-post-modal-header">
                        <h3>Editar Publicação</h3>
                        <button class="edit-post-modal-close" aria-label="Fechar">&times;</button>
                    </div>
                    <div class="edit-post-modal-body">
                        <textarea id="edit-post-content" class="edit-post-textarea" placeholder="Digite o novo conteúdo da publicação..." rows="6"></textarea>
                        <p class="edit-post-help-text">O conteúdo precisa ter pelo menos 5 caracteres.</p>
                    </div>
                    <div class="edit-post-modal-footer">
                        <button class="edit-post-btn edit-post-btn-cancel" id="edit-post-cancel">Cancelar</button>
                        <button class="edit-post-btn edit-post-btn-save" id="edit-post-save">Salvar</button>
                    </div>
                </div>
            </dialog>
            <div class="posts-header">

                <div>

                    <h3 id="h3-publicacoes">Publicações</h3>
                    <h4 id="h4-publicacoes">Todas as suas postagens na Eteconnect</h4>
                </div>
            <?php else: ?>
                <div class="posts-header">
                    <div>
                        <h3 id="h3-publicacoes">Publicações</h3>
                        <h4 id="h4-publicacoes">Todas as postagens na Eteconnect</h4>
                    </div>

                <?php endif; ?>
                <button id="toggle-posts-btn" class="toggle-posts-btn interactive">

                    <span class="toggle-text posts">
                        <i class="bi bi-grid-fill"></i>
                        <span class="showemcampo">Posts</span>
                    </span>

                    <span class="toggle-text liked">
                        <i class="bi bi-heart-fill"></i>
                        <span class="showemcampo">Curtidas</span>
                    </span>

                </button>
                </div>
                <div id="posts-box" class=" posts row mt-1 px-1">

                </div>
                <div id="liked-posts-box" class=" posts row mt-1 px-1">

                </div>


            </div>


            <?php if ($profile_id === "mine"): ?>

                <dialog id="edit-profile-modal">


                    <div class="alert-container">

                    </div>
                    <div id="modal-header">
                        <div>
                            <span style="font-size: 1.5rem;font-weight:500;">Editar Perfil</span>
                            <span aria-label="Fechar janela" id="close-modal-btn">X</span>
                        </div>
                        <span style="color:#666666;">Atualize suas informações pessoais</span>
                    </div>
                    <form id="update-form">
                        <div id="update-photo-div">
                            <input type="file" id="profilePic" style="display:none" value="nochange" />


                            <label for="profilePic" id="photo-label" title="Clique para alterar foto">
                            </label>
                            <i class="bi bi-pencil-fill" id="edit-icon" style="font-size: 0.85rem;position:relative;left:-1.5rem;bottom:-2rem;background:white;border-radius:50%;padding:0.25rem;border:1px solid black"></i>

                            <span aria-label="reset imagem de perfil" id="remove-pic" style="position:relative;left:-1.5rem;bottom:-2rem;background:white;border-radius:50%;padding: 0.25rem ;border:1px solid black;width: 1.5rem;height: 1.5rem;display:flex;justify-content:center;align-items:center;cursor:pointer;display:none;" title="clique para remover a foto">X</span>


                        </div>
                        <div id="update-user-div">
                            <label for="name-update">Nome</label>
                            <input type="text" id="name-update" name="name" placeholder="nome">
                            <label for="email-update">Email</label>
                            <input type="email" id="email-update" name="email" placeholder="email@etec.sp.gov.br">
                            <label for="phone-update">Telefone</label>
                            <input type="tel" id="phone-update" name="phone" placeholder="xxxxxxx-xxxx">
                            <label>ETEC</label>
                            <div id="campus-update-div">
                                <select class="campus-select" id="campus-select-1">
                                    <option disabled selected value="monstro">selecione</option>
                                </select>
                                <button type="button" id="add-campus-btn">+</button>
                            </div>
                            <!--Se for aluno-->
                            <label for="course-select">Curso</label>
                            <div id="course-update-div">

                                <button type="button" id="add-course-btn">+</button>

                            </div>


                        </div>
                        <div id="update-address-div">
                            <label for="street-update">Rua</label>
                            <input type="text" id="street-update" name="street" placeholder="Rua">

                            <label for="address-number-update">Número</label>
                            <input type="text" id="address-number-update" name="address_number" placeholder="Número">

                            <label for="city-update">Cidade</label>
                            <input type="text" id="city-update" name="city" placeholder="Cidade">

                            <label for="state-update">Estado</label>
                            <input type="text" id="state-update" name="state" placeholder="UF" maxlength="2">

                            <label for="zip-code-update">CEP</label>
                            <input type="text" id="zip-code-update" name="zip_code" placeholder="CEP">

                        </div>
                        <button type="submit">Enviar</button>
                    </form>

                </dialog>
            <?php endif; ?>

            <!-- Post Focus Modal -->
            <div class="container-post-focus d-none">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="post-focus">
                        <button class="close-post-focus" onclick="closePostFocus()">&times;</button>
                        <div class="d-flex align-items-center mb-2">
                            <div alt="perfil" class="img-profile-post me-2" id="profile-photo-post-focus">

                            </div>
                            <div>
                                <p class="name-text mb-0"><strong></strong></p>
                                <span class="badge "></span>
                                <p class="sub-text mb-0"></p>
                            </div>
                        </div>
                        <p id="textPost" class="mb-2">
                            <span class="text-primary"></span>
                        </p>

                        <!-- Container para mídia do post -->
                        <div id="postFocusMedia" class="post-focus-media mt-3 d-none">
                            <div class="d-flex flex-wrap gap-2" id="postFocusMediaContainer"></div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center gap-3">
                            <div class="like-post d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-heart me-1" viewBox="0 0 16 16">
                                    <path
                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                </svg>
                                <span id="qntLikes">0</span>
                            </div>


                            <div class="comments d-flex align-items-center" onclick="toggleCommentsFocus()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                </svg>
                            </div>
                        </div>


                        <div class="comment mt-3">
                            <p id="interactionComment"><strong>Comentários</strong></p>
                            <form class="form-comment">
                                <div class="write-comment">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control p-2" placeholder="Seu comentário" aria-label="Seu comentário" name="comment">
                                        <button class="btn btn-outline-secondary" type="button" id="btnSend"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                                            </svg></button>
                                    </div>
                                </div>
                            </form>
                            <div class="comment-list">
                                <!-- Comentários serão carregados aqui dinamicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal apenas para comentários -->
            <div class="container-comments-only d-none">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="comments-only-modal">
                        <button class="close-comments-only" onclick="closeCommentsOnly()">&times;</button>
                        <h5 class="mb-3">Comentários</h5>
                        <div id="commentsOnlyContainer">
                            <!-- Comentários serão carregados aqui -->
                        </div>
                        <form class="form-comment mt-3">
                            <div class="write-comment">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control p-2" placeholder="Seu comentário" aria-label="Seu comentário" name="comment">
                                    <button class="btn btn-outline-secondary" type="button" id="btnSendCommentsOnly">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

</section>

<div id="followModal" class="follow-modal-overlay">
    <div class="follow-modal bg-card shadow-heavy border-primary">
        <div class="follow-modal-header">
            <div class="follow-tabs">
                <button class="tab-btn active" data-tab="followers">Seguidores</button>
                <button class="tab-btn" data-tab="following">Seguindo</button>
            </div>
            <button class="close-modal">&times;</button>
        </div>

        <div class="follow-modal-body">
            <div class="tab-content active" id="followers">
                <p class="text-muted">Lista de seguidores aqui...</p>
            </div>

            <div class="tab-content" id="following">
                <p class="text-muted">Lista de seguindo aqui...</p>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="/frontend/static/css/posts.css">
<link rel="stylesheet" href="/frontend/static/css/post-focus.css">
<link rel="stylesheet" href="/frontend/static/css/comments.css">
<link rel="stylesheet" href="/frontend/static/css/alerts.css">
<link rel="stylesheet" href="/frontend/static/css/editPostModal.css">
<script src="/frontend/static/js/alerts.js"></script>
<script src="/frontend/static/js/commentsFunctions.js"></script>
<script src="/frontend/static/js/addCommentBox.js"></script>
<script src="/frontend/static/js/likeFunctions.js"></script>
<script src="/frontend/static/js/loadUserInformation.js"></script>
<script src="/frontend/static/js/executeWithRefresh.js"></script>
<script src="/frontend/static/js/getUserPosts.js"></script>
<script src="/frontend/static/js/getPayload.js"></script>
<script src="/frontend/static/js/addPostBox.js"></script>
<script src="/frontend/static/js/postFocusFunctions.js"></script>
<?php if ($profile_id == "mine"): ?>
    <script src="frontend/static/js/deletePost.js"></script>
    <script src="frontend/static/js/updatePost.js"></script>

<?php else: ?>
    <script src="/frontend/static/js/sendMessages.js"></script>

<?php endif; ?>
<script src="frontend/static/js/followFunctions.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', async function() {



        userData = await executeWithRefresh(loadUserInformation, <?= json_encode($profile_id) ?>);
        userData = userData?.data ?? null

        const userInfo = userData?.user ?? null
        const addressInfo = userData?.address ?? null
        const campusInfo = userData?.campus ?? null

        if (userInfo != null) {
            <?php if ($profile_id !== "mine"): ?>
                const payload = getPayload(localStorage.getItem("jwt_token"))
                const user_id = payload.id

                if (user_id == userInfo.id) {
                    window.history.replaceState(null, '', window.location.pathname);

                    window.location.href = "/profile?profile=mine"
                }
            <?php endif; ?>
            const username = userInfo?.name ?? "usuario"
            document.querySelector("#username").innerText = username;

            const role = userInfo?.role ?? "user"
            document.querySelector("#user-role").innerText = role;
            const roleColor = (role == "estudante") ? "#E11D48" : "#2563EB"
            document.querySelector("#user-role").style.background = roleColor;

            const created_at = userInfo.created_at;





            const date = new Date(created_at);

            const formattedDate = date.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            document.querySelector("#followers_count").innerText = userData?.followers_count?.followers_count
            document.querySelector("#following_count").innerText = userData?.following_count?.following_count

            document.querySelector("#perfil-created").innerText = `Membro desde ${formattedDate}`;

            const profilePath = userInfo.profile_photo_path

            const userPhoto = document.querySelector("#user-photo")

            userPhoto.style.backgroundImage = profilePath ?
                `url("${profilePath}")` :
                "none";

            userPhoto.style.backgroundColor = profilePath ?
                "transparent" :
                roleColor;

            userPhoto.innerText = profilePath ?
                "" :
                getProfileLetter(username);

            userPhoto.style.backgroundRepeat = "no-repeat";
            userPhoto.style.backgroundPosition = "center";
            userPhoto.style.backgroundSize = "cover";




        }
        if (campusInfo !== null) {

            const parent = document.querySelector("#user-infos")
            if (campusInfo.length == 1) {
                const span = document.createElement("span")
                span.classList.add("user-etec")
                span.innerText = campusInfo[0].name
                parent.appendChild(span)

            } else {
                const span = document.createElement("span")
                span.classList.add("user-etec")
                span.innerText = "ETECS"
                span.style.cursor = "pointer"
                span.style.color = "#E11D48"
                parent.appendChild(span)

                // Criar modal
                const modal = document.createElement("div")
                modal.id = "etecs-modal"
                modal.style.display = "none"

                const modalTitle = <?php if ($profile_id === "mine"): ?> "Suas ETECs"
            <?php else: ?> "ETECs de " + (userInfo?.name ?? "usuário") <?php endif; ?>

                modal.innerHTML = `
                    <div class="etecs-modal-content">
                        <div class="etecs-modal-header">
                            <h3>${modalTitle}</h3>
                            <button class="close-etecs-modal">×</button>
                        </div>
                        <div class="etecs-modal-body">
                            <ul class="etecs-list">
                                ${campusInfo.map(campus => `<li>${campus.name}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `
                document.body.appendChild(modal)

                // Função para abrir modal
                const openModal = (e) => {
                    e.stopPropagation()
                    const rect = span.getBoundingClientRect()
                    const profileBox = document.querySelector("#profile-box")
                    const profileBoxRect = profileBox.getBoundingClientRect()

                    // Posicionar modal centralizado
                    const modalWidth = 300
                    const spanCenter = rect.left + (rect.width / 2)
                    const modalLeft = spanCenter - (modalWidth / 2)

                    // Limitar dentro da div do perfil
                    const maxLeft = profileBoxRect.right - modalWidth - 20
                    const minLeft = profileBoxRect.left + 20
                    const finalLeft = Math.max(minLeft, Math.min(modalLeft, maxLeft))

                    modal.style.position = "absolute"
                    modal.style.top = (rect.bottom + 10) + "px"
                    modal.style.left = finalLeft + "px"
                    modal.style.display = "block"
                    span.style.pointerEvents = "none"
                }

                // Função para fechar modal
                const closeModal = () => {
                    modal.style.display = "none"
                    span.style.pointerEvents = "auto"
                }

                // Event listeners
                span.addEventListener("click", openModal)
                modal.querySelector(".close-etecs-modal").addEventListener("click", closeModal)
                document.addEventListener("click", (e) => {
                    if (!modal.contains(e.target) && e.target !== span) {
                        closeModal()
                    }
                })
            }


        } else {
            document.querySelector(".user-etec").innerText = "ETEC"

        }

        if (addressInfo != null) {
            const city = addressInfo?.city ?? ""
            const state = addressInfo?.state ?? ""
            document.querySelector("#perfil-address").innerText = `${city}, ${state}`;

        }

        if (userInfo?.role === "professor") {
            const toggleBtn = document.getElementById("toggle-posts-btn");
            toggleBtn.style.display = "flex";
            toggleBtn.dataset.mode = "posts"; // estado inicial

            toggleBtn.addEventListener("click", () => {
                if (toggleBtn.dataset.mode === "posts") {
                    toggleBtn.dataset.mode = "liked";
                    document.querySelector("#liked-posts-box").style.display = "block"
                    document.querySelector("#posts-box").style.display = "none"
                    <?php if ($profile_id === "mine"): ?>
                        document.querySelector("#h3-publicacoes").innerText = "Publicações Curtidas"
                        document.querySelector("#h4-publicacoes").innerText = "Todas as postagens que você curtiu na Eteconnect"
                    <?php else: ?>
                        document.querySelector("#h3-publicacoes").innerText = "Publicações Curtidas"
                        document.querySelector("#h4-publicacoes").innerText = "Todas as postagens que " + (userInfo?.name ?? "usuário") + " curtiu na Eteconnect"
                    <?php endif; ?>

                } else {
                    toggleBtn.dataset.mode = "posts";
                    document.querySelector("#liked-posts-box").style.display = "none"
                    document.querySelector("#posts-box").style.display = "flex"
                    <?php if ($profile_id === "mine"): ?>
                        document.querySelector("#h3-publicacoes").innerText = "Publicações"
                        document.querySelector("#h4-publicacoes").innerText = "Todas as suas postagens na Eteconnect"
                    <?php else: ?>
                        document.querySelector("#h3-publicacoes").innerText = "Publicações"
                        document.querySelector("#h4-publicacoes").innerText = "Todas as postagens na Eteconnect"
                    <?php endif; ?>
                }
            });


            const userPostData = await executeWithRefresh(getUserPosts, <?= json_encode($profile_id) ?>)
            const postsInfos = userPostData?.data?.posts ?? []
            const campusInfos = userPostData?.data?.campus ?? [{
                name: "ETEC"
            }]
            document.querySelector("#post-qtn").innerText = postsInfos?.length ?? 0
            document.querySelector("#liked-posts-box").style.display = "none"

            //perdi minha humanidade aqui

            postsInfos.forEach(postInfo => {
                postInfo["campus"] = campusInfos
                const post = addPostBox(postInfo)
                const likebtn = post.querySelector(".post-like-icon")
                const postId = postInfo.id

                // Adicionar evento de clique para abrir post focus
                post.addEventListener('click', function(e) {
                    // Não abrir se clicou no botão de like ou em elementos interativos
                    if (e.target.closest('.interactive')) {
                        return;
                    }
                    openPostFocus(postInfo);
                });

                likebtn.addEventListener("click", async () => {

                    if (post.dataset.user_liked == 0) {
                        const data = await executeWithRefresh(addLike, 'post', postId)
                        changeFrontLike(post, true)
                        post.dataset.user_liked = 1
                    } else {
                        const data = await executeWithRefresh(deleteLike, 'post', postId)

                        changeFrontLike(post, false)
                        post.dataset.user_liked = 0
                    }


                })
                <?php if ($profile_id === "mine"): ?>
                    const postModal = document.querySelector("#post-modal")

                    const openModalFunction = (e, id) => {
                        const postModal = document.querySelector("#post-modal")

                        if (!postModal.open) {
                            postModal.dataset.postId = id
                            postModal.style.visibility = 'hidden';
                            postModal.style.display = 'block';

                            e.preventDefault();

                            const clickX = e.pageX;
                            const clickY = e.pageY;

                            const windowWidth = window.innerWidth;
                            const windowHeight = window.innerHeight;

                            const modalWidth = postModal.offsetWidth;
                            const modalHeight = postModal.offsetHeight;

                            let left = clickX;
                            let top = clickY;

                            if (clickX + modalWidth > windowWidth) {
                                left = clickX - modalWidth;
                            }

                            if (clickY + modalHeight > windowHeight) {
                                top = clickY - modalHeight;
                            }

                            postModal.style.left = `${left}px`;
                            postModal.style.top = `${top}px`;
                            postModal.style.visibility = '';
                            postModal.style.display = '';

                            postModal.show()
                            const handleOutClick = (event) => {
                                if (!postModal.contains(event.target)) {
                                    postModal.close();
                                    document.removeEventListener('click', handleOutClick);
                                }
                            };

                            setTimeout(() => {
                                document.addEventListener('click', handleOutClick);
                            }, 0);
                        } else {
                            postModal.close();
                        }

                    }
                    const authorNameDiv = post.querySelector(".author-name-div")
                    const spanmenu = document.createElement("span")
                    spanmenu.classList.add("menu-post", "interactive");
                    spanmenu.innerText = "⋮"
                    authorNameDiv.append(spanmenu)
                    spanmenu.addEventListener("click", (e) => openModalFunction(e, postId))
                    post.addEventListener('contextmenu', (e) => openModalFunction(e, postId));

                <?php endif; ?>

                document.querySelector("#posts-box").appendChild(post)


            });
            <?php if ($profile_id === "mine"): ?>

                // Função auxiliar para fechar todos os modais exceto o especificado
                function closeOtherModals(exceptModal = null) {
                    const modals = [
                        document.querySelector("#edit-profile-modal"),
                        document.querySelector("#edit-post-modal"),
                        document.querySelector("#post-modal")
                    ];

                    modals.forEach(modal => {
                        if (modal && modal !== exceptModal && modal.open) {
                            modal.close();
                        }
                    });
                }

                // Handler para editar post
                const editli = document.querySelector("#edit-post-li")
                const editPostModal = document.querySelector("#edit-post-modal")
                const editPostContent = document.querySelector("#edit-post-content")
                const editPostSave = document.querySelector("#edit-post-save")
                const editPostCancel = document.querySelector("#edit-post-cancel")
                const editPostClose = document.querySelector(".edit-post-modal-close")

                editli.addEventListener("click", async () => {
                    const postModal = document.querySelector("#post-modal")
                    const postId = postModal.dataset.postId
                    const post = document.querySelector(`.post[data-post-id="${postId}"]`);

                    // Busca o conteúdo atual do post (classe .post-content)
                    const postContentElement = post.querySelector(".post-content");
                    const currentContent = postContentElement ? postContentElement.textContent.trim() : "";

                    if (!currentContent) {
                        showWarning("Não foi possível carregar o conteúdo da publicação.");
                        postModal.close();
                        return;
                    }

                    // Preenche o textarea com o conteúdo atual
                    editPostContent.value = currentContent;
                    editPostModal.dataset.postId = postId;

                    // Fecha o menu de opções
                    postModal.close();

                    // Fecha outros modais que possam estar abertos
                    closeOtherModals(editPostModal);

                    // Abre o modal de edição
                    editPostModal.showModal();
                });

                // Fechar modal de edição
                editPostClose.addEventListener("click", () => {
                    editPostModal.close();
                });

                editPostCancel.addEventListener("click", () => {
                    editPostModal.close();
                });

                // Salvar edição
                editPostSave.addEventListener("click", async () => {
                    const postId = editPostModal.dataset.postId;
                    const newContent = editPostContent.value.trim();

                    if (!newContent || newContent.length < 5) {
                        showWarning("O conteúdo precisa ter pelo menos 5 caracteres.");
                        return;
                    }

                    editPostSave.disabled = true;
                    editPostSave.textContent = "Salvando...";

                    const data = await executeWithRefresh(updatePost, postId, newContent);

                    if (data.status === "success") {
                        showSuccess("Publicação atualizada com sucesso!");
                        editPostModal.close();

                        // Recarrega os posts
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showBackendError(data, "Erro ao atualizar publicação");
                        editPostSave.disabled = false;
                        editPostSave.textContent = "Salvar";
                    }
                });

                // Handler para excluir post com confirmação
                const deleteli = document.querySelector("#delete-post-li")
                deleteli.addEventListener("click", async () => {
                    const postModal = document.querySelector("#post-modal")
                    const postId = postModal.dataset.postId
                    const post = document.querySelector(`.post[data-post-id="${postId}"]`);

                    // Fecha o menu de opções
                    postModal.close();

                    // Mostra modal de confirmação
                    const confirmed = await confirmAction(
                        "Tem certeza que deseja excluir esta publicação? Esta ação não pode ser desfeita.",
                        "Confirmar Exclusão"
                    );

                    if (confirmed) {
                        const data = await executeWithRefresh(deletePost, postId)
                        if (data.status === "success") {
                            showSuccess("Publicação excluída com sucesso!");
                            post.classList.add("post-deleting");
                            setTimeout(() => {
                                post.remove();
                            }, 600);
                        } else {
                            showBackendError(data, "Erro ao excluir publicação");
                        }
                    }
                })

            <?php endif; ?>

        }
        <?php if ($profile_id === "mine"): ?>

            // Função auxiliar para fechar todos os modais exceto o especificado
            function closeOtherModals(exceptModal = null) {
                const modals = [
                    document.querySelector("#edit-profile-modal"),
                    document.querySelector("#edit-post-modal"),
                    document.querySelector("#post-modal")
                ];

                modals.forEach(modal => {
                    if (modal && modal !== exceptModal && modal.open) {
                        modal.close();
                    }
                });
            }

            // Handler para editar post
            const editli = document.querySelector("#edit-post-li")
            const editPostModal = document.querySelector("#edit-post-modal")
            const editPostContent = document.querySelector("#edit-post-content")
            const editPostSave = document.querySelector("#edit-post-save")
            const editPostCancel = document.querySelector("#edit-post-cancel")
            const editPostClose = document.querySelector(".edit-post-modal-close")

            editli.addEventListener("click", async () => {
                const postModal = document.querySelector("#post-modal")
                const postId = postModal.dataset.postId
                const post = document.querySelector(`.post[data-post-id="${postId}"]`);

                // Busca o conteúdo atual do post (classe .post-content)
                const postContentElement = post.querySelector(".post-content");
                const currentContent = postContentElement ? postContentElement.textContent.trim() : "";

                if (!currentContent) {
                    showWarning("Não foi possível carregar o conteúdo da publicação.");
                    postModal.close();
                    return;
                }

                // Preenche o textarea com o conteúdo atual
                editPostContent.value = currentContent;
                editPostModal.dataset.postId = postId;

                // Fecha o menu de opções
                postModal.close();

                // Fecha outros modais que possam estar abertos
                closeOtherModals(editPostModal);

                // Abre o modal de edição
                editPostModal.showModal();
            });

            // Fechar modal de edição
            editPostClose.addEventListener("click", () => {
                editPostModal.close();
            });

            editPostCancel.addEventListener("click", () => {
                editPostModal.close();
            });

            // Salvar edição
            editPostSave.addEventListener("click", async () => {
                const postId = editPostModal.dataset.postId;
                const newContent = editPostContent.value.trim();

                if (!newContent || newContent.length < 5) {
                    showWarning("O conteúdo precisa ter pelo menos 5 caracteres.");
                    return;
                }

                editPostSave.disabled = true;
                editPostSave.textContent = "Salvando...";

                const data = await executeWithRefresh(updatePost, postId, newContent);

                if (data.status === "success") {
                    showSuccess("Publicação atualizada com sucesso!");
                    editPostModal.close();

                    // Recarrega os posts
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showBackendError(data, "Erro ao atualizar publicação");
                    editPostSave.disabled = false;
                    editPostSave.textContent = "Salvar";
                }
            });

            // Handler para excluir post com confirmação
            const deleteli = document.querySelector("#delete-post-li")
            deleteli.addEventListener("click", async () => {
                const postModal = document.querySelector("#post-modal")
                const postId = postModal.dataset.postId
                const post = document.querySelector(`.post[data-post-id="${postId}"]`);

                // Fecha o menu de opções
                postModal.close();

                // Mostra modal de confirmação
                const confirmed = await confirmAction(
                    "Tem certeza que deseja excluir esta publicação? Esta ação não pode ser desfeita.",
                    "Confirmar Exclusão"
                );

                if (confirmed) {
                    const data = await executeWithRefresh(deletePost, postId)
                    if (data.status === "success") {
                        showSuccess("Publicação excluída com sucesso!");
                        post.classList.add("post-deleting");
                        setTimeout(() => {
                            post.remove();
                        }, 600);
                    } else {
                        showBackendError(data, "Erro ao excluir publicação");
                    }
                }
            })

        <?php endif; ?>
        if (userInfo?.role === "estudante") {
            document.querySelector("#posts-box").style.display = "none"
            document.querySelector("#post-qtn-div").style.display = "none"

        }
        <?php if ($profile_id === "mine"): ?>
            if (userInfo?.role === "estudante") {
                document.querySelector("#post-qtn-div").style.display = "none"
                document.querySelector("#h3-publicacoes").innerText = "Publicações Curtidas"
                document.querySelector("#h4-publicacoes").innerText = "Todas as postagens que você curtiu na Eteconnect"



            }

        <?php else: ?>
            if (userInfo?.role === "estudante") {
                document.querySelector("#post-qtn-div").style.display = "none"
                document.querySelector("#h3-publicacoes").innerText = "Publicações Curtidas"
                document.querySelector("#h4-publicacoes").innerText = "Todas as postagens que " + (userInfo?.name ?? "usuário") + " curtiu na Eteconnect"

            }

        <?php endif; ?>

        function getLikedPostsByUser(user_id) {
            return fetch(`/api/getLikedPostsByUser?user_id=${user_id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('jwt_token')}`
                    }
                })
                .then(response => response.json());
        }
        const userLikedPosts = await executeWithRefresh(getLikedPostsByUser, <?= json_encode($profile_id) ?>)
        console.log("mal absluto")
        const postsInfos = userLikedPosts?.data?.posts ?? [];
        const likedPostsBox = document.querySelector("#liked-posts-box");
        likedPostsBox.innerHTML = "";


        postsInfos.forEach(postInfo => {

            postInfo.campus = [];

            if (postInfo.campus_names && postInfo.campus_names.length > 0) {
                postInfo.campus = postInfo.campus_names
                    .split(" | ")
                    .map(name => ({
                        name
                    }));
            } else {
                postInfo.campus = [{
                    name: "ETEC"
                }];
            }

            const post = addPostBox(postInfo);
            const likebtn = post.querySelector(".post-like-icon");
            const postId = postInfo.id;

            post.addEventListener("click", function(e) {
                if (e.target.closest(".interactive")) return;
                openPostFocus(postInfo);
            });

            likebtn.addEventListener("click", async () => {

                if (post.dataset.user_liked == 0) {
                    await executeWithRefresh(addLike, "post", postId);
                    changeFrontLike(post, true);
                    post.dataset.user_liked = 1;
                } else {
                    await executeWithRefresh(deleteLike, "post", postId);
                    changeFrontLike(post, false);
                    post.dataset.user_liked = 0;
                }
                const payload = getPayload(localStorage.getItem("jwt_token"))
                const user_id = payload.id
                console.log("user id:", user_id)
                console.log("userinfo:", userInfo)
                if (userInfo.id === user_id) {
                    post.remove();
                }
            });

            likedPostsBox.appendChild(post);
        });

        <?php if ($profile_id === "mine"): ?>

            function clearAllCookies() {
                const cookies = document.cookie.split(";");

                for (let cookie of cookies) {
                    const eqPos = cookie.indexOf("=");
                    const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;

                    document.cookie =
                        name.trim() + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                }
            }

            document.querySelector("#leave-account-button").addEventListener("click", async () => {
                const confirmed = await confirmAction(
                    "Tem certeza que deseja sair da sua conta? Você precisará fazer login novamente.",
                    "Confirmar Saída"
                );

                if (confirmed) {
                    localStorage.clear()
                    sessionStorage.clear()
                    clearAllCookies()
                    window.location.href = "/login"
                }
            })

            const remove_campus_id_array = []
            const remove_course_id_array = []

            document.querySelector("#edit-profile-button").addEventListener("click", async () => {
                const modal = document.querySelector("#edit-profile-modal")

                // Fecha outros modais que possam estar abertos
                closeOtherModals(modal);

                modal.showModal();

                let userData = null;
                try {
                    userData = JSON.parse(sessionStorage.getItem('userData'));
                } catch (e) {
                    userData = null;
                }
                if (userData === null) {
                    userData = await executeWithRefresh(loadUserInformation, "mine");
                    sessionStorage.setItem('userData', JSON.stringify(userData?.data));
                }

                const userInfo = userData?.user ?? null
                const addressInfo = userData?.address ?? null
                const campusInfos = userData?.campus ?? null
                const coursesInfos = userData?.course ?? null
                const role = userInfo?.role



                if (userInfo != null) {
                    const username = userInfo?.name ?? "usuario"

                    const role = userInfo?.role ?? "user"
                    const roleColor = (role == "estudante") ? "#E11D48" : "#2563EB"

                    const profilePath = userInfo.profile_photo_path
                    const userPhoto = document.querySelector("#photo-label")

                    userPhoto.style.backgroundImage = profilePath ?
                        `url("${profilePath}")` :
                        "none";

                    userPhoto.style.backgroundColor = profilePath ?
                        "transparent" :
                        roleColor;

                    userPhoto.innerText = profilePath ?
                        "" :
                        getProfileLetter(username);

                    userPhoto.style.backgroundRepeat = "no-repeat";
                    userPhoto.style.backgroundPosition = "center";
                    userPhoto.style.backgroundSize = "cover";


                    const email = userInfo?.email ?? ""
                    const phone = userInfo?.phone ?? ""

                    document.querySelector("#name-update").value = username
                    document.querySelector("#email-update").value = email
                    document.querySelector("#phone-update").value = phone

                }
                if (addressInfo != null) {
                    document.querySelector("#street-update").value = addressInfo.street ?? "";
                    document.querySelector("#address-number-update").value = addressInfo.address_number ?? "";
                    document.querySelector("#city-update").value = addressInfo.city ?? "";
                    document.querySelector("#state-update").value = addressInfo.state ?? "";
                    document.querySelector("#zip-code-update").value = addressInfo.zip_code ?? "";
                }
                const coursesOrEtecs = document.querySelectorAll('.pod-div');
                coursesOrEtecs.forEach(div => div.remove());
                if (campusInfos !== null) {
                    if (role === "professor") {
                        campusInfo.forEach((campusInfo) => {
                            const btn = document.querySelector("#add-campus-btn")
                            const div = document.createElement("div")
                            div.classList.add("pod-div")
                            div.innerText = `${campusInfo.name}`
                            document.querySelector("#campus-update-div").prepend(div);
                            //calmo frio me mantenho leve
                            const btnDeleteCampus = document.createElement("btn")
                            btnDeleteCampus.classList.add("delete-campus-btn")
                            btnDeleteCampus.dataset.id = campusInfo.id
                            btnDeleteCampus.innerText = "X"
                            div.append(btnDeleteCampus)
                            btnDeleteCampus.addEventListener("click", () => {
                                remove_campus_id_array.push(btnDeleteCampus.dataset.id)
                                div.remove();
                            })
                        })
                    } else {
                        const campusInfo = campusInfos[0]
                        const campusSelect1 = document.querySelector("#campus-select-1")
                        const selectedOption = campusSelect1.options[campusSelect1.selectedIndex];
                        selectedOption.text = campusInfo.name
                        selectedOption.value = "ameno murakomo no tsurugi"
                        campusSelect1.dataset.campusId = campusInfo.id
                    }
                }
                if (coursesInfos !== null) {
                    coursesInfos.forEach((courseInfo) => {
                        const btn = document.querySelector("#add-course-btn")
                        const div = document.createElement("div")
                        div.classList.add("pod-div")
                        div.innerText = `${courseInfo.name}`
                        document.querySelector("#course-update-div").prepend(div);
                        //calmo frio me mantenho leve
                        const btnDeleteCourse = document.createElement("btn")
                        btnDeleteCourse.classList.add("delete-campus-btn")
                        btnDeleteCourse.dataset.id = courseInfo.id
                        btnDeleteCourse.innerText = "X"
                        div.append(btnDeleteCourse)
                        btnDeleteCourse.addEventListener("click", () => {
                            remove_course_id_array.push(btnDeleteCourse.dataset.id)
                            div.remove();
                        })


                    })


                }

                const campusSelect = document.querySelector("#campus-select-1")
                campusSelect.addEventListener("click", async (event) => {
                    const select = campusSelect
                    if (select.options.length !== 1) {
                        return
                    }
                    const response = await executeWithRefresh(fetch, "/api/getAllEtecsNames")
                    if (!response.ok) {
                        return
                    }
                    const data = await response.json();
                    if (data.status !== "success") {
                        return
                    }
                    data.data.forEach((dt) => {
                        const option = document.createElement("option")
                        option.innerText = dt.name
                        option.value = dt.id
                        select.appendChild(option)
                    })
                })
                if (role === "professor") {
                    document.querySelector("#course-update-div").style.display = "none"
                    const label = document.querySelector('label[for="course-select"]')
                    label.style.display = "none"
                    document.querySelector("#add-campus-btn").addEventListener("click", (event) => {
                        const btn = event.target
                        const select = document.createElement("select")
                        select.classList.add("campus-select")
                        select.innerHTML = "<option disabled selected value='monstro'>selecione</option>"
                        document.querySelector("#campus-update-div").insertBefore(select, btn);

                        select.addEventListener("click", async (event) => {
                            if (select.options.length !== 1) {
                                return
                            }
                            const response = await fetch("/api/getAllEtecsNames")
                            if (!response.ok) {
                                return
                            }
                            const data = await response.json();
                            if (data.status !== "success") {
                                return
                            }
                            data.data.forEach((dt) => {
                                const option = document.createElement("option")
                                option.innerText = dt.name
                                option.value = dt.id
                                select.appendChild(option)
                            })
                        })


                    })
                    campusSelect.style.display = "none"

                } else {
                    document.querySelector("#add-campus-btn").style.display = "none"
                    campusSelect.addEventListener("change", async (event) => {
                        if (campusSelect.value == "monstro") {
                            //selecione uma etec primeiro
                            return
                        }


                        const response = await fetch(`/api/getCoursesByEtec?campus_id=${campusSelect.value}`)
                        if (!response.ok) {
                            return
                        }
                        const data = await response.json();
                        if (data.status !== "success") {
                            return
                        }
                        const selects = document.querySelectorAll(".course-select")
                        selects.forEach((select) => {
                            select.innerHTML = "<option disabled selected >selecione</option>"
                            data.data.forEach((dt) => {
                                const option = document.createElement("option")
                                option.innerText = dt.name
                                option.value = dt.id
                                select.appendChild(option)
                            })

                        })

                    })

                    document.querySelector("#add-course-btn").addEventListener("click", async (event) => {
                        const btn = event.target
                        const select = document.createElement("select")
                        select.classList.add("course-select")
                        select.innerHTML = "<option disabled selected value='monstro'>selecione</option>"
                        document.querySelector("#course-update-div").insertBefore(select, btn);

                        if (campusSelect.value == "monstro") {
                            //selecione uma etec primeiro
                            return
                        }
                        const campusSelect1 = document.querySelector("#campus-select-1")

                        const campusIdSearchQuery = (campusSelect.value === "ameno murakomo no tsurugi") ? campusSelect1.dataset.campusId : campusSelect.value


                        const response = await fetch(`/api/getCoursesByEtec?campus_id=${campusIdSearchQuery}`)
                        if (!response.ok) {
                            return
                        }
                        const data = await response.json();
                        if (data.status !== "success") {
                            return
                        }

                        select.innerHTML = "<option disabled selected >selecione</option>"
                        data.data.forEach((dt) => {
                            const option = document.createElement("option")
                            option.innerText = dt.name
                            option.value = dt.id
                            select.appendChild(option)

                        })


                    })
                }

            });


            document.querySelector("#close-modal-btn").addEventListener("click", () => {
                const modal = document.querySelector("#edit-profile-modal")
                modal.close();

            })
            const inputFile = document.querySelector("#profilePic")
            inputFile.addEventListener('change', () => {
                const file = inputFile.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    const photoLabel = document.querySelector("#photo-label")
                    photoLabel.style.backgroundImage = `url("${url}")`;
                    photoLabel.style.backgroundColor = "none"
                    photoLabel.innerText = ""
                    document.querySelector("#remove-pic").style.display = "flex";
                    document.querySelector("#edit-icon").style.display = "none";
                }
            });

            document.querySelector("#remove-pic").addEventListener("click", () => {

                inputFile.value = "";

                const username = userInfo?.name ?? "usuario"

                const role = userInfo?.role ?? "user"
                const roleColor = (role == "estudante") ? "#E11D48" : "#2563EB"

                const profilePath = userInfo.profile_photo_path
                const userPhoto = document.querySelector("#photo-label")

                userPhoto.style.backgroundImage = profilePath ?
                    `url("${profilePath}")` :
                    "none";

                userPhoto.style.backgroundColor = profilePath ?
                    "transparent" :
                    roleColor;

                userPhoto.innerText = profilePath ?
                    "" :
                    getProfileLetter(username);

                userPhoto.style.backgroundRepeat = "no-repeat";
                userPhoto.style.backgroundPosition = "center";
                userPhoto.style.backgroundSize = "cover";


                document.querySelector("#remove-pic").style.display = "none";
                document.querySelector("#edit-icon").style.display = "block";

            })
            //simoh hayha

            const form = document.querySelector("#update-form")
            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                // Confirmação antes de atualizar perfil



                const formData = new FormData();

                formData.append("name", form.name.value);
                formData.append("email", form.email.value);
                formData.append("phone", form.phone.value);
                formData.append("street", form.street.value);
                formData.append("address_number", form.address_number.value);
                formData.append("city", form.city.value);
                formData.append("state", form.state.value);
                formData.append("zip_code", form.zip_code.value);

                //bug de mira fds vamo abusa
                const has_address = (form.street.value.length === 0) ? false : true
                formData.append("has_address", has_address);


                if (form.profilePic.files.length > 0) {
                    formData.append("profilePic", form.profilePic.files[0]);
                }
                const updateUser = async (formData) => {
                    const token = localStorage.getItem("jwt_token");
                    const response = await fetch("/api/updateUser", {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                    return response.json();
                };

                // Aqui você chama o executeWithRefresh, passando a função updateUser e o formData
                const result = await executeWithRefresh(updateUser, formData);
                if (result.status !== "success") {
                    showBackendError(result, 'Erro ao atualizar perfil');
                    return;
                }

                userData = await executeWithRefresh(loadUserInformation, <?= json_encode($profile_id) ?>);
                sessionStorage.setItem('userData', userData);


                const campusSelects = document.querySelectorAll(".campus-select")
                const campusIds = []
                campusSelects.forEach((campusSelect) => {
                    const value = campusSelect.value
                    if (!isNaN(value)) {
                        campusIds.push(value)
                    }
                })
                if (remove_campus_id_array.length) {
                    const formCampus = new FormData();

                    formCampus.append("campus_Ids", remove_campus_id_array)


                    const deleteCampus = async (formData) => {
                        const token = localStorage.getItem("jwt_token");
                        const response = await fetch("/api/deleteCampusUser", {
                            method: "POST",
                            headers: {
                                'Authorization': `Bearer ${token}`
                            },
                            body: formData
                        });
                        return response.json();
                    };

                    const resultCampus = await executeWithRefresh(deleteCampus, formCampus);

                }
                const uniqueCampusIds = [...new Set(campusIds)];
                if (uniqueCampusIds.length) {

                    const formCampus = new FormData();

                    formCampus.append("campus_Ids", uniqueCampusIds)


                    const updateCampus = async (formData) => {
                        const token = localStorage.getItem("jwt_token");
                        const response = await fetch("/api/addCampusUser", {
                            method: "POST",
                            headers: {
                                'Authorization': `Bearer ${token}`
                            },
                            body: formData
                        });
                        return response.json();
                    };

                    const resultCampus = await executeWithRefresh(updateCampus, formCampus);
                    if (resultCampus.status !== "success") {
                        showBackendError(resultCampus, 'Erro ao atualizar campus');
                        return;
                    }
                }

                const coursesSelects = document.querySelectorAll(".course-select")

                const coursesIds = []
                coursesSelects.forEach((courseSelect) => {
                    const value = courseSelect.value
                    if (!isNaN(value)) {
                        coursesIds.push(value)
                    }
                })
                if (remove_course_id_array.length) {
                    const formCourses = new FormData();

                    formCourses.append("courses_Ids", remove_course_id_array)


                    const deleteCourse = async (formData) => {
                        const token = localStorage.getItem("jwt_token");
                        const response = await fetch("/api/deleteCourseUser", {
                            method: "POST",
                            headers: {
                                'Authorization': `Bearer ${token}`
                            },
                            body: formData
                        });
                        return response.json();
                    };

                    const resultCourse = await executeWithRefresh(deleteCourse, formCourses);
                }


                const uniqueCourseIds = [...new Set(coursesIds)];
                if (uniqueCourseIds.length) {

                    const formCourse = new FormData();

                    formCourse.append("courses_ids", uniqueCourseIds)


                    const updateCourse = async (formData) => {
                        const token = localStorage.getItem("jwt_token");
                        const response = await fetch("/api/addCourseUser", {
                            method: "POST",
                            headers: {
                                'Authorization': `Bearer ${token}`
                            },
                            body: formData
                        });
                        return response.json();
                    };

                    const resultCourse = await executeWithRefresh(updateCourse, formCourse);
                    if (resultCourse.status !== "success") {
                        showBackendError(resultCourse, 'Erro ao atualizar curso');
                        return;
                    }
                }
                showSuccess('Perfil atualizado com sucesso!');
                userData = await executeWithRefresh(loadUserInformation, "mine");
                userData = userData.data
                sessionStorage.setItem('userData', JSON.stringify(userData));

                setTimeout(() => {
                    window.location.reload();
                }, 1000);

            })


        <?php else: ?>
            const followerBtn = document.querySelector("#follower-button");
            const isFollowedData = await executeWithRefresh(isFollowed, <?= json_encode($profile_id) ?>)
            const isfollow = isFollowedData?.data ?? 0
            if (isfollow) {
                changeFrontBtn(followerBtn, true)
                followerBtn.dataset.follower = 1

            } else {
                changeFrontBtn(followerBtn, false)
                followerBtn.dataset.follower = 0

            }
            followerBtn.addEventListener("click", async () => {
                const followers_count_span = document.querySelector("#followers_count")
                if (followerBtn.dataset.follower === "0") {
                    const data = await executeWithRefresh(follow, <?= json_encode($profile_id) ?>)
                    if (data.status == "success") {
                        changeFrontBtn(followerBtn, true)
                        followerBtn.dataset.follower = 1
                        const newCount = parseInt(followers_count_span.innerText) + 1
                        followers_count_span.innerText = newCount
                    }
                } else {
                    const data = await executeWithRefresh(unfollow, <?= json_encode($profile_id) ?>)

                    if (data.status == "success") {
                        changeFrontBtn(followerBtn, false)
                        followerBtn.dataset.follower = 0
                        const newCount = parseInt(followers_count_span.innerText) - 1
                        followers_count_span.innerText = newCount

                    }
                }
            })

            const chatButton = document.querySelector("#chat-button");
            if (chatButton && userInfo && userInfo.id) {
                chatButton.addEventListener("click", () => {
                    const targetId = userInfo.id;
                    sendMessage(targetId," ")
                    window.location.href = `/messages`;

                });
            }

        <?php endif; ?>
        console.log("garou")

        console.log("garou")
        document.getElementById('btnBack').addEventListener('click', function() {

            const referrer = document.referrer;
            const currentHost = window.location.host;

            if (referrer && referrer.includes(currentHost)) {
                window.history.back();
            } else {
                window.location.href = '/';
            }

        });

        // Funções para o post-focus funcionar
        function openPostFocus(postInfo) {
            const postFocus = document.querySelector('.container-post-focus');
            if (postFocus) {
                postFocus.classList.remove('d-none');
                loadPostInFocus(postInfo.id);
            }
        }

        function closePostFocus() {
            const postFocus = document.querySelector('.container-post-focus');
            if (postFocus) {
                postFocus.classList.add('d-none');
            }
        }

        function closeCommentsOnly() {
            const commentsModal = document.querySelector('.container-comments-only');
            if (commentsModal) {
                commentsModal.classList.add('d-none');
            }
        }

        function toggleCommentsFocus() {
            const commentsModal = document.querySelector('.container-comments-only');
            if (commentsModal) {
                commentsModal.classList.remove('d-none');
            }
        }


        const userId = userInfo.id;
        const simohElements = document.querySelectorAll(".simoh");
        const modal = document.getElementById("followModal");
        const closeModal = document.querySelector(".close-modal");
        const tabs = document.querySelectorAll(".tab-btn");
        const contents = document.querySelectorAll(".tab-content");

        // abrir modal pelo perfil
        simohElements.forEach(el => {
            el.addEventListener("click", () => {
                const type = el.dataset.type;
                openModal(type);
                loadFollowData(type); // ✅ carrega ao abrir
            });
        });

        // trocar abas dentro do modal
        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                const type = tab.dataset.tab;

                tabs.forEach(t => t.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));

                tab.classList.add("active");
                document.getElementById(type).classList.add("active");

                loadFollowData(type); // ✅ carrega ao trocar aba
            });
        });

        function openModal(type) {
            modal.style.display = "flex";

            tabs.forEach(tab => {
                tab.classList.toggle("active", tab.dataset.tab === type);
            });

            contents.forEach(content => {
                content.classList.toggle("active", content.id === type);
            });
        }

        // fechar modal
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
        });

        modal.addEventListener("click", e => {
            if (e.target === modal) modal.style.display = "none";
        });

        function loadFollowData(type) {
            const container = document.getElementById(type);
            container.innerHTML = "<p class='text-muted'>Carregando...</p>";
            fetch(`/api/getFollowers?user_id=${userId}&type=${type}`, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("jwt_token")
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data.status !== "success") {
                        container.innerHTML = "<p class='text-muted'>Erro ao carregar</p>";
                        return;
                    }

                    if (!data.data || data.data.length === 0) {
                        container.innerHTML = "<p class='text-muted'>Nenhum resultado</p>";
                        return;
                    }

                    container.innerHTML = "";
                    data.data.forEach(user => {
                        container.appendChild(renderUserRow(user));

                    });
                })
                .catch(() => {
                    container.innerHTML = "<p class='text-muted'>Erro de conexão</p>";
                });
        }

        function renderUserRow(user) {
            const authorName = user.name ?? "usuario";
            const authorRole = user.role ?? "user";
            const roleColor = (authorRole === "estudante") ? "#E11D48" : "#2563EB";
            const author_id = user.id;
            const profilePath = user.profile_photo_path ?? null;


            const color = (profilePath) ? "transparent" : roleColor;
            const url = (profilePath) ? `url("${profilePath}")` : "none";
            const userPhotoText = (profilePath) ? "" : getProfileLetter(authorName);
            const naodapraesquecer = (user.is_following === 1) ? "seguindo" : "seguir";

            const div = document.createElement("div");
            div.classList.add("user-row");
            div.innerHTML = `
                        <div 
                class="user-photo-post interactive"
                style='background-color:${color}; background-image:${url};'
                onclick="window.location.href='/profile?profile=${author_id}'"
            >
                ${userPhotoText}
            </div>

            <div class="user-info">
                <span class="post-username">${authorName}</span>
                <span class="post-role" style="background:${roleColor}">
                    ${authorRole}
                </span>
            </div>

            <button class="follow-btn">${naodapraesquecer}</button>
`

            const followBtn = div.querySelector(".follow-btn");
            followBtn.addEventListener("click", async () => {
                if (followBtn.innerText === "seguir") {
                    const data = await executeWithRefresh(follow, author_id);
                    if (data.status === "success") {
                        followBtn.innerText = "seguindo";
                    }
                    const countSpan = document.querySelector("#following_count");
                    countSpan.innerText = parseInt(countSpan.innerText) + 1;

                } else {
                    const data = await executeWithRefresh(unfollow, author_id);
                    if (data.status === "success") {
                        followBtn.innerText = "seguir";
                    }
                    const countSpan = document.querySelector("#following_count");
                    countSpan.innerText = parseInt(countSpan.innerText) - 1;

                }
            });
            return div;
        }




    })
</script>