import {
    CART_EMPTY,
    CART_FETCH,
    CART_PENDING,
    CART_PUSH,
    CART_REMOVE,
    CART_UPDATE,
    CART_ERROR,
} from '../actions/cartActions';

const initial = {
    pending: false,
    error: null,
    products: []
}

const cartReducer = (state = initial, action = {}) => {
    const {type, payload} = action;

    switch (type) {
        case CART_EMPTY:
            return {
                ...state,
                pending: false,
                error: null,
                products: initial.products
            };

        case CART_FETCH:
            return {
                ...state,
                pending: false,
                error: null,
                products: payload || initial.products
            };

        case CART_PENDING:
            return {
                ...state,
                pending: true,
                error: null,
            };

        case CART_PUSH:
            return {
                ...state,
                pending: false,
                error: null,
                products: [...state.products, payload],
            };

        case CART_REMOVE:
            return {
                ...state,
                pending: false,
                error: null,
                products: state.products.filter((el) => el.id !== payload.id),
            };

        case CART_UPDATE:
            return {
                ...state,
                pending: false,
                error: null,
                products: state.products.map((el) => {
                    return el.id === payload.id ? {...payload} : {...el};
                }),
            };

        case CART_ERROR:
            return {
                ...state,
                error: payload,
                pending: false,
            };

        default: return state;
    }
}

export default cartReducer;
