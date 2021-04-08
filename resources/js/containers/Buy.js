import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import config from 'react-global-configuration';
import {cartFetch, cartProductAttach} from '../api/cart';
import BuyButton from '../components/BuyButton';
import BuyPrice from '../components/BuyPrice';
import BuyVariants from '../components/BuyVariants';
import NostockButton from '../components/NostockButton';
import {cartClose, cartOpen} from '../state/actions/cart';

const Buy = (props) => {
    const dispatch = useDispatch();
    const cartPending = useSelector((state) => state.cart.pending);
    const cartProducts = useSelector((state) => state.cart.products);
    const [variant, setVariant] = useState({});
    const [isValid, setIsValid] = useState(true);
    let isInStock; let isInCart;

    if (variant.id) {
        isInStock = !!variant.is_stock;
        isInCart = !!cartProducts.find((el) => el.variant_id === variant.id);
    } else {
        isInStock = !!props.product.is_stock;
        isInCart = !!cartProducts.find((el) => el.id === props.product.id);
    }

    useEffect(() => {
        if (!cartPending) {
            dispatch(cartFetch());
        }
    }, []);

    const showCart = () => dispatch(cartOpen());

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
    };

    return (
        <React.Fragment>
            {!!props.variants.length && <BuyVariants variants={props.variants}
                handleSelect={handleVariantSelect}
                isInvalid={!isValid}/>}

            <BuyPrice currency={config.get('currency')}
                product={props.product}
                variant={variant}/>

            {!props.variants.length || !!Object.keys(variant).length && (isInStock ?
                <BuyButton isInCart={isInCart} addToCart={handleAddToCart}
                    showCart={showCart}/> :
                <NostockButton/>
            )
            }
        </React.Fragment>
    );
};

export default Buy;

