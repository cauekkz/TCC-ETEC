<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<?php

$server_id = (isset($_GET['server'])) ? $_GET['server'] : null;
if (is_numeric($server_id)) {
    $safe_id = json_encode((int)$server_id);

?>
    <script>
        localStorage.setItem("selectedServer", (<?php echo $safe_id; ?>));
    </script>
<?php
}
?>
<script>
    const serverId = localStorage.getItem("selectedServer") ?? null;

    if (serverId === null) {
        window.location.href = "/servers";
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const serverName = localStorage.getItem("selectedServerName") ?? null;

        document.querySelector("#consecultivos").innerText =
            `Projetos TCC de ${serverName}`;

    });
</script>
<header>
    <div class="container-fluid">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto d-flex align-items-center mb-1">
                <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
                <h5 class="text-danger title-page">ETEConnect</h5>
            </div>
            <div class="col d-flex  justify-content-end align-items-center">


                <button id="btnCreate" class="btn btn-danger">+ Novo Projeto</button>
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
                <div class="col d-flex  col-hover">
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
                <div class="col d-flex col-used col-hover">
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
        <div class="col-6 flex-grow-1 overflow-auto px-3 " style="min-height: 0;">
            <div class="feed mt-4 px-4">

                <div class="d-flex ">
                    <div class="px-1">
                        <p id="feedTitle" class="mb-0 h2"><strong>Projetos de TCC</strong></p>
                        <p class="text-secondary" id="consecultivos"></p>
                    </div>
                </div>
                <div class="projects-grid">

                </div>


            </div>
        </div>
    </div>
</div>
<dialog id="projectModal" class="molested modal-dialog bg-card border-primary shadow-heavy">
    <!--SACOOOOOOOOOOOOOO -->
    <div id="confirmation-modal" class="confirmation-modal-overlay">
        <div class="confirmation-modal-content">
            <div class="confirmation-modal-header">
                <h3 class="confirmation-modal-title">Confirmar Ação</h3>
                <button class="confirmation-modal-close" aria-label="Fechar">&times;</button>
            </div>
            <div class="confirmation-modal-body">
                <p class="confirmation-modal-message">Deseja criar este projeto TCC?</p>
            </div>
            <div class="confirmation-modal-footer">
                <button class="confirmation-btn confirmation-btn-no" id="confirmation-no">Não</button>
                <button class="confirmation-btn confirmation-btn-yes" id="confirmation-yes">Sim</button>
            </div>
        </div>

    </div>
    <form id="querubim" class="modal-content">

        <header class="modal-header bg-secondary border-secondary">
            <h2 class="text-primary">Novo Projeto de TCC</h2>
            <button type="button" class="close-btn text-primary closeModalBtn">×</button>
        </header>


        <section class="modal-body">

            <div class="form-group">
                <label class="text-primary">Título</label>
                <input type="text" name="title" required class="input bg-input border-primary text-primary">
            </div>

            <div class="form-group">
                <label class="text-primary">Descrição</label>
                <textarea name="description" rows="4" class="input bg-input border-primary text-primary" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <!--
                    <label class="text-primary">Escola</label>
                    <select name="campus_id" class="input bg-input border-primary text-primary"></select>
                        -->
                    <label class="text-primary">Curso</label>

                    <select name="course_id" class="input bg-input border-primary text-primary"></select>
                </div>

            </div>

            <!-- Membros -->
            <div class="form-group">
                <label class="text-primary">Membros do grupo</label>

                <input type="text" id="memberSearch" placeholder="Digite a matricula do estudante..."
                    class="input bg-input border-primary text-primary">

                <div id="memberResults" class="results-box bg-secondary border-primary"></div>

                <div id="selectedMembers" class="selected-members">


                </div>
            </div>

            <!-- Arquivos -->
            <div class="form-group">
                <label class="text-primary">Arquivos</label>
                <input type="file" id="files" multiple class="input bg-input border-primary text-primary">
            </div>

        </section>

        <!-- FOOTER -->
        <footer class="modal-footer bg-secondary border-secondary">
            <button type="submit" class="btn save-btn">Salvar</button>
        </footer>

    </form>
