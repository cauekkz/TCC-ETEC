function serverInitials(name) {
    const clean = String(name || "").replace(/^Etec\s+(de\s+|da\s+|do\s+)?/i, "").replace(/\(.*?\)/g, "");
    const words = clean.split(/[\s–-]+/).filter(w => w.length > 2 || /^[A-Z]/.test(w));
    return ((words[0]?.[0] || "E") + (words[1]?.[0] || "")).toUpperCase();
}

function serverHue(id) {
    return (Number(id) * 47) % 360;
}

function addServerBox(server, isMine = false) {
    const serverBox = document.createElement('div');
    serverBox.classList.add('server-card');
    if (isMine) serverBox.classList.add('ui-mine');
    serverBox.dataset.name = String(server.name || "").toLowerCase();
    serverBox.tabIndex = 0;
    serverBox.setAttribute('role', 'link');

    const hue = serverHue(server.id);
    const isGeral = server.campus_id === null;
    const avatar = isGeral
        ? 'var(--grad-cool)'
        : `linear-gradient(135deg, hsl(${hue} 78% 52%), hsl(${(hue + 40) % 360} 85% 58%))`;

    serverBox.innerHTML = `
    <div class="server-icon" style="--ui-avatar:${avatar}">${isGeral ? "#" : uiEscape(serverInitials(server.name))}</div>
    <div class="server-info">
        <h3>${uiEscape(server.name)}</h3>
        ${isGeral ? '<span class="ui-mine-badge">Todas as Etecs</span>' : (isMine ? '<span class="ui-mine-badge">Sua Etec</span>' : '')}
    </div>`;

    const go = () => { window.location.href = `/?server=${server.id}`; };
    serverBox.addEventListener("click", go);
    serverBox.addEventListener("keydown", (e) => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); go(); } });

    return serverBox;
}
