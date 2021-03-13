import patchRequest from "./patchRequest";
import {cartPush} from "./cart";

export default function cartProductAdd(product) {
    return (dispatch, getState) => {
        const state = getState();
        const existIdx = state.products.findIndex((el) => el.id === product.id);
        let products;

        if (existIdx === -1) {
            product.amount = 1;
            products = [...state.products, product];

            patchRequest(products).then(() => {
                dispatch(cartPush(product));
            });
        } else {
            product.amount++;
            products = state.products.map((el) => {
                return el.id === product.id ? product : el;
            });

            patchRequest(products).then(() => {
                dispatch(cartUpdate(product));
            });
        }
    }
}
