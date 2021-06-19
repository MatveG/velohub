import React, {useState} from 'react';
import config from 'react-global-configuration';
import BuyButton from '../components/BuyButton';
import BuyPrice from '../components/BuyPrice';
import BuyVariants from '../components/BuyVariants';
import NostockButton from '../components/NostockButton';
import useCart from '../hooks/useCart';

const Buy = (props) => {
    const {products, showCart, addProduct} = useCart();
    const [keyId, setKeyId] = useState(undefined);
    const [isValid, setIsValid] = useState(true);
    const variant = keyId !== undefined ? props.variants[keyId] : {};
    let isInStock; let isInCart;

    if (variant.id) {
        isInStock = !!variant.is_stock;
        isInCart = !!products.find((el) => {
            return el.variant_id === variant.id;
        });
    } else {
        isInStock = !!props.product.is_stock;
        isInCart = !!products.find((el) => {
            return el.id === props.product.id;
        });
    }

    const handleVariantSelect = (event) => {
        if (Number.isInteger(+event.target.value)) {
            setKeyId(+event.target.value);
            return setIsValid(true);
        }
        setKeyId(undefined);
    };

    const handleAddToCart = () => {
        if (props.variants.length && !variant.id) {
            return setIsValid(false);
        }
        addProduct(variant.id ?
            {product_id: variant.product_id, variant_id: variant.id, amount: 1} :
            {product_id: props.product.id, variant_id: null, amount: 1},
        );
        showCart();
    };

    return (
        <div>
            {!!props.variants.length &&
                <BuyVariants
                    variants={props.variants}
                    isInvalid={!isValid}
                    value={keyId}
                    handleSelect={handleVariantSelect}/>
            }

            <BuyPrice
                currency={config.get('currency')}
                product={props.product}
                variant={variant}/>

            {isInStock
                ? <BuyButton
                    isInCart={isInCart}
                    showCart={showCart}
                    addToCart={handleAddToCart}/>
                : <NostockButton/>
            }
        </div>
    );
};

export default Buy;

