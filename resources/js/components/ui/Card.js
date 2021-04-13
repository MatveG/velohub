import React from 'react';

const Card = (props) => {
    return (
        <div className={`card ${!!props.classes && props.classes.join(' ')}`}>
            <div className="card-body">
                {props.children}
            </div>
        </div>
    );
};

export default Card;
