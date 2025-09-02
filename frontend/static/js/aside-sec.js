function fillAsideProfile(userData) {
    const userInfo = userData?.user ?? null;
    if (userInfo !== null) {
        const userRole = userInfo.role;
        const username = userInfo.name;
        const roleSpan = document.querySelector(".name-text.mt-2 span");
        const userPhoto = document.querySelector("#profile-pic-user");

        document.querySelector(".name-text.mt-2 strong").innerText = username;
        roleSpan.innerText = userRole;
        const roleColor = (userRole == "estudante") ? "#D32F2F" : "#2f32d3ff";
        roleSpan.style.setProperty('background-color', roleColor, 'important');

        const profilePath = userInfo.profile_photo_path;

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
}
function getProfileLetter(name) {
    return name ? name.charAt(0).toUpperCase() : '?';
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".row-profile").addEventListener("click", () => {
        window.location.href = "/profile?profile=mine"
    });
    console.log("porra")

    document.querySelector("#logout-button").addEventListener("click", (e) => {
        e.preventDefault()
        localStorage.clear()
        sessionStorage.clear()
        window.location.href = "/login"
    })
})
