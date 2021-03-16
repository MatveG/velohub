export const ERROR_FIRE = 'ERROR::FIRE';
export const ERROR_CLEAR = 'ERROR::CLEAR';

export const fireError = (message) => ({
    type: ERROR_FIRE,
    payload: message,
});

export const clearError = () => ({
    type: ERROR_CLEAR,
});
