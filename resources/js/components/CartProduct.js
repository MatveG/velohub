import React from 'react';

const CartProduct = (props) => {
    return (
        <tr style={{padding: '15rem'}}>
            <td className="align-middle">
                {props.removeProduct && <button className="btn btn-sm btn-bright btn-cart-remove"
                    onClick={() => props.removeProduct(props.product)}>&times;</button>}
            </td>

            <td className="text-left p-2">
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

            <td className="align-middle">
                {(+props.product.price).toLocaleString()}&nbsp;
                {props.currency.sign}
            </td>

            <td className="align-middle text-center">
                <div className="nowrap">
                    {props.updateAmount && <a className="btn btn-sm btn-primary btn-cart-decrease"
                        onClick={() => props.updateAmount(props.product, -1)} href="#">-</a>}
                    &nbsp;
                    <span id="amount-{{ $product->id }}"
                        className="font-weight-bold">{props.product.amount}</span>
                    &nbsp;
                    {props.updateAmount && <a className="btn btn-sm btn-primary btn-cart-increase"
                        onClick={() => props.updateAmount(props.product, 1)} href="#">+</a>}
                </div>
            </td>

            <td className="align-middle">
                {(props.product.amount * props.product.price).toLocaleString()}&nbsp;
                {props.currency.sign}
            </td>
        </tr>
    );
};

export default CartProduct;
