import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import CheckoutInfo from './CheckoutInfo';
import CheckoutFormCity from './CheckoutFormCity';
import CheckoutFormCourier from './CheckoutFormCourier';
import Select from './ui/Select';
import CheckoutComment from './CheckoutComment';

const CheckoutSecond = (props) => {
    const [payment, setPayment] = useState('');
    const [delivery, setDelivery] = useState('');
    const {register, errors, handleSubmit} = useForm();

    const handlePaymentSelect = ({target}) => setPayment(target.value);
    const handleDeliverySelect = ({target}) => setDelivery(target.value);

    return (
        <form noValidate onSubmit={handleSubmit(props.nextStep)}>
            <h4><span>Доставка</span></h4>

            <Select
                classes={['my-2']}
                name="payment"
                value={payment}
                options={props.payments}
                placeholder="[ Выбор способа оплаты ]"
                handleChange={handlePaymentSelect}
                register={register.bind(register, {required: true})}
                errors={errors} />

            <Select
                classes={['my-2']}
                name="delivery"
                value={delivery}
                options={props.couriers}
                placeholder="[ Выбор способа доставки ]"
                handleChange={handleDeliverySelect}
                register={register.bind(register, {required: true})}
                errors={errors} />

            {delivery && <CheckoutInfo
                classes={['my-2']}
                courier={props.couriers[+delivery]}
                currency={props.currency}/>}

            <div className="row">
                {+delivery === 2 && <CheckoutFormCity
                    delivery={delivery}
                    errors={errors}
                    register={register} />}

                {+delivery >= 3 && <CheckoutFormCourier
                    delivery={delivery}
                    errors={errors}
                    register={register} />}

                <CheckoutComment />
            </div>

            <div className="py-2 d-flex justify-content-between">
                <button className="btn btn-bright border" type="button" onClick={props.prevStep}>
                    ❮ Получатель
                </button>
                <button className="btn btn-bright border" type="submit">
                    Подтвердить
                </button>
            </div>
        </form>
    );
};

export default CheckoutSecond;
