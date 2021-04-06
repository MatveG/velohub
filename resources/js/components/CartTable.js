import React from 'react';
import config from 'react-global-configuration';

const CartTable = (props) => {
    return (
        <table className="table table-hover text-center">
            <thead className="thead-light">
                <tr>
                    <th scope="col"/>
                    <th scope="col">
                        <span className="p-2">Наименование</span>
                    </th>
                    <th scope="col">
                        <span className="py-2">Цена</span>
                    </th>
                    <th scope="col">
                        <span className="py-2">Шт</span>
                    </th>
                    <th scope="col">
                        <span className="py-2">Сумма</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                {props.children}

                <tr>
                    <td className="align-middle text-right" colSpan="4">
                        <strong>Итого:</strong>
                    </td>
                    <td className="align-middle fw-bold">
                        {(+props.totalCost).toLocaleString()} {config.get('currency').sign}
                    </td>
                </tr>
            </tbody>
        </table>
    );
};

export default CartTable;

