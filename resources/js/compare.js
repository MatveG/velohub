
import Core from './core.class';
import Compare from './compare.class';

$(() => {
    $('.compare-toggle').each(compareCheck).on('click', compareToggle);
    $('.compare-remove').on('click', compareRemove);
    $('#compare-reset').on('click', compareReset);
    $('#compare-show-all').on('click', compareShowAll);
    $('#compare-show-diff').on('click', compareShowDiff);

    $('.compare-row').on('mouseover', function() {
        $(this).addClass('bg-light');
    }).on('mouseout', function() {
        $(this).removeClass('bg-light');
    });
});

function compareCheck() {
    let id = $(this).data('id');

    if(Compare.check(id)) {
        $(this).addClass('btn-gray').removeClass('btn-light');
    }
}

function compareToggle() {
    let id = $(this).data('id');

    if(Compare.check(id)) {
        Compare.remove(id);
        $(this).removeClass('btn-gray').addClass('btn-light');

        Core.getAjax('/ajax/widget/compare/', (data) => {
            $('#navbar-info-compare .navbar-info-body').html(data);
            $('#compare-reset').on('click', compareReset);
        }, false);

        return;
    }

    Compare.add(id);
    $(this).addClass('btn-gray').removeClass('btn-light');

    Core.getAjax('/ajax/widget/compare/', (data) => {
        $('#navbar-info-compare .navbar-info-body').html(data);
        $('#navbar-info-compare').collapse('show');
        $('#compare-reset').on('click', compareReset);
    });
}

function compareRemove() {
    Compare.remove( $(this).data('id') );

    location.reload();
}

function compareReset() {
    Compare.reset();

    if(window.location.href.includes('compare')) {
        location.reload();
        return;
    }

    $('#navbar-info-compare').collapse('hide');
    Core.getAjax('/ajax/widget/compare/', (data) => {
        $('#navbar-info-compare .navbar-info-body').html(data);
    }, false);
}

function compareShowDiff() {
    $('.compare-row').each(function() {
        let same = true;
        let prev;

        $(this).children().each(function(i) {
            if(i === 0) return;

            if(prev && prev !== $(this).text()) {
                same = false;
            }
            prev = $(this).text();
        });

        if(same === true) {
            $(this).hide();
        }
    });
}

function compareShowAll() {
    $('.compare-row').each(function() {
        $(this).show();
    });
}
