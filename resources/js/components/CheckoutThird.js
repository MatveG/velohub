import React from 'react';
import CardShadow from './ui/CardShadow';

const CheckoutThird = (props) => {
    Object.entries(props.userData).forEach(el => console.log(el));

    return (
        <React.Fragment>
            <h4><span>Получатель</span></h4>
            <CardShadow>
                <div className="text-center">Спасибо</div>

                <table className="table">
                    <tbody>
                        {Object.entries(props.userData).map((el, idx) => (
                            <tr key={idx}>
                                <td>{el[0]}</td>
                                <td>{el[1]}</td>
                            </tr>
                        ))}
                        <tr>
                            <td>Имя</td>
                            <td>{props.userData.name}</td>
                        </tr>

                    </tbody>
                </table>
            </CardShadow>
        </React.Fragment>
    );
};

export default CheckoutThird;
