<?php
$server_id = (isset($_GET['server'])) ? $_GET['server'] : null;
if (is_numeric($server_id)) {
    $safe_id = json_encode((int)$server_id);
?>
    <script>
        localStorage.setItem("selectedServer", <?php echo $safe_id; ?>);

        fetch("/api/getServerById?serverId=<?php echo $safe_id; ?>")
            .then(response => {
                if (!response.ok) {
                    showBackendError("error");
                    throw new Error("Response not OK");
                }
                return response.json();
            })
            .then(data => {
                if (data.status !== "success") {
                    showBackendError(data);
                    throw new Error("Backend returned error");
                }

                const server = data.data[0];
                console.log(data)
                localStorage.setItem("selectedServerName", server.name);
                const serverName = localStorage.getItem("selectedServerName") ?? null;
                document.querySelector("#consecultivos").innerText =
                    `Acompanhe as novidades do servidor ${serverName}`;


                continueAfterServerLoad();
            })
            .catch(err => {
                console.error("Erro ao buscar servidor:", err);
            });

        // função que só roda depois que o servidor foi carregado
        function continueAfterServerLoad() {
            const serverId = localStorage.getItem("selectedServer") ?? null;
            if (serverId === null) {
                window.location.href = "/servers";
                return;
            }

            console.log("Servidor carregado:", serverId);

        }
    </script>
<?php
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const serverName = localStorage.getItem("selectedServerName") ?? null;
        document.querySelector("#consecultivos").innerText =
            `Acompanhe as novidades do servidor ${serverName}`;
    });
</script>
<header>
    <div class="container-fluid">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto d-flex align-items-center mb-1">
                <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
                <h5 class="text-danger title-page">ETEConnect</h5>
            </div>


            <div id="lua3" class="col d-flex justify-content-end align-items-center">
                <form id="searchForm" class="search-container">
                    <img class="search-icon" src="frontend/static/img/lupa.png" alt="Ícone de pesquisa" data-status="close">
                    <input
                        type="search"
                        id="searchInput"
                        class="search-input"
                        placeholder="Pesquisar na EteConnect...">


                </form>
                <div id="search-preview" class="search-preview hidden">

                    <!-- ===== USUÁRIOS ===== -->
                    <div class="preview-section">

                        <div class="preview-header">
                            <h4 class="preview-title">Usuários</h4>

                            <button class="preview-toggle" data-target="users">
                                <img class="hidden-icon" src="frontend/static/img/show.png" alt="Ícone de esconder" >
                            </button>
                        </div>

                        <div id="preview-users" class="preview-list">

                            <div class="preview-item user">
                                <div class="avatar">M</div>
                                <div>
                                    <strong>Matheus Vinicius</strong>
                                    <span class="text-muted">@matheus</span>
                                </div>
                            </div>

                            <div class="preview-item user">
                                <div class="avatar">A</div>
                                <div>
                                    <strong>Ana Clara</strong>
                                    <span class="text-muted">@anaclara</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ===== POSTAGENS ===== -->
                    <div class="preview-section">

                        <div class="preview-header">
                            <h4 class="preview-title">Postagens</h4>

                            <button class="preview-toggle" data-target="posts">
                                <img class="hidden-icon" src="frontend/static/img/show.png" alt="Ícone de esconder"     >
                            </button>
                        </div>

                        <div id="preview-posts" class="preview-list">

                            <div class="preview-item post">
                                <strong>Trabalho de Matemática</strong>
                                <p class="text-muted">Entrega até sexta-feira...</p>
                                <span class="preview-date">há 2 horas</span>
                            </div>

                            <div class="preview-item post">
                                <strong>Evento na quadra</strong>
                                <p class="text-muted">Campeonato interclasses...</p>
                                <span class="preview-date">ontem</span>
                            </div>

                        </div>
                    </div>

                </div>


                <button id="btnCreate" class="btn btn-danger">+ Nova postagem</button>
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

        </div>

    </div>

</header>


