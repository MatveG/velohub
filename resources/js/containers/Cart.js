import React from 'react';
import config from 'react-global-configuration';
import Modal from '../components/ui/Modal';
import CartControls from '../components/CartControls';
import CartComponent from '../components/CartComponent';
import useCart from '../hooks/useCart';

const Cart = (props) => {
    const {
        isOpen, products, totalCost,
        hideCart, removeProduct, updateProduct,
    } = useCart();

    const updateAmount = (product, mod) => {
        if (product.amount + mod > 0) {
            updateProduct({...product, amount: product.amount + mod});
        }
    };

    return (
        <Modal
            title="Корзина"
            classes={['modal-fullscreen', 'w-75']}
            bodyClasses={['p-2', 'px-4', 'text-center']}
            active={isOpen}
            handleClose={hideCart}>

            {products.length
                ? <div>
                    <CartComponent
                        currency={config.get('currency')}
                        products={products}
                        totalCost={totalCost}
                        updateAmount={updateAmount}
                        removeProduct={removeProduct} />
                    <CartControls
                        checkoutRoute={props.checkoutRoute}
                        hideCart={hideCart} />
                </div>
                : <p className="py-3 fst-italic">
                    Здесь пока пусто
                </p>
            }
        </Modal>
    );
};

export default Cart;
