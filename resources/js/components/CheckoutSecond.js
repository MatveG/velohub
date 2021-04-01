import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import Input from './ui/Input';

const CheckoutSecond = (props) => {
    const [commentFlag, setCommentFlag] = useState(false);
    const [addressFlag, setAddressFlag] = useState(null);
    const {register, errors, handleSubmit} = useForm();

    const handleSelect = ({target}) => {
        setAddressFlag(+target.value);
    };

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    const cityGroup = (
        <React.Fragment>
            <div className="col-8 py-2">
                <Input
                    name="adrStreet"
                    label="Улица"
                    placeholder="Адрес доставки"
                    register={register.bind(register, {required: true})}
                    error={errors.city} />
            </div>
            <div className="col-2 py-2">
                <Input
                    name="adrHouse"
                    label="Дом"
                    register={register.bind(register, {required: true})}
                    error={errors.city} />
            </div>
            <div className="col-2 py-2">
                <Input name="adrEntrance" label="Подъезд" />
            </div>
        </React.Fragment>
    );

    const carrierGroup = (
        <React.Fragment>
            <div className="col-6 py-2">
                <Input name="city" label="Город" placeholder="Город доставки"/>
            </div>
            <div className="col-6 py-2">
                <Input name="address"
                    label="Номер отделения"
                    placeholder="Номер отделения перевозчика" />
            </div>
        </React.Fragment>
    );

    return (
        <form className="row" onSubmit={handleSubmit(props.submitData)} noValidate>
            <div className="col-12 py-2">
                <label className="form-label">Способ доставки</label>
                <select className={'form-select ' + (errors.shipping && 'is-invalid')}
                    name="shipping"
                    onChange={handleSelect}>
                    {/* ref={register({required: 'foo'})}>*/}
                    <option value={null}>---Выберите---</option>
                    <option value="1">Курьером по Киеву и области</option>
                    <option value="2">Новой Почтой</option>
                    <option value="3">Деливери</option>
                </select>
            </div>

            {addressFlag === 1 && cityGroup }
            {addressFlag >= 2 && addressFlag <= 3 && carrierGroup }

            <div className="col-12 py-2">
                <a className="pointer-event" role="button" onClick={toggleComment}>
                    Добавить комментарий
                </a>
                { commentFlag && <div className="my-2">
                    <textarea className="form-control" rows="3" />
                </div> }
            </div>

            <div className="col-12 py-2 d-flex justify-content-between">
                <button className="btn btn-bright border"
                    type="button" onClick={props.prevStep}>❮ Ваши данные</button>
                <button className="btn btn-bright border" type="submit">Подтвердить</button>
            </div>
        </form>
    );
};

export default CheckoutSecond;
