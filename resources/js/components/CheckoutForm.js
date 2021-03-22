import React, {useState} from 'react';

const CheckoutForm = () => {
    const [data, setData] = useState({});

    return (
        <div className="row">
            <div className="col-6">
                <div className="mb-3">
                    <label className="form-label">Имя</label>
                    <input type="email" className="form-control" placeholder="" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Фамилия</label>
                    <input type="email" className="form-control" placeholder="" />
                </div>
            </div>
            <div className="col-6">
                <div className="mb-3">
                    <label className="form-label">Имя</label>
                    <input type="email" className="form-control" placeholder="" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Фамилия</label>
                    <input type="email" className="form-control" placeholder="" />
                </div>
            </div>
            <div className="col-12">
                <a href="{{ route('checkout') }}" className="btn btn-bright border"
                    role="button">Данные покупателя ❯</a>
            </div>
        </div>
    );
};

export default CheckoutForm;
