import axios from 'axios';
import {cartPush} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toasts';

export function cartProductAttach(product) {
    return (dispatch) => {
        return axios.patch(`/api/carts/products/attach`, product)
            .then((response) => {
                dispatch(cartPush(response.data));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed updating cart data'));
                console.error(err);
            });
    };
}
