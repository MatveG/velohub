import React from 'react';
import Card from './ui/Card';

const CheckoutFinal = () => {
    return (
        <div className="w-50 m-auto text-center">
            <Card classes={['shadow']}>
                <div className="alert alert-success text-center" role="alert">
                    Спасибо! Заказ # <span className="fw-bold">1636</span> принят.
                </div>
                <div className="my-3">
                    Мы свяжемся с Вами для подтверждения в рабочее время.
                </div>
                <a href="/" className="btn btn-gray">На главную</a>
            </Card>
        </div>
    );
};

export default CheckoutFinal;
