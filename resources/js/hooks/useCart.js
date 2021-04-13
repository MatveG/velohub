import {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import {cartFetch, cartProductAttach, cartProductDetach, cartProductUpdate} from '../api/cart';
import {cartOpen, cartClose} from '../state/actions/cart';

const computeTotal = (products) => {
    return products.reduce((total, el) => total + el.amount * el.price, 0);
};

const useCart = () => {
    const dispatch = useDispatch();
    const isOpen = useSelector(({cart}) => cart.isOpen);
    const isPending = useSelector(({cart}) => cart.isPending);
    const products = useSelector(({cart}) => cart.products);
    const totalCost = computeTotal(products);

    useEffect(() => {
        if (!isPending) {
            dispatch(cartFetch());
        }
    }, []);

    const showCart = () => {
        dispatch(cartOpen());
    };

    const hideCart = () => {
        dispatch(cartClose());
    };

    const attachProduct = (product) => {
        dispatch(cartProductAttach(product));
    };

    const removeProduct = (product) => {
        dispatch(cartProductDetach(product));
    };

    const updateProduct = (product) => {
        dispatch(cartProductUpdate(product));
    };

    return {
        isOpen,
        isPending,
        products,
        totalCost,
        showCart,
        hideCart,
        attachProduct,
        removeProduct,
        updateProduct,
    };
};

export default useCart;
