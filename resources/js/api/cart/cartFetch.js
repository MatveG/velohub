import axios from 'axios';
import {cartPending, cartFill} from '../../state/actions/cart';
import {fireDanger} from '../../state/actions/toast';

export function cartFetch() {
    return (dispatch) => {
        dispatch(cartPending());

        axios.post('/api/cart')
            .then((response) => {
                dispatch(cartFill(response.data));
            })
            .catch((err) => {
                dispatch(fireDanger('Failed fetching cart data'));
                console.error(err);
            });
    };
}
