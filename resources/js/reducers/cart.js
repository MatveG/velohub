import {
    CART_EMPTY,
    CART_FILL,
    CART_PENDING,
    CART_PUSH,
    CART_REMOVE,
    CART_UPDATE,
    CART_ERROR,
} from '../types/cart';

const initial = {
    pending: false,
    error: false,
    products: [],
};

const cart = (state = initial, action = {}) => {
    const {type, payload} = action;

    switch (type) {
    case CART_EMPTY:
        return {
            ...state,
            pending: false,
            error: null,
            products: initial.products,
        };

    case CART_FILL:
        return {
            ...state,
            pending: false,
            error: true,
            products: payload || initial.products,
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
            products: state.products.filter((el) => payload.variant_id ?
                el.id !== payload.id && el.variant_id !== payload.variant_id :
                el.id !== payload.id,
            ),
        };

    case CART_UPDATE:
        return {
            ...state,
            pending: false,
            error: null,
            products: state.products.map((el) => {
                return {...(el.id === payload.id ? payload : el)};
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
};

export default cart;
