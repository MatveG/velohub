import React from 'react';
import {connect} from 'react-redux';
import CartTable from '../components/CartTable';
import CartProducts from '../components/CartProducts';
import {cartFetch, cartProductUpdate, cartProductDetach} from '../actions/cart';

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
        return (
            <CartTable shipping={0} total={this.props.total}>
                <CartProducts products={this.props.products}
                    updateAmount={this.updateAmount}
                    removeProduct={this.removeProduct}
                    readOnly={this.props.readOnly} />
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
