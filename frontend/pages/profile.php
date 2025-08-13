<header>
    <img id="btnBack" src="frontend/static/img/left-arrow.png" alt="icon de voltar a pagina"> <span style="font-size: 1.3rem;">Perfil</span>
</header>

<section>
    <div id="profile-div">
        <div id="profile-box">
            <div id="user-infos">
                <div id="user-photo">

                </div>
                <span id="username"></span>
                <span id="user-role"></span>
                <span id="user-etec"></span>
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
                    <span id="post-qtn"></span>
                    <span>Posts</span>
                </div>
                <div>
                    <span id="following_count"></span>
                    <span>Seguindo</span>
                </div>
                <div>
                    <span id="followers_count"></span>
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
                <input type="file" id="profilePic" style="display:none" value="nochange" />


                <label for="profilePic" id="photo-label" title="Clique para alterar foto">
                </label>
                <i class="bi bi-pencil-fill" id="edit-icon" style="font-size: 0.85rem;position:relative;left:-1.5rem;bottom:-2rem;background:white;border-radius:50%;padding:0.25rem;border:1px solid black"></i>

                <span aria-label="reset imagem de perfil" id="remove-pic" style="position:relative;left:-1.5rem;bottom:-2rem;background:white;border-radius:50%;padding: 0.25rem ;border:1px solid black;width: 1.5rem;height: 1.5rem;display:flex;justify-content:center;align-items:center;cursor:pointer;display:none;" title="clique para remover a foto">X</span>


            </div>
            <div id="update-user-div">
                <label for="name-update">Nome</label>
                <input type="text" id="name-update" name="name" placeholder="nome">
                <label for="email-update">Email</label>
                <input type="email" id="email-update" name="email" placeholder="email@etec.sp.gov.br">
                <label for="phone-update">Telefone</label>
                <input type="tel" id="phone-update" name="phone" placeholder="xxxxxxx-xxxx">
                <label for="campus-select">ETEC</label>
                <div id="campus-update-div">

                </div>
                <select name="campus" id="campus-select">
                    <option disabled selected value="monstro">selecione</option>
                </select>
                <!--Se for aluno-->
                <div id="course-update-div">
                    <label for="course-select">Curso</label>
                    <select name="course" id="course-select">
                        <option disabled selected>selecione</option>
                    </select>
                </div>


            </div>
            <div id="update-address-div">
                <label for="street-update">Rua</label>
                <input type="text" id="street-update" name="street" placeholder="Rua">

                <label for="address-number-update">Número</label>
                <input type="text" id="address-number-update" name="address_number" placeholder="Número">

                <label for="city-update">Cidade</label>
                <input type="text" id="city-update" name="city" placeholder="Cidade">

                <label for="state-update">Estado</label>
                <input type="text" id="state-update" name="state" placeholder="UF" maxlength="2">

                <label for="zip-code-update">CEP</label>
                <input type="text" id="zip-code-update" name="zip_code" placeholder="CEP">

            </div>
            <button type="submit">Enviar</button>
        </form>

    </dialog>
</section>

