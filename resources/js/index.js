import '../sass/index.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import config from 'react-global-configuration';
import ProductImage from './components/ProductImage';
import Buy from './containers/Buy';
import Cart from './containers/Cart';
import Checkout from './containers/Checkout';
import Toast from './containers/Toast';
import state from './state/';
import {cartOpen} from './state/actions/cart';
import applyFilter from './utils/applyFilter';
import applySorting from './utils/applySorting';
import scrollState from './utils/scrollState';

config.set(_CONFIG);

const store = createStore(
    state,
    window.hasOwnProperty('_STATE') ? _STATE : {},
    applyMiddleware(thunk),
);

const productImage = document.getElementById('product-image');
productImage && render(
    <ProductImage images={_PRODUCT_IMAGES}/>,
    productImage,
);

const productBuy = document.getElementById('product-buy');
productBuy && render(
    <Provider store={store}>
        <Buy product={_PRODUCT} variants={_PRODUCT_VARIANTS}/>
    </Provider>,
    productBuy,
);

const shopCart = document.getElementById('shop-cart');
shopCart && render(
    <Provider store={store}>
        <Cart checkoutRoute={_CHECKOUT_ROUTE}/>
    </Provider>,
    shopCart,
);

const checkoutForm = document.getElementById('shop-checkout');
checkoutForm && render(
    <Provider store={store}>
        <Checkout/>
    </Provider>,
    checkoutForm,
);

const errorMessage = document.getElementById('error-message');
errorMessage && render(
    <Provider store={store}>
        <Toast/>
    </Provider>,
    errorMessage,
);

const cartStatus = document.getElementById('cart-status');
if (cartStatus) {
    cartStatus.addEventListener('click', () => store.dispatch(cartOpen()));
}
const scrollTop = document.getElementById('scroll-top');
if (scrollTop) {
    scrollTop.onclick = () => scrollTo({top: 0, behavior: 'smooth'});
}

addEventListener('load', scrollState);
addEventListener('scroll', scrollState);
Array.from(document.getElementsByClassName('select-sort')).forEach((el) => {
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
