import React, {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import ToastComponent from '../components/ToastComponent';
import {closeToast} from '../state/actions/toast';

const lifetime = 5000;
let timeouts = [];

const Toast = () => {
    const dispatch = useDispatch();
    const items = useSelector(({toast}) => toast.items);

    const closeByIdx = (idx) => {
        dispatch(closeToast(idx));
    };

    useEffect(() => {
        timeouts.forEach((el) => clearTimeout(el));
        timeouts = items.map((el, idx) => {
            return setTimeout(
                () => closeByIdx(idx),
                lifetime - (Date.now() - el.created),
            );
        });
    }, [items]);

    return (
        <React.Fragment>
            {items.map((el, idx) => (
                <ToastComponent
                    key={idx}
                    idx={idx}
                    type={el.type}
                    message={el.message}
                    close={closeByIdx}/>
            ))}
        </React.Fragment>
    );
};

export default Toast;


