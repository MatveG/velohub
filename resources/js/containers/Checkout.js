import axios from 'axios';
import React, {useState} from 'react';
import {useDispatch} from 'react-redux';
import config from 'react-global-configuration';
import CheckoutBuyer from '../components/CheckoutBuyer';
import CheckoutAddr from '../components/CheckoutAddr';
import CheckoutOrder from '../components/CheckoutOrder';
import Loader from '../components/ui/Loader';
import Card from '../components/ui/Card';
import useCart from '../hooks/useCart';
import CartComponent from '../components/CartComponent';
import {fireDanger} from '../state/actions/toast';

const localData = JSON.parse(localStorage.getItem('_udata') || '{}');

const mapShippingCost = (couriers, total) => couriers.map((el) => {
    const rate = total < el.free ? el.cost : 0;
    return {...el, rate, total: total + rate};
});

const Checkout = () => {
    const {isPending, products, totalCost} = useCart();
    const dispatch = useDispatch();
    const [stage, setStage] = useState(1);
    const [loading, setLoading] = useState(false);
    const [userData, setUserData] = useState({...localData});

    const prevStep = () => {
        setStage(stage - 1);
    };

    const nextStep = (formData) => {
        const newData = {...userData, ...formData};

        setUserData(newData);
        setStage(stage + 1);
        localStorage.setItem('_udata', JSON.stringify(newData));
    };

    const finalStep = (formData) => {
        const finalData = {...userData, ...formData};

        setLoading(true);
        axios.post('/api/order', finalData)
            .then(({data}) => {
                if (!data.id) {
                    throw new Error;
                }
                setUserData({...userData, ...data});
                setStage(stage + 1);
            })
            .catch((error) => {
                dispatch(fireDanger('Возникла ошибка при сохранении заказа'));
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    };

    if (stage === 3) {
        return <CheckoutOrder userData={userData} />;
    }

    return (
        <div className="row">
            <div className="col-7 px-4">
                <h4><span>Заказ</span></h4>

                <Card classes={['shadow-sm', 'p-3']}>
                    <CartComponent
                        currency={config.get('currency')}
                        items={products}
                        totalCost={totalCost} />
                </Card>
            </div>

            <div className="col-5 px-4">
                {stage === 1 &&
                    <CheckoutBuyer
                        userData={userData}
                        nextStep={nextStep} />
                }

                {stage === 2 &&
                    <CheckoutAddr
                        userData={userData}
                        payments={config.get('payments')}
                        couriers={mapShippingCost(config.get('couriers'), totalCost)}
                        prevStep={prevStep}
                        nextStep={finalStep} />
                }
            </div>

            <Loader active={loading || isPending}/>
        </div>
    );
};

export default Checkout;
