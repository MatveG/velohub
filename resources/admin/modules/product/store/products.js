import axios from 'axios';

const BLANK_PRODUCT = {
    features: {},
    variants: [],
    images: []
};

export default {
    state: {
        product: BLANK_PRODUCT,
        products: [],
    },

    getters: {
        product: (state, getters) => {
            state.product.category = getters.getCategoryById(state.product.category_id);
            state.product.variants = getters.variants;
            return state.product;
        },

        products: state => state.products,
    },

    mutations: {
        PRODUCT_SET(state, payload) {
            state.product = payload;
        },

        PRODUCT_ASSIGN(state, payload) {
            Object.assign(state.product, payload);
        },

        PRODUCTS_SET(state, payload) {
            state.products = payload;
        },

        PRODUCTS_PUSH(state, payload) {
            state.products.push(payload);
        },

        PRODUCTS_REMOVE(state, id) {
            state.products = state.products.filter(el => el.id !== id);
        },
    },

    actions: {
        async resetProduct(context) {
            context.commit('PRODUCT_SET', {...BLANK_PRODUCT});
        },

        async fetchProduct(context, id) {
            let product = context.state.products.find(el => el.id === id);

            if(!product) {
                const res = await axios.get(`/admin/products/${id}`);
                product = res.data;
            }

            context.commit('PRODUCT_SET', {...product});
        },

        async storeProduct(context, payload) {
            const res = await axios.post(`/admin/products`, payload);

            if(res.status === 200) {
                context.commit('PRODUCTS_PUSH', res.data);
            }

            return res.data;
        },

        async patchProduct(context, payload) {
            const res = await axios.patch(`/admin/products/${payload.id}`, payload);
            if(res.status === 200) {
                context.commit('PRODUCT_ASSIGN', res.data);
            }
        },

        async fetchProducts(context, force = false) {
            if(force || !context.state.products.length) {
                const res = await axios.get('/admin/products');
                context.commit('PRODUCTS_SET', res.data);
            }
        },

        async destroyProduct(context, id) {
            const res = await axios.delete(`/admin/products/${id}`);
            if(res.status === 200) {
                context.commit('PRODUCTS_REMOVE', id);
            }
        }
    },
};
