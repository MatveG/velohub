import React, {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import {cartFetch, cartProductUpdate, cartProductDetach} from '../api/cart';

const computeTotal = (products) => products.reduce((total, el) => total + el.amount * el.price, 0);

const Cart = (props) => {
    const dispatch = useDispatch();
    const pending = useSelector((state) => state.cart.pending);
    const products = useSelector((state) => state.cart.products);

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
        <CartTable totalCost={computeTotal(products)}>
            <CartProducts
                products={products}
                updateAmount={updateAmount}
                removeProduct={removeProduct} />
        </CartTable>
    );
};

export default Cart;
