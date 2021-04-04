import React from 'react';
import {formatAsPrice} from '../utils/formatAs';

const CartTable = (props) => {
    return (
        <table className="table text-center">
            <thead>
                <tr className="border border-left-0 border-right-0">
                    <th scope="col" className="border-0"/>
                    <th scope="col" className="border-0">
                        <span className="p-2">Наименование</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Цена</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Шт</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Сумма</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                {props.children}

                <tr className="border border-left-0 border-right-0">
                    <td className="border-0 align-middle text-right" colSpan="4">
                        <strong>Итого:</strong>
                    </td>
                    <td className="border-0 align-middle">
                        <strong>{formatAsPrice(props.total)}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    );
};

export default CartTable;

