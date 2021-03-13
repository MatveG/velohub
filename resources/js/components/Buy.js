import React, {useState} from "react";
import {connect} from 'react-redux';
import BuyVariants from './BuyVariants';
import cartProductAdd from "../store/actions/cartProductAdd";

const product = {
    "id": 997,
    "category_id": 2,
    "is_active": true,
    "is_stock": true,
    "is_sale": true,
    "stock": null,
    "price": "3597",
    "price_sale": null,
    "weight": null,
    "sale_text": null,
    "code": null,
    "barcode": null,
    "title": "Melissa Jacobson",
    "brand": "HP",
    "model": "Lauren Gibson",
    "slug": "id-soluta-eius-exercitationem",
    "seo_title": null,
    "seo_description": null,
    "seo_keywords": null,
    "summary": "Sunt natus nihil modi et assumenda. Aperiam sed sapiente corporis at. Veritatis et rerum accusantium culpa ab sit. Vero voluptatem est voluptas commodi expedita possimus fugit.",
    "description": "Alice called out 'The race is over!' and they all stopped and looked at Two. Two began in a piteous tone. And she went on in these words: 'Yes, we went to work shaking him and punching him in the.",
    "images": [
        "/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-1.jpg",
        "/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-2.jpg"
    ],
    "videos": "[]",
    "files": "[]",
    "settings": "{}",
    "features": {
        "os": "DOS",
        "ram": 24,
        "ssd": 32,
        "year": 2019,
        "options": [
            "Wi-Fi",
            "BT",
            "scaner",
            "more1",
            "more2",
            "more3"
        ],
        "processor": "Intel"
    },
    "created_at": "2021-03-05 16:42:57",
    "updated_at": "2021-03-05 16:42:57",
    "search": "'gibson':5A 'hp':3C 'jacobson':2B 'lauren':4A 'melissa':1B"
};
const variants = [
    {
        "id": 1001,
        "variant_id": 113,
        "category_id": 2,
        "is_active": true,
        "is_sale": true,
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
        "id": 1002,
        "variant_id": null,
        "category_id": 2,
        "is_active": true,
        "is_sale": true,
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

    const optionInCart = () => {
        return !!props.products.find((el) => el.variant_id === variant.variant_id) ||
            (!product.variant_id && props.products.find((el) => el.id === product.id));
    }

    if (!product.is_stock) {
        return (
            <p><b>нет в наличии</b></p>
        );
    }

    return (
        <div className="mt-2">
            <h4>
                <span>Купить</span>
            </h4>
            {variants.length ? (<BuyVariants variants={variants} selectOption={selectOption} />) : null}
            <p>
                <span id="price" className="price">
                    {variant.price ? variant.price : product.price}
                </span>
            </p>

            {optionInCart() ? (
                <button className="btn btn-gray w-50" role="button"
                        data-target="#modal-cart" data-toggle="modal">уже в корзине</button>
            ) : (
                <button className="btn btn-bright w-50" role="button"
                        onClick={() => props.addToCart(product)}>В корзину</button>
            )}
        </div>
    );
}

const mapState = ({products}) => {
    return {
        products
    }
}

const mapActions = (dispatch) => {
    return {
        addToCart: (product) => dispatch(cartProductAdd(product))
    };
};

export default connect(mapState, mapActions)(Buy)

