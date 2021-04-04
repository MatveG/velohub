import React, {useState} from 'react';
import {useSelector} from 'react-redux';
import CheckoutFirst from '../components/CheckoutFirst';
import CheckoutSecond from '../components/CheckoutSecond';
import CheckoutThird from '../components/CheckoutThird';
import Loader from '../components/ui/Loader';

const Checkout = (props) => {
    const [step, setStep] = useState(2);
    const [userData, setUserData] = useState({});
    const [loader, setLoader] = useState(false);
    const cartProducts = useSelector((state) => state.cart.products);
    const cartTotal = cartProducts.reduce((total, el) => total + el.amount * el.price, 0);
    const couriers = props.couriers.map((el) => {
        return {...el, total: cartTotal < el.free ? cartTotal + el.cost : cartTotal};
    });

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

        // axios.post('', userData)
        //     .then(() => {
        //         setStep(step + 1);
        //     })
        //     .catch((error) => {
        //         console.error(error);
        //     })
        //     .finally(() => {
        //         setLoader(false);
        //     });
    };

    return (
        <div>
            <Loader active={loader}/>

            {step === 1 && <CheckoutFirst userData={userData}
                nextStep={nextStep} />}

            {step === 2 && <CheckoutSecond userData={userData}
                couriers={couriers}
                cartTotal={cartTotal}
                currency={props.currency}
                prevStep={prevStep}
                nextStep={finalStep} />}

            {step === 3 && <CheckoutThird userData={userData}/>}
        </div>
    );
};

export default Checkout;
