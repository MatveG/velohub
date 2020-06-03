
import axios from 'axios';

export default {
    state: {
        category: {
            images: [],
            features: [],
            parameters: [],
        },

        categories: [],
    },

    getters: {
        category: state => state.category,

        categories: state => state.categories,
    },

    mutations: {
        assignCategories(state, payload) {
            state.categories = payload;
        },

        assignCategory(state, payload) {
            state.category = payload;
        },

        updateCategory(state, payload) {
            state.category = Object.assign(state.category, payload);
        },

        deleteCategory(state, payload) {
            state.categories = state.categories.filter(el => el !== payload);
        }
    },

    actions: {
        fetchCategories(context) {
            axios
                .get(`/admin/categories/`)
                .then((res) => context.commit('assignCategories', res.data))
                .catch((error) => console.log(error));
        },

        fetchCategory(context, id) {
            axios
                .get(`/admin/categories/${id}`)
                .then((res) => context.commit('assignCategory', res.data))
                .catch((error) => console.log(error));
        },

        storeCategory(context, payload) {
            axios
                .post(`/admin/categories/store`, payload)
                .then((res) => context.commit('updateCategory', res.data))
                .catch((error) => console.log(error));
        },

        patchCategory(context, payload) {
            axios
                .patch(`/admin/categories/${payload.id}`, payload)
                .then((res) => context.commit('updateCategory', res.data))
                .catch((error) => console.log(error));
        },

        destroyCategory(context, payload) {
            axios
                .delete(`/admin/categories/${payload.id}`)
                .then(() => context.commit('deleteCategory', payload))
                .catch((error) => console.log(error));
        }
    },
};
