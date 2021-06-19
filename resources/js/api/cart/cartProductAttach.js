import axios from 'axios';
import {cartFill} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toast';

export function cartProductAttach(product) {
    return (dispatch) => {
        return axios.patch(`/api/cart/add`, product)
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed updating cart data'));
                console.error(err);
            });
    };
}
