import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import cartReducer from './store/reducers/cartReducer';
import Cart from './components/Cart';
import Buy from './components/Buy';

const store = createStore(
    cartReducer,
    applyMiddleware(thunk)
);

render(
    <Provider store={store}>
        <Cart />
    </Provider>,
    document.getElementById("showCart")
);

render(
    <Provider store={store}>
        <Buy />
    </Provider>,
    document.getElementById("buyProduct")
);

















// import "./../sass/app.scss";

// require('./cart');
// require('./common');
// require('./compare');
// require('./shop');
//
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
