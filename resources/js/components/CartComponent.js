import React from 'react';
import CartTable from './CartTable';
import CartItem from './CartItem';

const CartComponent = (props) => {
    return (
        <CartTable
            totalCost={props.totalCost}
            currency={props.currency}>

            {props.items.map((item, idx) => (
                <CartItem
                    key={idx}
                    item={item}
                    currency={props.currency}
                    updateAmount={props.updateAmount}
                    removeProduct={props.removeProduct} />
            ))}
        </CartTable>
    );
};

export default CartComponent;
