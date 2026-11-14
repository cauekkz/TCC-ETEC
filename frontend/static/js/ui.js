/* ETEConnect — camada de interação (ui.js)
   - transforma o título de cada página em um banner (hero)
   - anima a entrada de cards conforme são renderizados (stagger)
   - skeleton enquanto o feed carrega
   - microinterações (curtida, menu ativo, tela de login)
   Tudo respeita prefers-reduced-motion. */
(function () {
  "use strict";

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const page = (document.body.className.match(/page-(\S+)/) || [])[1] || "";

  const ICONS = {
    home: '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z"/>',
    notices: '<path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
    events: '<rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/>',
    projects: '<path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/>',
    servers: '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
  };
  const SUBTITLES = {
    home: "O que está rolando na sua Etec",
    notices: "Comunicados oficiais da sua unidade",
    events: "Participe do que acontece na escola",
    projects: "Vitrine de TCCs da sua Etec",
    servers: "Escolha a comunidade da sua Etec",
  };

  /* ---------- 1. Hero das páginas ---------- */
  function buildHero() {
    const title = document.getElementById("feedTitle");
    if (!title || !ICONS[page]) return;
    const wrapper = title.closest(".d-flex") || title.parentElement;
    if (!wrapper || wrapper.classList.contains("ui-page-hero")) return;

    wrapper.classList.remove("d-flex");
    wrapper.classList.add("ui-page-hero");
    title.classList.add("ui-hero-title");
    title.classList.remove("h2");

    const icon = document.createElement("div");
    icon.className = "ui-hero-icon";
    icon.setAttribute("aria-hidden", "true");
    icon.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${ICONS[page]}</svg>`;
    wrapper.prepend(icon);

    let sub = document.getElementById("consecultivos");
    if (!sub) {
      sub = document.createElement("p");
      sub.textContent = SUBTITLES[page];
      title.after(sub);
    }
    sub.classList.add("ui-hero-sub");
    sub.classList.remove("text-secondary");
    if (!sub.textContent.trim() || /null/.test(sub.textContent)) sub.textContent = SUBTITLES[page];

    // chips com contexto do servidor atual
    const serverName = safeGet("selectedServerName");
    if (serverName && page !== "servers") {
      const chips = document.createElement("div");
      chips.className = "ui-hero-chips";
      chips.innerHTML = `<span class="ui-hero-chip"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin:-2px 4px 0 0"><path d="M12 22s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>${uiEscape(serverName)}</span>`;
      wrapper.appendChild(chips);
    }
  }

  function safeGet(key) {
    try { return localStorage.getItem(key); } catch (e) { return null; }
  }

  /* ---------- 2. Animação de entrada (stagger) ---------- */
  const CARD_SELECTOR = ".post, .notice-card, .event-card, .project-card, .server-card, .contact, .comment-box, .ui-section-label";
  let queue = [];
  let scheduled = false;

  function reveal(el) {
    if (reduceMotion || el.dataset.uiRevealed) return;
    el.dataset.uiRevealed = "1";
    queue.push(el);
    if (!scheduled) {
      scheduled = true;
      requestAnimationFrame(() => {
        queue.forEach((node, i) => {
          node.style.setProperty("--ui-delay", Math.min(i * 55, 500) + "ms");
          node.classList.add("ui-reveal");
          node.addEventListener("animationend", () => node.classList.remove("ui-reveal"), { once: true });
        });
        queue = [];
        scheduled = false;
      });
    }
  }

  function scan(root) {
    if (!(root instanceof Element)) return;
    if (root.matches(CARD_SELECTOR)) reveal(root);
    root.querySelectorAll(CARD_SELECTOR).forEach(reveal);
    // avisos: marcar o tipo para colorir a borda
    root.querySelectorAll?.(".notice-card").forEach(markNotice);
    if (root.matches?.(".notice-card")) markNotice(root);
  }

  function markNotice(card) {
    if (/evento/i.test(card.textContent.slice(0, 400)) && card.querySelector(".fa-calendar, .fa-star, .urgency-tag")) {
      const meta = card.querySelector(".notice-meta");
      if (meta && /evento/i.test(meta.textContent)) card.classList.add("ui-type-evento");
    }
  }

  /* ---------- 3. Skeleton do feed ---------- */
  function feedSkeleton() {
    const posts = document.querySelector(".page-home .posts");
    if (!posts || posts.children.length) return;
    const frag = document.createDocumentFragment();
    for (let i = 0; i < 3; i++) {
      const sk = document.createElement("div");
      sk.className = "ui-skeleton";
      sk.setAttribute("aria-hidden", "true");
      sk.innerHTML = `<div class="sk sk-avatar"></div><div class="sk-lines">
        <div class="sk sk-line" style="width:35%"></div>
        <div class="sk sk-line" style="width:20%"></div>
        <div class="sk sk-line" style="width:95%;margin-top:.4rem"></div>
        <div class="sk sk-line" style="width:80%"></div></div>`;
      frag.appendChild(sk);
    }
    posts.setAttribute("aria-busy", "true");
    posts.appendChild(frag);

    const obs = new MutationObserver(() => {
      const real = posts.querySelector(".post");
      if (real) {
        posts.querySelectorAll(".ui-skeleton").forEach((n) => n.remove());
        posts.removeAttribute("aria-busy");
        obs.disconnect();
      }
    });
    obs.observe(posts, { childList: true });
    // se não houver posts, some com o skeleton depois de um tempo
    setTimeout(() => {
      if (!posts.querySelector(".post")) {
        posts.querySelectorAll(".ui-skeleton").forEach((n) => n.remove());
        posts.removeAttribute("aria-busy");
      }
    }, 6000);
  }

  /* ---------- 4. Microinterações ---------- */
  function likePop(e) {
    const target = e.target.closest(".post-like-icon, .like-post, .like-btn, .comment-like");
    if (!target) return;
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
    btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg><span class="ui-btn-label" style="margin-left:.35rem">${uiEscape(text)}</span>`;
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
    head.innerHTML = `<h1 class="ui-auth-title">Bem-vindo ao <span>ETEConnect</span></h1>
      <p class="ui-auth-sub">A rede que conecta alunos e professores das Etecs</p>`;
    logoRow.after(head);
  }


  /* ---------- 5. Ripple, tema e contador ---------- */
  function ripple(e) {
    if (reduceMotion) return;
    const btn = e.target.closest(".btn, .participate-btn, .view-project-btn, .send, .server-card, .col-hover");
    if (!btn) return;
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const dot = document.createElement("span");
    dot.className = "ui-ripple";
    dot.style.width = dot.style.height = size + "px";
    dot.style.left = e.clientX - rect.left - size / 2 + "px";
    dot.style.top = e.clientY - rect.top - size / 2 + "px";
    btn.classList.add("ui-ripple-host");
    btn.appendChild(dot);
    dot.addEventListener("animationend", () => dot.remove(), { once: true });
  }

  function themeSpin(e) {
    const t = e.target.closest(".light-dark");
    if (!t) return;
    t.classList.remove("ui-theme-spin");
    void t.offsetWidth;
    t.classList.add("ui-theme-spin");
  }

  function watchLikeCounters() {
    new MutationObserver((mutations) => {
      for (const m of mutations) {
        const el = m.target.nodeType === 3 ? m.target.parentElement : m.target;
        const counter = el?.closest?.(".total_likes, #qntLikes");
        if (!counter || reduceMotion) continue;
        counter.classList.remove("ui-bump");
        void counter.offsetWidth;
        counter.classList.add("ui-bump");
      }
    }).observe(document.body, { characterData: true, childList: true, subtree: true });
  }

  /* ---------- init ---------- */
  function init() {
    buildHero();
    headerCreateButton();
    authScreen();
    feedSkeleton();
    scan(document.body);

    new MutationObserver((mutations) => {
      for (const m of mutations) m.addedNodes.forEach(scan);
    }).observe(document.body, { childList: true, subtree: true });

    document.addEventListener("click", likePop, true);
    document.addEventListener("pointerdown", ripple, true);
    document.addEventListener("click", themeSpin, true);
    watchLikeCounters();
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", init);
  else init();
})();
