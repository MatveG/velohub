import './../sass/app.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import state from './state/';
import {fireInfo, fireWarning, fireDanger} from './state/actions/toasts';
import ProductImage from './components/ProductImage';
import Toasts from './components/ui/Toasts';
import Buy from './containers/Buy';
import Cart from './containers/Cart';
import Checkout from './containers/Checkout';
import applyFilter from './utils/applyFilter';
import applySorting from './utils/applySorting';
import scrollState from './utils/scrollState';

const store = createStore(state, applyMiddleware(thunk));

['load', 'scroll'].forEach((eventType) => {
    window.addEventListener(eventType, () => scrollState());
});
document.getElementById('scroll-top').addEventListener('click', () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
});
Array.from(document.getElementsByClassName('category-select-sort')).forEach((el) => {
    el.addEventListener('change', () => applySorting(el));
});
Array.from(document.getElementsByClassName('category-filter')).forEach((el) => {
    el.addEventListener(el.type === 'text' ? 'change' : 'click', () => applyFilter(el));
});
Array.from(document.getElementsByClassName('navbar-icon-btn')).forEach((el) => {
    el.addEventListener('click', () => {
        Array.from(document.getElementsByClassName('navbar-info-block')).forEach((block) => {
            block.classList.remove('show');
        });
    });
});

const productImage = document.getElementById('product-image');
productImage && render(
    <ProductImage images={_PRODUCT_IMAGES} />,
    productImage,
);

const productBuy = document.getElementById('product-buy');
productBuy && render(
    <Provider store={store}>
        <Buy currency={_CONFIG.currency} product={_PRODUCT} variants={_PRODUCT_VARIANTS} />
    </Provider>,
    productBuy,
);

const shopCart = document.getElementById('shop-cart');
shopCart && render(
    <Provider store={store}>
        <Cart />
    </Provider>,
    shopCart,
);

const checkoutCart = document.getElementById('checkout-cart');
checkoutCart && render(
    <Provider store={store}>
        <Cart readOnly={true} />
    </Provider>,
    checkoutCart,
);

const checkoutForm = document.getElementById('checkout-form');
checkoutForm && render(
    <Provider store={store}>
        <Checkout currency={_CONFIG.currency} couriers={_CONFIG.couriers} />
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

window.hasOwnProperty('_NOTICE_INFO') && store.dispatch(fireInfo(_TOAST_INFO));
window.hasOwnProperty('_NOTICE_WARNING') && store.dispatch(fireWarning(_TOAST_WARNING));
window.hasOwnProperty('_NOTICE_DANGER') && store.dispatch(fireDanger(_TOAST_DANGER));
