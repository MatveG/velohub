import React from 'react';

const Variants = (props) => (
    <select className="form-control w-50 m-auto" onChange={props.selectOption}>
        <option>Выберите</option>

        {props.variants.map((el, idx) => (
            <option key={idx} value={idx}>
                {el.code}
            </option>
        ))}
    </select>
);

export default Variants;