</dialog>

<dialog id="viewProjectModal" class="modal-dialog bg-card border-primary shadow-heavy" aria-hidden="true">

    <div class="modal-content" role="document">

        <!-- HEADER -->
        <header class="modal-header bg-secondary border-secondary">
            <div class="modal-header-left">
                <h2 id="viewProjectTitle" class="text-primary">Título do Projeto</h2>
                <div class="meta small text-muted" id="viewProjectMeta">23/11/2025</div>
            </div>

        </header>

        <!-- BODY -->
        <section class="modal-body">
            <div class="project-tags">
                <span id="viewProjectCourse" class="project-tag"></span>
                <span id="viewProjectCampus" class="project-institution"></span>
            </div>
            <p id="viewProjectDescription" class="text-primary"></p>



            <h3 class="text-primary">Integrantes</h3>
            <ul id="viewProjectMembers" class="member-list text-primary"></ul>

            <h3 class="text-primary">Arquivos</h3>

            <!-- Slider for images/videos -->
            <div id="mediaCarouselWrap" class="media-carousel-wrap" hidden>
                <button class="carousel-arrow left" id="carouselPrev" aria-label="Anterior">‹</button>
                <div id="mediaCarousel" class="media-carousel" tabindex="0" role="group" aria-roledescription="carousel"></div>
                <button class="carousel-arrow right" id="carouselNext" aria-label="Próximo">›</button>
                <div id="carouselDots" class="carousel-dots" aria-hidden="true"></div>
            </div>

            <!-- Files list (pdf / zip) -->
            <div id="viewProjectFiles" class="file-list"></div>

        </section>

        <!-- FOOTER -->
        <footer class="modal-footer bg-secondary border-secondary">
            <button type="button" class="btn cancel-btn" id="absurdo">Fechar</button>
        </footer>

    </div>
</dialog>





<link rel="stylesheet" href="/frontend/static/css/header.css">
<link rel="stylesheet" href="/frontend/static/css/aside-sec.css">
<link rel="stylesheet" href="/frontend/static/css/alerts.css">

<script src="/frontend/static/js/likeFunctions.js"></script>
<script src="/frontend/static/js/alerts.js"></script>
<script src="/frontend/static/js/executeWithRefresh.js"></script>

