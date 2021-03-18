<template>
    <div>
        <modal-box :is-active="isModalActive" :trash-object-name="trashObjectName" @confirm="trashConfirm" @cancel="trashCancel"/>

        <b-table class="table-align-center"
            :checked-rows.sync="checkedRows"
            :checkable="checkable"
            :loading="isLoading"
            :paginated="paginated"
            :per-page="perPage"
            :striped="true"
            :hoverable="true"
            default-sort="name"
            :data='clients'>

            <template slot-scope="props">
                <b-table-column label="Код" field="id" searchable sortable centered>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column label="Фото" class="has-no-head-mobile is-image-cell" >
                    <div class="image">
                        <img :src="props.row.thumb" class="is-rounded">
                    </div>
                </b-table-column>

                <b-table-column label="Артикул" field="id" sortable>
                    <span class="is-italic">{{ props.row.codes }}</span>
                </b-table-column>

                <b-table-column class="has-text-left" label="Модель" field="model" searchable sortable>
                    <a :href="props.row.link">{{ props.row.model }}</a>
                </b-table-column>

                <b-table-column label="Бренд" field="brand" searchable sortable centered>
                    <span class="is-italic">{{ props.row.brand }}</span>
                </b-table-column>

                <b-table-column label="Категория" field="category_name" searchable sortable>
                    {{ props.row.category_name }}
                </b-table-column>

                <b-table-column label="Цена" field="price" sortable>
                    {{ props.row.price }}
                </b-table-column>

                <b-table-column label="Активен" field="is_active" sortable centered>
                    <label class="b-checkbox checkbox ce">
                        <input type="checkbox" :checked="props.row.is_active">
                        <span class="check"></span>
                    </label>
                </b-table-column>

                <b-table-column label="Наличие" field="is_stock" sortable centered>
                    <label class="b-checkbox checkbox">
                        <input type="checkbox" :checked="props.row.is_stock">
                        <span class="check"></span>
                    </label>
                </b-table-column>

                <b-table-column custom-key="actions" class="is-actions-cell">
                    <div class="buttons is-right">
                        <router-link :to="{name:'product.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                            <b-icon icon="account-edit" size="is-small"/>
                        </router-link>
                        <button class="button is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                            <b-icon icon="trash-can" size="is-small"/>
                        </button>
                    </div>
                </b-table-column>

            </template>

            <section class="section" slot="empty">
                <div class="content has-text-grey has-text-centered">
                    <template v-if="isLoading">
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
    </div>
</template>

<script>
    import axios from 'axios'
    import ModalBox from './ModalBox.vue'

    export default {
        name: 'ClientsTableSample',
        components: { ModalBox },
        props: {
            dataUrl: {
                type: String,
                default: null
            },
            checkable: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                isModalActive: false,
                trashObject: null,
                isLoading: false,
                paginated: false,
                perPage: 10,
                checkedRows: [],
                clients: [],
            }
        },
        computed: {
            trashObjectName () {
                if (this.trashObject) {
                    return this.trashObject.name
                }

                return null
            }
        },
        mounted () {
            if (this.dataUrl) {
                this.isLoading = true
                axios
                    .get(this.dataUrl)
                    .then(r => {
                        this.isLoading = false
                        if (r.data && r.data.data) {
                            if (r.data.data.length > this.perPage) {
                                this.paginated = true
                            }
                            this.clients = r.data.data
                        }
                    })
                    .catch(e => {
                        this.isLoading = false
                        this.$buefy.toasts.open({
                            message: `Error: ${e.message}`,
                            type: 'is-danger'
                        })
                    })
            }
        },
        methods: {
            trashModal (trashObject) {
                this.trashObject = trashObject
                this.isModalActive = true
            },
            trashConfirm () {
                this.isModalActive = false
                this.$buefy.snackbar.open({
                    message: 'Confirmed',
                    queue: false
                })
            },
            trashCancel () {
                this.isModalActive = false
            }
        }
    }
</script>
