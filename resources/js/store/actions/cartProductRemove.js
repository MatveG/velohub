import {cartRemove} from './cart';
import patchRequest from './patchRequest';

export default function cartProductRemove(product) {
    return (dispatch, getState) => {
        const state = getState();

        const products = state.products.filter((el) => {
            return el.id !== product.id;
        })

        patchRequest(products).then(() => {
            dispatch(cartRemove(product));
        });
    }
}
