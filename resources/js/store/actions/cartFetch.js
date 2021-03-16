import axios from 'axios';
import {cartFill} from './cartActions';
import {fireError} from './errorActions';

export default function cartFetch() {
    return (dispatch) => {
        axios.get(`/api/carts/products`)
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(fireError('Failed fetching cart data'));
                console.error(err);
            });
    };
}
