import axios from 'axios';
import {cartRemove} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toasts';

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
