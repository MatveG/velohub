import Cookies from "universal-cookie";
import axios from "axios";

const cookies = new Cookies();
const userCookie = cookies.get('_ucart');

export function initCart(cartStore) {
    return new Promise((resolve, reject) => {
        (userCookie ?
            axios.get(`/ajax/cart/${userCookie}`) :
            axios.post('/ajax/cart/', {})
        )
            .then((response) => {
                cookies.set('_ucart', response.data.uuid)
                resolve(response.data.products);
            }).catch((err) => {
            reject(err)
        });
    });
}
