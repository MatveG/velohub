import React from 'react';

const Input = (props) => {
    const id = `input-${Math.random() * 10 ** 16}`;
    const type = props.type || 'text';
    const error = props.errors && props.errors[props.name] || {};
    const classes = ['form-control'];

    error.type && classes.push('is-invalid');
    props.classes && classes.push(...props.classes);

    return (
        <React.Fragment>
            <label className="form-label" htmlFor={id}>{props.label}</label>

            <input className={classes.join(' ')}
                id={id}
                type={type}
                value={props.value}
                name={props.name}
                placeholder={props.placeholder}
                onChange={props.handleChange}
                ref={props.register && props.register()}
            />

            {error.type === 'required' && <div
                className="text-danger small text-end">Обязательное</div>}
        </React.Fragment>
    );
};

export default Input;
