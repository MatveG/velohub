import React, {useState} from 'react';
import ModalFull from './ui/ModalFull';

const ProductImages = (props) => {
    const [active, setActive] = useState(0);

    const thumbs = props.images.map((el, idx) => (
        <div role="button" key={idx} onClick={() => setActive(idx)}>
            <div className="m-1 p-1 border product-thumb">
                <img className="h-100" role="button" src={el} alt={props.alt} />
            </div>
        </div>
    ));

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
                {thumbs}
            </div>

            <ModalFull id="product-image-modal" title="Фото">
                <div className="d-flex justify-content-center">
                    {thumbs}
                </div>
                <div className="mt-2">
                    <img className="w-100"
                        src={props.images[active]}
                        alt={props.images[active]}/>
                </div>
            </ModalFull>
        </div>
    );
};

export default ProductImages;
