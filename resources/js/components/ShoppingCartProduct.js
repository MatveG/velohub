import React from 'react';
import {connect} from 'react-redux';
import cartProductUpdate from '../store/actions/cartProductUpdate';
import cartProductDetach from '../store/actions/cartProductDetach';

const ShoppingCartProduct = (props) => {
    const sum = (Math.round(
        props.product.amount * props.product.price * 100,
    ) / 100).toFixed();

    const remove = () => {
        props.removeProduct(props.product);
    };

    const incrAmount = () => {
        props.product.amount++;
        props.updateProduct(props.product);
    };

    const decrAmount = () => {
        if (props.product.amount > 1) {
            props.product.amount--;
            props.updateProduct(props.product);
        }
    };

    return (
        <tr className="disabled">
            <td className="border-0 align-middle">
                <button className="btn btn-sm btn-bright btn-cart-remove"
                    onClick={remove}>&times;</button>
            </td>
            <th scope="row" className="border-0 text-left">
                <div className="p-2">
                    <img src={props.product.image}
                        alt="" width="70" className="img-fluid rounded shadow-sm"/>
                    <div className="ml-3 d-inline-block align-middle">
                        <h5 className="mb-0">
                            <a href={props.product.link}
                                className="text-dark d-inline-block align-middle">
                                {props.product.brand} {props.product.model}
                            </a>
                        </h5>
                        <span className="text-muted font-weight-normal font-italic d-block">
                            {props.product.title}
                        </span>
                    </div>
                </div>
            </th>
            <td className="border-0 align-middle">{props.product.price}</td>
            <td className="border-0 align-middle text-center">
                <div className="nowrap">
                    <a className="btn btn-sm btn-primary btn-cart-decrease"
                        onClick={decrAmount} href="#">-</a>&nbsp;
                    <span id="amount-{{ $product->id }}"
                        className="font-weight-bold">{props.product.amount}</span>&nbsp;
                    <a className="btn btn-sm btn-primary btn-cart-increase"
                        onClick={incrAmount} href="#">+</a>
                </div>
            </td>
            <td className="border-0 align-middle">{sum}</td>
        </tr>
    );
};

const mapActions = (dispatch) => ({
    updateProduct: (product) => dispatch(cartProductUpdate(product)),
    removeProduct: (product) => dispatch(cartProductDetach(product)),
});

export default connect(null, mapActions)(ShoppingCartProduct);
