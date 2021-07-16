
export const forceInteger = {
    methods: {
        forceInteger(event) {
            event = (event) ? event : window.event;
            let code = (event.which) ? event.which : event.keyCode;

            if (code === 46) {
                event.preventDefault();
            }
        }
    }
};
