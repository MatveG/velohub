export const TOAST_PUSH = 'TOAST::INFO';
export const TOAST_REMOVE = 'TOAST::CLOSE';
export const TOAST_CLEAR = 'TOAST::CLOSE';

const initial = {
    items: [],
};

const toast = (state = initial, action = {}) => {
    const {type, payload} = action;

    switch (type) {
    case TOAST_PUSH:
        return {
            items: [payload, ...state.items],
        };

    case TOAST_REMOVE:
        return {
            items: [...state.items.filter((el, idx) => idx !== payload)],
        };

    case TOAST_CLEAR:
        return {
            state: initial,
        };

    default: return state;
    }
};

export default toast;
