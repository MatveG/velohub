import React from 'react';
import {connect} from 'react-redux';
import ShoppingCartTable from '../layouts/ShoppingCartTable';
import ShoppingCartProduct from './ShoppingCartProduct';
import cartFetch from '../store/actions/cartFetch';

function formatAsPrice(number) {
    return new Intl.NumberFormat('ua-UA').format(number);
};

class ShoppingCart extends React.Component {
    componentDidMount() {
        this.props.cartFetch();
    }

    render() {
        if (!this.props.products.length) {
            return (
                <div className="text-center">
                    <i>Здесь пока еще пусто</i>
                </div>
            );
        }

        return (
            <ShoppingCartTable total={this.props.total}>
                {this.props.products.map((el, idx) => (
                    <ShoppingCartProduct
                        key={idx}
                        product={el}
                        readOnly={this.props.readOnly} />
                ))}

                <tr className="border border-left-0 border-right-0">
                    <td className="border-0 align-middle text-right" colSpan="4">
                        Доставка:
                    </td>
                    <td className="border-0 align-middle">
                        {formatAsPrice(this.props.total)}
                    </td>
                </tr>

                <tr className="border border-left-0 border-right-0">
                    <td className="border-0 align-middle text-right text-uppercase" colSpan="4">
                        <strong>Итого:</strong>
                    </td>
                    <td className="border-0 align-middle">
                        <strong>{formatAsPrice(this.props.total)}</strong>
                    </td>
                </tr>
            </ShoppingCartTable>
        );
    }
};

const mapState = ({cart}) => ({
    products: cart.products,
    total: cart.products.reduce((total, el) => {
        return total + el.amount * el.price;
    }, 0),
});

const mapActions = (dispatch) => ({
    cartFetch: () => dispatch(cartFetch()),
});

export default connect(mapState, mapActions)(ShoppingCart);
