
import axios from 'axios';

const BLANK = {
    images: [],
    features: {}
};

export default {
    state: {
        product: BLANK,

        products: [],
    },

    getters: {
        product: state => state.product,

        products: state => state.products,
    },

    mutations: {
        resetProduct(state) {
            state.product = {...BLANK};
        },

        assignProduct(state, payload) {
            state.product = payload;
        },

        updateProduct(state, payload) {
            Object.assign(state.product, payload);
        },

        assignProducts(state, payload) {
            state.products = payload;
        },
    },

    actions: {
        async fetchProducts(context) {
            const res = await axios.get('/admin/products');
            context.commit('assignProducts', res.data);
        },

        async fetchProduct(context, id) {
            const res = await axios.get(`/admin/products/${id}`);
            context.commit('assignProduct', res.data);
        },

        async storeProduct(context, payload) {
            const res = await axios.post(`/admin/products`, payload);
            context.commit('updateProduct', res.data);
        },

        async patchProduct(context, payload) {
            const res = await axios.patch(`/admin/products/${payload.id}`, payload);
            context.commit('updateProduct', res.data);
        },

        async destroyProduct(context, payload) {
            await axios.delete(`/admin/products/${payload.id}`);
            const res = await axios.get(`/admin/products`);
            context.commit('assignProducts', res.data);
        },
    },
};
