import React from 'react';

const CheckoutThird = (props) => {
    return (
        <div>
            <button onClick={() => setActive(true)}>click</button>

            <h4><span>Заказ оформлен</span></h4>
            <div className="text-center">Спасибо</div>
        </div>
    );
};

export default CheckoutThird;
