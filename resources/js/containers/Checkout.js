import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import axios from 'axios';
import config from 'react-global-configuration';
import {cartFetch} from '../api/cart';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import CheckoutBuyer from '../components/CheckoutBuyer';
import CheckoutAddr from '../components/CheckoutAddr';
import CheckoutOrder from '../components/CheckoutOrder';
import Loader from '../components/ui/Loader';
import Card from '../components/ui/Card';
import {fireDanger} from '../state/actions/toasts';

const localData = localStorage.getItem('_udata') ? JSON.parse(localStorage.getItem('_udata')) : {};
const computeTotal = (products) => products.reduce((total, el) => {
    return total + el.amount * el.price;
}, 0);
const mapShippingCost = (couriers, total) => couriers.map((el) => {
    const rate = total < el.free ? el.cost : 0;
    return {...el, rate, total: total + rate};
});

const Checkout = () => {
    const [step, setStep] = useState(2);
    const [userData, setUserData] = useState({...localData});
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();
    const pending = useSelector(({cart}) => cart.pending);
    const products = useSelector(({cart}) => cart.products);
    const totalCost = computeTotal(products);

    useEffect(() => {
        dispatch(cartFetch());
    }, []);

    const prevStep = () => setStep(step - 1);

    const nextStep = (formData) => {
        const newData = {...userData, ...formData};

        localStorage.setItem('_udata', JSON.stringify(newData));
        setUserData(newData);
        setStep(step + 1);
    };

    const finalStep = (formData) => {
        const finalData = {...userData, ...formData};

        console.log(finalData);

        // setLoading(true);
        //
        // axios.post('/api/orders', finalData)
        //     .then(({data}) => {
        //         if (!data.id) {
        //             throw new Error;
        //         }
        //         setUserData({...userData, ...data});
        //         setStep(step + 1);
        //     })
        //     .catch((error) => {
        //         dispatch(fireDanger('Возникла ошибка при сохранении заказа'));
        //         console.error(error);
        //     })
        //     .finally(() => {
        //         setLoading(false);
        //     });
    };

    if (step === 3) {
        return <CheckoutOrder userData={userData} />;
    }

    return (
        <div className="row">
            <div className="col-7 px-4">
                <h4><span>Заказ</span></h4>

                <Card classes={['shadow-sm', 'p-3']}>
                    {products.length
                        ? <CartTable totalCost={totalCost} currency={config.get('currency')}>
                            <CartProducts products={products} currency={config.get('currency')} />
                        </CartTable>
                        : <div className="text-center fst-italic">Загружается...</div>
                    }
                </Card>
            </div>

            <div className="col-5 px-4">
                {step === 1 &&
                    <CheckoutBuyer
                        userData={userData}
                        nextStep={nextStep} />
                }

                {step === 2 &&
                    <CheckoutAddr
                        userData={userData}
                        payments={config.get('payments')}
                        couriers={mapShippingCost(config.get('couriers'), totalCost)}
                        prevStep={prevStep}
                        nextStep={finalStep} />
                }
            </div>

            <Loader active={loading || pending}/>
        </div>
    );
};

export default Checkout;
