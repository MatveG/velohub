import React from 'react';

const CheckoutCouriers = (props) => {
    return (
        <div>
            <select className={'form-select ' + (props.isInvalid && 'is-invalid')}
                name="delivery"
                value={props.delivery}
                onChange={props.handleChange}
                ref={props.register ? props.register() : null}>

                <option value={0}>---Выберите---</option>
                {props.couriers.map((el, idx) => (
                    <option key={idx} value={idx+1}>{el.title}</option>
                ))}
            </select>
        </div>
    );
};

export default CheckoutCouriers;