<div class="container-fluid container-style">
    <div class="col d-flex">
        <div class="tab d-flex flex-column px-3">

            <div class="row mt-4 row-profile">
                <div class="col">
                    <div class="d-flex">
                        <div class="mt-2 px-2">
                            <div src="" alt=" " class="img-fluid img-profile" id="profile-pic-user"></div>
                        </div>
                        <div class="row flex-column">
                            <p class="name-text mt-2">
                                <strong></strong>
                                <span class="badge bg-dark"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <a href="/" class="row mt-4 aside-a">
                <div class="col d-flex col-used col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Feed</p>
                </div>
            </a>



            <a href="/notices" class="row mt-2 aside-a">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Avisos</p>
                </div>
            </a>


            <a href="/projects" class="row mt-2 aside-a">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Projetos TCC</p>
                </div>
            </a>


            <a href="/events" class="row mt-2 aside-a">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                            <path d="M6.445 11.688V6.354h-.633A13 13 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Eventos</p>
                </div>
            </a>
            <a href="/messages" class="row mt-2 aside-a">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414l-3.707 3.707A1 1 0 0 1 0 14.293V2a1 1 0 0 1 1-1h13z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Mensagens</p>
                </div>
            </a>

            <a href="/servers" class="row mt-2 aside-a">
                <div class="col d-flex col-hover" id="server-col">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-server" viewBox="0 0 16 16">
                            <path d="M1 5a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5zm0 6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm2.5-5a.5.5 0 1 0 0 1 .5.5 0 0 0 0-1zm0 6a.5.5 0 1 0 0 1 .5.5 0 0 0 0-1z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Servidores</p>
                </div>
            </a>

            <a href="/logout" class="row mt-2 aside-a" id="logout-button">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Sair</p>
                </div>
            </a>

        </div>
        <div id="borboleta" class="col-6 flex-grow-1 overflow-auto px-3 " style="min-height: 0;">
            <div class="feed mt-4 px-4">

                <div class="d-flex ">
                    <div class="px-1">
                        <p id="feedTitle" class="mb-0 h2"><strong>Feed da comunidade</strong></p>
                        <p class="text-secondary" id="consecultivos"></p>
                    </div>
                </div>


                <!-- Container para posts dinâmicos -->
                <div class="posts row mt-5 px-3">
                    <!-- Os posts serão carregados dinamicamente aqui -->
                </div>

            </div>

            <div id="loadingPostIcon">

            </div>
            <div id="palavras">
                Sem mais resultados
            </div>


        </div>
    </div>
</div>


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

