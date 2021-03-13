import Cookies from "universal-cookie";

const cookies = new Cookies();

export function getCartCookies() {
    return cookies.get('_ucart');
}

export function setCartCookies(value) {
    return cookies.set('_ucart', value); // add expire
}


// function cartCookies() {
//     const cartCookies = cookies.get('_ucart');
//
//     axios.post('/ajax/cart/', {})
//         .then((response) => {
//             cookies.set('_ucart', response.data.uuid)
//             resolve(response.data.products);
//         })
//         .catch((err) => {
//             reject(err)
//         });
// }
//
