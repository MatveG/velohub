
<template>
    <div>
        <table class="table is-fullwidth table-align-center">
            <thead>
            <tr>
                <th>Основной</th>
                <th>Фото</th>
                <th>Артикулы</th>
                <th>Параметры</th>
                <th>Цены</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>
                        <input type="radio" name="is_default" :checked="item.is_default" @click="setDefault(item.id)"></input>
                    </td>
                    <td>
                        <modal-image v-if="item.images" :image="item.images[0]"></modal-image>
                    </td>
                    <td>
                        <div v-for="code in item.codes" class="is-italic">{{ code }}</div>
                    </td>
                    <td>
                        <template v-for="(option, key) in cols.options">
                            <div v-if="item.options[key]">
                                <span class="has-text-grey-light is-italic">{{ option.title }}:</span>
                                {{ item.options[key] }}
                            </div>
                        </template>
                    </td>
                    <td>
                        <template v-for="(price, key) in cols.prices">
                            <div v-if="item.prices[key]">
                                <span class="has-text-grey-light is-italic">{{ price.title }}:</span>
                                {{ formatPrice(item.prices[key]) }} {{ price.sign }}
                            </div>
                        </template>
                    </td>
                    <td>
                        <button class="button fas fa-pen" type="button" @click="edit(item.id)"></button>
                        <button class="button fas fa-trash-alt" type="button" @click="destroy(item.id)"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <button class="button is-primary" type="button" @click="create">Добавить</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <b-modal :active.sync="modal" has-modal-card aria-modal>
            <div class="modal-card">
                <div class="modal-card-head">
                    <p class="modal-card-title">{{ title }}</p>
                </div>
                <div class="modal-card-body">
                    <form @submit="save(false)" @change="save(false)" @keyup="saved=false">
                        <b-field label="Артикулы (один на строку)" label-position="on-border">
                            <b-input v-model="item.codesText" type="textarea" required @input="updateCodes" />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="item.barcode" />
                        </b-field>
                        <div class="columns">
                            <div class="column" v-for="(option, key) in cols.options">
                                <b-field :label="option.title" label-position="on-border">
                                    <b-input v-if="item.options" v-model="item.options[key]" />
                                </b-field>
                            </div>
                        </div>
                        <card-collapse class="font-weight-normal" v-if="item.id" :is-open="false" title="Цены и наличие">
                            <label class="label is-small has-text-centered less-margin">Цены</label>
                            <div class="columns">
                                <div class="column" v-for="(price, key) in cols.prices">
                                    <b-field :label="price.title" label-position="on-border">
                                        <b-input v-if="item.prices" v-model="item.prices[key]" />
                                    </b-field>
                                </div>
                            </div>
                            <label class="label is-small has-text-centered less-margin">Склады</label>
                            <div class="columns">
                                <div class="column" v-for="(stock, key) in cols.stocks">
                                    <b-field :label="stock.title" label-position="on-border">
                                        <b-input v-if="item.stocks" v-model="item.stocks[key]" />
                                    </b-field>
                                </div>
                            </div>
                        </card-collapse>
                        <card-collapse v-if="item.id" :is-open="false" title="Фотографии">
                            <div v-if="item.id">
                                <div class="control">
                                    <div class="image-block" v-for="(file, key) in item.images">
                                        <img class="image" :src="file" alt="">
                                        <button class="delete" @click="deleteImage(key)">x</button>
                                    </div>
                                    <div class="buttons is-centered">
                                        <b-field class="file">
                                            <b-upload v-model="file">
                                                <a class="button is-primary">Загрузить</a>
                                            </b-upload>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                        </card-collapse>
                    </form>
                </div>
                <footer class="modal-card-foot">
                   <button class="button is-primary" type="button"
                           :class="{ 'is-loading': loading }" :disabled="saved" @click="save(true)">Сохранить</button>
                </footer>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import CardCollapse from "./CardCollapse";
    import ModalImage from "./ModalImage";

    export default {
        props: ['productId'],

        components: {
            ModalImage,
            CardCollapse,
        },

        data() {
            return {
                title: 'Артикул товара',
                modal: false,
                saved: true,
                loading: false,
                item: {},
                items: {},
                cols: {},
                file: null,
            }
        },

        mounted() {
            axios.get(`/admin/sku/${this.productId}`)
                .then((res) => {
                    for (let data in res.data) {
                        this[data] = res.data[data];
                    }
                })
                .catch(error => window.error(error.message));

            console.log(this.item);
        },

        watch: {
            'file': function () {
                if(this.file) {
                    this.uploadImage();
                }
            }
        },

        methods: {
            create() {
                this.item = {
                    id: null,
                    product_id: this.productId,
                    is_active: false,
                    is_default: false,
                    options: {},
                    prices: {},
                    stocks: {},
                    images: [],
                    codesText: '',
                };

                this.modal = true;
            },

            edit(id) {
                this.item = this.items.find(item => item.id === id);
                this.item.codesText = this.item.codes.join('\n');

                if(!this.item.images) {
                    this.item.images = [];
                }
                this.modal = true;
            },

            save() {
                if (!this.item.codesText || this.item.codesText.length < 3) {
                    window.error('Заполните Артикулы');
                    return;
                }
                this.saved = false;
                this.loading = true;
                (this.item.id === null) ? this.store() : this.update();
            },

            store() {
                axios.post(`/admin/sku/store`, this.item)
                    .then((res) => {
                        this.item.id = res.data.id;
                        this.items.push(this.item);
                        this.edit(this.item.id);

                        this.saved = true;
                        this.loading = false;
                    })
                    .catch(error => console.log(error.response));
            },

            update() {
                if(!this.item.id) {
                    return;
                }

                axios.post(`/admin/sku/${this.item.id}/update`, this.item)
                    .then(() => {
                        this.saved = true;
                        this.loading = false;
                    })
                    .catch(error => window.error(error.message));
            },

            destroy(id) {
                if (this.items.find((item) => item.id === id).is_default === true) {
                    window.error('Невозможно удалить основную запись');

                    return;
                }

                this.items = this.items.filter(item => item.id !== id);
                axios.post(`/admin/sku/${id}/destroy`)
                    .catch(error => window.error(error.message));
            },

            updateCodes() {
                this.item.codes = this.item.codesText.split('\n');
            },

            setDefault(id) {
                this.items.map(item => item.is_default = (item.id === id));

                axios.post(`/admin/sku/${id}/set-default`)
                    .catch(error => window.error(error.message));
            },

            uploadImage: function () {
                let url = `/admin/sku/${this.item.id}/upload-image`;
                let data = new FormData();
                let settings = { headers: { 'content-type': 'multipart/form-data' } };
                data.append('image', this.file);

                axios.post(url, data, settings)
                    .then((res) => {
                        this.item.images.push(res.data.image);
                        this.file = null;
                    })
                    .catch(error => window.error(error.message));
            },

            deleteImage: function (key) {
                this.item.images.splice(key, 1);
                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`)
                    .catch(error => window.error(error.message));
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
            }
        }
    }
</script>

<style>
    .less-margin {
        margin-top: -1rem;
    }
    .font-weight-normal {
        font-weight: normal !important;
    }
</style>
