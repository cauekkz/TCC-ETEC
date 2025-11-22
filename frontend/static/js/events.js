const modal = document.querySelector(".molested");
const btnCreate = document.querySelector(".btnCreate");
const closeModalBtn = document.querySelector(".btn-close");
const eventsGrid = document.querySelector(".events-grid");
const token = localStorage.getItem("jwt_token")
userData = JSON.parse(sessionStorage.getItem('userData'));


modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.close();
});


if (userData.user.role !== "professor") {
    btnCreate.style.display = "none";
}


btnCreate.addEventListener("click", () => {
    modal.showModal();
});


closeModalBtn.addEventListener("click", () => {
    modal.close();
});


document.getElementById('createNoticeForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Confirmação antes de criar evento
    const confirmed = await confirmAction(
        "Deseja criar este evento?",
        "Confirmar Criação de Evento"
    );

    if (!confirmed) {
        return;
    }

    const form = e.target;
    const formData = new FormData(form);
    formData.append('server_id', localStorage.getItem("selectedServer"));

    const result = await fetch("/api/addEvents", {
        method: "POST",
        headers: {
            "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
        },
        body: formData
    }).then(res => res.json());

    
        location.reload();
});


async function addPresence(event_id) {
    const body = { event_id };

    const response = await fetch("/api/addParticipant", {
        method: "POST",
        headers: {
            "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(body)
    });


    await loadEvents();

}

window.addPresence = addPresence;

async function getParticipants(event) {
    const response = await fetch("/api/getEventParticipants?id=" + event.id, {
        method: "GET",
        headers: {
            "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
        },
    });

    const res = await response.json();
    const participants = res.data;

    if (!participants) {
        return { porcentagem: 0, quantidade: 0 };
    }

    const quantidade = Object.keys(participants).length;
    const porcentagem = (quantidade / event.capacity) * 100;

    return { porcentagem, quantidade };
}

async function deleteEvent(event_id){
    // Confirmação antes de excluir evento
    const confirmed = await confirmAction(
        "Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.",
        "Confirmar Exclusão"
    );

    if (!confirmed) {
        return;
    }

    body = {event_id}
    const response = await fetch("/api/deleteEvent", {
        method: "DELETE",
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    await loadEvents();
}


async function loadEvents() {
    eventsGrid.innerHTML = "";

    const response = await fetch("/api/getEvents", {
        method: "GET",
        headers: {
            "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
        },
    });

    const data_events = await response.json();

    if (!data_events.data || data_events.data.length === 0) {
        eventsGrid.innerHTML = "<p>Nenhum evento disponível.</p>";
        return;
    }

    for (const event of data_events.data) {
        const dataFormatada = new Date(event.date).toLocaleDateString("pt-BR");
        const { porcentagem, quantidade } = await getParticipants(event);

        eventsGrid.innerHTML += `
            <div class="event-card">
                <div class="event-header d-flex justify-content-between">
                    <h3>${event.title}</h3>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" style="color: rgba(255, 0, 0, 0.85); cursor:pointer;" onclick="deleteEvent(${event.id})" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" >
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
                </div>
                <p class="event-description">${event.description}</p>
                <div class="event-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>${dataFormatada}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>${event.time}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>${event.location}</span>
                    </div>
                    <div class="detail-item">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-users"></i>
                            <span>${quantidade}/${event.capacity} Participantes</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${porcentagem}%;"></div>
                        </div>
                    </div>
                </div>
                <button class="participate-btn" onclick="addPresence(${event.id})">Participar</button>
            </div>
        `;
    }
}


loadEvents();
