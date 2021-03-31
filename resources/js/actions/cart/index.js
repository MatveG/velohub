import {
    CART_EMPTY,
    CART_FILL,
    CART_PENDING,
    CART_PUSH,
    CART_REMOVE,
    CART_UPDATE,
    CART_ERROR,
} from '../../types/cart';

export const cartEmpty = () => ({
    type: CART_EMPTY,
});

export const cartFill = (products) => ({
    type: CART_FILL,
    payload: products,
});

export const cartPending = () => ({
    type: CART_PENDING,
});

export const cartPush = (product) => ({
    type: CART_PUSH,
    payload: product,
});

export const cartRemove = (product) => ({
    type: CART_REMOVE,
    payload: product,
});

export const cartUpdate = (product) => ({
    type: CART_UPDATE,
    payload: product,
});

export const cartError = (error) => ({
    type: CART_ERROR,
    payload: error,
});
