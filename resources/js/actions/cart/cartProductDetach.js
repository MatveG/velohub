import axios from 'axios';
import {cartRemove} from '../cart';
import {fireDanger} from '../toasts';

export function cartProductDetach(product) {
    return (dispatch) => {
        return axios.patch(`/api/carts/products/detach`, product)
            .then(() => {
                dispatch(cartRemove(product));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed fetching cart data'));
                console.error(err);
            });
    };
}
