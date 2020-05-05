
<template>
    <b-table class="table-valign-center"
             ref="table"
             :data='items'
             :loading="loading"
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
             @sort="openedDetails = []"
             :class="(recursive) ? 'table-hide-header' : ''">

        <template slot-scope="props">
            <b-table-column field="sorting" label="" width="10%" sortable centered>
                {{ props.row.sorting }}
            </b-table-column>

            <b-table-column field="child.length" label="Родительская" width="15%" sortable centered>
                <span v-if="props.row.is_parent" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                </span>
            </b-table-column>

            <b-table-column field="title" label="Название категории" width="45%" searchable>
                {{ props.row.title }}
            </b-table-column>

            <b-table-column field="is_active" label="Активна" width="15%" sortable centered>
                <b-checkbox v-model="props.row.is_active" @change.native="update(props.row)" class="is-small" />
            </b-table-column>

            <b-table-column custom-key="actions" width="15%" centered>
                <button @click="$router.push({ name:'category.edit', params: { id: props.row.id } })" class="button fas fa-pen is-small" />
                <button @click="destroy(props.row)" type="button" class="button fas fa-trash-alt is-small" />
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
                paginated: false,
                perPage: 15,
                loading: false,
                openedDetails: [],
            }
        },

        mounted () {
            this.items = this.propItems;
            this.paginated = !this.recursive && this.perPage < this.items.length;
        },

        methods: {
            update(item) {
                this.loading = true;
                axios.post(`/admin/categories/${item.id}/update`, {
                        id: item.id,
                        is_active: item.is_active,
                        sorting: item.sorting
                    })
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.loading = false);
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.items = this.items.filter((each) => each.id !== item.id);
                    this.items.map((each) => each.sorting = (each.sorting > item.sorting) ? --each.sorting : each.sorting);

                    this.loading = true;
                    axios.post(`/admin/categories/${item.id}/destroy`)
                        .catch((error) => core.ajaxError(error.response))
                        .then(() => this.loading = false);
                });
            },

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row.sorting === this.draggingRow.sorting) {
                    return;
                }
                [payload.row.sorting, this.draggingRow.sorting] = [this.draggingRow.sorting, payload.row.sorting];
                this.$refs.table.initSort();

                this.update(payload.row);
                this.update(this.draggingRow);
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

<style>
    .table-hide-header .table thead tr:first-child {
        display: none;
    }
    .table-hide-header .table thead input {
        display: none;
    }
</style>
