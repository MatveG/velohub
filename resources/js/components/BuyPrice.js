import React from 'react';

const BuyPrice = (props) => {
    return (
        <p className="my-3">
            <span className="product-price">
                {props.variant.price || props.product.price}
            </span>&nbsp;
            <span>{props.currency.sign}</span>
        </p>
    );
};

export default BuyPrice;
