import React, {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import {cartFetch, cartProductUpdate, cartProductDetach} from '../api/cart';

const Cart = (props) => {
    const dispatch = useDispatch();
    const pending = useSelector((state) => state.cart.pending);
    const products = useSelector((state) => state.cart.products);
    const total = products.reduce((total, el) => total + el.amount * el.price, 0);

    useEffect(() => {
        if (!pending) {
            dispatch(cartFetch());
        }
    }, []);

    const updateAmount = (product, mod) => {
        if (product.amount + mod > 0) {
            dispatch(cartProductUpdate({...product, amount: product.amount + mod}));
        }
    };

    const removeProduct = (product) => {
        dispatch(cartProductDetach(product));
    };

    return (
        <CartTable total={total}>
            <CartProducts products={products}
                updateAmount={updateAmount}
                removeProduct={removeProduct}
                readOnly={props.readOnly} />
        </CartTable>
    );
};

export default Cart;
