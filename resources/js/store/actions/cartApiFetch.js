import axios from "axios";
import {cartFetch, cartEmpty} from "./cartActions";
import {getCartCookies, setCartCookies} from "../../utils/cartCookies";

export default function cartApiFetch() {
    const cookies = getCartCookies();

    return (dispatch) => {
        if (cookies) {
            axios.post(`/api/cart/${getCartCookies()}`)
                .then((response) => {
                    dispatch(cartFetch(response.data.products));
                })
                .catch((err) => {
                    throw new Error('Error fetching cartReducer data');
                });
        }

        axios.post(`/api/cart/create`)
            .then((response) => {
                setCartCookies(response.data.uuid);
                dispatch(cartEmpty());
            })
            .catch((err) => {
                throw new Error('Error fetching cartReducer data');
            });
    }
}
