
import Core from '../../js/core.class';

$(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.page-prev').on('click', pagePrev);
    $('.page-next').on('click', pageNext);
    $('.limit-select').on('change', limitChange);
    $('.mass-check').on('click', massCheck);
    $('.mass-action').on('change', massAction);
    $('.row-action').on('change', rowAction);

    $('button.reset').on('click', filterReset);

    $('#filters').on('submit', function (event) {
        event.preventDefault();
    });

    $('#main-table thead :input').not('.mass-check, .mass-check').each(function () {
        if($(this).data('suggest')) {
            filterSuggest(this);
        }

        $(this).on('change', updateRows);

        $(this).keypress(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                updateRows();
            }
        });
    });

    $('.sku-delete').on('click', skuDelete);
    $('.sku-set-default').on('click', setDefault);
    $('.sku-set-active').on('click', setActive);
});

function updateRows() {
    window.page = 1;
    pageNumber();
    loadRows();
}

function loadRows() {
    let query = 'get/?' + $('#filters').serialize() +
        `&limit=${window.limit}&page=${window.page}&sort=${window.sort[0]}&order=${window.sort[1]}`;

    Core.ajaxGet(window.path + query, function (res) {
        $('#rows').html(res);
    })
}

function filterSuggest(element) {
    let name = $(element).attr('name');
    let pluck = $(element).data('pluck');

    $(element).typeahead({
        source: function (value, process) {
            return $.get(window.path + 'suggest/', { column: name, value: value, pluck: pluck }, function (data) {
                return process(data);
            });
        }
    });
}

function filterReset() {
    window.page = 1;
    window.sort = ['id', 'desc'];
    this.form.reset();
    updateRows();
}

function massCheck() {
    $('#main-table tbody input[type=checkbox], .mass-check').prop("checked", $(this).is(':checked'));
}

function rowAction() {
    let ids = [$(this).data('id')];
    let action = $(this).find('option:selected').val();

    if(action === 'Edit') {
        window.location.href = window.path + 'edit/?id=' + $(this).data('id');
    }
    if(action === 'Delete') {
        actionDelete(ids);
    }
}

function massAction() {
    let ids = [];
    let action = $(this).find('option:selected').val();

    $('#main-table input:checkbox:checked').not('.mass-check').each(function(){
        ids.push($(this).val());
    });

    if(action === 'Delete') {
        actionDelete(ids);
    }
}

function actionDelete() {
    alert('123');

    let url = window.path;
    // let sure = confirm("Удалить?");
    //
    // if(!sure) return;
    //
    // Core.ajaxPost(url, { ids: JSON.stringify(ids) }, function (data) {
    //     if(data.ok) {
    //         loadRows();
    //     }
    // })
}

function limitChange() {
    window.limit = $(this).val();
    updateRows();
}

function pagePrev() {
    if(window.page <= 1) return;
    window.page--;
    pageNumber();
    loadRows(false);
}

function pageNext() {
    window.page++;
    pageNumber();
    loadRows(false);
}

function pageNumber() {
    $('.page-number').html(window.page);
}



function skuDelete() {
    let row = $(this).closest('tr');
    Core.ajaxPost('/admin/sku/delete/', 'delete', { id: $(this).data('id') }, function (res) {
        row.fadeOut(500);
    })
}

function setDefault() {
    Core.ajaxPost('/admin/sku/set-default/', 'patch', { id: $(this).data('id') }, function (res) {
        //console.log(res);
    })
}

function setActive() {
    let val = ($(this).prop("checked")) ? 1 : 0;
    Core.ajaxPost('/admin/sku/set-active/', 'patch', { id: $(this).data('id'), is_active: val }, function (res) {
        //console.log(res);
    })
}
