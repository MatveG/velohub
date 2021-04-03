import React from 'react';
import {useForm} from 'react-hook-form';
import Input from './ui/Input';

const CheckoutFirst = (props) => {
    const {register, errors, handleSubmit} = useForm();

    return (
        <form className="row" onSubmit={handleSubmit(props.nextStep)} noValidate>
            <h4><span>Ваши данные</span></h4>

            <div className="col-6 py-2">
                <Input
                    name="name"
                    label="Имя"
                    placeholder="Ваше имя"
                    defaultValue={props.userData.name}
                    register={register.bind(register, {
                        required: true,
                        minLength: 3,
                    })}
                    errors={errors} />
            </div>
            <div className="col-6 py-2">
                <Input
                    name="surname"
                    label="Фамилия"
                    placeholder="Ваша фамилия"
                    defaultValue={props.userData.surname} />
            </div>
            <div className="col-6 py-2">
                <Input
                    name="phone"
                    label="Телефон"
                    placeholder="Контактный номер"
                    register={register.bind(register, {
                        required: true,
                        minLength: 10,

                    })}
                    errors={errors}
                    defaultValue={props.userData.phone} />
            </div>
            <div className="col-6 py-2">
                <Input
                    name="email"
                    label="E-mail"
                    placeholder="Электронная почта"
                    register={register.bind(register, {
                        required: true,
                        pattern: {
                            value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                            message: 'invalid email address',
                        },
                    })}
                    errors={errors}
                    defaultValue={props.userData.email} />
            </div>
            <div className="col-12 text-end py-2">
                <button className="btn btn-bright border" type="submit">
                    Оплата и доставка ❯
                </button>
            </div>
        </form>
    );
};

export default CheckoutFirst;
