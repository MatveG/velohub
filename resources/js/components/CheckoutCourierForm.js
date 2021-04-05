import React from 'react';
import Input from './ui/Input';

const CheckoutForm = (props) => {
    return (
        <React.Fragment>
            <div className="col-8 py-2">
                <Input
                    name="address[city]"
                    label="Город"
                    placeholder="Город доставки"
                    register={props.delivery > 2 && props.register.bind(
                        props.register, {required: true},
                    )}
                    errors={props.errors} />
            </div>

            <div className="col-4 py-2">
                <Input
                    name="address[branch]"
                    label="Отделение"
                    placeholder="Номер отделения"
                    register={props.delivery > 2 && props.register.bind(
                        props.register, {required: true},
                    )}
                    errors={props.errors} />
            </div>
        </React.Fragment>
    );
};

export default CheckoutForm;
