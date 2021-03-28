import {combineReducers} from 'redux';
import toasts from './reducers/toastsReducer';
import cart from './reducers/cartReducer';

export default combineReducers({
    toasts,
    cart,
});
