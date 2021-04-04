import React from 'react';

const CheckoutInfo = (props) => {
    return (
        <div className="card shadow-sm">
            <div className="card-body">
                <div className="d-flex justify-content-between">
                    <div className="text-center">
                        Стоимость доставки
                    </div>
                    <div className="text-center">
                        {props.delivery.cost} {props.currency.sign}
                    </div>
                </div>
                <div className="d-flex mt-2 justify-content-between">
                    <div className="text-center fw-bold">
                        Всего к оплате
                    </div>
                    <div className="text-center fw-bold">
                        {props.delivery.total} {props.currency.sign}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CheckoutInfo;
