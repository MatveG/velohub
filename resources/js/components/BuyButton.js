import React from 'react';

const BuyButton = (props) => {
    if (!props.isStock) {
        return <b>нет в наличии</b>;
    }

    return props.isInCart ? (
        <button className="btn btn-gray w-50"
            role="button"
            data-bs-target="#modal-shopping-cart"
            data-bs-toggle="modal">
            уже в корзине
        </button>
    ) : (
        <button className="btn btn-bright w-50" role="button" onClick={props.addToCart}>
            В корзину
        </button>
    );
};

export default BuyButton;