<script src="/frontend/static/js/aside-sec.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
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

        const btnCreate = document.getElementById("btnCreate");
        if (userData.user.role === "professor") {
            btnCreate.style.display = "block";
        }

        const serverId = localStorage.getItem("selectedServer");

        const responseCampus = await fetch(`/api/getCampusIdByServerId?server_id=${serverId}`)
        if (!responseCampus.ok) {
            showAlert("error", "Erro ao carregar informações do servidor");
            return;
        }
        const resultCampus = await responseCampus.json();
        if (resultCampus.status !== "success") {
            showAlert("error", "Erro ao carregar informações do servidor");
            return;
        }
        const campusId = resultCampus.data[0].campus_id;

        const responseProjects = await fetch(`/api/getTCCProjectsByCampusId?campus_id=${campusId}`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
            }
        });

        if (!responseProjects.ok) {
            showAlert("error", "Erro ao carregar projetos");
            return;
        }
        const resultProjects = await responseProjects.json();
        if (resultProjects.status !== "success") {
            showAlert("error", "Erro ao carregar projetos");
            return;
        }

        function createMemberAvatar(member) {
            const roleColor = "#D32F2F";
            const profilePath = member.profile_photo_path;
            const letter = getProfileLetter(member.name);

            return `
        <div class="member-avatar" 
             style="
                width: 42px;
                height: 42px;
                border-radius: 50%;
                background-color: ${profilePath ? "transparent" : roleColor};
                background-image: ${profilePath ? `url('${profilePath}')` : "none"};
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                font-size: 18px;
             ">
            ${profilePath ? "" : letter}
        </div>
    `;
        }





        async function openProjectModal(projectId) {
            const modal = document.getElementById("viewProjectModal");

            // limpar tudo antes
            document.getElementById("viewProjectTitle").textContent = "Carregando...";
            document.getElementById("viewProjectDescription").textContent = "";
            document.getElementById("viewProjectCourse").textContent = "";
            document.getElementById("viewProjectCampus").textContent = "";
            document.getElementById("viewProjectMembers").innerHTML = "";
            document.getElementById("viewProjectFiles").innerHTML = "";
            document.getElementById("mediaCarousel").innerHTML = "";
            document.getElementById("carouselDots").innerHTML = "";
            document.getElementById("mediaCarouselWrap").hidden = true;

            try {
                const res = await fetch(`/api/getTCCProjectById?id=${projectId}`, {
                    method: "GET",
                    headers: {
                        "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
                    }
                });




                const json = await res.json();
                if (json.status !== "success") return;

                const p = json.data.project;
                const date = new Date(p.created_at);

                document.getElementById("viewProjectMeta").textContent = date.toLocaleDateString('pt-BR');

                // ============================
                //  INFO PRINCIPAL
                // ============================
                document.getElementById("viewProjectTitle").textContent = p.title;
                document.getElementById("viewProjectDescription").textContent = p.description;
                document.getElementById("viewProjectCourse").textContent = p.course_name;
                document.getElementById("viewProjectCampus").textContent = p.campus_name;

                // ============================
                //  INTEGRANTES (com foto)
                // ============================
                const membersEl = document.getElementById("viewProjectMembers");
                membersEl.innerHTML = json.data.members
                    .map(m => `
        <li class="member-item" style='cursor: pointer;' onclick="window.location.href='/profile?profile=${m.id}'">
            ${createMemberAvatar(m)}
            <span>${m.name}</span>
        </li>
    `)
                    .join("");

                const files = json.data.files;
                const filesEl = document.getElementById("viewProjectFiles");

                const mediaFiles = files.filter(f => ["image", "video"].includes(f.file_type));
                const downloadFiles = files.filter(f => ["pdf", "zip"].includes(f.file_type));

                if (mediaFiles.length > 0) {
                    const mediaWrap = document.getElementById("mediaCarouselWrap");
                    const carousel = document.getElementById("mediaCarousel");
                    const dots = document.getElementById("carouselDots");

                    mediaWrap.hidden = false;
                    let currentIndex = 0;

                    // montar slides
                    carousel.innerHTML = mediaFiles.map((f, i) => `
                <div class="carousel-item ${i === 0 ? "active" : ""}">
                    ${
                        f.file_type === "image"
                            ? `<img src="${f.file_url}" class="carousel-media">`
                            : `<video src="${f.file_url}" class="carousel-media" controls></video>`
                    }
                </div>
            `).join("");

                    // dots
                    dots.innerHTML = mediaFiles.map((_, i) => `
                <span class="dot ${i === 0 ? "active" : ""}" data-index="${i}"></span>
            `).join("");

                    const items = document.querySelectorAll(".carousel-item");
                    const dotsEl = document.querySelectorAll(".dot");

                    function updateCarousel(newIndex) {
                        items[currentIndex].classList.remove("active");
                        dotsEl[currentIndex].classList.remove("active");

                        currentIndex = newIndex;

                        items[currentIndex].classList.add("active");
                        dotsEl[currentIndex].classList.add("active");
                    }

                    document.getElementById("carouselPrev").onclick = () => {
                        const next = (currentIndex - 1 + items.length) % items.length;
                        updateCarousel(next);
                    };

                    document.getElementById("carouselNext").onclick = () => {
                        const next = (currentIndex + 1) % items.length;
                        updateCarousel(next);
                    };

                    dotsEl.forEach(dot => {
                        dot.onclick = () => updateCarousel(Number(dot.dataset.index));
                    });
                }

                // ----------------------------
                //  PDF / ZIP estilizados
                // ----------------------------
                filesEl.innerHTML = downloadFiles.map(f => `
            <div class="file-item styled-file">
                <div class="file-icon">
                    ${f.file_type === "pdf" ? "📄" : "🗂️"}
                </div>
                <div class="file-info">
                    <span>${f.file_name}</span>
                    <a class="download-btn" href="${f.file_url}" download>Baixar</a>
                </div>
            </div>
        `).join("");

            } catch (err) {
                console.error(err);
            }

            modal.showModal();
        }

        document.querySelector("#absurdo").addEventListener("click", () => {
            document.getElementById("viewProjectModal").close();
        });


        const projectsGrid = document.querySelector(".projects-grid");
        console.log(resultProjects)
        resultProjects?.data?.forEach(project => {
            const projectCard = document.createElement("div");
            projectCard.classList.add("project-card");
            const liked = (project.user_liked == 1) ? true : false;
            projectCard.dataset.id = project.id;
            projectCard.dataset.total_likes = project.total_likes;
            projectCard.innerHTML = `
                <div class="project-info">
                    <h3>${project.title}</h3>
                    <div class="project-tags">
                        <span class="project-tag">${project.course_name}</span>
                        <span class="project-institution">${project.campus_name}</span>
                    </div>
                    <p class="project-description">${project.description}</p>
                    <div class="project-actions">
                        <button class="view-project-btn">Ver Projeto</button>
                        <button class="like-btn">
                            <span class="like_icon"></span>
                            <span class="total_likes">${project.total_likes}</span>
                        </button>
                    </div>
                </div>
            `;

            const viewProjectBtn = projectCard.querySelector(".view-project-btn");
            viewProjectBtn.addEventListener("click", () => {
                openProjectModal(project.id);
            });



            if (liked) {
                projectCard.dataset.user_liked = 1
                projectCard.querySelector(".like_icon").innerHTML = `  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D32F2F" viewBox="0 0 16 16">
    <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
  </svg>`

            } else {
                projectCard.dataset.user_liked = 0
                projectCard.querySelector(".like_icon").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
     fill="none" stroke="currentColor" stroke-width="1" 
     viewBox="0 0 16 16">
  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 
           1.4 3.053c-.523 1.023-.641 2.5.314 
           4.385.92 1.815 2.834 3.989 6.286 
           6.357 3.452-2.368 5.365-4.542 
           6.286-6.357.955-1.886.838-3.362.314-4.385
           C13.486.878 10.4.28 8.717 2.01z"/>
</svg>`
            }
            const likeBtn = projectCard.querySelector(".like-btn");
            likeBtn.addEventListener("click", () => {
                if (projectCard.dataset.user_liked == 1) {
                    deleteLike("tcc_project", project.id);
                    changeFrontLike(projectCard, false);
                } else {
                    addLike("tcc_project", project.id);
                    changeFrontLike(projectCard, true);
                }


            });




            projectsGrid.appendChild(projectCard);
        });





        const modal = document.querySelector(".molested");

        btnCreate.addEventListener("click", () => {
            modal.showModal();

        });
        modal.querySelector(".closeModalBtn").addEventListener("click", () => {
            modal.close();
        });
        /*
        const AllCampus = await fetch("/api/getAllEtecsNames").then(res => res.json());
        if (AllCampus === null || AllCampus.status !== "success") {
            showAlert("error", "Erro ao carregar");
            return;
        }
        AllCampus.data.forEach(campus => {
            const option = document.createElement("option");
            option.value = campus.id;
            option.textContent = campus.name;
            modal.querySelector("select[name='campus_id']").appendChild(option);
        });
        */
        const courseSelect = modal.querySelector("select[name='course_id']");
        courseSelect.innerHTML = "";

        const response = await fetch(`/api/getCoursesByEtec?campus_id=${campusId}`);
        const result = await response.json();
        if (result.status !== "success") {
            showAlert("error", "Erro ao carregar cursos");
            return;
        }
        result.data.forEach(course => {
            const option = document.createElement("option");
            option.value = course.id;
            option.textContent = course.name;
            courseSelect.appendChild(option);
        });

        //modal.querySelector("select[name='campus_id']").addEventListener("change", async function() {})
        modal.querySelector("#memberSearch").addEventListener("input", async () => {
            const query = modal.querySelector("#memberSearch").value.trim();
            const resultsBox = modal.querySelector("#memberResults");
            resultsBox.innerHTML = "";

            if (query.length < 3) {
                return;
            }

            const response = await fetch(`/api/getStudentByRegistrationLike?registration_param=${encodeURIComponent(query)}`, {
                method: "GET",
                headers: {
                    "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
                }
            });
            const result = await response.json();
            console.log("rei nada mal")

            if (result.status !== "success") {
                showAlert("error", "Erro ao buscar estudantes");
                return;
            }


            result.data?.forEach(student => {
                const studentDiv = document.createElement("div");

                console.log(student)

                studentDiv.classList.add("result-item");
                studentDiv.textContent = `${student.name}  (${student.registration})`;

                studentDiv.addEventListener("click", () => {
                    const selectedMembersDiv = modal.querySelector("#selectedMembers");

                    const memberSpan = document.createElement("span");
                    memberSpan.classList.add("member-tag");
                    memberSpan.textContent = `${student.name} (${student.registration})`;
                    memberSpan.dataset.studentId = student.id;

                    const removeBtn = document.createElement("button");
                    removeBtn.type = "button";
                    removeBtn.classList.add("remove");
                    removeBtn.textContent = "×";
                    removeBtn.addEventListener("click", () => {
                        selectedMembersDiv.removeChild(memberSpan);
                    });

                    memberSpan.appendChild(removeBtn);
                    selectedMembersDiv.appendChild(memberSpan);

                    resultsBox.innerHTML = "";
                    modal.querySelector("#memberSearch").value = "";
                });

                resultsBox.appendChild(studentDiv);
            });

        })
        modal.querySelector("#memberSearch").addEventListener("focus", () => {
            const resultsBox = modal.querySelector("#memberResults");
            resultsBox.style.display = "block";
        });

        modal.querySelector("#querubim").addEventListener("submit", async (e) => {
            e.preventDefault();

            // Confirmação antes de criar projeto

            const confirmed = await confirmAction(
                "Deseja criar este projeto TCC?",
                "Confirmar Criação de Projeto"
            );
            if (!confirmed) {
                return
            }


            const title = modal.querySelector("input[name='title']").value.trim();
            const description = modal.querySelector("textarea[name='description']").value.trim();
            const courseId = modal.querySelector("select[name='course_id']").value;

            const selectedMemberSpans = modal.querySelectorAll("#selectedMembers .member-tag");
            const memberIds = Array.from(selectedMemberSpans).map(span => span.dataset.studentId);

            const filesInput = modal.querySelector("#files");
            const files = filesInput.files;

            const formData = new FormData();
            formData.append("title", title);
            formData.append("description", description);
            formData.append("campus_id", campusId);
            formData.append("course_id", courseId);
            memberIds.forEach(id => formData.append("member_ids[]", id));
            for (let i = 0; i < files.length; i++) {
                formData.append("files[]", files[i]);
            }

            const response = await fetch("/api/addTCCProject", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
                },
                body: formData
            });
            const result = await response.json();
            console.log(result)
            if (result.status === "success") {
                showSuccess("Projeto criado com sucesso!");
                modal.close();
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                modal.close();

                showBackendError(result, "Erro ao criar projeto");
            }

        });



    });
</script>