import React from 'react';

const VariantSelect = (props) => {
    return (
        <select className={`form-control w-50 m-auto ${props.isInvalid && 'is-invalid bg-warning'}`}
            onChange={props.handleSelect}>
            <option>Выберите</option>

            {props.variants.map((el, idx) => (
                <option key={idx} value={idx}>
                    {el.code}
                </option>
            ))}
        </select>
    );
};

export default VariantSelect;
