import React from 'react';

const Input = (props) => {
    const id = `input-${Math.random() * 10 ** 16}`;
    const type = props.type || 'text';
    const classes = ['form-control', ...props.classes || []];
    const values = {};
    let error = {};

    props.value ? values.value = props.value : null;
    props.defaultValue ? values.defaultValue = props.defaultValue : null;
    // if (props.defaultValue) {
    //     foo.defaultValue = props.defaultValue;
    // }

    if (props.errors && props.errors[props.name]) {
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

    return (
        <React.Fragment>
            {!!props.label && <label className="form-label" htmlFor={id}>{props.label}</label>}

            <input
                className={classes.join(' ')}
                id={id}
                type={type}
                name={props.name}
                placeholder={props.placeholder}
                {...values}
                onChange={props.handleChange}
                ref={props.register ? props.register() : null}
            />

            {error.type === 'required' && <div
                className="text-danger small text-end">Обязательное</div>}
        </React.Fragment>
    );
};

export default Input;
