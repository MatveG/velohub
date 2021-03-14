import Cookies from "universal-cookie";

const cookies = new Cookies();
let cartCookies = cookies.get('_ucart');

export function getCartCookies() {
    cookies.set('_ucart', cartCookies, {maxAge: 60 * 60 * 24 * 90});

    return cartCookies;
}

export function setCartCookies(value) {
    cartCookies = value;
    cookies.set('_ucart', value, {maxAge: 60 * 60 * 24 * 90});

    return cartCookies;
}

