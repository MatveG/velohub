import React from 'react';

const BuyButton = (props) => {
    if (props.isInCart) {
        return (
            <button className="btn btn-gray w-auto" role="button" onClick={props.showCart}>
                уже в корзине
            </button>
        );
    }

    return (
        <button className="btn btn-bright w-auto" role="button" onClick={props.addToCart}>
            в корзину
        </button>
    );
};

export default BuyButton;
