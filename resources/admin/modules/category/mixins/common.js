
import Vue from "vue";
import {required, requiredIf, minLength} from "vuelidate/lib/validators";

export const common = {
    props: {
        propItems: {
            type: [Array, String],
            default: () => []
        },

        propSub: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            items: this.propItems,
            item: {},
            index: null,
        }
    },

    validations: {
        item: {
            title: {
                required,
                minLength: minLength(2)
            },

            type: {
                required,
            },

            values: {
                required: requiredIf(function () {
                    return this.item.type === 'select' || this.item.type === 'multiple';
                }),
                minLength: minLength(1),
            }
        },
    },

    methods: {
        save() {
            if (this.validate() && this.uniqueTitle()) {
                if (this.index === null) {
                    this.items.push(this.item);
                } else {
                    this.items = this.items.map((el, i) => el = i === this.index ? this.item : el);
                }

                this.$emit('update', this.items);
                this.cancel();
            }
        },

        assign(index, property, value) {
            this.items[index][property] = value;
            this.$emit('update', this.items);
        },

        remove(index) {
            this.confirm('Удалить?', () => {
                this.items.splice(index, 1);
                this.$emit('update', this.items);
                this.cancel();
            });
        },

        cancel() {
            this.$v.$reset();
            this.index = null;
            this.item = {};
        },

        drop(payload) {
            this.dragdrop(payload);

            if (this.hasOpen()) {
                return false;
            }

            let [indexOne, indexTwo] = [payload.index, this.draggingRowIndex];

            if (indexOne && indexTwo && indexOne !== indexTwo) {
                let temp = this.items[indexTwo];

                Vue.set(this.items, indexTwo, this.items[indexOne]);
                Vue.set(this.items, indexOne, temp);

                this.$refs.table.initSort();
                this.$emit('update', this.items);
            }
        },

        uniqueTitle() {
            if (this.items.find(el => el.title === this.item.title && el.id !== this.item.id)) {
                this.toast('Уже есть запись с таким Именем');

                return false;
            }

            return true;
        },

        hasOpen() {
            return !!Object.keys(this.item).length;
        },
    }
};

