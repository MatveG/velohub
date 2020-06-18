
import axios from 'axios';

const BLANK = {
    parent_id: 0,
    images: [],
    features: [],
    parameters: [],
};

export default {
    state: {
        category: BLANK,

        categories: [],
    },

    getters: {
        category: state => state.category,

        categories: state => state.categories,

        categoriesParent: state => [
            { id: 0, title: '[root]' },
            ...state.categories.filter(el => el.is_parent)
        ],
    },

    mutations: {
        resetCategory(state) {
            state.category = {...BLANK};
        },

        assignCategory(state, payload) {
            state.category = payload;
        },

        updateCategory(state, payload) {
            Object.assign(state.category, payload);
        },

        assignCategories(state, payload) {
            state.categories = payload;
        },
    },

    actions: {
        async fetchCategories(context) {
            const res = await axios.get('/admin/categories');
            context.commit('assignCategories', res.data);
        },

        async fetchCategory(context, id) {
            const res = await axios.get(`/admin/categories/${id}`);
            context.commit('assignCategory', res.data);
        },

        async storeCategory(context, payload) {
            const res = await axios.post(`/admin/categories`, payload);
            context.commit('updateCategory', res.data);
        },

        async patchCategory(context, payload) {
            const res = await axios.patch(`/admin/categories/${payload.id}`, payload);
            context.commit('updateCategory', res.data);
        },

        async destroyCategory(context, payload) {
            await axios.delete(`/admin/categories/${payload.id}`);
            const res = await axios.get(`/admin/categories`);
            context.commit('assignCategories', res.data);
        },
    },
};
