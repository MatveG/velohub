import axios from 'axios';
import {cartFill} from './cartActions';
import {fireDanger} from './toastsActions';

export default function cartFetch() {
    return (dispatch) => {
        axios.get(`/api/carts/products`)
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed fetching cart data'));
                console.error(err);
            });
    };
}
