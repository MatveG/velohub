<template>
    <b-table class="table-valign-center" :class="(recursive) ? 'table-hide-header' : ''"
             ref="table"
             :data='items'
             :per-page="perPage"
             :paginated="paginated"
             :loading="loading"
             default-sort="sorting"
             icon-pack="fa"
             hoverable

             draggable
             custom-row-key="sorting"
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
            <b-table-column field="child.length" label="Дочерних" width="10%" sortable centered>
                {{ (props.row.child.length) ? props.row.child.length : '-' }}
            </b-table-column>

            <b-table-column field="id" label="Изображение" width="20%" numeric centered>
                []
            </b-table-column>

            <b-table-column field="id" label="ID" width="10%" searchable sortable centered>
                {{ props.row.id }}
            </b-table-column>

            <b-table-column field="sorting" label="Порядок" width="10%" sortable centered>
                {{ props.row.sorting }}
            </b-table-column>

            <b-table-column field="title" label="Название категории" width="25%" searchable>
                {{ props.row.title }}
            </b-table-column>

            <b-table-column field="is_active" label="Активна" width="10%" sortable centered>
                <b-checkbox v-model="props.row.is_active" @change.native="update(props.row)" :class="(recursive) ? 'is-small' : ''" />
            </b-table-column>

            <b-table-column custom-key="actions" width="15%" class="is-actions-cell">
                <router-link :to="{ name:'category.edit', params: { id: props.row.id } }">
                    <button type="button" class="button fas fa-pen" :class="(recursive) ? 'is-small' : ''" />
                </router-link>
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
                axios.post(`/admin/category/${item.id}/update`, item)
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.loading = false);
            },


            // drag&sort
            dragstart (payload) {
                //this.openedDetails = [];

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

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row && this.draggingRow) {
                    let temp = payload.row.sorting;
                    payload.row.sorting = this.draggingRow.sorting;
                    this.draggingRow.sorting = temp;

                    this.$refs.table.initSort();
                }
            }
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
