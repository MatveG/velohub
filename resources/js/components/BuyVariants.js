import React from 'react';

const BuyVariants = (props) => {
    const options = props.variants.map((el, idx) => (
        <option key={idx} value={idx}>
            {el.code}
        </option>
    ));

    if (!props.variants.length) {
        return null;
    }

    return (
        <select className={`form-control w-50 m-auto ${props.isInvalid && 'is-invalid bg-warning'}`}
            onChange={props.handleSelect}>
            <option>Выберите</option>
            {options}
        </select>
    );
};

export default BuyVariants;

