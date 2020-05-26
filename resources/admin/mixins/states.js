
export const states = {
    data () {
        return {
            loading: false,
            saved: true,
        }
    },

    methods: {
        stateDraft() {
            this.saved = false;
        },

        stateLoading() {
            this.saved = false;
            this.loading = true;
        },

        stateSaved() {
            this.saved = true;
            this.loading = false;
        },
    }
};
