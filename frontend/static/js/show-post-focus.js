const postFocus = document.querySelector(".container-post-focus");

cards.addEventListener("click", () => {
    postFocus.classList.remove("d-none");
});
postFocus.addEventListener("click", (e) => {
    const conteudo = document.querySelector(".post-focus");
    if (!conteudo.contains(e.target)) {
        postFocus.classList.add("d-none");
    }
});
