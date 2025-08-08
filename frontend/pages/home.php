<div class="container-fluid">
    <div class="col d-flex">
        <div class="tab d-flex flex-column px-3">
            <div class="row row-arrows d-flex pt-3">
                <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">

                <div class="col text-end">
                    <!-- To left  <- -->
                    <div class="col" id="left-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                        </svg>
                    </div>


                    <!-- To right -> -->
                    <div class="col d-none" id="right-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="row mt-4 row-profile">
                <div class="col">
                    <div class="d-flex">
                        <div class="mt-2 px-2">
                            <img src="" alt=" " class="img-fluid img-profile">
                        </div>
                        <div class="row flex-column">
                            <p class="name-text mt-2"> <strong>Maria silva</strong> <span class="badge bg-dark">Aluno</span></p>
                            <p class="sub-text">Desenvolvimento de sistemas</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col d-flex col-used p-2">
                    <div class="d-flex align-items-center px-1  ">
                        <div class="mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                            </svg>
                        </div>
                        <p class="px-2 mb-0" id="home">Feed</p>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Grupos</p>
                </div>
            </div>

            <div class="row mt-2 logout">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Avisos</p>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Projetos TCC</p>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                            <path d="M6.445 11.688V6.354h-.633A13 13 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Eventos</p>
                </div>
            </div>

            <div class="row">
                <div class="col d-flex col-hover">
                    <div class="svg-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                        </svg>
                    </div>
                    <p class="px-2 mt-1">Sair</p>
                </div>
            </div>


        </div>
        <div class="col-6 flex-grow-1 overflow-auto px-3 " style="min-height: 0;">
            <div class="feed mt-4 px-4">
                <div class="d-flex align-items-center justify-content-around">
                    <div class="px-4">
                        <p id="feedTitle" class="mb-0 h4"><strong>Feed da comunidade</strong></p>
                        <p class="text-secondary">Acompanhe as novidades da sua ETEC</p>
                    </div>
                    <button id="btnCreate">+ Nova postagem</button>
                </div>

                <!-- Mudar para a parte do bd dps -->
                <!-- Tbm é só pra ter uma estrutura do card em um geral -->
                <div class="posts row mt-5 px-3">
                    <div class="card-post p-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                            <div>
                                <p class="name-text mb-0"><strong>Ana Silva</strong></p>
                                <span class="badge bg-dark">Aluna - Desenvolvimento de Sistemas</span>
                                <p class="sub-text mb-0">ETEC Zona Leste</p>
                            </div>
                        </div>

                        <p id="textPost" class="mb-2">
                            Acabei de apresentar meu TCC sobre automação industrial! Muito feliz com o resultado.
                            Obrigada aos professores pelo apoio e aos colegas pelas dicas 🎓✨
                            <span class="text-primary">#ETEC #TCC #AutomacaoIndustrial</span>
                        </p>
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

                            <div class="comments d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                </svg>
                                <span id="qntComments">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-post p-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                            <div>
                                <p class="name-text mb-0"><strong>Prof. Carlos Mendes</strong></p>
                                <span class="badge bg-dark">Professor - Informática</span>
                                <p class="sub-text mb-0">ETEC Centro-Oeste</p>
                            </div>
                        </div>

                        <p id="textPost" class="mb-2">
                            Lembrete importante: As inscrições para o projeto de extensão em Python
                            estão abertas até sexta-feira! Não percam essa
                            oportunidade de aprender mais sobre programação. 🐍💻
                        </p>
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

                            <div class="comments d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                </svg>
                                <span id="qntComments">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-post p-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                            <div>
                                <p class="name-text mb-0"><strong>Prof. Carlos Mendes</strong></p>
                                <span class="badge bg-dark">Professor - Informática</span>
                                <p class="sub-text mb-0">ETEC Centro-Oeste</p>
                            </div>
                        </div>

                        <p id="textPost" class="mb-2">
                            Lembrete importante: As inscrições para o projeto de extensão em Python
                            estão abertas até sexta-feira! Não percam essa
                            oportunidade de aprender mais sobre programação. 🐍💻
                        </p>
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

                            <div class="comments d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                </svg>
                                <span id="qntComments">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-post p-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                            <div>
                                <p class="name-text mb-0"><strong>Prof. Carlos Mendes</strong></p>
                                <span class="badge bg-dark">Professor - Informática</span>
                                <p class="sub-text mb-0">ETEC Centro-Oeste</p>
                            </div>
                        </div>

                        <p id="textPost" class="mb-2">
                            Lembrete importante: As inscrições para o projeto de extensão em Python
                            estão abertas até sexta-feira! Não percam essa
                            oportunidade de aprender mais sobre programação. 🐍💻
                        </p>
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

                            <div class="comments d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                </svg>
                                <span id="qntComments">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-post-focus d-none">
    <div class="d-flex justify-content-center align-items-center">
        <div class="post-focus">
            <div class="d-flex align-items-center mb-2">
                <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                <div>
                    <p class="name-text mb-0"><strong>Prof. Carlos Mendes</strong></p>
                    <span class="badge bg-dark">Professor - Informática</span>
                    <p class="sub-text mb-0">ETEC Centro-Oeste</p>
                </div>
            </div>
            <p id="textPost" class="mb-2">
                Acabei de apresentar meu TCC sobre automação industrial! Muito feliz com o resultado.
                Obrigada aos professores pelo apoio e aos colegas pelas dicas 🎓✨
                <span class="text-primary">#ETEC #TCC #AutomacaoIndustrial</span>
            </p>
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

                <div class="comments d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chat me-1" viewBox="0 0 16 16">
                        <path
                            d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                    </svg>
                    <span id="qntComments">1</span>
                </div>
            </div>

            <div class="comment mt-3">
                <p id="interactionComment"><strong>Comentários</strong></p>
                <div class="comment-box p-3 my-2 shadow-sm border rounded">
                    <div class="d-flex align-items-center pt-3">

                        <div class="d-flex">
                            <img src="frontend/static/img/profile1.png" alt="perfil" class="img-profile-post me-2" width="40" height="40">
                            <div class="flex-column">
                                <p class="name-text mb-0 "><strong>Prof. Carlos Mendes</strong></p>
                                <span class="badge bg-dark">Professor - Informática</span>
                            </div>
                        </div>
                    </div>
                    <p>Matheus Fiot Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis non natus molestias? Dolores animi necessitatibus a, eum saepe repellat mollitia maxime, culpa maiores aut quae delectus ipsa quod corporis aspernatur!</p>
                </div>
                <form class="form-comment">
                    <div class="write-comment mt-5">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control p-2" placeholder="Seu comentário" aria-label="Seu comentário" name="comment">
                            <button class="btn btn-outline-secondary" type="button" id="btnSend"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                                </svg></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-create d-none">
    <div class="d-flex justify-content-center align-items-center">
        <div class="create-card">
            <p>Criar post</p>
        </div>
    </div>
</div>

<script src="/frontend/static/js/home.js"></script>