import axios from "axios";
import {cartUpdate} from "./cart";
import {getCartCookies} from "../../utils/cartCookies";

export default function cartPatch(products) {
    return (dispatch) => {
        axios.patch(`/api/cart/${getCartCookies()}`, {products})
            .then((response) => {
                dispatch(cartUpdate(products));
            })
            .catch((err) => {
                throw new Error('Error patching cart data');
            });
    }
}

