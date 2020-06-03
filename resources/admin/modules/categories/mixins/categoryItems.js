
import Collection from "@/services/Collection";

export const categoryItems = {
    props: {
        propItems: {
            type: Array,
            default: () => []
        },
    },

    data() {
        return {
            method: null,
            item: {},
            collection: new Collection(),
        }
    },

    computed: {
        items: function() {
            return this.collection.all();
        },
    },

    mounted() {
        this.collection.collect(this.propItems);
    },

    methods: {
        add() {
            this.cancel();
            this.method = 'add';
            this.item = {...this.blank};
        },

        edit(row) {
            this.cancel();
            this.method = 'edit';
            this.item = row;
        },

        save() {
            if (this.validate()) {
                (this.method === 'add') ? this.collection.push(this.item) : this.collection.put(this.item.index, this.item);
                this.$emit('update', this.items);
                this.cancel();
            }
        },

        remove(row) {
            this.confirm('Удалить?', () => {
                this.collection.remove(row.index);
                this.$emit('update', this.items);
                this.cancel();
            });
        },

        assign(row, property, value) {
            this.collection.update(row.index, {[property]: value});
            this.$emit('update', this.items);
        },

        cancel() {
            this.$v.$reset();
            this.method = null;
            this.item = {};
        },

        reset() {
            Object.assign(this.item, this.blank)
        },

        drop(payload) {
            this.dragdrop(payload);

            if (Object.keys(this.item).length) {
                return false;
            }

            if (payload.row && this.draggingRow && payload.row.sorting !== this.draggingRow.sorting) {
                this.collection
                    .update(payload.row.index, {sorting: this.draggingRow.sorting})
                    .update(this.draggingRow.index, {sorting: payload.row.sorting});

                this.$refs.table.initSort();
                this.$emit('update', this.items);
            }
        },
    }
};
