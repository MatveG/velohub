import React, {useState} from 'react';
import Modal from './ui/Modal';
import ProductThumbs from './ProductThumbs';

const ProductImage = (props) => {
    const [isOpen, setIsOpen] = useState(false);
    const [active, setActive] = useState(0);

    const openModal = () => setIsOpen(true);
    const closeModal = () => setIsOpen(false);

    return (
        <div>
            <div className="product-image">
                <img className="w-100"
                    alt=""
                    role="button"
                    src={props.baseUrl + props.images[active]}
                    onClick={openModal}/>
            </div>

            <div className="mt-2 d-flex justify-content-center">
                <ProductThumbs
                    images={props.images}
                    baseUrl={props.baseUrl}
                    handleClick={setActive} />
            </div>

            <Modal
                title="Фото"
                classes={['modal-fullscreen', 'w-50', 'below-lg-100']}
                active={isOpen}
                handleClose={closeModal}>

                <div className="d-flex justify-content-center">
                    <ProductThumbs
                        images={props.images}
                        baseUrl={props.baseUrl}
                        handleClick={setActive} />
                </div>

                <div className="mt-2">
                    <img className="w-100"
                        src={props.baseUrl + props.images[active]}
                        alt={props.images[active]}/>
                </div>
            </Modal>
        </div>
    );
};

export default ProductImage;

