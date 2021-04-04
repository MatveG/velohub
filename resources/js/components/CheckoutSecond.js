import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import CheckoutCouriers from './CheckoutCouriers';
import CheckoutInfo from './CheckoutInfo';
import CheckoutCityForm from './CheckoutCityFrom';
import CheckoutCourierForm from './CheckoutCourierForm';

const CheckoutSecond = (props) => {
    const [delivery, setDelivery] = useState(1);
    const {register, errors, handleSubmit} = useForm();

    const handleCourierChange = ({target}) => {
        setDelivery(+target.value);
    };

    return (
        <form noValidate onSubmit={handleSubmit(props.nextStep)}>
            <h4><span>Данные доставки</span></h4>

            <label className="form-label">Способ доставки</label>

            <CheckoutCouriers couriers={props.couriers}
                delivery={delivery}
                handleChange={handleCourierChange}
                register={register.bind(register, {required: true, min: 1})}
                isInvalid={errors.delivery} />

            <div className="mt-2">
                {!!delivery && <CheckoutInfo delivery={props.couriers[delivery]}
                    currency={props.currency}/>}
            </div>

            <div className="row">
                {delivery === 1 ?
                    <CheckoutCityForm delivery={delivery} errors={errors} register={register} /> :
                    <CheckoutCourierForm delivery={delivery} errors={errors} register={register} />
                }
            </div>

            <div className="py-2 d-flex justify-content-between">
                <button className="btn btn-bright border"
                    type="button" onClick={props.prevStep}>❮ Ваши данные</button>
                <button className="btn btn-bright border" type="submit">Подтвердить</button>
            </div>
        </form>
    );
};

export default CheckoutSecond;
