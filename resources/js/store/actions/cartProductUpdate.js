import cartPatch from './cartPatch';

export default function cartProductUpdate(product) {
    return (dispatch, getState) => {
        const state = getState();

        const products = state.products.map((el) => {
            return el.id === product.id ? {...product} : el;
        })

        dispatch(cartPatch(products));
    }
}
