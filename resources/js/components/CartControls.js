import React from 'react';

const CartControls = (props) => {
    return (
        <React.Fragment>
            <button className="btn btn-gray border" type="button" onClick={props.hideCart}>
                Продолжить покупки
            </button>

            <a href={props.checkoutRoute} className="btn btn-bright border" role="button">
                Оформить заказ
            </a>
        </React.Fragment>
    );
};

export default CartControls;
