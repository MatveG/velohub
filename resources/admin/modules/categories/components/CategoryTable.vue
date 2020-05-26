
<template>
    <b-table class="table-valign-center"
             ref="table"
             :data='propItems'
             :loading="loading"
             default-sort="sorting"
             custom-row-key="sorting"
             icon-pack="fa"
             striped
             hoverable
             draggable
             @drop="drop"
             @dragstart="dragstart"
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
                {{props.row.id}}
                <button @click="edit(props.row.id)" class="button fas fa-pen is-small" />
                <button @click="destroy(props.row.id)" type="button" class="button fas fa-trash-alt is-small" />
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
    import CategoryTable from "./CategoryTable";
    import {draggable} from "@/mixins/draggable";

    export default {
        name: 'CategoryTable',

        mixins: [draggable],

        components: [CategoryTable],

        props: ['propItems', 'recursive'],

        data () {
            return {
                perPage: 15,
                paginated: false,
                openedDetails: [],
                loading: false,
            }
        },

        mounted () {
            this.paginated = !this.recursive && this.perPage < this.propItems.length;

            setTimeout(() => { console.log(this.$store.getters.getAll); }, 3000);
        },

        methods: {
            edit(id) {
                this.$router.push({
                    name:'category.edit',
                    params: { propId: id }
                });
            },

            update(item) {
                this.$store.dispatch('saveOne', item);
            },

            destroy() {
                this.confirm('Удалить?', () => {
                    this.stateLoading();
                    //this.items = this.items.filter((each) => each.id !== item.id);
                    //this.items.map((each) => each.sort = (each.sort > item.sort) ? --each.sort : each.sort);
                    this.$store
                        .dispatch('destroyOne')
                        .finally(() => this.stateSaved());
                });
            },

            drop(payload) {
                this.dragdrop(payload);

                if (payload.row.sorting !== this.draggingRow.sorting) {
                    this.dragswap(payload);
                    this.$store.dispatch('postOne', payload.row);
                    this.$store.dispatch('postOne', this.draggingRow);
                }
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
