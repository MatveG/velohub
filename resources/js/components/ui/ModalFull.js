import React from 'react';

const ModalFull = (props) => {
    return (
        <div className="modal overflow-scroll" id={props.id} tabIndex="-1" aria-hidden="true">
            <div className="modal-dialog modal-fullscreen modal-dialog-scrollable w-75 m-auto">
                <div className="modal-content">
                    <div className="modal-header px-4">
                        <h3 className="modal-title">{props.title}</h3>
                        <button type="button" className="btn-close" data-bs-dismiss="modal"/>
                    </div>
                    <div className="modal-body text-center">
                        {props.children}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ModalFull;
