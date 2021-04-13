import React, {useEffect, useState} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import ToastComponent from '../components/ToastComponent';

const Toasts = (props) => {
    const dispatch = useDispatch();
    const toasts = useSelector(({cart}) => cart.active);
    const [arr, setArr] = useState([
        {active: true, type: 'info', message: 'foo-bar'},
        {active: true, type: 'danger', message: 'danger-bar'},
    ]);

    if (true === false) {
        dispatch(toasts);
    }

    useEffect(() => {
        setTimeout(() => setArr([
            ...arr,
            {active: true, type: 'warning', message: 'warning-bar'},
        ]), 1500);


    }, []);

    const closeToast = (keyId) => {
        setArr(arr.filter((el, idx) => idx !== keyId));
    };

    return (
        <div>
            {arr.map((el, idx) => (
                <ToastComponent
                    key={idx}
                    keyId={idx}
                    active={el.active}
                    type={el.type}
                    message={el.message}
                    close={closeToast}/>
            ))}
        </div>
    );
};

export default Toasts;
