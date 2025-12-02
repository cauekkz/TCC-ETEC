function fillAsideProfile(userData) {
  const userInfo = userData?.user ?? null;
  if (userInfo !== null) {
    const userRole = userInfo.role;
    const username = userInfo.name;
    const roleSpan = document.querySelector(".name-text.mt-2 span");
    const userPhoto = document.querySelector("#profile-pic-user");

    document.querySelector(".name-text.mt-2 strong").innerText = username;
    roleSpan.innerText = userRole;
    const roleColor = userRole == "estudante" ? "#D32F2F" : "#2f32d3ff";
    roleSpan.style.setProperty("background-color", roleColor, "important");

    const profilePath = userInfo.profile_photo_path;

    userPhoto.style.backgroundImage = profilePath
      ? `url("${profilePath}")`
      : "none";

    userPhoto.style.backgroundColor = profilePath ? "transparent" : roleColor;

    userPhoto.innerText = profilePath ? "" : getProfileLetter(username);

    userPhoto.style.backgroundRepeat = "no-repeat";
    userPhoto.style.backgroundPosition = "center";
    userPhoto.style.backgroundSize = "cover";
  }
}
function getProfileLetter(name) {
  return name ? name.charAt(0).toUpperCase() : "?";
}

document.addEventListener("DOMContentLoaded", () => {
  const rowProfile = document.querySelector(".row-profile");
  if (rowProfile) {
    rowProfile.addEventListener("click", () => {
      window.location.href = "/profile?profile=mine";
    });
  }

  const logoutButton = document.querySelector("#logout-button");
  if (logoutButton) {
    logoutButton.addEventListener("click", (e) => {
      e.preventDefault();
      localStorage.clear();
      sessionStorage.clear();
      window.location.href = "/login";
    });
  }
  setTimeout(() => {
    const serverName = localStorage.getItem("selectedServerName") ?? null;
    const link = document.querySelector('a[href="/projects"]');
    if (serverName === "Geral") {
      link.style.display = "none";
      console.log(serverName);

    } else {
      link.style.display = "block";
    }
  }, 100);
  initMobileMenu();
});

function initMobileMenu() {
  const tab = document.querySelector(".tab");
  if (!tab) return;

  // Criar overlay para o menu mobile
  let overlay = document.querySelector(".mobile-menu-overlay");
  if (!overlay) {
    overlay = document.createElement("div");
    overlay.className = "mobile-menu-overlay";
    document.body.appendChild(overlay);
  }

  // Criar botão de toggle se não existir
  let mobileToggle = document.querySelector(".mobile-menu-toggle");
  if (!mobileToggle) {
    mobileToggle = document.createElement("button");
    mobileToggle.className = "mobile-menu-toggle";
    mobileToggle.setAttribute("aria-label", "Abrir menu");
    mobileToggle.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        `;
    document.body.appendChild(mobileToggle);

    // Atualizar visibilidade inicial
    updateMobileToggleVisibility();

    const toggleMenu = () => {
      const isOpen = tab.classList.contains("open");
      if (isOpen) {
        tab.classList.remove("open");
        overlay.classList.remove("active");
        document.body.style.overflow = "";
      } else {
        tab.classList.add("open");
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
      }
    };

    mobileToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      toggleMenu();
    });

    overlay.addEventListener("click", () => {
      toggleMenu();
    });

    // Fechar menu ao clicar em um link do menu
    const menuLinks = tab.querySelectorAll(".aside-a");
    menuLinks.forEach((link) => {
      link.addEventListener("click", () => {
        if (window.innerWidth <= 768 && tab.classList.contains("open")) {
          toggleMenu();
        }
      });
    });
  }

  // Atualizar visibilidade do botão ao redimensionar
  window.addEventListener("resize", updateMobileToggleVisibility);

  function updateMobileToggleVisibility() {
    if (mobileToggle && overlay) {
      if (window.innerWidth > 768) {
        mobileToggle.style.display = "none";
        overlay.classList.remove("active");
        tab.classList.remove("open");
        document.body.style.overflow = "";
      } else {
        mobileToggle.style.display = "flex";
      }
    }
  }
}
