import {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import {cartFetch, cartProductAttach, cartProductDetach, cartProductUpdate} from '../api/cart';
import {cartOpen, cartClose} from '../state/actions/cart';

const computeTotal = (products) => {
    return products.reduce((total, el) => {
        return total + el.amount * el[el.variant ? 'variant' : 'product'].price;
    }, 0);
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

    const addProduct = (product) => {
        dispatch(cartProductAttach(product));
    };

    const updateProduct = (product) => {
        dispatch(cartProductUpdate(product));
    };

    const removeProduct = (product) => {
        dispatch(cartProductDetach(product));
    };

    return {
        isOpen,
        isPending,
        products,
        totalCost,
        showCart,
        hideCart,
        addProduct,
        updateProduct,
        removeProduct,
    };
};

export default useCart;
