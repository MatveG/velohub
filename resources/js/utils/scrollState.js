export default () => {
    const action = window.scrollY > 15 ? 'add' : 'remove';
    const navbarMain = document.getElementById('navbar-main');
    const navbarInfo = document.getElementById('navbar-info');
    const scrollTop = document.getElementById('scroll-top');

    navbarMain && navbarMain.classList[action]('navbar-main-scroll');
    navbarInfo && navbarInfo.classList[action]('navbar-info-scroll');
    scrollTop && scrollTop.classList[action]('d-block');
};
