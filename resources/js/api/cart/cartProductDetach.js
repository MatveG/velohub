import axios from 'axios';
import {cartFill} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toast';

export function cartProductDetach(product) {
    return (dispatch) => {
        return axios.patch(`/api/cart/remove`, product)
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed fetching cart data'));
                console.error(err);
            });
    };
}
