import {combineReducers} from 'redux';
import error from './errorReducer';
import cart from './cartReducer';

export default combineReducers({
    error,
    cart,
});
