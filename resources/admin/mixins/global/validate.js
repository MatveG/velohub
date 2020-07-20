
import Vue from "vue";

Vue.mixin({
    methods: {
            validate() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                this.toast('Заполните обязательные поля');

                return false;
            }

            return true;
        },
    }
});
