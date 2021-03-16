import React from 'react';
import {connect} from 'react-redux';
import CartTable from '../layouts/CartTable';
import ShoppingCartProduct from './ShoppingCartProduct';

const ShoppingCart = (props) => {
    if (!props.products.length) {
        return (
            <div className="text-center">
                <i>Здесь пока еще пусто</i>
            </div>
        );
    }

    return (
        <CartTable total={props.total}>
            {props.products.map((el, idx) => <ShoppingCartProduct key={idx} product={el}/>)}
        </CartTable>
    );
};

const mapState = ({cart}) => ({
    products: cart.products,
    total: cart.products.reduce((total, el) => {
        return total + el.amount * el.price;
    }, 0),
});

export default connect(mapState)(ShoppingCart);
