
<template>
    <div class="table-draggable-nested">
        <b-table ref="table"
                 :data='propItems'
                 :loading="loading"
                 default-sorting="sorting"
                 custom-row-key="id"
                 icon-pack="fa"
                 hoverable
                 draggable
                 @drop="drop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 detailed
                 detail-key="id"
                 :show-detail-icon="false"
                 :opened-detailed="opened"
                 class="valign-center">

            <template slot-scope="props">
                <b-table-column field="sorting" label="" width="10%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="child.length" label="Родительская" width="15%" sortable centered>
                    <span v-if="props.row.is_parent" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="title" label="Название категории" width="55%" :searchable="!propNested">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="is_active" label="Активна" width="15%" sortable centered>
                    <b-checkbox v-model="props.row.is_active" @change.native="update(props.row)" class="is-small" />
                </b-table-column>

                <b-table-column custom-key="actions" width="15%" centered>
                    <b-dropdown hoverable :expanded="false" aria-role="list" class="dropdown-buttons">
                        <button @click="edit(props.row)" slot="trigger" class="button is-primary fas fa-pen" />

                        <b-dropdown-item v-if="props.row.is_parent" @click="addSub(props.row)" aria-role="listitem">
                            <b-icon pack="fas" icon="plus" />
                        </b-dropdown-item>

                        <b-dropdown-item @click="destroy(props.row)" aria-role="listitem">
                            <b-icon pack="fas" icon="trash" />
                        </b-dropdown-item>
                    </b-dropdown>
                </b-table-column>
            </template>

            <template slot="detail" slot-scope="props">
                <category-table v-if="props.row.is_parent" :prop-items="props.row.child" :propNested="true" />
            </template>
        </b-table>
    </div>
</template>

<script>
    import {draggable} from "@/mixins/draggable";
    import {states} from "@/mixins/states";
    import CategoryTable from "./CategoryTable"

    export default {
        name: 'CategoryTable',

        mixins: [states, draggable],

        components: {CategoryTable},

        props: {
            propItems: {
                type: Array,
                default: () => []
            },

            propNested: {
                type: Boolean,
                default: false
            }
        },

        data () {
            return {
                opened: [],
                perPage: 15,
                paginated: !this.propNested && this.perPage < this.propItems.length,
            }
        },

        mounted() {
            this.opened = this.getOpened();
        },

        methods: {
            getOpened() {
                return this.propItems.filter(el => el.is_parent === true).map(el => el.id);
            },

            addSub(row) {
                this.$router.push({
                    name:'category-create-sub',
                    params: { propParent: row.id }
                });
            },

            edit(row) {
                this.$router.push({
                    name:'category-edit',
                    params: { propId: row.id }
                });
            },

            update(row) {
                this.stateLoading();
                this.$store
                    .dispatch('patchCategory', row)
                    .then(() => this.stateSaved());
            },

            destroy(row) {
                this.confirm('Удалить?', () => {
                    this.stateLoading();
                    this.$store
                        .dispatch('destroyCategory', row)
                        .then(() => {
                            this.reduceSorting(this.propItems, row.sorting);
                            this.stateSaved();
                    });
                });
            },

            reduceSorting(objsArray, afterValue) {
                return objsArray.forEach((el) => {
                    if (el.sorting > afterValue) {
                        --el.sorting;
                        this.$store.commit('updateCategory', el);
                    }
                });
            },

            drop(payload) {
                this.dragdrop(payload);

                if (payload.row && this.draggingRow && payload.row.sorting !== this.draggingRow.sorting) {
                    this.$store.dispatch('patchCategory', {...payload.row, sorting: this.draggingRow.sorting});
                    this.$store.dispatch('patchCategory', {...this.draggingRow, sorting: payload.row.sorting});

                    this.$refs.table.initSort();
                }
            },
        }
    }
</script>

<!--<style>-->
<!--    .table-hide-header .table {-->
<!--        background: #eee;-->
<!--    }-->
<!--    /*.table-hide-header .table thead tr:first-child {*/-->
<!--    /*    display: none;*/-->
<!--    /*}*/-->
<!--    /*.table-hide-header .table thead input {*/-->
<!--    /*    display: none;*/-->
<!--    /*}*/-->
<!--    .category-table .chevron-cell a {-->
<!--        display: none;-->
<!--    }-->
<!--    .category-table tr.parent .chevron-cell a {-->
<!--        display: block;-->
<!--    }-->
<!--</style>-->
