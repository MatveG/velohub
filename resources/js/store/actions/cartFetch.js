import axios from "axios";
import {cartRewrite} from "./cart";
import {getCartCookies} from "../../utils/cartCookies";

export default function cartFetch() {
    return (dispatch) => {
        axios.get(`/api/cart/${getCartCookies()}`)
            .then((response) => {
                dispatch(cartRewrite(response.data.products));
            })
            .catch((err) => {
                throw new Error('Error fetching cart data');
            });
    }
}
