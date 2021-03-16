export default () => {
    const action = window.scrollY > 15 ? 'add' : 'remove';

    document.getElementById('navbar-main').classList[action]('navbar-main-scroll');
    document.getElementById('navbar-info').classList[action]('navbar-info-scroll');
    document.getElementById('scroll-top').classList[action]('d-block');
};
