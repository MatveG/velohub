import axios from 'axios';

export default {
    state: {
        variant: {},
        variants: []
    },

    getters: {
        variant: state => state.variant,

        variants: state => state.variants
    },

    mutations: {
        ASSIGN_VARIANTS(state, payload) {
            state.variants = payload;
        },

        ADD_VARIANT(state, payload) {
            state.product.variants.push(payload);
        },

        UPDATE_VARIANT(state, payload) {
            state.product.variants = state.product.variants.map(el => el.id === payload.id ? payload : el);
        },

        DELETE_VARIANT(state, payload) {
            state.product.variants = state.product.variants.filter(el => el !== payload);
        }
    },

    actions: {
        async fetchVariants(context, payload) {
            const res = await axios.get(`/admin/variants/${payload.product_id}`);
            context.commit('ASSIGN_VARIANTS', res.data);
        },

        async storeVariant(context, payload) {
            const res = await axios.post(`/admin/variants/${payload.product_id}`, payload);
            if(res.status === 200) {
                context.commit('UPDATE_VARIANT', res.data);
            }
        },

        async patchVariant(context, payload) {
            const res = await axios.patch(`/admin/variants/${payload.id}`, payload);
            if(res.status === 200) {
                context.commit('UPDATE_VARIANT', res.data);
            }
        },

        async destroyVariant(context, payload) {
            const res = await axios.delete(`/admin/variants/${payload.id}`);
            if(res.status === 200) {
                context.commit('DELETE_VARIANT', payload);
            }
        },
    },
};
