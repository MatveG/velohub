import {
    TOAST_PUSH,
    TOAST_REMOVE,
    TOAST_CLEAR,
} from '../reducers/toast';

export const fireInfo = (message) => ({
    type: TOAST_PUSH,
    payload: {type: 'info', created: Date.now(), message},
});

export const fireWarning = (message) => ({
    type: TOAST_PUSH,
    payload: {type: 'warning', created: Date.now(), message},
});

export const fireDanger = (message) => ({
    type: TOAST_PUSH,
    payload: {type: 'danger', created: Date.now(), message},
});

export const closeToast = (idx) => ({
    type: TOAST_REMOVE,
    payload: idx,
});

export const clearToasts = () => ({
    type: TOAST_CLEAR,
});
