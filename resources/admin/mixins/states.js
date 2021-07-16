
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

            return this;
        },

        stateLoading() {
            this.saved = false;
            this.loading = true;

            return this;
        },

        stateSaved() {
            this.saved = true;
            this.loading = false;

            return this;
        },
    }
};
