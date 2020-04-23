<template>
    <b-table class="table-valign-center" :class="(recursive) ? 'table-hide-header' : ''"
             ref="table"
             :data='items'
             default-sort="sorting"
             custom-row-key="sorting"
             icon-pack="fa"
             striped
             hoverable
             draggable
             @dragstart="dragstart"
             @drop="drop"
             @dragover="dragover"
             @dragleave="dragleave"
             detailed
             detail-key="id"
             custom-detail-row
             :opened-detailed="openedDetails"
             @sort="openedDetails = []">

        <template slot-scope="props">
            <b-table-column field="sorting" label="" width="10%" sortable centered>
                {{ props.row.sorting }}
            </b-table-column>

            <b-table-column field="child.length" label="Родительская" width="10%" sortable centered>
                <span v-if="props.row.is_parent" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                </span>
            </b-table-column>

            <b-table-column field="id" label="Изображение" width="20%" centered class="has-text-centered">
                <div style="margin: auto">
                <figure class="image is-96x96">
                    <img v-if="props.row.images.length" :src="props.row.images[0]" alt="" class="rounded category-image">
                </figure>
                </div>
            </b-table-column>

            <b-table-column field="title" label="Название категории" width="30%" searchable>
                {{ props.row.title }}
            </b-table-column>

            <b-table-column field="is_active" label="Активна" width="10%" sortable centered>
                <b-checkbox v-model="props.row.is_active" @change.native="update(props.row)" :class="(recursive) ? 'is-small' : ''" />
            </b-table-column>

            <b-table-column custom-key="actions" width="20%" class="is-actions-cell">
                <button @click="$router.push({ name:'category.edit', params: { id: props.row.id } })" class="button fas fa-pen" />
                <button @click="destroy(props.row)" type="button" class="button fas fa-trash-alt" :class="(recursive) ? 'is-small' : ''" />
            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
            <tr>
                <td colspan="7">
                    <category-table v-if="props.row.child" :prop-items="props.row.child" :recursive="true" />
                </td>
            </tr>
        </template>
    </b-table>
</template>

<script>
    import axios from 'axios';
    import draggable from 'vuedraggable';
    import core from "./../js/Core";
    import CardComponent from "../components/CardComponent";
    import CategoryTable from "../components/CategoryTable";

    export default {
        name: 'CategoryTable',

        components: { draggable, CardComponent, CategoryTable },

        props: [ 'propItems', 'recursive'],

        data () {
            return {
                items: [],
                checked: [],
                openedDetails: [],
                paginated: false,
                perPage: 15,
                paginate: true,
                loading: false,
            }
        },

        mounted () {
            this.items = this.propItems;
            this.paginated = !this.recursive && this.perPage < this.items.length;
        },

        methods: {
            // toggle(row) {
            //     this.openedDetails = [];
            //     this.qwe = row.child;
            //     this.openedDetails = [row.id];
            // },
            // edit(item) {
            //     this.$router.push({ name:'product.edit', params: { id: item.id } });
            // }
            update(item) {
                this.loading = true;
                axios.post(`/admin/categories/${item.id}/update`, item)
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.loading = false);
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.items = this.items.filter((each) => each.id !== item.id);
                    this.items.map((each) => each.sorting = (each.sorting > item.sorting) ? --each.sorting : each.sorting);

                    axios.post(`/admin/categories/${item.id}/destroy`)
                        .catch((error) => core.ajaxError(error.response))
                });
            },


            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row.sorting === this.draggingRow.sorting) {
                    return;
                }
                [payload.row.sorting, this.draggingRow.sorting] = [this.draggingRow.sorting, payload.row.sorting];
                this.$refs.table.initSort();
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
    }
</script>

<style scoped>
    .table-hide-header .table thead tr:first-child {
        display: none;
    }
    .table-hide-header .table thead input {
        display: none;
    }
    .category-image {
        width: 1%;
    }
</style>
