import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import Input from './ui/Input';

const CheckoutSecond = (props) => {
    const [shipping, setShipping] = useState(1);
    const [commentFlag, setCommentFlag] = useState(false);
    const {register, errors, handleSubmit} = useForm();

    const handleSelect = ({target}) => {
        setShipping(+target.value);
    };

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    return (
        <form className="row" noValidate onSubmit={handleSubmit(props.finalStep)}>
            <h4><span>Данные доставки</span></h4>

            <div className="col-12 py-2">
                <label className="form-label">Способ доставки</label>
                <select className={'form-select ' + (errors.shipping && 'is-invalid')}
                    name="shipping"
                    value={shipping}
                    onChange={handleSelect}
                    ref={register({
                        required: true,
                        min: 1,
                    })}>

                    <option value={0}>---Выберите---</option>
                    <option value={1}>Курьером по Киеву и области</option>
                    <option value={2}>Новой Почтой</option>
                    <option value={3}>Деливери</option>
                </select>
            </div>

            <div className={shipping === 1 ? 'row p-0 m-0' : 'd-none'}>
                <div className="col-8 py-2">
                    <Input
                        name="addressStreet"
                        label="Улица"
                        placeholder="Адрес доставки"
                        register={shipping === 1 && register.bind(register, {required: true})}
                        errors={errors} />
                </div>

                <div className="col-4 py-2">
                    <Input
                        name="addressHouse"
                        label="Дом"
                        placeholder="Номер"
                        register={shipping === 1 && register.bind(register, {required: true})}
                        errors={errors} />
                </div>
            </div>

            <div className={shipping >= 2 ? 'row' : 'd-none'}>
                <div className="col-8 py-2">
                    <Input
                        name="addressCity"
                        label="Город"
                        placeholder="Город доставки"
                        register={shipping => 2 && register.bind(register, {required: true})}
                        errors={errors} />
                </div>

                <div className="col-4 py-2">
                    <Input
                        name="addressBranch"
                        label="Отделение"
                        placeholder="Номер отделения"
                        register={shipping => 2 && register.bind(register, {required: true})}
                        errors={errors} />
                </div>
            </div>

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
