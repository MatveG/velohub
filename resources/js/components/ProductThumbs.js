import React from 'react';

const ProductThumbs = (props) => {
    return (
        props.images.map((image, idx) => (
            <div role="button" key={idx} onClick={() => props.handleClick(idx)}>
                <div className="m-1 p-1 border product-thumb">
                    <img className="h-100" role="button" src={image} alt={props.alt} />
                </div>
            </div>
        ))
    );
};

export default ProductThumbs;
