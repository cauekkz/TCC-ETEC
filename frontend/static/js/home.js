const tab = document.querySelector(".tab");
const leftArrow = document.querySelector("#left-arrow");
const rightArrow = document.querySelector("#right-arrow");
const leftArrowInfo = document.querySelector("#left-arrow-infos");
const rightArrowInfo = document.querySelector("#right-arrow-infos");
const img = document.querySelector(".img-logo");
const cardProfile = document.querySelector(".row-profile");
const tabInfo = document.querySelector(".tab-infos");
const tabContainer = document.querySelector(".tab-container");
let textTabLeft = document.querySelectorAll(".col > p");
let textTabRight = document.querySelectorAll(".suggested-friends > p");
const centerContent = document.querySelector(
  ".col-6.flex-grow-1.overflow-auto"
);

/* leftArrow.addEventListener("click", () => {
  leftArrow.classList.add("d-none");
  rightArrow.classList.remove("d-none");
  tab.style.width = "2rem";
  tab.classList.remove("px-3");
  tab.classList.add("px-1");
  textTabLeft.forEach((text) => text.classList.add("d-none"));
  document.querySelector("#home").classList.add("d-none");
  cardProfile.classList.add("d-none");
  img.classList.add("d-none");
  setTimeout(() => {}, 400);
});

rightArrow.addEventListener("click", () => {
  rightArrow.classList.add("d-none");
  leftArrow.classList.remove("d-none");
  tab.style.width = "12rem";
  tab.classList.remove("px-1");
  tab.classList.add("px-3");
  document.querySelector("#home").classList.remove("d-none");
  img.classList.remove("d-none");
  textTabLeft.forEach((text) => text.classList.remove("d-none"));
  cardProfile.classList.remove("d-none");
}); */

const cardPost = document.querySelectorAll(".card-post");
const postFocus = document.querySelector(".container-post-focus");

cardPost.forEach((cards) => {
  // Passar os values por aq, img, nome, etec, 'função'
  cards.addEventListener("click", () => {
    postFocus.classList.remove("d-none");
  });
});

postFocus.addEventListener("click", (e) => {
  const conteudo = document.querySelector(".post-focus");
  if (!conteudo.contains(e.target)) {
    postFocus.classList.add("d-none");
  }
});

const btnSendComment = document.querySelector("#btnSend");
const form = document.querySelector(".form-comment");

btnSendComment.addEventListener("click", () => {
  if (!form.comment.value) {
    return;
  }

  // manda pra API, só arruma bgl de cada post antes
});

const btnCreate = document.querySelector("#btnCreate");
const containerCreate = document.querySelector(".container-create");

btnCreate.addEventListener("click", () => {
  containerCreate.classList.remove("d-none");
});

containerCreate.addEventListener("click", (e) => {
  const conteudo = document.querySelector(".create-card");
  if (!conteudo.contains(e.target)) {
    containerCreate.classList.add("d-none");
  }
});

document.querySelector(".like-post").addEventListener("click", (e) => {
  e.stopPropagation();
});

const formCreatePost = document.querySelector(".form-create");
const textareaCreate = document.querySelector("#textareaCreate");
const btnPublish = document.querySelector("#btnPublish");

btnPublish.setAttribute("disabled", true);

textareaCreate.addEventListener("input", () => {
  const textCreate = textareaCreate.value.trim();

  if (textCreate === "") {
    btnPublish.setAttribute("disabled", true);
  } else {
    btnPublish.removeAttribute("disabled");
  }
});

btnPublish.addEventListener("click", (e) => {
  e.preventDefault();
  const postContent = textareaCreate.value;
  if (!postContent) {
    return;
  }
  
  // passar pra API
});
