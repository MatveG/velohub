import React, {useState} from 'react';
import ShoppingCart from './ShoppingCart';
import CheckoutFirst from './CheckoutFirst';
import CheckoutSecond from './CheckoutSecond';

const CheckoutForm = () => {
    const [step, setStep] = useState(1);
    let data = {foo: 'bar'};

    const prevStep = () => {
        setStep(step - 1);
    };

    const nextStep = () => {
        if (step < 2) {
            return setStep(step + 1);
        }
    };

    const submitData = (formData) => {
        data = {...data, ...formData};
        nextStep();
    };

    return (
        <div className="row">
            <div className="col-7 px-4">
                <div className="card shadow-sm p-2">
                    <div className="card-body">
                        <ShoppingCart readOnly={true}/>
                    </div>
                </div>
            </div>
            <div className="col-5 px-4">
                <h4>
                    <span>{step === 1 ? 'Ваши данные' : 'Данные доставки'}</span>
                </h4>
                {step === 1 && <CheckoutFirst
                    data={data}
                    submitData={submitData}/>}

                {step === 2 && <CheckoutSecond
                    data={data}
                    prevStep={prevStep}
                    submitData={submitData}/>}
            </div>
        </div>
    );
};

export default CheckoutForm;
