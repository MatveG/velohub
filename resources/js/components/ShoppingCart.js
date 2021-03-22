import React from 'react';
import {connect} from 'react-redux';
import ShoppingCartTable from '../layouts/ShoppingCartTable';
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
        <ShoppingCartTable total={props.total}>
            {props.products.map((el, idx) => <ShoppingCartProduct key={idx} product={el}/>)}

            <tr className="border border-left-0 border-right-0">
                <td className="border-0 align-middle text-right text-uppercase" colSpan="4">
                    <strong>Итого:</strong>
                </td>
                <td className="border-0 align-middle">
                    <strong>{props.total}</strong>
                </td>
            </tr>
        </ShoppingCartTable>
    );
};

const mapState = ({cart}) => ({
    products: cart.products,
    total: cart.products.reduce((total, el) => {
        return total + el.amount * el.price;
    }, 0),
});

export default connect(mapState)(ShoppingCart);
