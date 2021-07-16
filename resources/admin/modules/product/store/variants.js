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
        VARIANTS_SET(state, payload) {
            state.variants = payload;
        },

        VARIANTS_REMOVE(state, payload) {
            state.variants = state.variants.filter(el => el.id !== payload.id);
        },

        VARIANT_ADD(state, payload) {
            state.variants.push(payload);
        },

        VARIANT_UPDATE(state, payload) {
            state.variants = state.variants.map(el => el.id === payload.id ? payload : el);
        },
    },

    actions: {
        async fetchVariants(context, productId) {
            const res = await axios.get(`/admin/variants/${productId}`);
            if(res.status === 200) {
                context.commit('VARIANTS_SET', res.data);
            }
        },

        async storeVariant(context, payload) {
            const res = await axios.post(`/admin/variants/${payload.product_id}`, payload);
            if(res.status === 200) {
                context.commit('VARIANT_ADD', res.data);
            }
        },

        async patchVariant(context, payload) {
            const res = await axios.patch(`/admin/variants/${payload.id}`, payload);
            if(res.status === 200) {
                context.commit('VARIANT_UPDATE', res.data);
            }
        },

        async destroyVariant(context, payload) {
            const res = await axios.delete(`/admin/variants/${payload.id}`);
            if(res.status === 200) {
                context.commit('VARIANTS_REMOVE', payload);
            }
        },
    },
};
