import {combineReducers} from 'redux';
import cart from './reducers/cart';
import toasts from './reducers/toasts';

export default combineReducers({
    cart,
    toasts,
});
