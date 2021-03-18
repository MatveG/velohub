export const TOAST_INFO = 'ERROR::INFO';
export const TOAST_WARNING = 'ERROR::WARNING';
export const TOAST_DANGER = 'ERROR::DANGER';
export const TOAST_CLEAR = 'ERROR::CLEAR';

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
