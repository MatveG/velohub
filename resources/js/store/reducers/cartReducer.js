import {
    CART_ERROR,
    CART_PENDING,
    CART_PUSH,
    CART_UPDATE,
    CART_REMOVE,
    CART_REWRITE,
    CART_EMPTY
} from '../actions/cart';

const initialState = {
    pending: false,
    error: null,
    products: []
}

const cartReducer = (state = initialState, action = {}) => {
    const {type, payload} = action;

    switch (type) {
        case CART_ERROR:
            return {
                ...state,
                error: payload,
                pending: false,
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

        case CART_UPDATE:
            return {
                ...state,
                pending: false,
                error: null,
                products: state.products.map((el) => {
                    return el.id === payload.id ? {...payload} : el;
                }),
            };

        case CART_REMOVE:
            return {
                ...state,
                pending: false,
                error: null,
                products: state.products.filter((el) => el.id !== payload.id),
            };

        case CART_REWRITE:
            return {
                ...state,
                pending: false,
                error: null,
                products: payload || initialState.products
            };

        case CART_EMPTY:
            return {
                ...state,
                pending: false,
                error: null,
                products: initialState.products
            };

        default: return state;
    }
}

export default cartReducer;
