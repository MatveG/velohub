import {
    TOAST_INFO,
    TOAST_WARNING,
    TOAST_DANGER,
    TOAST_CLEAR,
} from '../reducers/toasts';

export const fireInfo = (message) => ({
    type: TOAST_INFO,
    payload: message,
});

export const fireWarning = (message) => ({
    type: TOAST_WARNING,
    payload: message,
});

export const fireDanger = (message) => ({
    type: TOAST_DANGER,
    payload: message,
});

export const clearToast = () => ({
    type: TOAST_CLEAR,
});
