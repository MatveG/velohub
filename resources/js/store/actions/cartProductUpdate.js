import axios from 'axios';
import {cartUpdate} from './cartActions';
import {fireDanger} from './toastsActions';

export default function cartProductUpdate(product) {
    return (dispatch) => {
        return axios.patch(`/api/carts/products/update`, product)
            .then(() => {
                dispatch(cartUpdate(product));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed updating cart data'));
                console.error(err);
            });
    };
}
