import {combineReducers} from 'redux';
import cart from './reducers/cart';
import toast from './reducers/toast';

export default combineReducers({
    cart,
    toast,
});
