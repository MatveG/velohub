import axios from "axios";
import {getCartCookies} from "../../utils/cartCookies";

export default function patchRequest(products) {
    return axios.patch(`/api/cart/${getCartCookies()}`, {products})
        .then((response) => {
            return response;
        })
        .catch((err) => {
            throw new Error('Error patching cart data');
        });
}
