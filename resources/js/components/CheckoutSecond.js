import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import CheckoutCouriers from './CheckoutCouriers';
import CheckoutInfo from './CheckoutInfo';
import CheckoutCityForm from './CheckoutCityFrom';
import CheckoutCourierForm from './CheckoutCourierForm';

const CheckoutSecond = (props) => {
    const [delivery, setDelivery] = useState(0);
    const [commentFlag, setCommentFlag] = useState(false);
    const {register, errors, handleSubmit} = useForm();

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    const handleCourierChange = ({target}) => {
        setDelivery(+target.value);
    };

    return (
        <form noValidate onSubmit={handleSubmit(props.nextStep)}>
            <h4><span>Доставка</span></h4>

            <CheckoutCouriers couriers={props.couriers}
                delivery={delivery}
                handleChange={handleCourierChange}
                register={register.bind(register, {required: true, min: 1})}
                isInvalid={errors.delivery} />

            <div className="mt-2">
                {!!delivery && <div className="my-2">
                    <CheckoutInfo courier={props.couriers[delivery-1]} currency={props.currency}/>
                </div>}
            </div>

            <div className="row">
                {delivery === 2 && <CheckoutCityForm
                    delivery={delivery}
                    errors={errors}
                    register={register} />}
                {delivery >= 3 && <CheckoutCourierForm
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
