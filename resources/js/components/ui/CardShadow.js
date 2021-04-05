import React from 'react';

const CardShadow = (props) => {
    return (
        <div className="card shadow-sm">
            <div className="card-body">
                {props.children}
            </div>
        </div>
    );
};

export default CardShadow;
