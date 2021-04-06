import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import CheckoutInfo from './CheckoutInfo';
import CheckoutFormCity from './CheckoutFormCity';
import CheckoutFormCourier from './CheckoutFormCourier';
import Select from './ui/Select';

const CheckoutSecond = (props) => {
    const [payment, setPayment] = useState('');
    const [delivery, setDelivery] = useState('');
    const [commentFlag, setCommentFlag] = useState(false);
    const {register, errors, handleSubmit} = useForm();

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    const handlePaymentChange = ({target}) => {
        setPayment(target.value);
    };

    const handleCourierChange = ({target}) => {
        setDelivery(target.value);
    };

    return (
        <form noValidate onSubmit={handleSubmit(props.nextStep)}>
            <h4><span>Доставка</span></h4>

            <div className="my-2">
                <Select
                    name="payment"
                    value={payment}
                    options={props.payments}
                    placeholder="[ Выберите способ оплаты ]"
                    handleChange={handlePaymentChange}
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>

            <div className="my-2">
                <Select
                    name="delivery"
                    value={delivery}
                    options={props.couriers}
                    placeholder="[ Выберите способ доставки ]"
                    handleChange={handleCourierChange}
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>

            {delivery && <div className="my-2">
                <CheckoutInfo
                    courier={props.couriers[+delivery]}
                    currency={props.currency}/>
            </div>}

            <div className="row">
                {+delivery === 2 && <CheckoutFormCity
                    delivery={delivery}
                    errors={errors}
                    register={register} />}

                {+delivery >= 3 && <CheckoutFormCourier
                    delivery={delivery}
                    errors={errors}
                    register={register} />}

                <div className="col-12 py-2">
                    <a className="pointer-event" role="button" onClick={toggleComment}>
                        Добавить комментарий
                    </a>
                    { commentFlag && <div className="my-2">
                        <textarea name="text" className="form-control" rows="3" />
                    </div> }
                </div>
            </div>

            <div className="py-2 d-flex justify-content-between">
                <button className="btn btn-bright border"
                    type="button" onClick={props.prevStep}>❮ Получатель</button>
                <button className="btn btn-bright border" type="submit">Подтвердить</button>
            </div>
        </form>
    );
};

export default CheckoutSecond;
