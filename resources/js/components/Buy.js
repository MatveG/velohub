import React, {useState} from "react";
import {connect} from 'react-redux';
import BuyVariants from './BuyVariants';
import cartApiPush from "../store/actions/cartApiPush";

const product = {
    "id": 997,
    "is_stock": true,
};
const variants = [
    {
        "id": 101,
        "product_id": 100,
        "category_id": 2,
        "is_active": true,
        "is_sale": true,
        "is_stock": true,
        "stock": 0,
        "price": 110,
        "surcharge": "0",
        "weight": "15",
        "code": "1111111111",
        "barcode": "1111111111",
        "images": [],
        "parameters": {
            "-dvIJE": "S"
        }
    },
    {
        "id": 201,
        "product_id": 200,
        "category_id": 2,
        "is_active": true,
        "is_sale": true,
        "is_stock": false,
        "stock": 0,
        "price": 90,
        "surcharge": "0",
        "weight": "17",
        "code": "22222222222",
        "barcode": "22222222222",
        "images": [],
        "parameters": {
            "-dvIJE": "L"
        }
    },
];

const Buy = (props) => {
    const [variant, setVariant] = useState({});

    const selectOption = (event) => {
        const chosen = Number.isInteger(+event.target.value) ? +event.target.value : null;
        setVariant(variants[chosen] ? variants[chosen] : {});
    };

    const isStock = () => {
        return variant.is_stock || (!variant.id && product.is_stock);
    }

    const existsInCart = () => {
        return (!!variant.id && !!props.products.find((el) => el.variant_id === variant.id)) ||
            (!variant.id && !!props.products.find((el) => el.id === product.id));
    }

    const addToCart = () => {
        props.addToCart(variant.id ?
            {id: variant.product_id, variant_id : variant.id} :
            {id: product.id}
        );
    }

    return (
        <div className="mt-2">
            <h4>
                <span>Купить</span>
            </h4>
            {variants.length && <BuyVariants variants={variants} selectOption={selectOption} />}
            <p>
                <span id="price" className="price">
                    {variant.price || product.price}
                </span>
            </p>

            {isStock() ? (
                existsInCart() ? (
                    <button className="btn btn-gray w-50" role="button"
                            data-target="#modal-cartReducer" data-toggle="modal">уже в корзине</button>
                ) : (
                    <button className="btn btn-bright w-50" role="button"
                            onClick={addToCart}>В корзину</button>
                )
            ) : (
                <p><b>нет в наличии</b></p>
            )}
        </div>
    );
}

const mapState = ({products}) => ({
    products
});

const mapActions = (dispatch) => ({
    addToCart: (product) => dispatch(cartApiPush(product))
});

export default connect(mapState, mapActions)(Buy)

