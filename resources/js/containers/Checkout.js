import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import axios from 'axios';
import config from 'react-global-configuration';
import {cartFetch} from '../api/cart';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import CheckoutFirst from '../components/CheckoutFirst';
import CheckoutSecond from '../components/CheckoutSecond';
import CheckoutFinal from '../components/CheckoutFinal';
import Loader from '../components/ui/Loader';
import Card from '../components/ui/Card';
import {fireDanger} from '../state/actions/toasts';

const computeTotal = (products) => products.reduce((total, el) => {
    return total + el.amount * el.price;
}, 0);

const mapShippingCost = (couriers, total) => couriers.map((el) => {
    const rate = total < el.free ? el.cost : 0;
    return {...el, rate, total: total + rate};
});

const Checkout = () => {
    const [step, setStep] = useState(1);
    const [userData, setUserData] = useState({
        'name': 'Serg',
        'surname': 'Matv',
        'phone': '1234567890',
        'email': 'mail@mail.foo',
        'address[street]': 'Zamkov',
        'address[house]': '104',
    });
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();
    const pending = useSelector((state) => state.cart.pending);
    const products = useSelector((state) => state.cart.products);
    const totalCost = computeTotal(products);
    const couriers = mapShippingCost(config.get('couriers'), totalCost);

    useEffect(() => {
        if (!pending) {
            dispatch(cartFetch());
        }
    }, []);

    const prevStep = () => setStep(step - 1);

    const nextStep = (formData) => {
        setUserData({...userData, ...formData});
        setStep(step + 1);
    };

    const finalStep = (formData) => {
        const finalData = {...userData, ...formData};

        setLoading(true);

        // call api function
        axios.post('/api/orders', finalData)
            .then(({data}) => {
                setUserData({...userData, ...data});
                setStep(step + 1);
            })
            .catch((error) => {
                fireDanger('Возникла ошибка при сохранении заказа');
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    };

    if (step === 3) {
        return <CheckoutFinal userData={userData} />;
    }

    return (
        <div className="row">
            <div className="col-7 px-4">
                <h4><span>Заказ</span></h4>

                <Card classes={['shadow-sm', 'p-3']}>
                    {!!products.length &&
                    <CartTable totalCost={totalCost} currency={config.get('currency')}>
                        <CartProducts products={products} currency={config.get('currency')} />
                    </CartTable>}
                </Card>
            </div>

            <div className="col-5 px-4">
                {step === 1 && <CheckoutFirst
                    userData={userData}
                    nextStep={nextStep} />}

                {step === 2 && <CheckoutSecond
                    payments={config.get('payments')}
                    couriers={couriers}
                    prevStep={prevStep}
                    nextStep={finalStep} />}
            </div>

            <Loader active={loading || pending}/>
        </div>
    );
};

export default Checkout;
