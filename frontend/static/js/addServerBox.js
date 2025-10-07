function addServerBox(server) {
    const serverBox = document.createElement('div');
    console.log(server)
    serverBox.classList.add('server-card')
    serverBox.innerHTML = `
    
    <div class="server-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="auto" height="90%" fill="currentColor" class="bi bi-server" viewBox="0 0 16 16">
            <path d="M1 5a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5zm0 6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm2.5-5a.5.5 0 1 0 0 1 .5.5 0 0 0 0-1zm0 6a.5.5 0 1 0 0 1 .5.5 0 0 0 0-1z" />
        </svg>
    </div>
    <div class="server-info">
        <h3>${server.name}</h3>
        <!--
        <div class="server-tags">
            <span class="tag etec">ETEC</span>
            <span class="members"><i class="fas fa-user"></i> 847</span>
        </div>
        <p>Servidor oficial da ETEC Cidade Tiradentes para todos os alunos e professores.</p>       
        -->
    </div>`

    serverBox.addEventListener("click", (e) => {
        
        window.location.href = `/?server=${server.id}`;
    });

    return serverBox;
}

