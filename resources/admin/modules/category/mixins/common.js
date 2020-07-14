
import {required, requiredIf, minLength} from "vuelidate/lib/validators";
import SortedCollection from "@/services/SortedCollection";

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
            method: null,
            item: {},
            collection: new SortedCollection(this.propItems),
        }
    },

    computed: {
        items: function() {
            return this.collection.all();
        },
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
                    return this.item.type === 'select';
                }),
                minLength: minLength(1),
            }
        },
    },

    methods: {
        add() {
            this.cancel();
            this.method = 'add';
        },

        edit() {
            this.cancel();
            this.method = 'edit';
        },

        save() {
            if (this.validate() && this.unique()) {
                if (this.method === 'add') {
                    this.collection.push(this.item);
                } else {
                    this.collection.put(this.item.id, this.item);
                }

                this.$emit('update', this.items);
                this.cancel();
            }
        },

        unique() {
            if (this.collection.find(el => el.title === this.item.title && el.id !== this.item.id)) {
                this.toast('Уже есть запись с таким Именем');

                return false;
            }

            return true;
        },

        assign(row, property, value) {
            this.collection.update(row.id, {[property]: value});
            this.$emit('update', this.items);
        },

        remove(row) {
            this.confirm('Удалить?', () => {
                this.collection.remove(row.id);
                this.$emit('update', this.items);
                this.cancel();
            });
        },

        cancel() {
            this.$v.$reset();
            this.method = null;
            this.item = {};
        },

        reset() {
            this.item.reset();
        },

        drop(payload) {
            this.dragdrop(payload);

            if (Object.keys(this.item).length) {
                return false;
            }

            if (payload.row && this.draggingRow && payload.row.ord !== this.draggingRow.ord) {
                this.collection
                    .update(payload.row.id, {ord: this.draggingRow.ord})
                    .update(this.draggingRow.id, {ord: payload.row.ord});

                this.$refs.table.initSort();
                this.$emit('update', this.items);
            }
        },
    }
};

