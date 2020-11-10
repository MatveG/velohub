
import axios from 'axios';

export default {
    state: {
        settings: {},
    },

    getters: {
        settings: state => (group, key) => state.settings[group] ? state.settings[group][key] : {},
    },

    mutations: {
        assignSettings(state, payload) {
            state.settings = payload;
        },
    },

    actions: {
        async fetchSettings(context) {
            const res = await axios.get('/admin/settings');
            context.commit('assignSettings', res.data);
        },
    },
};
