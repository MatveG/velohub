import React from 'react';

const BuyVariants = (props) => {
    return (
        <select
            nmae="variant"
            value={props.value}
            className={`form-control w-50 m-auto ${props.isInvalid && 'is-invalid bg-warning'}`}
            onChange={props.handleSelect}>
            <option>
                Выберите
            </option>

            {props.variants.map((el, idx) => (
                <option key={idx} value={idx}>
                    {!!el.parameters.size && el.parameters.size + ' '}
                    {!!el.parameters.color && el.parameters.color + ' '}
                </option>
            ))}
        </select>
    );
};

export default BuyVariants;

