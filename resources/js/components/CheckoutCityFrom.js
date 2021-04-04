import React from 'react';
import Input from './ui/Input';

const CheckoutCityForm = (props) => {
    return (
        <React.Fragment>
            <div className="col-8 py-2">
                <Input
                    name="addressStreet"
                    label="Улица"
                    placeholder="Адрес доставки"
                    register={props.register.bind(props.register, {required: true})}
                    errors={props.errors} />
            </div>

            <div className="col-4 py-2">
                <Input
                    name="addressHouse"
                    label="Дом"
                    placeholder="Номер"
                    register={props.delivery === 2 && props.register.bind(
                        props.register, {required: true},
                    )}
                    errors={props.errors} />
            </div>
        </React.Fragment>
    );
};

export default CheckoutCityForm;
