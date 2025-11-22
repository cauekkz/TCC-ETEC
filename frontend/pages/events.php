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

<style></style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const serverName = localStorage.getItem("selectedServerName") ?? null;
        document.querySelector("#consecultivos").innerText =
            `Eventos em destaque de ${serverName}`;
    });
</script>
<header>
    <div class="container-fluid">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto d-flex align-items-center mb-1">
                <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
                <h5 class="text-danger title-page">ETEConnect</h5>
            </div>
            <div class="col d-flex mt-3 justify-content-end">

                <button class="btn btn-danger btnCreate">+ Novo evento</button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


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
                <div class="col d-flex col-used col-hover">
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
                        <p id="feedTitle" class="mb-0 h2"><strong>Eventos</strong></p>
                        <p class="text-secondary" id="consecultivos"> </p>
                    </div>

                </div>


                <div class="events-grid">

                </div>


                <dialog class="molested">
                    <div class="modal-header">
                        <h5 class="modal-title">Criar Novo Evento</h5>
                        <button type="button" class="btn-close" id="closeModal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <form id="createNoticeForm" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="eventTitle">Título do Evento *</label>
                                    <input type="text" id="eventTitle" name="title" placeholder="Ex: Feira de Profissões 2024" required>
                                </div>
                                <div class="form-group">
                                    <label for="eventCategory">Categoria *</label>
                                    <select id="eventCategory" name="category" required>
                                        <option value="">Selecione a categoria</option>
                                        <option value="educacional">Educacional</option>
                                        <option value="cerimonia">Cerimônia</option>
                                        <option value="esportivo">Esportivo</option>
                                        <option value="cultural">Cultural</option>
                                        <option value="tecnico">Técnico</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="eventDescription">Descrição *</label>
                                <textarea id="eventDescription" name="description" placeholder="Descreva o evento, objetivos e informações importantes" rows="4" required></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="eventDate">Data *</label>
                                    <input type="date" id="eventDate" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="eventTime">Horário *</label>
                                    <input type="time" id="eventTime" name="time" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="eventLocation">Local *</label>
                                <input type="text" id="eventLocation" name="location" placeholder="Ex: Auditório Central - ETEC Cidade Tiradentes" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="maxParticipants">Máximo de Participantes</label>
                                    <input type="number" id="maxParticipants" name="capacity" placeholder="Ex: 300" min="1">
                                </div>
                                <div class="form-group">
                                    <label for="eventType">Tipo de Evento</label>
                                    <select id="eventType" name="type">
                                        <option value="presencial">Presencial</option>
                                        <option value="online">Online</option>
                                        <option value="hibrido">Híbrido</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-actions mt-3 d-flex justify-content-end gap-2">
                                <button type="submit" class="action-btn primary">Criar Evento</button>
                            </div>
                        </form>
                    </div>
                </dialog>



                <link rel="stylesheet" href="/frontend/static/css/header.css">
                <link rel="stylesheet" href="/frontend/static/css/post-focus.css">
                <link rel="stylesheet" href="/frontend/static/css/aside-sec.css">
                <link rel="stylesheet" href="/frontend/static/css/alerts.css">


                <script src="/frontend/static/js/alerts.js"></script>
                <script src="/frontend/static/js/executeWithRefresh.js"></script>
                <script src="frontend/static/js/loaduserinformation.js"></script>
                <script src="/frontend/static/js/events.js"></script>
                <!-- <script src="/frontend/static/js/events.js"></script> -->

                <script src="/frontend/static/js/aside-sec.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", async () => {
                        let userData = null;
                        try {
                            userData = JSON.parse(sessionStorage.getItem('userData'));
                        } catch (e) {
                            userData = null;
                        }

                        if (userData === null) {
                            userData = await executeWithRefresh(loadUserInformation, "mine");
                            userData = userData?.data;
                            sessionStorage.setItem('userData', JSON.stringify(userData));
                        }

                        fillAsideProfile(userData);



                        

                    });
                </script>