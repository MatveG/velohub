import {cartUpdate} from "./cartActions";
import patchRequest from "./patchRequest";

export default function cartApiUpdate(product) {
    return (dispatch, getState) => {
        const state = getState();

        const products = state.products.map((el) => {
            return el.id === product.id ? product : el;
        })

        patchRequest(products).then(() => {
            dispatch(cartUpdate(product));
        });
    }
}
