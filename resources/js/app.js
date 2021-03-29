import './../sass/app.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import reducer from './store';
import {fireInfo, fireWarning, fireDanger} from './store/actions/toastsActions';
import Toasts from './components/ui/Toasts';
import Cart from './components/cart/Cart';
import Checkout from './components/checkout/Checkout';
import ProductBuy from './components/product/buy/Buy';
import ProductImages from './components/product/images/Images';
import applyFilter from './utils/applyFilter';
import applySorting from './utils/applySorting';
import scrollState from './utils/scrollState';

const store = createStore(reducer, applyMiddleware(thunk));

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

window.hasOwnProperty('_PRODUCT_IMAGES') && render(
    <ProductImages images={_PRODUCT_IMAGES} />,
    document.getElementById('product-images'),
);
window.hasOwnProperty('_PRODUCT_BUY') && render(
    <Provider store={store}>
        <ProductBuy product={_PRODUCT_BUY} variants={_PRODUCT_VARIANTS} />
    </Provider>,
    document.getElementById('product-buy'),
);
document.getElementById('error-message') && render(
    <Provider store={store}>
        <Toasts />
    </Provider>,
    document.getElementById('error-message'),
);
document.getElementById('shopping-cart') && render(
    <Provider store={store}>
        <Cart />
    </Provider>,
    document.getElementById('shopping-cart'),
);
document.getElementById('checkout-form') && render(
    <Provider store={store}>
        <Checkout />
    </Provider>,
    document.getElementById('checkout-form'),
);

window.hasOwnProperty('_NOTICE_INFO') && store.dispatch(fireInfo(_TOAST_INFO));
window.hasOwnProperty('_NOTICE_WARNING') && store.dispatch(fireWarning(_TOAST_WARNING));
window.hasOwnProperty('_NOTICE_DANGER') && store.dispatch(fireDanger(_TOAST_DANGER));
