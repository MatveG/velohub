<template>
    <section class="section is-main-section">
        <card-component class="has-table has-mobile-sort-spaced" title="Товары">
            <div v-if="checked.length" class="buttons">
                <button class="button"></button>
                <button class="button"></button>
            </div>
            <b-table @select="edit"

                     selectable

                     :data='items'
                     :checked-rows="checked"
                     :per-page="perPage"
                     :paginated="paginate"
                     :loading="loading"
                     :checkable="true"
                     :hoverable="true"
                     :striped="true"
                     default-sort="['id', 'desc']"
                     icon-pack="fa"
                     class="table-vertical-center">

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

                    <b-table-column label="Категория" field="category_title" width="15%" searchable>
                        {{ props.row.category_title }}
                    </b-table-column>

                    <b-table-column label="Цена" field="price" width="10%" numeric sortable>
                        {{ props.row.price }}
                    </b-table-column>

                    <b-table-column label="Активен" field="is_active" width="10%" sortable centered>
                        <b-checkbox v-model="props.row.is_active" @click.native.prevent />
                    </b-table-column>

                    <b-table-column custom-key="actions" width="5%" class="is-actions-cell">
                        <div class="buttons is-right">
<!--                            <router-link :to="{name:'product.edit', params: {id: props.row.id}}" class="button is-small is-primary">-->
<!--                                <b-icon icon="account-edit" size="is-small"/>-->
<!--                            </router-link>-->
                            <button class="button fas fa-trash-alt is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                            </button>
                        </div>
                    </b-table-column>
                </template>

                <section class="section" slot="empty">
                    <div class="content has-text-grey has-text-centered">
                        <template v-if="loading">
                            <p>
                                <b-icon icon="dots-horizontal" size="is-large"/>
                            </p>
                            <p>Loading...</p>
                        </template>
                        <template v-else>
                            <p>
                                <b-icon icon="emoticon-sad" size="is-large"/>
                            </p>
                            <p>Nothing's here&hellip;</p>
                        </template>
                    </div>
                </section>
            </b-table>
        </card-component>
    </section>
</template>

<script>
    import axios from 'axios'
    import CardComponent from "@/components/CardComponent";

    export default {
        name: 'itemsTableSample',

        components: { CardComponent },

        // props: {
        //     dataUrl: {
        //         type: String,
        //         default: null
        //     },
        //     checkable: {
        //         type: Boolean,
        //         default: true
        //     }
        // },

        data () {
            return {
                items: [],
                checked: [],
                perPage: 15,
                paginate: true,
                loading: false,
            }
        },

        // watch: {
        //     'checkedRows': function() {
        //         console.log(this.checkedRows.length);
        //     }
        // },

        mounted () {
            this.dataUrl = '/admin/product/';
            this.loading = true;
            if (!this.dataUrl) return;
            axios
                .get(this.dataUrl)
                .then(r => {
                    this.loading = false;
                    if (r.data && r.data.data) {
                        if (r.data.data.length > this.perPage) {
                            this.paginate = true
                        }
                        this.items = r.data.data
                    }
                })
                .catch(e => {
                    this.loading = false
                    this.$buefy.toast.open({
                        message: `Error: ${e.message}`,
                        type: 'is-danger'
                    })
                });
        },

        methods: {
            edit(item) {
                this.$router.push({ name:'product.edit', params: { id: item.id } });
            }
        }
    }
</script>
