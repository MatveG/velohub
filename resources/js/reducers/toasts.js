export const TOAST_INFO = 'ERROR::INFO';
export const TOAST_WARNING = 'ERROR::WARNING';
export const TOAST_DANGER = 'ERROR::DANGER';
export const TOAST_CLEAR = 'ERROR::CLEAR';

const initial = {
    active: false,
    type: '',
    message: null,
};

const toasts = (state = initial, action = {}) => {
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

export default toasts;
