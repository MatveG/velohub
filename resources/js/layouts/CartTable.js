import React from "react";

export default (props) => {
    return (
        <div>
            <div className="table-responsive p-3">
                <table className="table text-center">
                    <thead>
                        <tr className="border border-left-0 border-right-0">
                            <th scope="col" className="border-0">
                                <div className="py-2 text-uppercase">Удалить</div>
                            </th>
                            <th scope="col" className="border-0">
                                <div className="p-2 px-3 text-uppercase">Наименование</div>
                            </th>
                            <th scope="col" className="border-0">
                                <div className="py-2 text-uppercase">Цена</div>
                            </th>
                            <th scope="col" className="border-0">
                                <div className="py-2 text-uppercase">Кол-во</div>
                            </th>
                            <th scope="col" className="border-0">
                                <div className="py-2 text-uppercase">Сумма, ₴</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {props.children}

                        <tr className="border border-left-0 border-right-0">
                            <td className="border-0 align-middle text-right text-uppercase" colSpan="4">
                                <strong>Итого:</strong></td>
                            <td className="border-0 align-middle"><strong>{props.total}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div className="text-center">
                <button className="btn btn-gray border" data-dismiss="modal">Продолжить покупки</button>
                <a href="" className="btn btn-bright border">Оформить заказ</a>
            </div>
        </div>
    );
}
