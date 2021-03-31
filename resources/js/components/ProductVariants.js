import React from 'react';

const ProductVariants = (props) => {
    const variantsOptions = props.variants.map((el, idx) => (
        <option key={idx} value={idx}>
            {el.code}
        </option>
    ));

    return (
        <select className="form-control w-50 m-auto" onChange={props.handleSelect}>
            <option>Выберите</option>
            {variantsOptions}
        </select>
    );
};

export default ProductVariants;
