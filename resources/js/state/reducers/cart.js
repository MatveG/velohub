export const CART_OPEN = 'CART::OPEN';
export const CART_CLOSE = 'CART::CLOSE';
export const CART_EMPTY = 'CART::EMPTY';
export const CART_FILL = 'CART::FILL';
export const CART_PENDING = 'CART::PENDING';
// export const CART_PUSH = 'CART::PUSH';
// export const CART_REMOVE = 'CART::REMOVE';
// export const CART_UPDATE = 'CART::UPDATE';

const initialState = {
    isOpen: false,
    isPending: false,
    products: [],
};

const cart = (state = initialState, action = {}) => {
    const {type, payload} = action;

    switch (type) {
    case CART_OPEN:
        return {
            ...state,
            isOpen: true,
        };

    case CART_CLOSE:
        return {
            ...state,
            isOpen: false,
        };

    case CART_EMPTY:
        return {
            ...state,
            isPending: false,
            products: initialState.products,
        };

    case CART_FILL:
        return {
            ...state,
            isPending: false,
            products: payload,
        };

    case CART_PENDING:
        return {
            ...state,
            isPending: true,
        };

    // case CART_PUSH:
    //     return {
    //         ...state,
    //         isPending: false,
    //         products: [...state.products, payload],
    //     };
    //
    // case CART_REMOVE:
    //     return {
    //         ...state,
    //         isPending: false,
    //         products: state.products.filter((el) => payload.variant_id ?
    //             el.id !== payload.id && el.variant_id !== payload.variant_id :
    //             el.id !== payload.id,
    //         ),
    //     };
    //
    // case CART_UPDATE:
    //     return {
    //         ...state,
    //         isPending: false,
    //         products: state.products.map((el) => {
    //             return {...(el.id === payload.id ? payload : el)};
    //         }),
    //     };

    default: return state;
    }
};

export default cart;
