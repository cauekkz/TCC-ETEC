function addNoticeBox(noticeInfo) {


    const notice = document.createElement("div")
    const noticeId = noticeInfo.id;
    const noticeType = noticeInfo.type === 'evento' ? 'Evento' : 'Importante';
    const title = noticeInfo.title;
    const description = noticeInfo.description;
    const created_at = new Date(noticeInfo.created_at).toLocaleDateString('pt-BR');
    const noticeTypeIcon = noticeInfo.type === 'evento' ? 'far fa-star' : 'fas fa-exclamation-triangle';
    notice.innerHTML = `

                        <div class="notice-header">
                            <h3>${title}</h3>
                                                <svg xmlns="http://www.w3.org/2000/svg" style="color: rgba(255, 0, 0, 0.85); cursor:pointer;" onclick="deleteNotice(${noticeId})" width="16" height="16" fill="currentColor" class="bi bi-trash delete-notice-btn" viewBox="0 0 16 16" >
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>

                        </div>
                        <div class="notice-meta">
                            <div class="meta-item">
                                <i class="${noticeTypeIcon} "></i>
                                <span>${noticeType}</span>
                            </div>
                            <div class="meta-separator">•</div>
                            <div class="meta-item">
                                <span>${created_at}</span>
                            </div>
                        </div>
                        <div class="notice-content">
                            <p>${description}</p>
                        </div>
    `;
    notice.classList.add("notice-card")
    const deleteBtn = notice.querySelector(".delete-notice-btn");
    const userData = JSON.parse(sessionStorage.getItem('userData'));

    const campusInfo = userData.campus;

    if (userData.user.role === "professor") {
        const serverID = parseInt(localStorage.getItem("selectedServer"))
        if (serverID == 1 || campusInfo.some(info => info.id == serverID - 1)) {
            deleteBtn.style.display = "block";

        } else {
            deleteBtn.style.display = "none";
        }

    } else {
        deleteBtn.style.display = "none"
    }

    return notice;
}
const deleteModal = document.getElementById("delete-modal");
const closeBtn = deleteModal.querySelector('.confirmation-modal-close');
closeBtn.addEventListener("click", () => {
    deleteModal.classList.remove("active");
});


async function deleteNotice(notice_id) {
    deleteModal.classList.add("active");

    const confirmBtn = deleteModal.querySelector("#confirmation-yes");
    const cancelBtn = deleteModal.querySelector("#confirmation-no");
    const confirmed = await new Promise((resolve) => {
        const onConfirm = () => {
            cleanup();
            resolve(true);
        };

        const onCancel = () => {
            cleanup();
            resolve(false);
        };

        function cleanup() {
            deleteModal.classList.remove("active");
            confirmBtn.removeEventListener("click", onConfirm);
            cancelBtn.removeEventListener("click", onCancel);
        }

        confirmBtn.addEventListener("click", onConfirm);
        cancelBtn.addEventListener("click", onCancel);
    });

    if (!confirmed) {
        console.log("User cancelled");
        return;
    }

    const body = {
        notice_id
    };

    try {
        const token = localStorage.getItem("jwt_token");
        const response = await fetch("/api/deleteNotice", {
            method: "DELETE",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            },
            body: JSON.stringify(body)
        });

        if (!response.ok) {
            throw new Error("Error ao deletar aviso");
        }
        window.location.reload();
    } catch (err) {
        console.error(err);
        alert("Erro ao excluir o aviso.");
    }
}
