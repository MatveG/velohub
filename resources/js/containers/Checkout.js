import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import axios from 'axios';
import {cartFetch} from '../api/cart';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import CheckoutFirst from '../components/CheckoutFirst';
import CheckoutSecond from '../components/CheckoutSecond';
import CheckoutThird from '../components/CheckoutThird';
import Loader from '../components/ui/Loader';
import CardShadow from '../components/ui/CardShadow';
import {fireDanger} from '../state/actions/toasts';

const initialData = {payment: '1'};
const computeTotal = (products) => products.reduce((total, el) => {
    return total + el.amount * el.price;
}, 0);
const mapShippingCost = (couriers, total) => couriers.map((el) => {
    const rate = total < el.free ? el.cost : 0;
    return {...el, rate, total: total + rate};
});

const Checkout = (props) => {
    const [step, setStep] = useState(2);
    const [userData, setUserData] = useState({...initialData});
    const [loader, setLoader] = useState(false);
    const dispatch = useDispatch();
    const pending = useSelector((state) => state.cart.pending);
    const products = useSelector((state) => state.cart.products);
    const totalCost = computeTotal(products);
    const couriers = mapShippingCost(props.couriers, totalCost);

    useEffect(() => {
        if (!pending) {
            dispatch(cartFetch());
        }
    }, []);

    const prevStep = () => {
        setStep(step - 1);
    };

    const nextStep = (formData) => {
        setUserData({...userData, ...formData});
        setStep(step + 1);
    };

    const finalStep = (formData) => {
        const finalData = {...userData, ...formData};

        setLoader(true);

        axios.post('/api/orders', finalData)
            .then(() => {
                // setStep(step + 1);
            })
            .catch((error) => {
                fireDanger(error);
                console.error(error);
            })
            .finally(() => {
                setLoader(false);
            });
    };

    return (
        <div className="row">
            <Loader active={loader}/>

            <div className="col-7 px-4">
                <h4><span>Заказ</span></h4>

                <CardShadow>
                    <div className="p-3">
                        <CartTable totalCost={totalCost}>
                            <CartProducts products={products} />
                        </CartTable>
                    </div>
                </CardShadow>
            </div>

            <div className="col-5 px-4">
                {step === 1 && <CheckoutFirst
                    userData={userData}
                    nextStep={nextStep} />}

                {step === 2 && <CheckoutSecond
                    couriers={couriers}
                    prevStep={prevStep}
                    nextStep={finalStep} />}

                {step === 3 && <CheckoutThird userData={userData}/>}
            </div>
        </div>
    );
};

export default Checkout;
