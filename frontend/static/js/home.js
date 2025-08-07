const tab = document.querySelector('.tab')
const leftArrow = document.querySelector('#left-arrow')
const rightArrow = document.querySelector('#right-arrow')
const leftArrowInfo = document.querySelector('#left-arrow-infos')
const rightArrowInfo = document.querySelector('#right-arrow-infos')
const img = document.querySelector('.img-logo')
const cardProfile = document.querySelector('.card-profile')
const filters = document.querySelector('.filters')
const tabInfo = document.querySelector('.tab-infos')
const tabContainer = document.querySelector('.tab-container')
let textTabLeft = document.querySelectorAll('.col > p')
let textTabRight = document.querySelectorAll('.suggested-friends > p')
const centerContent = document.querySelector('.col-6.flex-grow-1.overflow-auto')

leftArrow.addEventListener('click', () => {
    leftArrow.classList.add('d-none')
    rightArrow.classList.remove('d-none')
    tab.style.width = '2rem'
    tab.classList.remove('px-3')
    tab.classList.add('px-1')
    textTabLeft.forEach(text => text.classList.add('d-none'))
    document.querySelector('#home').classList.add('d-none')
    setTimeout(() => {
        img.classList.add('d-none')
        cardProfile.classList.add('d-none')
        filters.classList.add('d-none')
    }, 400)
});

rightArrow.addEventListener('click', () => {
    rightArrow.classList.add('d-none')
    leftArrow.classList.remove('d-none')
    tab.style.width = '17rem'
    tab.classList.remove('px-1')
    tab.classList.add('px-3')
    document.querySelector('#home').classList.remove('d-none')
    img.classList.remove('d-none')
    textTabLeft.forEach(text => text.classList.remove('d-none'))
    cardProfile.classList.remove('d-none')
    filters.classList.remove('d-none')
});

rightArrowInfo.addEventListener('click', () => {
    leftArrowInfo.classList.remove('d-none')
    rightArrowInfo.classList.add('d-none')
    tabInfo.style.width = '2rem'
    centerContent.classList.add('expanded-center');
    tabContainer.classList.add('d-none')
});

leftArrowInfo.addEventListener('click', () => {
    leftArrowInfo.classList.add('d-none')
    rightArrowInfo.classList.remove('d-none')
    tabInfo.style.width = '17rem'
    centerContent.classList.remove('expanded-center')
    tabContainer.classList.remove('d-none')
});