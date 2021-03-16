import {
    ERROR_FIRE,
    ERROR_CLEAR,
} from '../actions/errorActions';

const initial = {
    error: false,
    message: null,
};

const errorReducer = (state = initial, action = {}) => {
    const {type, payload} = action;

    switch (type) {
    case ERROR_FIRE:
        return {
            ...state,
            error: true,
            message: payload,
        };

    case ERROR_CLEAR:
        return {
            ...state,
            error: false,
            message: null,
        };

    default: return state;
    }
};

export default errorReducer;
