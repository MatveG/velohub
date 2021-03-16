import React, {useState} from 'react';

const ProductImages = (props) => {
    const [active, setActive] = useState(0);
    const [modal, setModal] = useState(false);

    const thumbs = props.images.map((el, idx) => (
        <div role="button" key={idx} onClick={() => setActive(idx)}>
            <div className="m-1 p-1 border product-thumb">
                <img className="h-100" role="button" src={el} alt="--????????--" />
            </div>
        </div>
    ));

    return (
        <div>
            <div className="product-image">
                <img className="w-100"
                    role="button"
                    src={props.images[active]}
                    alt={props.images[active]}
                    onClick={() => setModal(!modal)}/>
            </div>

            <div className="mt-2 d-flex justify-content-center">
                {thumbs}
            </div>

            <div className={`modal ${modal && 'd-block'}`} tabIndex="-1" aria-hidden="true">
                <div className="modal-dialog modal-fullscreen modal-dialog-scrollable">
                    <div className="modal-content">
                        <div className="modal-header px-4">
                            <h3 className="modal-title" id="exampleModalLabel">Фото</h3>
                            <button type="button" className="btn-close"
                                onClick={() => setModal(false)}/>
                        </div>
                        <div className="modal-body text-center">
                            <div className="d-flex justify-content-center">
                                {thumbs}
                            </div>
                            <div className="mt-2">
                                <img className="w-100"
                                    src={props.images[active]}
                                    alt={props.images[active]}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ProductImages;
