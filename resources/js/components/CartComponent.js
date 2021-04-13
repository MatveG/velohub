import React from 'react';
import CartTable from './CartTable';
import CartProduct from './CartProduct';

const CartComponent = (props) => {
    return (
        <CartTable
            totalCost={props.totalCost}
            currency={props.currency}>

            {props.products.map((el, idx) => (
                <CartProduct
                    key={idx}
                    product={el}
                    currency={props.currency}
                    updateAmount={props.updateAmount}
                    removeProduct={props.removeProduct} />
            ))}
        </CartTable>
    );
};

export default CartComponent;
