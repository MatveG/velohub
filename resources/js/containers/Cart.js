import React, {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import config from 'react-global-configuration';
import {cartFetch, cartProductUpdate, cartProductDetach} from '../api/cart';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import Modal from '../components/ui/Modal';
import {cartClose} from '../state/actions/cart';
import CartControls from '../components/CartControls';
import Card from '../components/ui/Card';

const computeTotal = (products) => products.reduce((total, el) => total + el.amount * el.price, 0);

const Cart = (props) => {
    const dispatch = useDispatch();
    const open = useSelector(({cart}) => cart.open);
    const products = useSelector(({cart}) => cart.products);
    const totalCost = computeTotal(products);

    useEffect(() => {
        dispatch(cartFetch());
    }, []);

    const hideCart = () => dispatch(cartClose());

    const removeProduct = (product) => dispatch(cartProductDetach(product));

    const updateAmount = (product, mod) => {
        if (product.amount + mod > 0) {
            dispatch(cartProductUpdate({...product, amount: product.amount + mod}));
        }
    };

    if (!products.length) {
        return <Modal
            title="Корзина"
            classes={['modal-fullscreen', 'w-75']}
            active={open}
            handleClose={hideCart}>
            <div className="p-3 text-center">
                <i>Здесь пока еще пусто</i>
            </div>
        </Modal>;
    }

    return (
        <Modal
            title="Корзина"
            classes={['modal-fullscreen', 'w-75']}
            active={open}
            handleClose={hideCart}>

            <div className="p-2 px-4">
                <CartTable
                    totalCost={totalCost}
                    currency={config.get('currency')}>

                    <CartProducts
                        products={products}
                        currency={config.get('currency')}
                        updateAmount={updateAmount}
                        removeProduct={removeProduct}/>
                </CartTable>

                <CartControls
                    checkoutRoute={props.checkoutRoute}
                    hideCart={hideCart} />
            </div>
        </Modal>
    );
};

export default Cart;
