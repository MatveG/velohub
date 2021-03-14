import {cartFetch, cartUpdate} from "./cartActions";
import patchRequest from "./patchRequest";

export default function cartApiPush(product) {
    return (dispatch, getState) => {
        const state = getState();
        const exists = state.products.findIndex((el) => el.id === product.id) === -1;

        if (exists) {
            product.amount = 1;
            const products = [...state.products, product];

            patchRequest(products).then((response) => {
                console.log(response.data.products);
                dispatch(cartFetch(response.data.products));
            });
        } else {
            product.amount++;
            const products = state.products.map((el) => {
                return el.id === product.id ? product : el;
            });

            patchRequest(products).then((response) => {
                dispatch(cartUpdate(product));
            });
        }
    }
}
