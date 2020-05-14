import Vue from "vue";
import {DialogProgrammatic as Dialog} from "buefy";

Vue.mixin({
    methods: {
        confirm(message, callback) {
            Dialog.confirm({
                message: message,
                confirmText: 'Да',
                cancelText: 'Нет',
                onConfirm: () => callback()
            });
        }
    }
});
