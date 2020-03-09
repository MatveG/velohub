
import Core from './core.class';
import Cart from './cart.class';

$(() => {
    $('#product-options').on('change', selectOption);
    $('#add-button').on('click', cartAdd);
    $('#added-button').on('click', showCart);

    bindButtons();
    updCartStatus();
    updButtons();
});

function bindButtons() {
    $('.btn-cart-remove').on('click', cartRemove);

    $('.btn-cart-increase').on('click', function () {
        Cart.increase($(this).data('id'));
        showCart();
    });

    $('.btn-cart-decrease').on('click', function () {
        Cart.decrease($(this).data('id'));
        showCart();
    });
}

function showCart() {
    Core.ajaxGet('/ajax/widget/cart/', (data) => {
        $('#modal-cart .modal-body').html(data);

        bindButtons();
    });
}

function updCartStatus() {
    let icon = $('#cart-status');

    if(Cart.counter() > 0) {
        icon.addClass('icon-cart-full');
        return;
    }
    icon.removeClass('icon-cart-full');
}

function updButtons() {
    (Cart.check($('#add-button').data('id'))) ? addedState() : addState() ;
}

function selectOption() {
    let option = $(this).find('option:selected');

    $('#add-button').data('id', option.data('id'));
    $('#price').html(option.data('price'));
    $(this).removeClass('alert-danger');

    updButtons(option.val());
}

function cartAdd() {
    let select = $('#product-options');
    let id;

    if(select.length) {
        id = select.children("option:selected").val();

        if(!id) {
            select.addClass('alert-danger');
            return false;
        }
    } else {
        id = $(this).data('id');
    }

    Cart.add(id);
    addedState();
    updCartStatus();
}

function cartRemove() {
    let id = $(this).data('id');

    Cart.remove(id);

    if(id === $('#add-button').data('id')) {
        addState();
    }
    showCart();
    updCartStatus();
}

function addState() {
    $('#add-button').show();
    $('#added-button').hide();
}

function addedState() {
    $('#add-button').hide();
    $('#added-button').show();
}

