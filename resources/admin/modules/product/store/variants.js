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
        VARIANTS_ASSIGN(state, payload) {
            state.variants = payload;
        },

        VARIANT_ADD(state, payload) {
            state.product.variants.push(payload);
        },

        VARIANT_UPDATE(state, payload) {
            state.product.variants = state.product.variants.map(el => el.id === payload.id ? payload : el);
        },

        VARIANTS_REMOVE(state, payload) {
            state.product.variants = state.product.variants.filter(el => el !== payload);
        }
    },

    actions: {
        async fetchVariants(context, payload) {
            const res = await axios.get(`/admin/variants/${payload.product_id}`);
            context.commit('VARIANTS_ASSIGN', res.data);
        },

        async fetchVariant(context, id) {
            // const res = await axios.get(`/admin/variants/${payload.product_id}`);
            // context.commit('ASSIGN_VARIANTS', res.data);
            console.log(id);
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
