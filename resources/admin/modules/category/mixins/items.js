
import SortedCollection from "@/services/SortedCollection";

export const items = {
    props: {
        propItems: {
            type: Array,
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
            coll: new SortedCollection(this.propItems),
        }
    },

    computed: {
        items: function() {
            return this.coll.all();
        },
    },

    methods: {
        add() {
            this.cancel();
            this.method = 'add';
            // this.item = {...this.blank};
        },

        edit() {
            this.cancel();
            this.method = 'edit';
            // this.item = row;
        },

        save() {
            if (this.validate()) {
                if (this.method === 'add') {
                    this.coll.push(this.item);
                } else {
                    this.coll.put(this.item.id, this.item);
                }

                this.$emit('update', this.items);
                this.cancel();
            }
        },

        assign(row, property, value) {
            this.coll.update(row.id, {[property]: value});
            this.$emit('update', this.items);
        },

        remove(row) {
            this.confirm('Удалить?', () => {
                this.coll.remove(row.id);
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
                this.coll
                    .update(payload.row.id, {ord: this.draggingRow.ord})
                    .update(this.draggingRow.id, {ord: payload.row.ord});

                this.$refs.table.initSort();
                this.$emit('update', this.items);
            }
        },
    }
};

