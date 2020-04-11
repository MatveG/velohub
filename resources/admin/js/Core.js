
import { ToastProgrammatic as Toast } from 'buefy'
import { DialogProgrammatic as Dialog } from 'buefy'

export default new class Core {
    error(message) {
        Toast.open({
            message: message,
            type: 'is-danger',
            queue: false
        });
    }

    ajaxError(response) {
        this.error(`Error ${response.status}: ${response.data.error}`);
        console.log(response);
    }


    // formatPrice(value) {
    //     let val = (value/1).toFixed(2).replace('.', ',')
    //     return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
    // }

    confirm(message, callback) {
        Dialog.confirm({
            message: message,
            confirmText: 'Да',
            cancelText: 'Нет',
            onConfirm: () => callback()
        });
    }

    banDecimal(event) {
        event = (event) ? event : window.event;
        let code = (event.which) ? event.which : event.keyCode;

        if (code === 46) {
            event.preventDefault();
        }
    }
}
