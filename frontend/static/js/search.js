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
})