
import axios from 'axios';

const PRODUCT_BLANK = {
    images: [],
    variants: [],
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
        resetProduct(state) {
            state.product = {...PRODUCT_BLANK};
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

        //
        assignVariant(state, payload) {
            state.variant = payload;
        },

        updateVariant(state, payload) {
            Object.assign(state.variant, payload);

            if (state.product.variants.find(el => el.id === payload.id)) {
                state.product.variants = state.product.variants.map(el => el.id === payload.id ? payload : el);
            } else {
                state.product.variants.push(payload);
            }
        },

        deleteVariant(state, payload) {
            state.product.variants = state.product.variants.filter(el => el !== payload);
        }
    },

    actions: {
        async fetchProducts(context) {
            const res = await axios.get('/admin/products');
            context.commit('assignProducts', res.data);
        },

        async fetchProduct(context, payload) {
            const res = await axios.get(`/admin/products/${payload.id}`);
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

        async storeVariant(context, payload) {
            const res = await axios.post(`/admin/variants`, payload);
            context.commit('updateVariant', res.data);
        },

        async patchVariant(context, payload) {
            const res = await axios.patch(`/admin/variants/${payload.id}`, payload);
            context.commit('updateVariant', res.data);
        },

        async destroyVariant(context, payload) {
            await axios.delete(`/admin/variants/${payload.id}`);
            context.commit('deleteVariant', payload);
        },
    },
};
