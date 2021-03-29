import React from 'react';
import {connect} from 'react-redux';
import cartProductUpdate from '../../../store/actions/cartProductUpdate';
import cartProductDetach from '../../../store/actions/cartProductDetach';

function formatAsPrice(number) {
    return new Intl.NumberFormat('ua-UA').format(number);
};

const Product = (props) => {
    const productPrice = formatAsPrice(props.product.price);
    const productSum = formatAsPrice(props.product.amount * props.product.price);

    const updateAmount = (mod) => {
        if (props.product.amount + mod > 0) {
            props.updateProduct(props.product.amount + mod);
        }
    };

    const removeProduct = () => {
        props.removeProduct(props.product);
    };

    return (
        <tr className="disabled">
            <td className="border-0 align-middle">
                {!props.readOnly && <button className="btn btn-sm btn-bright btn-cart-remove"
                    onClick={removeProduct}>&times;</button>}
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
            <td className="border-0 align-middle">
                {productPrice}
            </td>
            <td className="border-0 align-middle text-center">
                <div className="nowrap">
                    {!props.readOnly && <a className="btn btn-sm btn-primary btn-cart-decrease"
                        onClick={() => updateAmount(-1)} href="#">-</a>}
                    &nbsp;
                    <span id="amount-{{ $product->id }}"
                        className="font-weight-bold">{props.product.amount}</span>
                    &nbsp;
                    {!props.readOnly && <a className="btn btn-sm btn-primary btn-cart-increase"
                        onClick={() => updateAmount(1)} href="#">+</a>}
                </div>
            </td>
            <td className="border-0 align-middle">{productSum}</td>
        </tr>
    );
};

const mapActions = (dispatch) => ({
    updateProduct: (product) => dispatch(cartProductUpdate(product)),
    removeProduct: (product) => dispatch(cartProductDetach(product)),
});

export default connect(null, mapActions)(Product);
