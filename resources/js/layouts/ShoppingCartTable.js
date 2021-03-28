import React from 'react';

const ShoppingCartTable = (props) => (
    <table className="table text-center">
        <thead>
            <tr className="border border-left-0 border-right-0">
                <th scope="col" className="border-0"></th>
                <th scope="col" className="border-0">
                    <span className="p-2">Наименование</span>
                </th>
                <th scope="col" className="border-0">
                    <span className="py-2">Цена</span>
                </th>
                <th scope="col" className="border-0">
                    <span className="py-2">шт</span>
                </th>
                <th scope="col" className="border-0">
                    <span className="py-2">Сумма</span>
                </th>
            </tr>
        </thead>
        <tbody>
            {props.children}
        </tbody>
    </table>
);

export default ShoppingCartTable;

