import React from 'react';
import CartProduct from './CartProduct';

const CartProducts = (props) => {
    return (
        <React.Fragment>
            {props.products.map((el, idx) => (
                <CartProduct
                    key={idx}
                    product={el}
                    updateAmount={props.updateAmount}
                    removeProduct={props.removeProduct}
                    readOnly={props.readOnly} />))}
        </React.Fragment>
    );
};

export default CartProducts;
