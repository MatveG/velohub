import React from 'react';

const ProductThumbs = (props) => {
    return (
        props.images.map((image, idx) => (
            <div
                className="m-1 border product-thumb"
                role="button"
                key={idx}
                onClick={() => props.handleClick(idx)}>
                <img src={image} alt={props.alt} />
            </div>
        ))
    );
};

export default ProductThumbs;