<script src="frontend/static/js/likeFunctions.js"></script>
<script src="frontend/static/js/loaduserinformation.js"></script>
<script src="frontend/static/js/executeWithRefresh.js"></script>
<script src="frontend/static/js/getUserPosts.js"></script>
<script src="frontend/static/js/addPostBox.js"></script>
<script src="frontend/static/js/getPayload.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {

        const userData = await executeWithRefresh(loadUserInformation, 'mine')
        sessionStorage.setItem('userData', JSON.stringify(userData?.data));

        const userInfo = userData?.data?.user
        const addressInfo = userData?.data?.address
        console.log(userData)


        if (userInfo != null) {

            const username = userInfo?.name ?? "usuario"
            document.querySelector("#username").innerText = username;

            const role = userInfo?.role ?? "user"
            document.querySelector("#user-role").innerText = role;
            const roleColor = (role == "student") ? "#D32F2F" : "#2f32d3ff"
            document.querySelector("#user-role").style.background = roleColor;

            const created_at = userInfo.created_at;

            const campus = userInfo?.campus_name ?? "ETEC"
            document.querySelector("#user-etec").innerText = campus



            const date = new Date(created_at);

            const formattedDate = date.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            document.querySelector("#followers_count").innerText = userData?.data?.followers_count?.followers_count
            document.querySelector("#following_count").innerText = userData?.data?.following_count?.following_count

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

            const postsInfos = userPostData?.data ?? []

            document.querySelector("#post-qtn").innerText = postsInfos?.length ?? 0
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


                const email = userInfo?.email ?? ""
                const phone = userInfo?.phone ?? ""

                document.querySelector("#name-update").value = username
                document.querySelector("#email-update").value = email
                document.querySelector("#phone-update").value = phone

            }
            if (addressInfo != null) {
                document.querySelector("#street-update").value = addressInfo.street ?? "";
                document.querySelector("#address-number-update").value = addressInfo.address_number ?? "";
                document.querySelector("#city-update").value = addressInfo.city ?? "";
                document.querySelector("#state-update").value = addressInfo.state ?? "";
                document.querySelector("#zip-code-update").value = addressInfo.zip_code ?? "";
            }


        });
        document.querySelector("#close-modal-btn").addEventListener("click", () => {
            const modal = document.querySelector("#edit-profile-modal")
            modal.close();

        })
        const inputFile = document.querySelector("#profilePic")
        inputFile.addEventListener('change', () => {
            const file = inputFile.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                const photoLabel = document.querySelector("#photo-label")
                photoLabel.style.backgroundImage = `url("${url}")`;
                photoLabel.style.backgroundColor = "none"
                photoLabel.innerText = ""
                document.querySelector("#remove-pic").style.display = "flex";
                document.querySelector("#edit-icon").style.display = "none";
            }
        });

        document.querySelector("#remove-pic").addEventListener("click", () => {

            inputFile.value = "";

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


            document.querySelector("#remove-pic").style.display = "none";
            document.querySelector("#edit-icon").style.display = "block";

        })

        const campusSelect = document.querySelector("#campus-select")
        campusSelect.addEventListener("click", async (event) => {
            const select = campusSelect
            if (select.options.length !== 1) {
                return
            }
            const response = await fetch("/api/getAllEtecsNames")
            if (!response.ok) {
                return
            }
            const data = await response.json();
            if (data.status !== "success") {
                return
            }
            data.data.forEach((dt) => {
                const option = document.createElement("option")
                option.innerText = dt.name
                option.value = dt.id
                select.appendChild(option)
            })
        })
        campusSelect.addEventListener("change", async (event) => {
            const select = document.querySelector("#course-select")
            if (campusSelect.value == "monstro") {
                //selecione uma etec primeiro
                return

            }

            const response = await fetch(`/api/getCoursesByEtec?campus_id=${campusSelect.value}`)
            if (!response.ok) {
                return
            }
            const data = await response.json();
            if (data.status !== "success") {
                return
            }

            select.innerHTML = "<option disabled selected >selecione</option>"
            data.data.forEach((dt) => {
                const option = document.createElement("option")
                option.innerText = dt.name
                option.value = dt.id
                select.appendChild(option)
            })
        })

        const form = document.querySelector("#update-form")
        form.addEventListener("submit", async (event) => {
            event.preventDefault();
            const formData = new FormData();

            formData.append("name", form.name.value);
            formData.append("email", form.email.value);
            formData.append("phone", form.phone.value);
            formData.append("street", form.street.value);
            formData.append("address_number", form.address_number.value);
            formData.append("city", form.city.value);
            formData.append("state", form.state.value);
            formData.append("zip_code", form.zip_code.value);
            //bug de mira fds vamo abusa
            const has_address = (form.street.value.length === 0) ? false : true
            formData.append("has_address", has_address);


            if (form.profilePic.files.length > 0) {
                formData.append("profilePic", form.profilePic.files[0]);
            }
            const updateUser = async (formData) => {
                const token = localStorage.getItem("jwt_token");
                const response = await fetch("/api/updateuser", {
                    method: "POST",
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });
                return response.json();
            };

            // Aqui você chama o executeWithRefresh, passando a função updateUser e o formData
            const result = await executeWithRefresh(updateUser, formData);
            if (result.status === "success") {
                window.location.reload();

            }
        })
        document.getElementById('btnBack').addEventListener('click', function() {
            const referrer = document.referrer;
            const currentHost = window.location.host;

            if (referrer && new URL(referrer).host === currentHost) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        });

    })
</script>