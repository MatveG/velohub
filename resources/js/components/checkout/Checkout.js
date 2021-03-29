import React, {useState} from 'react';
import Cart from '../cart/Cart';
import FistStep from './first/FirstStep';
import SecondStep from './second/SecondStep';

const Checkout = () => {
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
                        <Cart readOnly={true}/>
                    </div>
                </div>
            </div>
            <div className="col-5 px-4">
                <h4>
                    <span>{step === 1 ? 'Ваши данные' : 'Данные доставки'}</span>
                </h4>
                {step === 1 && <FistStep
                    data={data}
                    submitData={submitData}/>}

                {step === 2 && <SecondStep
                    data={data}
                    prevStep={prevStep}
                    submitData={submitData}/>}
            </div>
        </div>
    );
};

export default Checkout;
