import React from 'react';

const BuyPrice = (props) => {
    return (
        <p className="my-3">
            {props.product.is_sale && <del className="text-secondary">
                {props.variant.price_old || props.product.price_old}&nbsp;
                {props.currency.sign}
            </del>}
            <p className="product-price mt-1">
                {props.variant.price || props.product.price}&nbsp;{props.currency.sign}
            </p>
        </p>
    );
};

export default BuyPrice;
