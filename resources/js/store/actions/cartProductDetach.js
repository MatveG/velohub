import axios from 'axios';
import {cartRemove} from './cartActions';
import {fireError} from './errorActions';

export default function cartProductDetach(product) {
    return (dispatch) => {
        return axios.patch(`/api/carts/products/detach`, product)
            .then(() => {
                dispatch(cartRemove(product));
            })
            .catch((err) => {
                dispatch(fireError('Failed updating cart data'));
                console.error(err);
            });
    };
}
