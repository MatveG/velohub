import {combineReducers} from 'redux';
import toasts from './toastsReducer';
import cart from './cartReducer';

export default combineReducers({
    toasts,
    cart,
});
