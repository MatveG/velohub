
// on load
$(() => {
    ($(window).scrollTop() > 15) ? scrollState() : topState();

    $('#scroll-top').on('click', function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
    });

    $('.scroll-to-id').on('click', function () {
        $('html, body').animate({
            scrollTop: $('#' + $(this).data('id')).offset().top-100
        }, 500);
    });

    let errorText = $('#error').text();

    if (errorText) {
        notify(errorText);
    }
});

// on scroll
$(window).scroll(() => {
    $('.navbar-info-block').collapse('hide'); // hide all navbar-info

    ($(window).scrollTop() > 15) ? scrollState() : topState(); // change scroll state
});

let scrollFlag = 0;
const scrollState = () => {
    if(scrollFlag === 1) return;

    $('#navbar-main').addClass('navbar-main-scroll');
    $('#navbar-info').addClass('navbar-info-scroll');
    $('#scroll-top').show();
    scrollFlag = 1;
};

const topState = () => {
    $('#navbar-main').removeClass('navbar-main-scroll');
    $('#navbar-info').removeClass('navbar-info-scroll');
    $('#scroll-top').hide();
    scrollFlag = 0;
};

// global
window.notify = (html) => {
    $('#navbar-info-notify .navbar-info-body').html(html);
    $('#navbar-info-notify').collapse('show');

    setTimeout(() => $("#navbar-info-notify").collapse('hide'), 5000);
};


