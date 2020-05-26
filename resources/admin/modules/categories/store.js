
import axios from 'axios';

export default {
    actions: {
        fetchCategories(context) {
            axios
                .get(`/admin/categories/`)
                .then((res) => context.commit('assignAll', res.data))
                .catch((error) => console.log(error));
        },

        fetchCategory(context, id) {
            axios
                .get(`/admin/categories/${id}/edit/`)
                .then((res) => context.commit('assignOne', res.data))
                .catch((error) => console.log(error));
        },

        storeCategory() {
            axios
                .post(`/admin/categories/store`, context.state.category)
                .then((res) => context.commit('updateOne', res.data))
                .catch((error) => console.log(error));
        },

        saveCategory(context, payload) {
            context.commit('updateOne', payload);
            axios.post(`/admin/categories/${payload.id}/update`, payload).catch((error) => console.log(error));
        }
    },

    mutations: {
        assignOne(state, value) {
            state.category = value;
        },

        updateOne(state, value) {
            state.category = Object.assign(state.category, value);
        },

        assignAll(state, value) {
            state.categories = value;
        }
    },

    state: {
        category: {
            images: [],
            features: [],
            parameters: [],
        },

        categories: [],
    },

    getters: {
        getCategory: state => state.category,

        getCategories: state => state.categories,

        getWhere: state => (prop, val) => state.categories.find(el => el[prop] === val),
    },
};
