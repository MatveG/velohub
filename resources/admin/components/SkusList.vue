
<template>
    <div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th>default</th>
                <th>codes</th>
                <th>title</th>
                <th>barcode</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>
                        <input type="radio" name="is_default" v-bind:checked="item.is_default" @click="setDefault(item.id)"></input>
                    </td>
                    <td>
                        <div class="is-italic" v-for="code in item.codes">{{ code }}</div>
                    </td>
                    <td>{{ item.title }}</td>
                    <td class="is-italic">{{ item.barcode }}</td>
                    <td>
                        <button class="button fas fa-pen" @click="edit(item.id)"></button>
                        <button class="button fas fa-trash-alt" @click="destroy(item.id)"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        <button class="button is-primary" @click="create">Добавить</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <b-modal :active.sync="modalActive" has-modal-card aria-modal>
            <div class="modal-card">
                <div class="modal-card-head">
                    <p class="modal-card-title">Modal title</p>
                </div>
                <div class="modal-card-body">
                    <form v-on:submit.prevent v-on:change="update">
                        <b-field label="Наименование" label-position="on-border">
                            <b-input v-model="item.title" required />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="item.barcode" />
                        </b-field>
                        <b-field label="Артикулы (один на строку)" label-position="on-border">
                            <b-input v-model="item.codesText" type="textarea" @input="updateCodes" required />
                        </b-field>
                        <div class="columns">
                            <div class="column" v-for="(option, key) in cols.options">
                                <b-field :label="option.title" label-position="on-border">
                                    <b-input v-if="item.options" v-model="item.options[key]" />
                                </b-field>
                            </div>
                        </div>
                        <card-collapse :is-open="false" title="Цены и наличие">
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
                                <label class="label">Фотографии</label>
                                <div class="control">
                                    <div class="image-block" v-for="(file, key) in item.images">
                                        <img class="image" :src="file" alt="">
                                        <button class="delete" @click="deleteImage(key)">x</button>
                                    </div>
                                    <div class="buttons is-centered">
                                        <b-field class="file">
                                            <b-upload v-model="file">
                                                <a class="button is-primary">Загрузить фото</a>
                                            </b-upload>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                        </card-collapse>
                    </form>
                </div>
                <footer class="modal-card-foot">
                    <button class="button is-primary" v-if="!item.id" @click="submit">Добавить</button>
                    <button class="button" type="button" @click="modalActive=false">Закрыть</button>
                </footer>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import modal from './ModalBox';
    import CardCollapse from "./CardCollapse";

    export default {
        props: ['productId'],

        components: {
            CardCollapse,
            modal
        },

        data() {
            return {
                modalActive: false,
                item: {},
                items: {},
                cols: {},
                file: null,
            }
        },

        mounted() {
            axios.get(`/admin/sku/${this.productId}`).then((res) => {
                for (let data in res.data) {
                    this[data] = res.data[data];
                }
            });
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

                for (let key in this.cols.options) {
                    this.item.options[key] = '';
                }

                for (let key in this.cols.prices) {
                    this.item.prices[key] = 0;
                }

                for (let key in this.cols.stocks) {
                    this.item.stocks[key] = 0;
                }

                this.modalActive = true;
            },

            edit(id) {
                this.item = this.items.find(item => item.id === id);
                this.item.codesText = this.item.codes.join('\n');

                if(!this.item.images) {
                    this.item.images = [];
                }
                this.modalActive = true;
            },

            submit() {
                if (!this.item.title) {
                    return;
                }
                if (!this.item.codesText || this.item.codesText.length < 3) {
                    return;
                }
                (this.item.id === null) ? this.store() : this.update();
            },

            store() {
                axios.post(`/admin/sku/store`, this.item).then((res) => {
                    this.item.id = res.data.id;
                    this.items.push(this.item);
                    this.edit(this.item.id);
                    this.$buefy.snackbar.open('Сохранено');
                }).catch(error => console.log(error.response));
            },

            update() {
                if(this.item.id) {
                    axios.post(`/admin/sku/${this.item.id}/update`, this.item).catch(error => console.log(error));
                    this.$buefy.snackbar.open('Сохранено');
                }
            },

            destroy(id) {
                if (this.items.find((item) => item.id === id).is_default === true) {
                    alert('Невозможно удалить основную запись');
                    return;
                }
                axios.post(`/admin/sku/${id}/destroy`).catch(error => console.log(error));
                this.items = this.items.filter(item => item.id !== id);
            },

            updateCodes() {
                this.item.codes = this.item.codesText.split('\n');
            },

            setDefault(id) {
                this.items.map(item => {
                    item.is_default = (item.id === id);
                });
                axios.post(`/admin/sku/${id}/set-default`).catch(error => console.log(error.response));
            },

            uploadImage: function () {
                let settings = { headers: { 'content-type': 'multipart/form-data' } };
                let data = new FormData();
                data.append('image', this.file);

                axios.post(`/admin/sku/${this.item.id}/upload-image`, data, settings).then((res) => {
                    this.item.images.push(res.data.image);
                    this.file = null;
                }).catch(error => console.log(error));
            },

            deleteImage: function (key) {
                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`).catch(error => console.log(error));
                this.item.images.splice(key, 1);
            }
        }
    }
</script>

<style>
    .less-margin {
        margin-top: -1rem;
    }
    .card-header-title {
        font-weight: normal;
    }
</style>
