import React from 'react';
import {formatAsPrice} from '../utils/formatAs';

const CartProduct = (props) => {
    const productPrice = formatAsPrice(props.product.price);
    const productSum = formatAsPrice(props.product.amount * props.product.price);

    const removeProduct = () => {
        props.removeProduct(props.product);
    };

    const incrementAmount = () => {
        props.updateAmount(props.product, 1);
    };

    const decrementAmount = () => {
        props.updateAmount(props.product, -1);
    };

    return (
        <tr>
            <td className="border-0 align-middle">
                {!props.readOnly && <button className="btn btn-sm btn-bright btn-cart-remove"
                    onClick={removeProduct}>&times;</button>}
            </td>

            <td className="border-0 text-left p-2">
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
            </td>

            <td className="border-0 align-middle">
                {productPrice}
            </td>

            <td className="border-0 align-middle text-center">
                <div className="nowrap">
                    {!props.readOnly && <a className="btn btn-sm btn-primary btn-cart-decrease"
                        onClick={decrementAmount} href="#">-</a>}
                    &nbsp;
                    <span id="amount-{{ $product->id }}"
                        className="font-weight-bold">{props.product.amount}</span>
                    &nbsp;
                    {!props.readOnly && <a className="btn btn-sm btn-primary btn-cart-increase"
                        onClick={incrementAmount} href="#">+</a>}
                </div>
            </td>

            <td className="border-0 align-middle">{productSum}</td>
        </tr>
    );
};

export default CartProduct;
