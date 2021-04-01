import './../sass/app.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import state from './state';
import {fireInfo, fireWarning, fireDanger} from './actions/toasts';
import Toasts from './components/ui/Toasts';
import Cart from './containers/Cart';
import Checkout from './containers/Checkout';
import ProductBuy from './containers/ProductBuy';
import ProductImages from './components/ProductImages';
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

const productImages = document.getElementById('product-images');
productImages && render(
    <ProductImages images={_PRODUCT_IMAGES} />,
    productImages,
);

const productBuy = document.getElementById('product-buy');
productBuy && render(
    <Provider store={store}>
        <ProductBuy product={_PRODUCT_BUY} variants={_PRODUCT_VARIANTS} />
    </Provider>,
    productBuy,
);

const errorMessage = document.getElementById('error-message');
errorMessage && render(
    <Provider store={store}>
        <Toasts />
    </Provider>,
    errorMessage,
);

const shoppingCart = document.getElementById('shopping-cart');
shoppingCart && render(
    <Provider store={store}>
        <Cart />
    </Provider>,
    shoppingCart,
);

const checkoutForm = document.getElementById('checkout-form');
checkoutForm && render(
    <Provider store={store}>
        <Checkout />
    </Provider>,
    checkoutForm,
);

window.hasOwnProperty('_NOTICE_INFO') && store.dispatch(fireInfo(_TOAST_INFO));
window.hasOwnProperty('_NOTICE_WARNING') && store.dispatch(fireWarning(_TOAST_WARNING));
window.hasOwnProperty('_NOTICE_DANGER') && store.dispatch(fireDanger(_TOAST_DANGER));
