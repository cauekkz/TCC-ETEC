<header>
    <img src="frontend/static/img/left-arrow.png" alt="icon de voltar a pagina"> <span style="font-size: 1.3rem;">Perfil</span>
</header>

<section>
    <div id="profile-div">
        <div id="profile-box">
            <div id="user-infos">
                <div id="user-photo">

                </div>
                <span id="username"></span>
                <span id="user-role"></span>
                <span id="user-etec">ETEC de heliopólis</span>
            </div>

            <div id="perfil-icon-div">
                <span>
                    <img class="perfil-icon" src="frontend/static/img/loca-icon.png" alt="icon de localização">
                    <span id="perfil-address"></span>
                </span>
                <span>
                    <img class="perfil-icon" src="frontend/static/img/calendar-icon.png" alt="icon de calendário">
                    <span id="perfil-created">Membro desde março de 2025</span>
                </span>
            </div>
            <div id="social-info-div">
                <div>
                    <span>303</span>
                    <span>Posts</span>
                </div>
                <div>
                    <span>303</span>
                    <span>Seguindo</span>
                </div>
                <div>
                    <span>303</span>
                    <span>Seguidores</span>
                </div>

            </div>

            <button class="perfil-button" id="edit-profile-button">
                Editar perfil
            </button>
            <button class="perfil-button" id="leave-account-button">
                Sair da conta
            </button>
        </div>


    </div>

    <div id="posts-div">
        <h3>Suas publicações</h3>
        <h4>Todas as suas postagens na Eteconnect</h4>
        <div id="posts-box">

        </div>


    </div>
    <dialog id="edit-profile-modal">
        <div id="modal-header">
            <div>
                <span style="font-size: 1.5rem;font-weight:500;">Editar Perfil</span>
                <span aria-label="Fechar janela" id="close-modal-btn">X</span>
            </div>
            <span style="color:#666666;">Atualize suas informações pessoais</span>
        </div>
        <form id="update-form">
            <div id="update-photo-div">
                <input type="file" id="profilePic" style="display:none" />
                <label for="profilePic" id="photo-label" title="Clique para alterar foto" >
                </label>
                    <i class="bi bi-pencil-fill" style="font-size: 0.85rem;position:relative;left:-1.5rem;bottom:-2rem;background:white;border-radius:50%;padding:0.25rem;border:1px solid black"></i>



            </div>

        </form>

    </dialog>
</section>

<script src="frontend/static/js/likeFunctions.js"></script>
<script src="frontend/static/js/loaduserinformation.js"></script>
<script src="frontend/static/js/executeWithRefresh.js"></script>
<script src="frontend/static/js/getUserPosts.js"></script>
<script src="frontend/static/js/addPostBox.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {

        const userData = await executeWithRefresh(loadUserInformation, 'mine')
        sessionStorage.setItem('userData', JSON.stringify(userData?.data));

        const userInfo = userData?.data?.user
        const addressInfo = userData?.data?.address



        if (userInfo != null) {

            const username = userInfo?.name ?? "usuario"
            document.querySelector("#username").innerText = username;

            const role = userInfo?.role ?? "user"
            document.querySelector("#user-role").innerText = role;
            const roleColor = (role == "student") ? "#D32F2F" : "#2f32d3ff"
            document.querySelector("#user-role").style.background = roleColor;

            const created_at = userInfo.created_at;
            const date = new Date(created_at);

            const formattedDate = date.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            document.querySelector("#perfil-created").innerText = `Membro desde ${formattedDate}`;

            const profilePath = userInfo.profile_photo_path

            const userPhoto = document.querySelector("#user-photo")

            userPhoto.style.backgroundImage = profilePath ?
                `url("${profilePath}")` :
                "none";

            userPhoto.style.backgroundColor = profilePath ?
                "transparent" :
                roleColor;

            userPhoto.innerText = profilePath ?
                "" :
                getProfileLetter(username);

            userPhoto.style.backgroundRepeat = "no-repeat";
            userPhoto.style.backgroundPosition = "center";
            userPhoto.style.backgroundSize = "cover";




        }
        if (addressInfo != null) {
            const city = addressInfo?.city ?? ""
            const state = addressInfo?.state ?? ""
            document.querySelector("#perfil-address").innerText = `${city}, ${state}`;

        }
        if (userInfo?.role === "teacher") {
            const userPostData = await executeWithRefresh(getUserPosts, 'mine')

            const postsInfos = userPostData?.data
            postsInfos.forEach(postInfo => {

                const post = addPostBox(postInfo)
                const likebtn = post.querySelector(".post-like-icon")
                const postId = postInfo.id
                likebtn.addEventListener("click", async () => {

                    if (post.dataset.user_liked == 0) {
                        const data = await executeWithRefresh(addLike, 'post', postId)
                        changeFrontLike(post, true)
                        post.dataset.user_liked = 1
                    } else {
                        const data = await executeWithRefresh(deleteLike, 'post', postId)
                        changeFrontLike(post, false)
                        post.dataset.user_liked = 0
                    }

                })
                document.querySelector("#posts-box").appendChild(post)
            });
        }

        document.querySelector("#leave-account-button").addEventListener("click", () => {
            localStorage.clear()
            window.location.href = "/login"


        })
        document.querySelector("#edit-profile-button").addEventListener("click", () => {

            const modal = document.querySelector("#edit-profile-modal")
            modal.showModal();
            const userData = JSON.parse(sessionStorage.getItem('userData'));
            const userInfo = userData?.user
            const addressInfo = userData?.address



            if (userInfo != null) {
                const username = userInfo?.name ?? "usuario"

                const role = userInfo?.role ?? "user"
                const roleColor = (role == "student") ? "#D32F2F" : "#2f32d3ff"

                const profilePath = userInfo.profile_photo_path
                const userPhoto = document.querySelector("#photo-label")

                userPhoto.style.backgroundImage = profilePath ?
                    `url("${profilePath}")` :
                    "none";

                userPhoto.style.backgroundColor = profilePath ?
                    "transparent" :
                    roleColor;

                userPhoto.innerText = profilePath ?
                    "" :
                    getProfileLetter(username);

                userPhoto.style.backgroundRepeat = "no-repeat";
                userPhoto.style.backgroundPosition = "center";
                userPhoto.style.backgroundSize = "cover";


            }


        });
        const inputFile = document.querySelector("#profilePic")
        inputFile.addEventListener('change', () => {
            const file = inputFile.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                const photoLabel = document.querySelector("#photo-label")
                photoLabel.style.backgroundImage = `url("${url}")`;
                photoLabel.style.backgroundColor = "none"
                photoLabel.innerText = ""
            }
        });

    })
</script>