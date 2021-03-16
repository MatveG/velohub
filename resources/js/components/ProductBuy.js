import React, {useState} from 'react';
import {connect} from 'react-redux';
import ProductBuyVariants from './ProductBuyVariants';
import cartProductAttach from '../store/actions/cartProductAttach';

const ProductBuy = (props) => {
    const product = props.product;
    const variants = props.variants;
    const [variant, setVariant] = useState({});

    const selectOption = (event) => {
        const selectedIdx = Number.isInteger(+event.target.value) ? +event.target.value : null;
        setVariant(variants[selectedIdx] ? variants[selectedIdx] : {});
    };

    const isStock = () => {
        return variant.is_stock || (!variant.id && product.is_stock);
    };

    const existInCart = () => {
        return (!!variant.id && !!props.cartItems.find((el) => el.variant_id === variant.id)) ||
            (!variant.id && !!props.cartItems.find((el) => el.id === product.id));
    };

    const addToCart = () => {
        props.addToCart(variant.id ?
            {id: variant.product_id, variant_id: variant.id, amount: 1} :
            {id: product.id, amount: 1},
        );
    };

    return (
        <div className="mt-2">
            <h4>
                <span>Купить</span>
            </h4>

            {variants.length && <p>
                <ProductBuyVariants variants={variants} selectOption={selectOption} />
            </p>}

            <p>
                <span className="product-price">
                    {variant.price || product.price}
                </span>
            </p>

            {isStock() ? (
                existInCart() ? (
                    <button className="btn btn-gray w-50" role="button"
                        data-target="#modal-cartReducer" data-toggle="modal"
                    >уже в корзине</button>
                ) : (
                    <button className="btn btn-bright w-50" role="button"
                        onClick={addToCart}>В корзину</button>
                )
            ) : (
                <b>нет в наличии</b>
            )}
        </div>
    );
};

const mapState = ({cart}) => ({
    cartItems: cart.products,
});

const mapActions = (dispatch) => ({
    addToCart: (product) => dispatch(cartProductAttach(product)),
});

export default connect(mapState, mapActions)(ProductBuy);

