<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button @click="$router.push({ name: 'product-create' })" class="button is-primary fas fa-plus"></button>
        </div>

        <card-component class="has-table has-mobile-sort-spaced" title="Товары">
            <b-table ref="table"
                     :data="products"
                     :per-page="perPage"
                     :paginated="paginated"
                     :loading="loading"
                     :checked-rows="checked"
                     custom-row-key="id"
                     default-sort="['id', 'desc']"
                     striped
                     checkable
                     hoverable
                     icon-pack="fa"
                     class="valign-center">

                <template slot-scope="props">
                    <b-table-column label="Фото" field="thumb" width="10%" centered>
                        <div class="image">
                            <img :src="props.row.thumb" class="is-rounded">
                        </div>
                    </b-table-column>

                    <b-table-column label="Код" field="id" width="7%" searchable sortable centered>
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column label="Артикул" field="code" width="8%" searchable sortable centered>
                        <span class="is-italic">{{ props.row.code }}</span>
                    </b-table-column>

                    <b-table-column label="Модель" field="model" width="20%" searchable>
                        {{ props.row.model }}
                    </b-table-column>

                    <b-table-column label="Бренд" field="brand" width="15%" searchable>
                        <span class="is-italic">{{ props.row.brand }}</span>
                    </b-table-column>

                    <b-table-column label="Категория" field="category.title" width="15%" searchable>
                        {{ (props.row.category) ? props.row.category.title : '' }}
                    </b-table-column>

                    <b-table-column field="is_active" label="Активен" width="15%" sortable centered>
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
            </b-table>
        </card-component>
    </section>
</template>

<script>
    import {mapGetters} from "vuex";
    import {states} from "@/mixins/states";
    import CardComponent from "@/components/CardComponent";

    export default {
        name: 'ProductIndex',

        mixins: [states],

        components: { CardComponent },

        data () {
            return {
                checked: [],
                perPage: settings.perPage,
            }
        },

        computed: {
            ...mapGetters(['products']),

            paginated() {
                return this.perPage < this.products.length;
            },
        },

        watch: {
            'checked': function() {
                console.log(this.checked.length);
            }
        },

        mounted () {
            this.$store.dispatch('fetchProducts');
        },

        methods: {
            edit(row) {
                this.$router.push({
                    name:'product-edit',
                    params: { propId: row.id }
                });
            },

            update(row) {
                this.stateLoading();
                this.$store.dispatch('patchProduct', row).then(() => this.stateSaved());
            },

            confirmDestroy(row) {
                this.confirm('Удалить?', this.destroy.bind(null, row));
            },

            destroy(row) {
                this.stateLoading();
                this.$store.dispatch('destroyProduct', row).then(() => this.stateSaved());
            },
        }
    }
</script>
