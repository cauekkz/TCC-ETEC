function addNoticeBox(noticeInfo) {


    const notice = document.createElement("div")
    const noticeType = noticeInfo.type === 'evento' ? 'Evento' : 'Importante';
    const title = noticeInfo.title;
    const description = noticeInfo.description;
    const created_at = new Date(noticeInfo.created_at).toLocaleDateString('pt-BR');
    const noticeTypeIcon = noticeInfo.type === 'evento' ? 'far fa-star' : 'fas fa-exclamation-triangle';
    notice.innerHTML = `

                        <div class="notice-header">
                            <h3>${title}</h3>
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
    return notice;
}