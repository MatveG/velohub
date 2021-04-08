import React, {useState} from 'react';
import Modal from './ui/Modal';
import ProductThumbs from './ProductThumbs';

const ProductImage = (props) => {
    const [modal, setModal] = useState(false);
    const [active, setActive] = useState(0);

    return (
        <div>
            <div className="product-image">
                <img className="w-100"
                    alt=""
                    role="button"
                    src={props.images[active]}
                    onClick={() => setModal(true)}/>
            </div>

            <div className="mt-2 d-flex justify-content-center">
                <ProductThumbs images={props.images} handleClick={setActive} />
            </div>

            <Modal active={modal} title="Фото" classes={['modal-fullscreen', 'w-50']}>
                <div className="d-flex justify-content-center">
                    <ProductThumbs images={props.images} handleClick={setActive} />
                </div>

                <div className="mt-2">
                    <img className="w-100" src={props.images[active]} alt={props.images[active]}/>
                </div>
            </Modal>
        </div>
    );
};

export default ProductImage;
