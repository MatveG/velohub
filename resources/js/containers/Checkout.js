import React, {useState} from 'react';
import Cart from './Cart';
import CheckoutFirst from '../components/CheckoutFirst';
import CheckoutSecond from '../components/CheckoutSecond';
import CheckoutThird from '../components/CheckoutThird';
import Loader from '../components/ui/Loader';
import axios from 'axios';

const componentByStep = {
    1: CheckoutFirst,
    2: CheckoutSecond,
    3: CheckoutThird,
};

const Checkout = () => {
    const [step, setStep] = useState(2);
    const [userData, setUserData] = useState({});
    const [loader, setLoader] = useState(false);

    const prevStep = () => {
        setStep(step - 1);
    };

    const nextStep = (formData) => {
        setUserData({...userData, ...formData});
        setStep(step + 1);
    };

    const finalStep = (formData) => {
        setLoader(true);
        setUserData({...userData, ...formData});

        axios.post('', userData)
            .then(() => {
                setStep(step + 1);
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                setLoader(false);
            });
    };

    const Component = componentByStep[step];

    return (
        <div className="row">
            <Loader active={loader}/>
            <div className="col-7 px-4">
                <div className="card shadow-sm p-2">
                    <div className="card-body">
                        <Cart readOnly={true}/>
                    </div>
                </div>
            </div>
            <div className="col-5 px-4">
                {<Component
                    userData={userData}
                    prevStep={prevStep}
                    nextStep={nextStep}
                    finalStep={finalStep}/>}
            </div>
        </div>
    );
};

export default Checkout;
