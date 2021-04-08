import React, {useState} from 'react';

const CheckoutComment = () => {
    const [flag, setFlag] = useState(false);

    const toggleComment = () => setFlag(!flag);

    return (
        <div className="col-12 py-2">
            <a className="pointer-event" role="button" onClick={toggleComment}>
                Добавить комментарий
            </a>
            { flag && <div className="my-2">
                <textarea name="text" className="form-control" rows="3" />
            </div> }
        </div>
    );
};

export default CheckoutComment;
