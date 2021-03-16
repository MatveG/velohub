import React from 'react';
import {connect} from 'react-redux';
import {clearError} from '../store/actions/errorActions';

const errorMessage = (props) => {
    setTimeout(() => {
        props.clearError();
    }, 10000);

    return (
        <div>
            <div className="toast-container position-fixed p-3 bottom-0 end-0" style={{zIndex: 99}}>
                <div className={`toast ${props.error ? 'show' : ''}`} role="alert">
                    <div className="toast-header">
                        <strong className="me-auto text-danger" style={{opacity: 0.75}}>
                            &#9940; Error
                        </strong>
                        <button type="button" className="btn-close" aria-label="Close"
                            onClick={props.clearError}/>
                    </div>
                    <div className="toast-body">{props.message}</div>
                </div>
            </div>
        </div>
    );
};

const mapState = ({error}) => ({
    error: error.error,
    message: error.message,
});

const mapActions = (dispatch) => ({
    clearError: () => dispatch(clearError()),
});

export default connect(mapState, mapActions)(errorMessage);
