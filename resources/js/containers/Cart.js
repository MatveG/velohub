import React from 'react';
import {connect} from 'react-redux';
import CartTable from '../components/CartTable';
import CartProduct from '../components/CartProduct';
import {cartFetch, cartProductUpdate, cartProductDetach} from '../actions/cart';
import {formatAsPrice} from '../utils/formatAs';

class Cart extends React.Component {
    constructor(props) {
        super(props);

        this.updateAmount = this.updateAmount.bind(this);
        this.removeProduct = this.removeProduct.bind(this);
    }

    componentDidMount() {
        if (!this.props.pending) {
            this.props.cartFetch();
        }
    }

    updateAmount(product, mod) {
        if (product.amount + mod > 0) {
            this.props.updateProduct({...product, amount: product.amount + mod});
        }
    };

    removeProduct(product) {
        this.props.removeProduct(product);
    };

    render() {
        if (!this.props.products.length) {
            return (
                <div className="text-center">
                    <i>Здесь пока еще пусто</i>
                </div>
            );
        }

        const cartProducts = this.props.products.map((el, idx) => (
            <CartProduct
                key={idx}
                product={el}
                updateAmount={this.updateAmount}
                removeProduct={this.removeProduct}
                readOnly={this.props.readOnly} />
        ));

        return (
            <CartTable>
                {cartProducts}

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
            </CartTable>
        );
    }
}

const mapState = ({cart}) => ({
    pending: cart.pending,
    products: cart.products,
    total: cart.products.reduce((total, el) => total + el.amount * el.price, 0),
});

const mapActions = (dispatch) => ({
    cartFetch: () => dispatch(cartFetch()),
    updateProduct: (product) => dispatch(cartProductUpdate(product)),
    removeProduct: (product) => dispatch(cartProductDetach(product)),
});

export default connect(mapState, mapActions)(Cart);
