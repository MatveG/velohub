import React from 'react';

const Loader = (props) => {
    return (
        <div className="loader" style={{display: props.active ? 'block' : 'none'}}>
            <div className="line">
                <div className="bar" />
            </div>
        </div>
    );
};

export default Loader;
