import React from 'react';

const ToastComponent = (props) => {
    const title = props.type.charAt(0).toUpperCase() + props.type.substr(1);

    return (
        <div className="d-block">
            <div className="toast-container position-fixed p-3 bottom-0 end-0"
                style={{zIndex: 9999, marginBottom: `${props.idx * 100}px`}}>
                <div className="toast show" role="alert">
                    <div className="toast-header">
                        <strong className={`me-auto text-${props.type}`} style={{opacity: 0.75}}>
                            {props.type === 'info' && 'ⓘ'}
                            {props.type === 'warning' && '⚠'}
                            {props.type === 'danger' && '⛔'}
                            &nbsp;{title}
                        </strong>
                        <button type="button" className="btn-close" aria-label="Close"
                            onClick={() => props.close(props.idx)}/>
                    </div>
                    <div className="toast-body">{props.message}</div>
                </div>
            </div>
        </div>
    );
};

export default ToastComponent;
