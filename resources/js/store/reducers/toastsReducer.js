import {
    TOAST_INFO,
    TOAST_WARNING,
    TOAST_DANGER,
    TOAST_CLEAR,
} from '../actions/toastsActions';

const initial = {
    active: false,
    type: '',
    message: null,
};

const toastsReducer = (state = initial, action = {}) => {
    const {type, payload} = action;

    switch (type) {
    case TOAST_INFO:
        return {
            ...state,
            active: true,
            type: 'info',
            message: payload,
        };

    case TOAST_WARNING:
        return {
            ...state,
            active: true,
            type: 'warning',
            message: payload,
        };

    case TOAST_DANGER:
        return {
            ...state,
            active: true,
            type: 'danger',
            message: payload,
        };

    case TOAST_CLEAR:
        return {
            ...state,
            active: false,
            type: '',
            message: null,
        };

    default: return state;
    }
};

export default toastsReducer;
