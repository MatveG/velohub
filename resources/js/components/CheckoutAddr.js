import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import CheckoutInfo from './CheckoutInfo';
import CheckoutAddrCity from './CheckoutAddrCity';
import CheckoutAddrCourier from './CheckoutAddrCourier';
import CheckoutSelect from './CheckoutSelect';
import CheckoutComment from './CheckoutComment';

const CheckoutAddr = (props) => {
    const [payment, setPayment] = useState();
    const [delivery, setDelivery] = useState();
    const {register, errors, handleSubmit} = useForm();

    const handlePaymentSelect = ({target}) => setPayment(target.value);
    const handleDeliverySelect = ({target}) => setDelivery(target.value);

    return (
        <form noValidate onSubmit={handleSubmit(props.nextStep)}>
            <h4><span>Доставка</span></h4>

            <CheckoutSelect
                classes={['my-2']}
                name="payment"
                value={payment}
                options={props.payments}
                placeholder="[ Выбор способа оплаты ]"
                handleChange={handlePaymentSelect}
                register={register.bind(register, {required: true})}
                errors={errors} />

            <CheckoutSelect
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
                courier={props.couriers.find((el) => el.id === +delivery)}
                currency={props.currency}/>}

            <div className="row">
                {delivery === '1' && <input
                    type="hidden"
                    name="address[pickup]"
                    value="shop"
                    ref={register()} />}

                {delivery === '2' && <CheckoutAddrCity
                    delivery={delivery}
                    errors={errors}
                    register={register} />}

                {(delivery === '3' || delivery === '4') && <CheckoutAddrCourier
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

export default CheckoutAddr;
