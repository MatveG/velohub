export const CART_EMPTY = 'CART::EMPTY';
export const CART_FILL = 'CART::FILL';
export const CART_PENDING = 'CART::PENDING';
export const CART_PUSH = 'CART::PUSH';
export const CART_REMOVE = 'CART::REMOVE';
export const CART_UPDATE = 'CART::UPDATE';
export const CART_ERROR = 'CART::ERROR';

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
