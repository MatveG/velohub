import React from 'react';
import config from 'react-global-configuration';
import CardShadow from './ui/CardShadow';

const CheckoutInfo = (props) => {
    return (
        <CardShadow>
            <div className="d-flex justify-content-between">
                <div className="text-center">
                    Стоимость доставки
                </div>
                <div className="text-center">
                    {props.courier.rate ?
                        `${props.courier.rate} ${config.get('currency').sign}` :
                        'бесплатно'
                    }
                </div>
            </div>
            <div className="d-flex mt-2 justify-content-between">
                <div className="text-center fw-bold">
                    Всего к оплате
                </div>
                <div className="text-center fw-bold">
                    {props.courier.total} {config.get('currency').sign}
                </div>
            </div>
        </CardShadow>
    );
};

export default CheckoutInfo;
