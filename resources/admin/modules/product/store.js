
import axios from 'axios';

const PRODUCT_BLANK = {
    images: [],
    variants: [],
    features: {}
};

export default {
    state: {
        product: PRODUCT_BLANK,
        products: [],
        variant: {},
    },

    getters: {
        product: state => state.product,
        products: state => state.products,
        variant: state => state.variant,
    },

    mutations: {
        ASSIGN_PRODUCT(state, payload) {
            state.product = payload;
        },

        UPDATE_PRODUCT(state, payload) {
            Object.assign(state.product, payload);

            // update products if the product is within
        },

        ASSIGN_PRODUCTS(state, payload) {
            state.products = payload;
        },

        ASSIGN_VARIANT(state, payload) {
            state.variant = payload;
        },

        UPDATE_VARIANT(state, payload) {
            Object.assign(state.variant, payload);

            if (state.product.variants.find(el => el.id === payload.id)) {
                state.product.variants = state.product.variants.map(el => el.id === payload.id ? payload : el);
            } else {
                state.product.variants.push(payload);
            }
        },

        DELETE_VARIANT(state, payload) {
            state.product.variants = state.product.variants.filter(el => el !== payload);
        }
    },

    actions: {
        resetProduct(context) {
            context.commit('ASSIGN_PRODUCT', PRODUCT_BLANK);
        },

        async fetchProducts(context) {
            const res = await axios.get('/admin/products');
            context.commit('ASSIGN_PRODUCTS', res.data);
        },

        async fetchProduct(context, payload) {
            const res = await axios.get(`/admin/products/${payload.id}`);
            context.commit('ASSIGN_PRODUCT', res.data);
        },

        async storeProduct(context, payload) {
            const res = await axios.post(`/admin/products`, payload);
            context.commit('UPDATE_PRODUCT', res.data);
        },

        async patchProduct(context, payload) {
            const res = await axios.patch(`/admin/products/${payload.id}`, payload);
            context.commit('UPDATE_PRODUCT', res.data);
        },

        async destroyProduct(context, payload) {
            await axios.delete(`/admin/products/${payload.id}`);
            const res = await axios.get(`/admin/products`);
            context.commit('ASSIGN_PRODUCTS', res.data);
        },

        async storeVariant(context, payload) {
            const res = await axios.post(`/admin/variants`, payload);
            context.commit('UPDATE_VARIANT', res.data);
        },

        async patchVariant(context, payload) {
            const res = await axios.patch(`/admin/variants/${payload.id}`, payload);
            context.commit('UPDATE_VARIANT', res.data);
        },

        async destroyVariant(context, payload) {
            await axios.delete(`/admin/variants/${payload.id}`);
            context.commit('DELETE_VARIANT', payload);
        },
    },
};
