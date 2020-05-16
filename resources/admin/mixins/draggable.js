
export const draggable = {
    methods: {
        dragdrop(payload) {
            payload.event.target.closest('tr').classList.remove('is-selected');

            if (payload.row.ord !== this.draggingRow.ord) {
                [payload.row.ord, this.draggingRow.ord] = [this.draggingRow.ord, payload.row.ord];
                this.$refs.table.initSort();
            }
        },

        dragstart (payload) {
            this.draggingRow = payload.row;
            this.draggingRowIndex = payload.index;
            payload.event.dataTransfer.effectAllowed = 'copy';
        },

        dragover(payload) {
            payload.event.dataTransfer.dropEffect = 'copy';
            payload.event.target.closest('tr').classList.add('is-selected');
            payload.event.preventDefault();
        },

        dragleave(payload) {
            payload.event.target.closest('tr').classList.remove('is-selected');
            payload.event.preventDefault();
        },
    }
};
