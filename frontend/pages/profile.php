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
                <span class="user-etec"></span>
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
                <div id="post-qtn-div">
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
                <label>ETEC</label>
                <div id="campus-update-div">
                    <select class="campus-select" id="campus-select-1">
                        <option disabled selected value="monstro">selecione</option>
                    </select>
                    <button type="button" id="add-campus-btn">+</button>
                </div>
                <!--Se for aluno-->
                <label for="course-select">Curso</label>
                <div id="course-update-div">

                    <button type="button" id="add-course-btn">+</button>

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

        const userInfo = userData?.data?.user ?? null
        const addressInfo = userData?.data?.address ?? null
        const campusInfo = userData?.data?.campus ?? null
        console.log(userData)

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
        if (campusInfo !== null) {

            const parent = document.querySelector("#user-infos")
            if (campusInfo.length == 1) {
                const span = document.createElement("span")
                span.classList.add("user-etec")
                span.innerText = campusInfo[0].name
                parent.appendChild(span)

            } else {
                const span = document.createElement("span")
                span.classList.add("user-etec")
                span.innerText = "ETECS..."
                parent.appendChild(span)

                campusInfo.forEach((campus) => {
                    span.title += campus.name + ". "
                })
            }


        } else {
            document.querySelector(".user-etec").innerText = "ETEC"

        }

        if (addressInfo != null) {
            const city = addressInfo?.city ?? ""
            const state = addressInfo?.state ?? ""
            document.querySelector("#perfil-address").innerText = `${city}, ${state}`;

        }

        if (userInfo?.role === "teacher") {
            const userPostData = await executeWithRefresh(getUserPosts, 'mine')

            const postsInfos = userPostData?.data?.posts ?? []
            const campusInfos = userPostData?.data?.campus ?? ["ETEC"]
            document.querySelector("#post-qtn").innerText = postsInfos?.length ?? 0
            postsInfos.forEach(postInfo => {
                postInfo["campus"] = campusInfos
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
        if (userInfo?.role === "student") {
            document.querySelector("#post-qtn-div").style.display = "none"
        }

        document.querySelector("#leave-account-button").addEventListener("click", () => {
            localStorage.clear()
            window.location.href = "/login"


        })
        const remove_campus_id_array = []
        const remove_course_id_array = []

        document.querySelector("#edit-profile-button").addEventListener("click", () => {
            const modal = document.querySelector("#edit-profile-modal")
            modal.showModal();
            const userData = JSON.parse(sessionStorage.getItem('userData'));
            const userInfo = userData?.user ?? null
            const addressInfo = userData?.address ?? null
            const campusInfos = userData?.campus ?? null
            const coursesInfos = userData?.course ?? null
            const role = userInfo?.role



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
            if (campusInfos !== null) {
                if (role === "teacher") {
                    campusInfo.forEach((campusInfo) => {
                        const btn = document.querySelector("#add-campus-btn")
                        const div = document.createElement("div")
                        div.classList.add("pod-div")
                        div.innerText = `${campusInfo.name}`
                        document.querySelector("#campus-update-div").prepend(div);
                        //calmo frio me mantenho leve
                        const btnDeleteCampus = document.createElement("btn")
                        btnDeleteCampus.classList.add("delete-campus-btn")
                        btnDeleteCampus.dataset.id = campusInfo.id
                        btnDeleteCampus.innerText = "X"
                        div.append(btnDeleteCampus)
                        btnDeleteCampus.addEventListener("click", () => {
                            remove_campus_id_array.push(btnDeleteCampus.dataset.id)
                            div.remove();
                        })
                    })
                } else {
                    const campusInfo = campusInfos[0]
                    const campusSelect1 = document.querySelector("#campus-select-1")
                    const selectedOption = campusSelect1.options[campusSelect1.selectedIndex];
                    selectedOption.text = campusInfo.name
                    selectedOption.value = "ameno murakomo no tsurugi"
                    campusSelect1.dataset.campusId = campusInfo.id
                }
            }
            if (coursesInfos !== null) {
                coursesInfos.forEach((courseInfo) => {
                    const btn = document.querySelector("#add-course-btn")
                    const div = document.createElement("div")
                    div.classList.add("pod-div")
                    div.innerText = `${courseInfo.name}`
                    document.querySelector("#course-update-div").prepend(div);
                    //calmo frio me mantenho leve
                    const btnDeleteCourse = document.createElement("btn")
                    btnDeleteCourse.classList.add("delete-campus-btn")
                    btnDeleteCourse.dataset.id = courseInfo.id
                    btnDeleteCourse.innerText = "X"
                    div.append(btnDeleteCourse)
                    btnDeleteCourse.addEventListener("click", () => {
                        remove_course_id_array.push(btnDeleteCourse.dataset.id)
                        div.remove();
                    })


                })


            }

            const campusSelect = document.querySelector("#campus-select-1")
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
            if (role === "teacher") {
                document.querySelector("#course-update-div").style.display = "none"
                document.querySelector("#add-campus-btn").addEventListener("click", (event) => {
                    const btn = event.target
                    const select = document.createElement("select")
                    select.classList.add("campus-select")
                    select.innerHTML = "<option disabled selected value='monstro'>selecione</option>"
                    document.querySelector("#campus-update-div").insertBefore(select, btn);

                    select.addEventListener("click", async (event) => {
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


                })
                campusSelect.style.display = "none"

            } else {
                document.querySelector("#add-campus-btn").style.display = "none"
                campusSelect.addEventListener("change", async (event) => {
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
                    const selects = document.querySelectorAll(".course-select")
                    selects.forEach((select) => {
                        select.innerHTML = "<option disabled selected >selecione</option>"
                        data.data.forEach((dt) => {
                            const option = document.createElement("option")
                            option.innerText = dt.name
                            option.value = dt.id
                            select.appendChild(option)
                        })

                    })

                })

                document.querySelector("#add-course-btn").addEventListener("click", async (event) => {
                    const btn = event.target
                    const select = document.createElement("select")
                    select.classList.add("course-select")
                    select.innerHTML = "<option disabled selected value='monstro'>selecione</option>"
                    document.querySelector("#course-update-div").insertBefore(select, btn);

                    if (campusSelect.value == "monstro") {
                        //selecione uma etec primeiro
                        return
                    }
                    const campusSelect1 = document.querySelector("#campus-select-1")

                    const campusIdSearchQuery = (campusSelect.value === "ameno murakomo no tsurugi") ? campusSelect1.dataset.campusId : campusSelect.value
                    console.log(campusIdSearchQuery)

                    const response = await fetch(`/api/getCoursesByEtec?campus_id=${campusIdSearchQuery}`)
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
        //simoh hayha

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
            if (result.status !== "success") {
                return
            }
            const campusSelects = document.querySelectorAll(".campus-select")
            const campusIds = []
            campusSelects.forEach((campusSelect) => {
                const value = campusSelect.value
                if (!isNaN(value)) {
                    campusIds.push(value)
                }
            })
            if (remove_campus_id_array.length) {
                const formCampus = new FormData();

                formCampus.append("campus_Ids", remove_campus_id_array)


                const deleteCampus = async (formData) => {
                    const token = localStorage.getItem("jwt_token");
                    const response = await fetch("/api/deleteCampusUser", {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                    return response.json();
                };

                const resultCampus = await executeWithRefresh(deleteCampus, formCampus);
                console.log("resultCampus")
                console.log(resultCampus)
            }
            const uniqueCampusIds = [...new Set(campusIds)];
            if (uniqueCampusIds.length) {

                const formCampus = new FormData();

                formCampus.append("campus_Ids", uniqueCampusIds)


                const updateCampus = async (formData) => {
                    const token = localStorage.getItem("jwt_token");
                    const response = await fetch("/api/addCampusUser", {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                    return response.json();
                };

                const resultCampus = await executeWithRefresh(updateCampus, formCampus);
            }

            const coursesSelects = document.querySelectorAll(".course-select")
            console.log(coursesSelects)
            const coursesIds = []
            coursesSelects.forEach((courseSelect) => {
                const value = courseSelect.value
                if (!isNaN(value)) {
                    coursesIds.push(value)
                }
            })
            if (remove_course_id_array.length) {
                const formCourses = new FormData();

                formCourses.append("courses_Ids", remove_course_id_array)


                const deleteCourse = async (formData) => {
                    const token = localStorage.getItem("jwt_token");
                    const response = await fetch("/api/deleteCourseUser", {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                    return response.json();
                };

                const resultCourse = await executeWithRefresh(deleteCourse, formCourses);
                console.log(resultCourse)
            }


            const uniqueCourseIds = [...new Set(coursesIds)];
            if (uniqueCourseIds.length) {

                const formCourse = new FormData();

                formCourse.append("courses_ids", uniqueCourseIds)


                const updateCourse = async (formData) => {
                    const token = localStorage.getItem("jwt_token");
                    const response = await fetch("/api/addCourseUser", {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                    return response.json();
                };

                const resultCourse = await executeWithRefresh(updateCourse, formCourse);
                console.log(resultCourse)
            }

            // window.location.reload();

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