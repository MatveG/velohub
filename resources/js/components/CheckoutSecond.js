import React, {useState, useRef} from 'react';
import {useForm} from 'react-hook-form';
import Input from './ui/Input';

const CheckoutSecond = (props) => {
    const [shipping, setShipping] = useState('');
    const [commentFlag, setCommentFlag] = useState(false);
    const formRef = useRef();
    const {register, errors, handleSubmit} = useForm();

    const handleSelect = ({target}) => {
        setShipping(+target.value);
        formRef.current.reset();
    };

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    const cityShipping = (
        <React.Fragment>
            <div className="col-7 py-2">
                <Input
                    name="addressStreet"
                    label="Улица"
                    placeholder="Адрес доставки"
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>
            <div className="col-3 py-2">
                <Input
                    name="addressHouse"
                    label="Дом"
                    placeholder="Номер"
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>
            <div className="col-2 py-2">
                <Input name="addressEntrance" label="Подъезд" />
            </div>
        </React.Fragment>
    );

    const carrierShipping = (
        <React.Fragment>
            <div className="col-8 py-2">
                <Input
                    name="addressCity"
                    label="Город"
                    placeholder="Город доставки"
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>
            <div className="col-4 py-2">
                <Input
                    name="addressBranch"
                    label="Отделение"
                    placeholder="Номер отделения"
                    register={register.bind(register, {required: true})}
                    errors={errors} />
            </div>
        </React.Fragment>
    );

    return (
        <form className="row"
            onSubmit={handleSubmit(props.submitCheckout)}
            ref={formRef}
            noValidate>
            <h4><span>Данные доставки</span></h4>

            <div className="col-12 py-2">
                <label className="form-label">Способ доставки</label>
                <select className={'form-select ' + (errors.shipping && 'is-invalid')}
                    name="shipping"
                    value={shipping}
                    onChange={handleSelect}
                    ref={register({required: true})}>

                    <option value="">---Выберите---</option>
                    <option value="1">Курьером по Киеву и области</option>
                    <option value="2">Новой Почтой</option>
                    <option value="3">Деливери</option>
                </select>
            </div>

            {!!shipping && (shipping === '1' ? cityShipping : carrierShipping)}

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
