
import axios from 'axios';

export default {
    state: {
        settings: {},
    },

    getters: {
        settings: state => (group, key) => state.settings[group] ? state.settings[group][key] || null : {},
    },

    mutations: {
        assignSettings(state, payload) {
            state.settings = payload;
        },
    },

    actions: {
        async setSettings(context, settings) {
            try {
                settings = JSON.parse(settings);
            } catch (e) {} // not a json string

            context.commit('assignSettings', settings);
        },

        async fetchSettings(context) {
            const res = await axios.get('/admin/settings');
            context.commit('assignSettings', res.data);
        },
    },
};
