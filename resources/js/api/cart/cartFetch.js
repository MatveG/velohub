import axios from 'axios';
import {cartPending, cartFill} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toasts';

export function cartFetch() {
    return (dispatch) => {
        dispatch(cartPending());

        axios.get('/api/carts/products')
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(cartEmpty());
                dispatch(fireDanger('Failed fetching cart data'));
                console.error(err);
            });
    };
}
