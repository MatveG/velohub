// column is_stock in variants
// delete expired product from cart

import './../sass/app.scss';
import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import cartFetch from './store/actions/cartFetch';
import rootReducer from './store/reducers/';
import ErrorMessage from './components/ErrorMessage';
import ProductBuy from './components/ProductBuy';
import ProductImages from './components/ProductImages';
import ShoppingCart from './components/ShoppingCart';
import applyFilter from './utils/applyFilter';
import applySorting from './utils/applySorting';
import scrollState from './utils/scrollState';

['load', 'scroll'].forEach((eventType) => {
    window.addEventListener(eventType, () => {
        scrollState();
        // Array.from(document.getElementsByClassName('navbar-info-block')).forEach((el) => {
        //     el.classList.remove('show');
        // });
    });
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


const store = createStore(rootReducer, applyMiddleware(thunk));
store.dispatch(cartFetch());

const productImagesEl = document.getElementById('product-images');
productImagesEl && _PRODUCT_IMAGES && render(
    <Provider store={store}>
        <ProductImages images={_PRODUCT_IMAGES} />
    </Provider>,
    productImagesEl,
);

const productBuyEl = document.getElementById('product-buy');
productBuyEl && _PRODUCT_BUY && render(
    <Provider store={store}>
        <ProductBuy product={_PRODUCT_BUY} variants={_PRODUCT_VARIANTS} />
    </Provider>,
    productBuyEl,
);

const errorMessageEl = document.getElementById('error-message');
errorMessageEl && render(
    <Provider store={store}>
        <ErrorMessage />
    </Provider>,
    errorMessageEl,
);
// if (backendData.error) {
//     store.dispatch(fireError(backendData.error));
// }


const shoppingCartEl = document.getElementById('shopping-cart');
shoppingCartEl && render(
    <Provider store={store}>
        <ShoppingCart />
    </Provider>,
    shoppingCartEl,
);
