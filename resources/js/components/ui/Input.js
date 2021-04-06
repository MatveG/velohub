import React from 'react';

const Input = (props) => {
    const id = `input-${Math.random() * 10 ** 16}`;
    const type = props.type || 'text';
    const classes = ['form-control'];
    let error = {};

    if (Object.keys(props.errors).length) {
        const match = props.name.match(/\[(.*?)\]/);

        if (match) {
            const parent = props.name.substr(0, match.index);
            const child = match[1];
            error = props.errors[parent][child] || {};
        } else {
            error = props.errors[props.name] || {};
        }

        if (error.type) {
            classes.push('is-invalid');
        }
    }

    if (props.classes) {
        classes.push(...props.classes);
    }

    return (
        <React.Fragment>
            {!!props.label && <label className="form-label" htmlFor={id}>{props.label}</label>}

            <input className={classes.join(' ')}
                id={id}
                type={type}
                name={props.name}
                value={props.value}
                defaultValue={props.defaultValue}
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
