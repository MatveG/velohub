import React, {useState} from 'react';
import ModalFull from './ui/ModalFull';
import ProductThumbs from './ProductThumbs';

const ProductImage = (props) => {
    const [active, setActive] = useState(0);

    return (
        <div>
            <div className="product-image">
                <img className="w-100"
                    alt=""
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#product-image-modal"
                    src={props.images[active]}/>
            </div>

            <div className="mt-2 d-flex justify-content-center">
                <ProductThumbs images={props.images} handleClick={setActive} />
            </div>

            <ModalFull id="product-image-modal" title="Фото">
                <div className="d-flex justify-content-center">
                    <ProductThumbs images={props.images} handleClick={setActive} />
                </div>
                <div className="mt-2">
                    <img className="w-100" src={props.images[active]} alt={props.images[active]}/>
                </div>
            </ModalFull>
        </div>
    );
};

export default ProductImage;
