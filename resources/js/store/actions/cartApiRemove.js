import {cartRemove} from './cartActions';
import patchRequest from './patchRequest';

export default function cartApiRemove(product) {
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
