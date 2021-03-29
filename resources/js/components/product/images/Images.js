import React, {useState} from 'react';

const Images = (props) => {
    const [active, setActive] = useState(0);

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
                    data-bs-toggle="modal"
                    data-bs-target="#product-image-modal"
                    src={props.images[active]}
                    alt={props.images[active]}/>
            </div>

            <div className="mt-2 d-flex justify-content-center">
                {thumbs}
            </div>

            <div className="modal overflow-scroll" id="product-image-modal" tabIndex="-1" aria-hidden="true">
                <div className="modal-dialog modal-fullscreen modal-dialog-scrollable w-75 m-auto">
                    <div className="modal-content">
                        <div className="modal-header px-4">
                            <h3 className="modal-title" id="exampleModalLabel">Фото</h3>
                            <button type="button" className="btn-close" data-bs-dismiss="modal"/>
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

export default Images;
