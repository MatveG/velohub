import React from 'react';
import {connect} from 'react-redux';
import {clearToast} from '../../actions/toasts';

const toasts = (props) => {
    setTimeout(() => {
        props.clearToast();
    }, 10000);

    const title = props.type.charAt(0).toUpperCase() + props.type.substr(1);

    return (
        <div>
            <div className="toast-container position-fixed p-3 bottom-0 end-0" style={{zIndex: 99}}>
                <div className={`toast ${props.active ? 'show' : ''}`} role="alert">
                    <div className="toast-header">
                        <strong className={`me-auto text-${props.type}`} style={{opacity: 0.75}}>
                            {props.type === 'info' && 'ⓘ'}
                            {props.type === 'warning' && '⚠'}
                            {props.type === 'danger' && '⛔'}
                            &nbsp;{title}
                        </strong>
                        <button type="button" className="btn-close" aria-label="Close"
                            onClick={props.clearToast}/>
                    </div>
                    <div className="toast-body">{props.message}</div>
                </div>
            </div>
        </div>
    );
};

const mapState = ({toasts}) => ({
    active: toasts.active,
    type: toasts.type,
    message: toasts.message,
});

const mapActions = (dispatch) => ({
    clearToast: () => dispatch(clearToast()),
});

export default connect(mapState, mapActions)(toasts);
