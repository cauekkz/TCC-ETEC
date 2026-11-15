const postFocus = document.querySelector(".container-post-focus");

cards.addEventListener("click", () => {
    postFocus.classList.remove("d-none");
});
postFocus.addEventListener("click", (e) => {
    const content = document.querySelector(".post-focus");
    if (!content.contains(e.target)) {
        postFocus.classList.add("d-none");
    }
});
