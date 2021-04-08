import React from 'react';

const Modal = (props) => {
    return (
        <div className={`modal overflow-scroll ${props.active ? 'd-block' : ''}`} tabIndex="-1">
            <div className={`modal-dialog modal-dialog-scrollable m-auto
                ${props.classes.join(' ')}`}>
                <div className="modal-content">
                    <div className="modal-header px-4">
                        <h3 className="modal-title">{props.title}</h3>

                        <button type="button" className="btn-close" onClick={props.handleClose} />
                    </div>
                    <div className="modal-body text-center">
                        {props.children}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Modal;
