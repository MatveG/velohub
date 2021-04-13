import React from 'react';

const Input = (props) => {
    const id = `input-${Math.random() * 10 ** 16}`;
    const type = props.type || 'text';
    const classes = ['form-control', ...props.classes || []];
    const error = props.error || {};
    const values = {
        ...(!!props.value && {value: props.value}),
        ...(!!props.defaultValue && {defaultValue: props.defaultValue}),
    };

    if (error.type) {
        classes.push('is-invalid');
    }

    return (
        <React.Fragment>
            {!!props.label && <label className="form-label" htmlFor={id}>{props.label}</label>}

            <input
                {...values}
                className={classes.join(' ')}
                id={id}
                type={type}
                name={props.name}
                placeholder={props.placeholder}
                onChange={props.handleChange}
                ref={props.register ? props.register() : null}
            />

            {error.type === 'required' && <div
                className="text-danger small text-end">Обязательное</div>}
        </React.Fragment>
    );
};

export default Input;
