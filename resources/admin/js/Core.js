
import { ToastProgrammatic as Toast } from 'buefy'

export default new class Core {
    error(message) {
        Toast.open({
            message: message,
            type: 'is-danger',
            queue: false
        });
    }

    axiosError(response) {
        console.log(response);
        this.error('Error ' + response.status + ': ' + response.data.error);
    }

    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
    }

    banDecimal(event) {
        event = (event) ? event : window.event;
        let code = (event.which) ? event.which : event.keyCode;

        if (code === 46) {
            event.preventDefault();
        }
    }
}
