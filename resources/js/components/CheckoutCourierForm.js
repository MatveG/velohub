import React, {useState} from 'react';
import Input from './ui/Input';

const CheckoutForm = (props) => {
    const [commentFlag, setCommentFlag] = useState(false);

    const toggleComment = () => {
        setCommentFlag(!commentFlag);
    };

    return (
        <React.Fragment>
            <div className="col-8 py-2">
                <Input
                    name="addressCity"
                    label="Город"
                    placeholder="Город доставки"
                    register={props.delivery > 2 && props.register.bind(
                        props.register, {required: true},
                    )}
                    errors={props.errors} />
            </div>

            <div className="col-4 py-2">
                <Input
                    name="addressBranch"
                    label="Отделение"
                    placeholder="Номер отделения"
                    register={props.delivery > 2 && props.register.bind(
                        props.register, {required: true},
                    )}
                    errors={props.errors} />
            </div>

            <div className="col-12 py-2">
                <a className="pointer-event" role="button" onClick={toggleComment}>
                    Добавить комментарий
                </a>
                { commentFlag && <div className="my-2">
                    <textarea className="form-control" rows="3" />
                </div> }
            </div>
        </React.Fragment>
    );
};

export default CheckoutForm;
