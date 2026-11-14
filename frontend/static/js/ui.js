(function () {
  "use strict";

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const page = (document.body.className.match(/page-(\S+)/) || [])[1] || "";

  const SUBTITLES = {
    home: "Publicações de alunos e professores",
    notices: "Comunicados oficiais da unidade",
    events: "Agenda da escola. Inscreva-se para garantir sua vaga",
    projects: "Trabalhos de conclusão de curso desta unidade",
    servers: "Cada Etec tem seu espaço. O canal Geral reúne todas",
  };
  const KICKERS = { servers: "Comunidades" };

  function safeGet(key) {
    try { return localStorage.getItem(key); } catch (e) { return null; }
  }

    function buildSectionHead() {
    const title = document.getElementById("feedTitle");
    if (!title || !SUBTITLES[page]) return;
    const wrapper = title.closest(".d-flex") || title.parentElement;
    if (!wrapper || wrapper.classList.contains("ui-section-head")) return;

    wrapper.classList.remove("d-flex");
    wrapper.classList.add("ui-section-head");
    title.classList.remove("h2", "mb-0");

    const kicker = document.createElement("p");
    kicker.className = "ui-kicker";
    kicker.textContent = KICKERS[page] || safeGet("selectedServerName") || "ETEConnect";
    title.before(kicker);

    let sub = document.getElementById("consecultivos");
    if (!sub) {
      sub = document.createElement("p");
      sub.className = "ui-sub";
      title.after(sub);
    }
    sub.classList.remove("text-secondary");
    const fix = () => { if (sub.textContent !== SUBTITLES[page]) sub.textContent = SUBTITLES[page]; };
    fix();
    new MutationObserver(fix).observe(sub, { childList: true, characterData: true, subtree: true });
  }

    function markRoles(root) {
    root.querySelectorAll?.(".post-role, .badge, #user-role").forEach((el) => {
      const txt = el.textContent.trim().toLowerCase();
      if (txt !== "professor" && txt !== "estudante") return;
      el.classList.remove("ui-role-professor", "ui-role-estudante");
      el.classList.add("ui-role-" + txt);
      el.style.removeProperty("background");
      el.style.removeProperty("background-color");
    });
  }

    const CARD_SELECTOR = ".post, .notice-card, .event-card, .project-card, .server-card";

  function reveal(el) {
    if (reduceMotion || el.dataset.uiRevealed) return;
    el.dataset.uiRevealed = "1";
    el.classList.add("ui-reveal");
    el.addEventListener("animationend", () => el.classList.remove("ui-reveal"), { once: true });
  }

  function markNotice(card) {
    const meta = card.querySelector(".notice-meta");
    if (meta && /evento/i.test(meta.textContent)) card.classList.add("ui-type-evento");
  }

  function scan(root) {
    if (!(root instanceof Element)) return;
    if (root.matches(CARD_SELECTOR)) reveal(root);
    root.querySelectorAll(CARD_SELECTOR).forEach(reveal);
    if (root.matches(".notice-card")) markNotice(root);
    root.querySelectorAll(".notice-card").forEach(markNotice);
    markRoles(root.parentElement || root);
  }

    function feedSkeleton() {
    const posts = document.querySelector(".page-home .posts");
    if (!posts || posts.children.length) return;
    for (let i = 0; i < 3; i++) {
      const sk = document.createElement("div");
      sk.className = "ui-skeleton";
      sk.setAttribute("aria-hidden", "true");
      sk.innerHTML = `<div class="sk sk-avatar"></div><div class="sk-lines">
        <div class="sk sk-line" style="width:30%"></div>
        <div class="sk sk-line" style="width:18%"></div>
        <div class="sk sk-line" style="width:92%;margin-top:.4rem"></div>
        <div class="sk sk-line" style="width:74%"></div></div>`;
      posts.appendChild(sk);
    }
    posts.setAttribute("aria-busy", "true");
    const clear = () => {
      posts.querySelectorAll(".ui-skeleton").forEach((n) => n.remove());
      posts.removeAttribute("aria-busy");
    };
    const obs = new MutationObserver(() => {
      if (posts.querySelector(".post")) { clear(); obs.disconnect(); }
    });
    obs.observe(posts, { childList: true });
    setTimeout(() => { if (!posts.querySelector(".post")) clear(); }, 6000);
  }

    function likePop(e) {
    const target = e.target.closest(".post-like-icon, .like-post, .like-btn");
    if (!target || reduceMotion) return;
    target.classList.remove("ui-like-pop");
    void target.offsetWidth;
    target.classList.add("ui-like-pop");
  }

  function headerCreateButton() {
    const btn = document.getElementById("btnCreate");
    if (!btn || btn.dataset.uiDone) return;
    btn.dataset.uiDone = "1";
    const text = btn.textContent.replace("+", "").trim();
    if (!text) return;
    btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg><span class="ui-btn-label" style="margin-left:.35rem">${uiEscape(text)}</span>`;
    btn.setAttribute("aria-label", text);
  }

  function authScreen() {
    if (page !== "login") return;
    const container = document.querySelector(".container");
    const logoRow = container?.querySelector(".row");
    if (!logoRow || document.querySelector(".ui-auth-title")) return;
    const logoCol = logoRow.querySelector(".col");
    logoCol?.classList.remove("justify-content-between");
    logoCol?.classList.add("justify-content-center");
    const head = document.createElement("div");
    head.innerHTML = `<h1 class="ui-auth-title">A rede das <em>Etecs</em>.</h1>
      <p class="ui-auth-sub">Entre com seu e-mail institucional.</p>`;
    logoRow.after(head);
  }

    function init() {
    buildSectionHead();
    headerCreateButton();
    authScreen();
    feedSkeleton();
    scan(document.body);
    markRoles(document);

    new MutationObserver((mutations) => {
      for (const m of mutations) m.addedNodes.forEach((n) => scan(n.nodeType === 3 ? n.parentElement : n));
    }).observe(document.body, { childList: true, subtree: true });

    document.addEventListener("click", likePop, true);
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", init);
  else init();
})();
