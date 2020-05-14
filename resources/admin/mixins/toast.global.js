import Vue from "vue";
import {ToastProgrammatic as Toast} from "buefy";

Vue.mixin({
    methods: {
        toast(message, style = 'is-danger') {
            Toast.open({
                message: message,
                type: style,
                queue: false
            });
        }
    }
});
