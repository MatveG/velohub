
import axios from 'axios';

const BLANK = {
    parent_id: 0,
    images: [],
    features: [],
    parameters: [],
};

const parentsList = (items) => {
    return items.reduce((acc, el) => {
        if(el.is_parent) {
            acc.push(el);
        }
        if(el.child.length) {
            acc = [...acc, ...parentsList(el.child)];
        }

        return acc;
    }, []);
};

export default {
    state: {
        category: BLANK,
        categories: [],
    },

    getters: {
        category: state => state.category,

        categories: state => state.categories,

        parentCategories: state => parentsList(state.categories),
    },

    mutations: {
        resetCategory(state) {
            state.category = BLANK;
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

        removeFromCategories(state, payload) {
            state.categories = state.categories.filter(el => el !== payload);
        },
    },

    actions: {
        fetchCategories(context) {
            axios
                .get(`/admin/categories`)
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
                .post(`/admin/categories`, payload)
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
                .then(() => context.commit('removeFromCategories', payload))
                .catch((error) => console.log(error));
        },
    },
};
