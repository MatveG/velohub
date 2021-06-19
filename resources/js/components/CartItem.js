import React from 'react';

const CartItem = (props) => {
    return (
        <tr>
            <td className="align-middle">
                {props.removeProduct && <button className="btn btn-sm btn-gray btn-cart-remove"
                    onClick={() => props.removeProduct(props.item)}>&times;</button>}
            </td>

            <td className="text-left p-2">
                <img src={props.item.product.image}
                    alt="" width="70" className="img-fluid rounded shadow-sm"/>
            </td>

            <td className="text-left p-2">
                <div className="ml-3 d-inline-block align-middle">
                    <h5 className="mb-0">
                        <a href={props.item.product.link}
                            className="text-dark d-inline-block align-middle">
                            {props.item.product.brand} {props.item.product.model}
                        </a>
                    </h5>
                    <span className="text-muted font-weight-normal font-italic d-block">
                        {props.item.product.title}
                    </span>
                </div>
            </td>

            <td className="align-middle">
                {(+props.item[props.item.variant ? 'variant' : 'product'].price).toLocaleString()}
                &nbsp;
                {props.currency.sign}
            </td>

            <td className="align-middle text-center">
                <div className="nowrap">
                    {props.updateAmount && <a className="btn btn-sm btn-bright btn-cart-decrease"
                        onClick={() => props.updateAmount(props.item, -1)} href="#">-</a>}
                    &nbsp;
                    <span id="amount-{{ $item->id }}"
                        className="font-weight-bold">{props.item.amount}</span>
                    &nbsp;
                    {props.updateAmount && <a className="btn btn-sm btn-bright btn-cart-increase"
                        onClick={() => props.updateAmount(props.item, 1)} href="#">+</a>}
                </div>
            </td>

            <td className="align-middle">
                {(props.item.amount *
                    props.item[props.item.variant ? 'variant' : 'product'].price).toLocaleString()}
                &nbsp;
                {props.currency.sign}
            </td>
        </tr>
    );
};

export default CartItem;
