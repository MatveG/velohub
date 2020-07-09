
<template>
    <div class="table-draggable-nested">
        <b-table ref="table"
                 :data="items"
                 :per-page="perPage"
                 :paginated="paginated"
                 :loading="loading"
                 custom-row-key="id"
                 default-sort="ord"
                 @drop="drop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 hoverable
                 draggable
                 detailed
                 detail-key="id"
                 :show-detail-icon="false"
                 :opened-detailed="opened"
                 icon-pack="fa"
                 class="valign-center">

            <template slot-scope="props">
                <b-table-column field="ord" label="" width="10%" sortable centered class="has-text-grey">
                    {{ props.row.ord }}
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

                        <b-dropdown-item @click="confirmDestroy(props.row)" aria-role="listitem">
                            <b-icon pack="fas" icon="trash" />
                        </b-dropdown-item>
                    </b-dropdown>
                </b-table-column>
            </template>

            <template slot="detail" slot-scope="props">
                <category-table v-if="props.row.is_parent" :prop-parent="props.row.id" :propNested="true" />
            </template>
        </b-table>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {draggable} from "@/mixins/draggable";
    import {states} from "@/mixins/states";
    import CategoryTable from "./CategoryTable"

    export default {
        name: 'CategoryTable',

        mixins: [states, draggable],

        components: {CategoryTable},

        props: {
            propParent: {
                type: Number,
                default: 0
            },

            propNested: {
                type: Boolean,
                default: false
            }
        },

        data () {
            return {
                perPage: settings.perPage
            }
        },

        computed: {
            ...mapGetters(['categories']),

            items() {
                return this.categories.filter(el => el.parent_id === this.propParent);
            },

            opened() {
                return this.items.filter(el => el.is_parent).map(el => el.id);
            },

            paginated() {
                return !this.propNested && this.perPage < this.items.length;
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
                this.$store.dispatch('patchCategory', row).then(() => this.stateSaved());
            },

            createChild(row) {
                this.$router.push({
                    name:'category-create-child',
                    params: { propParent: row.id }
                });
            },

            confirmDestroy(row) {
                this.confirm('Удалить?', this.destroy.bind(null, row));
            },

            destroy(row) {
                this.stateLoading();
                this.$store.dispatch('destroyCategory', row).then(() => this.stateSaved());
            },

            drop(payload) {
                let [rowOne, rowTwo] = [payload.row, this.draggingRow];

                if (rowOne && rowTwo && rowOne.ord !== rowTwo.ord) {
                    [rowOne.ord, rowTwo.ord] = [rowTwo.ord, rowOne.ord];
                    this.$store.dispatch('patchCategory', rowOne);
                    this.$store.dispatch('patchCategory', rowTwo);
                    this.$refs.table.initSort();
                }
                this.dragdrop(payload);
            },
        }
    }
</script>
