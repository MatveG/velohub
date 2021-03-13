import React from "react";
import {connect} from 'react-redux';
import CartTable from '../layouts/CartTable';
import CartItem from './CartProduct';
import cartFetch from '../store/actions/cartFetch';
import {getCartCookies} from '../utils/cartCookies';

class Cart extends React.Component {
    componentDidMount() {
        console.log(getCartCookies());
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
                {this.props.products.map((el, idx) => <CartItem key={idx} product={el}/>)}
            </CartTable>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        ...state,
        total: state.products.reduce((total, el) => total + el.amount * el.price, 0)
    }
}

const mapActionsToProps = (dispatch) => {
    return {
        fetchCartData: (uuid) => dispatch(cartFetch(uuid))
    };
};

export default connect(mapStateToProps, mapActionsToProps)(Cart)
