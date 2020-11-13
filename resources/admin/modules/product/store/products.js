import axios from 'axios';

const PRODUCT_BLANK = {
    images: [],
    features: {}
};

export default {
    state: {
        product: PRODUCT_BLANK,
        products: [],
    },

    getters: {
        product: state => state.product,

        products: state => state.products,
    },

    mutations: {
        SET_PRODUCT(state, payload) {
            state.product = payload;
        },

        ASSIGN_PRODUCT(state, payload) {
            Object.assign(state.product, payload);
        },

        SET_PRODUCTS(state, payload) {
            state.products = payload;
        },

        PUSH_TO_PRODUCTS(state, payload) {
            state.products.push(payload);
        },

        REMOVE_FROM_PRODUCTS(state, id) {
            state.products = state.products.filter(el => el.id !== id);
        },
    },

    actions: {
        async resetProduct(context) {
            context.commit('SET_PRODUCT', PRODUCT_BLANK);
        },

        async fetchProducts(context) {
            const res = await axios.get('/admin/products');
            context.commit('SET_PRODUCTS', res.data);
        },

        async fetchProduct(context, id) {
            let product = context.state.products.find(el => el.id === id);

            if(!product) {
                const res = await axios.get(`/admin/products/${id}`);
                product = res.data;
            }
            context.commit('SET_PRODUCT', product);
        },

        async storeProduct(context, payload) {
            const res = await axios.post(`/admin/products`, payload);
            if(res.status === 200) {
                context.commit('PUSH_TO_PRODUCTS', res.data);
            }
        },

        async patchProduct(context, payload) {
            const res = await axios.patch(`/admin/products/${payload.id}`, payload);
            if(res.status === 200) {
                context.commit('ASSIGN_PRODUCT', res.data);
            }
        },

        async destroyProduct(context, id) {
            const res = await axios.delete(`/admin/products/${id}`);
            if(res.status === 200) {
                context.commit('REMOVE_FROM_PRODUCTS', id);
            }
        },
    },
};
