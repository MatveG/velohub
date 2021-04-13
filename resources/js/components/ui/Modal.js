import React from 'react';

const Modal = (props) => {
    const outEl = React.createRef();

    const outClick = ({target}) => {
        if (target === outEl.current) {
            props.handleClose();
        }
    };

    return (
        <div
            className={`modal overflow-scroll ${props.active ? 'd-block' : ''}`}
            tabIndex="-1"
            ref={outEl}
            onClick={outClick}>
            <div className={`modal-dialog modal-dialog-scrollable m-auto
                ${!!props.classes && props.classes.join(' ')}`}>
                <div className="modal-content">
                    <div className="modal-header px-4">
                        <h3 className="modal-title">{props.title}</h3>

                        <button type="button" className="btn-close" onClick={props.handleClose} />
                    </div>
                    <div className={`modal-body text-center
                    ${!!props.bodyClasses && props.bodyClasses.join(' ')}`}>
                        {props.children}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Modal;
