import React from "react";
import {connect} from 'react-redux';
import CartTable from '../layouts/CartTable';
import CartProduct from './CartProduct';
import cartApiFetch from '../store/actions/cartApiFetch';

class Cart extends React.Component {
    componentDidMount() {
        this.props.fetchCartData();
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
            <CartTable total={this.props.total}>
                {this.props.products.map((el, idx) => <CartProduct key={idx} product={el}/>)}
            </CartTable>
        );
    }
}

const mapState = ({products}) => ({
    products,
    total: products.reduce((total, el) => total + el.amount * el.price, 0)
});

const mapActions = (dispatch) => ({
    fetchCartData: (uuid) => dispatch(cartApiFetch(uuid))
});

export default connect(mapState, mapActions)(Cart)
