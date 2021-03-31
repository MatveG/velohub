import React, {useState} from 'react';
import Cart from './Cart';
import CheckoutFirst from '../components/CheckoutFirst';
import CheckoutSecond from '../components/CheckoutSecond';

const Checkout = () => {
    const [step, setStep] = useState(2);
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
                        <Cart readOnly={true}/>
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

export default Checkout;
