import './../sass/app.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import config from 'react-global-configuration';
import ProductImage from './components/ProductImage';
import Toasts from './components/ui/Toasts';
import Buy from './containers/Buy';
import Cart from './containers/Cart';
import Checkout from './containers/Checkout';
import state from './state/';
import {cartOpen} from './state/actions/cart';
import {fireInfo, fireWarning, fireDanger} from './state/actions/toasts';
import applyFilter from './utils/applyFilter';
import applySorting from './utils/applySorting';
import scrollState from './utils/scrollState';

const store = createStore(state, applyMiddleware(thunk));

config.set(_CONFIG);

const productImage = document.getElementById('product-image');
productImage && render(
    <ProductImage images={_PRODUCT_IMAGES} />,
    productImage,
);

const productBuy = document.getElementById('product-buy');
productBuy && render(
    <Provider store={store}>
        <Buy product={_PRODUCT} variants={_PRODUCT_VARIANTS} />
    </Provider>,
    productBuy,
);

const shopCart = document.getElementById('shop-cart');
shopCart && render(
    <Provider store={store}>
        <Cart checkoutRoute={_CHECKOUT_ROUTE} />
    </Provider>,
    shopCart,
);

const checkoutForm = document.getElementById('shop-checkout');
checkoutForm && render(
    <Provider store={store}>
        <Checkout />
    </Provider>,
    checkoutForm,
);

const errorMessage = document.getElementById('error-message');
errorMessage && render(
    <Provider store={store}>
        <Toasts />
    </Provider>,
    errorMessage,
);

window.hasOwnProperty('_NOTICE_INFO') && store.dispatch(fireInfo(_NOTICE_INFO));
window.hasOwnProperty('_NOTICE_WARNING') && store.dispatch(fireWarning(_NOTICE_WARNING));
window.hasOwnProperty('_NOTICE_DANGER') && store.dispatch(fireDanger(_NOTICE_DANGER));

const cartStatus = document.getElementById('cart-status');
if (cartStatus) {
    cartStatus.onclick = () => store.dispatch(cartOpen());
}
const scrollTop = document.getElementById('scroll-top');
if (scrollTop) {
    scrollTop.onclick = () => scrollTo({top: 0, behavior: 'smooth'});
}

['load', 'scroll'].forEach((eventType) => {
    window.addEventListener(eventType, scrollState);
});
Array.from(document.getElementsByClassName('category-select-sort')).forEach((el) => {
    el.addEventListener('change', applySorting);
});
Array.from(document.getElementsByClassName('category-filter')).forEach((el) => {
    el.addEventListener(el.type === 'text' ? 'change' : 'click', applyFilter);
});
Array.from(document.getElementsByClassName('navbar-icon-btn')).forEach((el) => {
    el.onclick = () => {
        Array.from(document.getElementsByClassName('navbar-info-block')).forEach((block) => {
            block.classList.remove('show');
        });
    };
});
