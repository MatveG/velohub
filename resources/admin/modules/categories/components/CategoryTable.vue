
<template>
    <div class="table-draggable-nested">
        <b-table ref="table"
                 :loading="loading"
                 :data="propItems"
                 default-sort="sorting"
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
                <b-table-column field="sorting" label="" width="10%" sortable centered class="has-text-grey">
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="id" label="ID" width="10%" sortable centered :searchable="!propNested">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="title" label="Название категории" width="50%" sortable :searchable="!propNested">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="is_active" label="Активна" width="15%" sortable centered>
                    <b-checkbox v-model="props.row.is_active" @change.native="update(props.row)" class="is-small" />
                </b-table-column>

                <b-table-column custom-key="actions" width="15%" centered>
                    <b-dropdown hoverable :expanded="false" aria-role="list" class="dropdown-buttons">
                        <button @click="edit(props.row)" slot="trigger" class="button is-primary fas fa-pen" />

                        <b-dropdown-item v-if="props.row.is_parent" @click="createChild(props.row)" aria-role="listitem">
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
                perPage: 15,
                paginated: !this.propNested && this.perPage < this.propItems.length,
            }
        },

        computed: {
            opened() {
                return this.propItems.filter(el => el.is_parent).map(el => el.id);
            },
        },

        methods: {
            edit(row) {
                this.$router.push({
                    name:'category-edit',
                    params: { propId: row.id }
                });
            },

            update(row) {
                this.stateLoading();
                this.$store.dispatch('patchCategory', row)
                    .then(() => this.stateSaved());
            },

            createChild(row) {
                this.$router.push({
                    name:'category-create-child',
                    params: { propParent: row.id }
                });
            },

            destroy(row) {
                this.confirm('Удалить?', () => {
                    this.stateLoading();
                    this.$store.dispatch('destroyCategory', row).then(() => {
                        this.$store.commit(
                            'assignCategories',
                            this.propItems.map(el => (el.sorting > row.sorting) ? {...el, sorting: el.sorting-1} : el)
                        );
                        this.stateSaved();
                    });
                });
            },

            drop(payload) {
                if (payload.row && this.draggingRow && payload.row.sorting !== this.draggingRow.sorting) {
                    [payload.row.sorting, this.draggingRow.sorting] = [this.draggingRow.sorting, payload.row.sorting];
                    this.$refs.table.initSort();

                    this.$store.dispatch('patchCategory', payload.row);
                    this.$store.dispatch('patchCategory', this.draggingRow);
                }
                this.dragdrop(payload);
            },
        }
    }
</script>