<div class="container-create d-none">
    <div>
        <div class="create-card p-4">
            <p id="titleCreate" class="mb-1"><strong>Nova postagem</strong></p>
            <p class="text-secondary" id="subTitleCreate">Compartilhe algo interessante com a comunidade da ETEConnect</p>
            <div class="align-items-center">
                <div class="d-flex">
                    <div alt="perfil" class="img-profile-post me-2"></div>
                    <div class="flex-column">
                        <p class="name-text mb-0 "><strong></strong></p>
                        <span class="badge">Professor</span>
                    </div>
                </div>
            </div>


            <div class="form-create-container mt-3">
                <form class="form-create" id="formCreatePost">
                    <textarea name="createPost" id="textareaCreate" class="form-control p-3" placeholder="O que você quer compartilhar com a comunidade ETEC?"></textarea>

                    <!-- Input para mídia (imagens e vídeos) -->
                    <input type="file" id="mediaInput" name="media[]" multiple accept="image/*,video/*" class="d-none">

                    <!-- Preview das mídias selecionadas -->
                    <div id="mediaPreview" class="mt-3 d-none">
                        <div class="d-flex flex-wrap gap-2" id="previewContainer"></div>
                    </div>


                    <hr>
                    <div class="row d-flex gap-3 mt-3">
                        <button type="button" class="btn btn-light w-25" id="btnAddMedia">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
                            </svg>
                            Mídia
                        </button>
                        <button type="button" class="w-25 btn btn-light btn-space" id="btnCancel">Cancelar</button>
                        <button type="submit" class="w-25 btn btn-danger" id="btnPublish" disabled>Publicar</button>
                    </div>
                </form>
            </div>



        </div>

    </div>

    <link rel="stylesheet" href="/frontend/static/css/search.css">
    <link rel="stylesheet" href="/frontend/static/css/header.css">
    <link rel="stylesheet" href="/frontend/static/css/aside-sec.css">
    <link rel="stylesheet" href="/frontend/static/css/posts.css">
    <link rel="stylesheet" href="/frontend/static/css/post-focus.css">
    <link rel="stylesheet" href="/frontend/static/css/alerts.css">

    <!---->

    <!---->
    <script src="/frontend/static/js/alerts.js"></script>
    <script src="/frontend/static/js/commentsFunctions.js"></script>
    <script src="/frontend/static/js/executeWithRefresh.js"></script>
    <script src="/frontend/static/js/likeFunctions.js"></script>
    <script src="/frontend/static/js/addCommentBox.js"></script>
    <script src="/frontend/static/js/createPost.js"></script>
    <script src="/frontend/static/js/addPostBox.js"></script>
    <script src="/frontend/static/js/home.js"></script>
    <script src="frontend/static/js/loaduserinformation.js"></script>
    <script src="frontend/static/js/loadHomePosts.js"></script>
    <script src="frontend/static/js/postFocusFunctions.js"></script>
    <script src="/frontend/static/js/aside-sec.js"></script>
    <script src="/frontend/static/js/search.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {

            const formCreatePost = document.querySelector("#formCreatePost");
            formCreatePost.addEventListener("submit", async (e) => {
                e.preventDefault();
                const postContent = textareaCreate.value.trim();
                if (!postContent) {
                    showWarning("Digite o conteúdo do post!");
                    return;
                }

                // Confirmação antes de criar post
                const confirmed = await confirmAction(
                    "Deseja publicar esta publicação?",
                    "Confirmar Publicação"
                );

                if (!confirmed) {
                    return;
                }

                btnPublish.disabled = true;
                btnPublish.textContent = "Publicando...";
                const serverId = localStorage.getItem("selectedServer");
                const result = await executeWithRefresh(createPost, postContent, serverId, selectedFiles);
                console.log(result)
                if (result.status === "success") {
                    showSuccess("Post criado com sucesso!");
                    containerCreate.classList.add("d-none");
                    resetForm();
                    const postsContainer = document.querySelector(".posts");
                    postsContainer.innerHTML = ""

                    renderHomePosts();
                } else {
                    showBackendError(result, "Erro ao criar post");
                }
                btnPublish.disabled = false;
                btnPublish.textContent = "Publicar";

            });


            let userData = null;
            try {
                userData = JSON.parse(sessionStorage.getItem('userData'));
            } catch (e) {
                userData = null;
            }
            if (userData === null) {
                userData = await executeWithRefresh(loadUserInformation, "mine");
                userData = userData?.data

                sessionStorage.setItem('userData', JSON.stringify(userData));
            }

            fillAsideProfile(userData);


            const userInfo = userData?.user ?? null
            if (userInfo !== null) {

                const userRole = userInfo.role
                const username = userInfo.name
                document.querySelector(".name-text.mt-2 strong").innerText = username
                const roleSpan = document.querySelector(".name-text.mt-2 span")
                roleSpan.innerText = userRole
                const roleColor = (userRole == "estudante") ? "#D32F2F" : "#2f32d3ff"
                roleSpan.style.setProperty('background-color', roleColor, 'important');


                const profilePath = userInfo.profile_photo_path

                const userPhoto = document.querySelector("#profile-pic-user")

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

                const addDivForm = document.querySelector(".container-create")

                addDivForm.querySelector(".name-text>strong").innerText = `${username}`
                console.log(addDivForm)
                const profileAddPost = addDivForm.querySelector(".img-profile-post")

                profileAddPost.style.backgroundImage = profilePath ?
                    `url("${profilePath}")` :
                    "none";

                profileAddPost.style.backgroundColor = profilePath ?
                    "transparent" :
                    roleColor;

                profileAddPost.innerText = profilePath ?
                    "" :
                    getProfileLetter(username);


                profileAddPost.style.justifyContent = "center";
                profileAddPost.style.backgroundRepeat = "no-repeat";
                profileAddPost.style.backgroundPosition = "center";
                profileAddPost.style.backgroundSize = "cover";



            }


        })
    </script>