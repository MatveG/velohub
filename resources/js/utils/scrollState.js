export default () => {
    const action = window.scrollY > 15 ? 'add' : 'remove';
    const navbarMain = document.getElementById('navbar-main');
    const navbarInfo = document.getElementById('navbar-info');
    const toolBar = document.getElementById('toolbar');
    const scrollTop = document.getElementById('scroll-top');

    if (navbarMain) {
        navbarMain.classList[action]('navbar-main-scroll');
    }
    if (navbarInfo) {
        navbarInfo.classList[action]('navbar-info-scroll');
    }
    if (toolBar) {
        toolBar.classList[action]('toolbar-scroll');
    }
    if (scrollTop) {
        scrollTop.classList[action]('d-block');
    }
};
