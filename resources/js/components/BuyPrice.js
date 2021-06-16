import React from 'react';

const BuyPrice = (props) => {
    return (
        <div className="my-4">
            {props.product.is_sale && !!props.product.price_old && <del className="text-secondary">
                { props.product.price_old}&nbsp;{props.currency.sign}
            </del>}
            <p className="product-price mt-1">
                {props.variant.price || props.product.price}&nbsp;{props.currency.sign}
            </p>
        </div>
    );
};

export default BuyPrice;
