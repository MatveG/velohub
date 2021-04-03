import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import {cartFetch, cartProductAttach} from '../actions/cart';
import BuyButton from '../components/BuyButton';
import BuyPrice from '../components/BuyPrice';
import BuyVariants from '../components/BuyVariants';

const Buy = (props) => {
    const dispatch = useDispatch();
    const cartPending = useSelector((state) => state.cart.pending);
    const cartProducts = useSelector((state) => state.cart.products);
    const [variant, setVariant] = useState({});
    const [isValid, setIsValid] = useState(true);
    let isStock; let isInCart;

    useEffect(() => {
        if (!cartPending) {
            dispatch(cartFetch());
        }
    }, []);

    if (variant.id) {
        isStock = !!variant.is_stock;
        isInCart = !!cartProducts.find((el) => el.variant_id === variant.id);
    } else {
        isStock = !!props.product.is_stock;
        isInCart = !!cartProducts.find((el) => el.id === props.product.id);
    }

    const handleVariantSelect = (event) => {
        const idx = Number.isInteger(+event.target.value) ? +event.target.value : null;
        setVariant(props.variants[idx] || {});
        setIsValid(true);
    };

    const handleAddToCart = () => {
        if (props.variants.length && !variant.id) {
            return setIsValid(false);
        }

        const product = variant.id ?
            {id: variant.product_id, variant_id: variant.id, amount: 1} :
            {id: props.product.id, variant_id: null, amount: 1};

        dispatch(cartProductAttach(product));

        new bootstrap.Modal(document.getElementById('modal-shopping-cart'), {}).show();
    };

    return (
        <div className="mt-2">
            <h4><span>Купить</span></h4>

            <BuyVariants variants={props.variants}
                handleSelect={handleVariantSelect}
                isInvalid={!isValid}/>

            <BuyPrice currency={props.currency}
                product={props.product}
                variant={variant}/>

            <BuyButton isStock={isStock}
                isInCart={isInCart}
                addToCart={handleAddToCart} />
        </div>
    );
};

export default Buy;

