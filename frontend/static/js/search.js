document.addEventListener('DOMContentLoaded', function () {
    const searchIcon = document.querySelector('.search-icon');
    const searchInput = document.querySelector('#searchInput');
    const searchForm = document.querySelector('#searchForm');
    const searchPreview = document.querySelector("#search-preview");
    const previewToggle = document.querySelectorAll('.preview-toggle');

    searchIcon.addEventListener('click', function () {
        const status = searchIcon.getAttribute('data-status');

        if (status === 'close') {
            searchIcon.style.transform = "scaleX(-1)"
            searchIcon.setAttribute('data-status', 'open');
            searchForm.style.width = "30vw";
            searchInput.focus();

        } else {
            searchIcon.style.transform = "scaleX(1)"
            searchIcon.setAttribute('data-status', 'close');
            searchInput.blur();
            searchForm.style.width = "1px";
            searchPreview.classList.add("hidden");

            searchInput.value = '';
        }

    })

    searchInput.addEventListener("input", () => {
        if (searchInput.value.trim() !== "") {
            searchPreview.classList.remove("hidden");
        } else {
            searchPreview.classList.add("hidden");


        }
    });

    previewToggle.forEach(icon => {
        icon.addEventListener('click', () => {
            const target = icon.getAttribute('data-target');
            const hiddenIcon = icon.querySelector('.hidden-icon');
            const previewSection = document.querySelector(`#preview-${target}`);
            if (previewSection.classList.contains('hidden')) {
                previewSection.classList.remove('hidden');
                hiddenIcon.src = "frontend/static/img/show.png";
            } else {
                previewSection.classList.add('hidden');
                hiddenIcon.src = "frontend/static/img/hide.png";
            }
        });
    });

    searchForm.addEventListener("submit", async (event) => {
        event.preventDefault()


        const searchTerm = searchInput.value.trim();
        if (searchTerm.length === 0) {
            return
        }
        const response = await fetch(`/api/getProfilesPostsSearch?q=${encodeURIComponent(searchTerm)}&server_id=${localStorage.getItem("selectedServer")}`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${localStorage.getItem("jwt_token")}`
            }
        })
        if (!response.ok) {
            return
        }
        const data = await response.json()
        if (data.status !== "success") {
            showBackendError(data, "erro ao buscar")
        }
        previewUsers = document.querySelector("#preview-users")
        previewPosts = document.querySelector("#preview-posts")
        previewUsers.innerHTML = ""
        previewPosts.innerHTML = ""

        const profiles = data.data?.profiles
        const posts = data.data?.posts
        profiles.forEach((profile) => {
            const profileName = profile.name ?? "usuario"
            const profileRole = profile.role ?? "user"
            const profileId = profile.id

            const roleColor = (profileRole == "estudante") ? "#9F2A20" : "#1F4FB8"
            const profilePath = profile?.profile_photo_path ?? null;

            const color = (profilePath) ? "transparent" : roleColor
            const url = (profilePath) ? `url("${profilePath}")` : "none"
            const userPhotoText = (profilePath) ? "" : getProfileLetter(profileName)
            const htmlProfile = document.createElement("div")
            htmlProfile.classList.add("preview-item", "user")
            htmlProfile.innerHTML = `
            <div class="avatar" style='background-image:${url};background-color:${color}'>
            ${userPhotoText}
            
            </div>

             <div style="display:flex;align-items:center;gap:0.5rem;">
                    <strong style="white-space: nowrap;
">${profileName}</strong>
            <span style="background-color:${roleColor};text-transform:capitalize;    padding: 0.1rem 0.3rem;
    border-radius: 7px;
    font-size: 0.75rem;
color:white;">
${profileRole}
            </span>
           </div>
           <span class="text-muted" style="display:flex;width:100%;justify-content:flex-end;">${profile.email}</span>

            `
            htmlProfile.addEventListener("click", () => {
                window.location.href = `/profile?profile=${profileId}`
            }
            )
            previewUsers.appendChild(htmlProfile);

        })

        posts.forEach((post) => {

            console.log(post)
            const author_name = post.author_name ?? "usuario"
            const content = post.content ?? ""
            const postId = post.id
            const created_at = post.created_at ?? ""
            const fCreatedAt = formatTimeAgo(created_at)
            const postPreview = document.createElement("div")
            postPreview.classList.add("preview-item", "post")
            postPreview.innerHTML = `
                        <strong>${author_name}</strong>
                        <p class="text-muted">${content.length > 30 ? content.substring(0, 30) + "..." : content}</p>
                        <span class="preview-date">há ${fCreatedAt}</span>
                    `

            postPreview.addEventListener("click", () => {
                openPostFocus(postId);
            })
            previewPosts.appendChild(postPreview);





            /* <div class="preview-item post">
                        <strong>Trabalho de Matemática</strong>
                        <p class="text-muted">Entrega até sexta-feira...</p>
                        <span class="preview-date">há 2 horas</span>
                    </div>*/
        })

    })
    function formatTimeAgo(created_at) {
        const createdDate = new Date(created_at.replace(" ", "T"));
        const now = new Date();

        const diffMs = now - createdDate;
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHrs = Math.floor(diffMin / 60);
        const diffDays = Math.floor(diffHrs / 24);
        const diffMonths = Math.floor(diffDays / 30);
        const diffYears = Math.floor(diffMonths / 12);

        if (diffYears > 0) return `${diffYears}y`;
        if (diffMonths > 0) return `${diffMonths}m`;
        if (diffDays > 0) return `${diffDays}d`;
        if (diffHrs > 0) return `${diffHrs}h`;
        if (diffMin > 0) return `${diffMin}min`;
        return `${diffSec}s`;
    }


    function openPostFocus(postId) {
        const postFocus = document.querySelector('.container-post-focus');
        if (postFocus) {
            postFocus.classList.remove('d-none');
            loadPostInFocus(postId);
        }
    }



})