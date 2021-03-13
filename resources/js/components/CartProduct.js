import React from "react";
import {connect} from 'react-redux'
import cartProductUpdate from '../store/actions/cartProductUpdate';
import cartProductRemove from '../store/actions/cartProductRemove';

const CartProduct = (props) => {
    const incrAmount = (product) => {
        product.amount++;
        props.updateProduct(product);
    };

    const decrAmount = (product) => {
        if (product.amount > 1) {
            product.amount--;
        }
        props.updateProduct(product);
    };

    const remove = (product) => {
        props.removeProduct(product);
    };

    return (
        <tr>
            <td className="border-0 align-middle">
                <button className="btn btn-sm btn-gray btn-cart-remove"
                        onClick={() => remove(props.product)}>&times;</button>
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
                    <a className="btn btn-sm btn-gray btn-cart-decrease"
                       onClick={() => decrAmount(props.product)} href="#">-</a>&nbsp;
                    <span id="amount-{{ $product->id }}"
                          className="font-weight-bold">{props.product.amount}</span>&nbsp;
                    <a className="btn btn-sm btn-gray btn-cart-increase"
                       onClick={() => incrAmount(props.product)} href="#">+</a>
                </div>
            </td>
            <td className="border-0 align-middle">{props.product.amount * props.product.price}</td>
        </tr>
    );
}

const mapActions = (dispatch) => {
    return {
        updateProduct: (product) => dispatch(cartProductUpdate(product)),
        removeProduct: (product) => dispatch(cartProductRemove(product)),
    };
};

export default connect(null, mapActions)(CartProduct);
