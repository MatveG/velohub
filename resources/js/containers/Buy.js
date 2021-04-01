import React, {useState, useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import {cartFetch, cartProductAttach} from '../actions/cart';
import BuyButton from '../components/BuyButton';
import VariantSelect from '../components/VariantSelect';

let isStock; let isInCart;

const Buy = (props) => {
    const dispatch = useDispatch();
    const cartPending = useSelector((state) => state.cart.pending);
    const cartProducts = useSelector((state) => state.cart.products);
    const [variant, setVariant] = useState({});
    const [isValid, setIsValid] = useState(true);

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

            {!!props.variants.length && <VariantSelect
                variants={props.variants}
                handleSelect={handleVariantSelect}
                isInvalid={!isValid}/>}

            <p className="py-2 pt-3">
                <span className="product-price">{variant.price || props.product.price}</span>&nbsp;
                <span>{props.currency.sign}</span>
            </p>

            {isStock ?
                <BuyButton isInCart={isInCart} addToCart={handleAddToCart} /> :
                <b>нет в наличии</b>}
        </div>
    );
};

export default Buy;

