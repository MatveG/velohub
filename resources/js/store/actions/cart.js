export const CART_ERROR = 'CART::ERROR';
export const CART_PENDING = 'CART::PENDING';
export const CART_PUSH = 'CART::REMOVE';
export const CART_UPDATE = 'CART::UPDATE';
export const CART_REMOVE = 'CART::REMOVE';
export const CART_REWRITE = 'CART::REWRITE';
export const CART_EMPTY = 'CART::CLEAR';

export const cartError = (error) => {
    return{
        type: CART_PENDING,
        payload: error
    }
}

export const cartPending = () => {
    return{
        type: CART_PENDING,
    }
}

export const cartPush = (product) => {
    return{
        type: CART_PUSH,
        payload: product
    }
}

export const cartUpdate = (product) => {
    return{
        type: CART_UPDATE,
        payload: product
    }
}

export const cartRemove = (product) => {
    return{
        type: CART_PUSH,
        payload: product
    }
}

export const cartRewrite = (products) => {
    return{
        type: CART_REWRITE,
        payload: products
    }
}

export const cartEmpty = () => {
    return{
        type: CART_EMPTY,
    }
}
