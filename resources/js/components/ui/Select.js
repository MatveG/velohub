import React from 'react';

const Select = (props) => {
    const id = `input-${Math.random() * 10 ** 16}`;
    const classes = ['form-control', ...props.classes || []];
    let error = {};

    if (props.errors && props.errors[props.name]) {
        error = props.errors[props.name];

        if (error.type) {
            classes.push('is-invalid');
        }
    }

    return (
        <React.Fragment>
            <select className={classes.join(' ')}
                id={id}
                name={props.name}
                value={props.value}
                onChange={props.handleChange}
                ref={props.register ? props.register() : null}>

                <option value="">{props.placeholder}</option>

                {props.options.map((el, idx) => (
                    <option key={idx} value={idx}>
                        {typeof el === 'object' ? el[props.property] : el}
                    </option>
                ))}
            </select>

            {error.type === 'required' && <div
                className="text-danger small text-end">Обязательное</div>}
        </React.Fragment>
    );
};

export default Select;
