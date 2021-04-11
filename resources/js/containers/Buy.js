import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import config from 'react-global-configuration';
import {cartFetch, cartProductAttach} from '../api/cart';
import {cartOpen} from '../state/actions/cart';
import BuyButton from '../components/BuyButton';
import BuyPrice from '../components/BuyPrice';
import BuyVariants from '../components/BuyVariants';
import NostockButton from '../components/NostockButton';

const Buy = (props) => {
    const dispatch = useDispatch();
    const cartProducts = useSelector(({cart}) => cart.products);
    const [keyId, setKeyId] = useState(undefined);
    const [isValid, setIsValid] = useState(true);
    const variant = keyId !== undefined ? props.variants[keyId] : {is_stock: false};
    let isInStock; let isInCart;

    if (variant.id) {
        isInStock = !!variant.is_stock;
        isInCart = !!cartProducts.find((el) => {
            return el.variant_id === variant.id;
        });
    } else {
        isInStock = !!props.product.is_stock;
        isInCart = !!cartProducts.find((el) => {
            return el.id === props.product.id && el.variant_id === 0;
        });
    }

    useEffect(() => {
        dispatch(cartFetch());
    }, []);

    const showCart = () => dispatch(cartOpen());

    const handleVariantSelect = (event) => {
        setKeyId(Number.isInteger(+event.target.value) ? +event.target.value : undefined);
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
            {!!props.variants.length && <BuyVariants
                variants={props.variants}
                isInvalid={!isValid}
                value={keyId}
                handleSelect={handleVariantSelect} />}

            <BuyPrice
                currency={config.get('currency')}
                product={props.product}
                variant={variant} />

            {isInStock
                ? <BuyButton
                    isInCart={isInCart}
                    showCart={showCart}
                    addToCart={handleAddToCart} />
                : <NostockButton/>
            }
        </React.Fragment>
    );
};

export default Buy;

