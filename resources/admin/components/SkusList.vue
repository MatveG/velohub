
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
                        <b-field label="Артикулы" label-position="on-border">
                            <b-input v-model="item.codesText" @input="updateCodes" type="textarea" rows="2" placeholder="Один артикул на строку"  required />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="item.barcode"  placeholder="Штрих-код товара" />
                        </b-field>

                        <div v-if="item.id" class="columns">
                            <div v-for="(option, key) in cols.options" class="column">
                                <b-field :label="option.title" label-position="on-border">
                                    <b-input v-if="item.options" v-model="item.options[key]" :placeholder="'Опция [' + option.title + ']'" />
                                </b-field>
                            </div>
                        </div>

                        <div v-if="item.id" class="columns">
                            <div v-for="(price, key) in cols.prices" class="column">
                                <b-field :label="price.title" label-position="on-border">
                                    <b-input v-if="item.prices" v-model="item.prices[key]" :placeholder="'Цена [' + price.title + ']'" />
                                </b-field>
                            </div>
                        </div>

                        <div v-if="item.id" class="columns">
                            <div v-for="(stock, key) in cols.stocks" class="column">
                                <b-field :label="stock.title" label-position="on-border">
                                    <b-input v-if="item.stocks" v-model="item.stocks[key]" :placeholder="'Склад [' + stock.title + ']'" />
                                </b-field>
                            </div>
                        </div>

                        <div v-if="item.id" class="card">
                            <div class="card-content">
                                <ul @change.stop>
                                    <draggable v-model="item.images" @end="sortImages" ghost-class="has-background-light">
                                        <li v-for="(file, key) in item.images" class="image-block is-square">
                                            <img :src="file" class="image" alt="">
                                            <button @click="deleteImage(key)" class="delete">x</button>
                                        </li>
                                    </draggable>
                                </ul>
                                <label v-if="!item.images.length" class="label has-text-centered has-text-grey-light">Загрузите фото</label>
                                <b-field class="file upload-icon">
                                    <b-upload v-model="file" multiple drag-drop>
                                        <div class="is-flex">
                                            <i class="fa fa-upload is-size-3 has-text-primary"></i>
                                        </div>
                                    </b-upload>
                                </b-field>
                            </div>
                        </div>

                    </form>
                </div>
                <footer class="modal-card-foot">
                    <button class="button is-primary" type="button"
                            :class="{ 'is-loading': loading }" :disabled="saved" @click="save(true)">Сохранить</button>
                    <button class="button" type="button" @click="modal=false">Закрыть</button>
                </footer>
            </div>
        </b-modal>

    </div>
</template>

<script>
    import axios from 'axios';
    import draggable from 'vuedraggable'
    import CardCollapse from "./CardCollapse";
    import ModalImage from "./ModalImage";

    export default {
        props: ['productId'],

        components: {
            draggable,
            ModalImage,
            CardCollapse,
        },

        data() {
            return {
                title: 'Артикул',
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
        },

        watch: {
            'file': function () {
                if(this.file && this.file.length) {
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
                    drag: false
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

                if(this.drag === true) {
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
                this.file.forEach(file => {
                    let url = `/admin/sku/${this.item.id}/upload-image`;
                    let data = new FormData();
                    let settings = { headers: { 'content-type': 'multipart/form-data' } };
                    data.append('image', file);

                    axios.post(url, data, settings)
                        .then((res) => {
                            this.item.images.push(res.data.image);
                            this.file = null;
                        })
                        .catch(error => window.error(error.message));
                });
            },

            deleteImage: function (key) {
                this.item.images.splice(key, 1);
                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`)
                    .catch(error => window.error(error.message));
            },

            sortImages() {
                this.drag = false;
                this.saved = false;
                this.loading = true;

                axios.post(`/admin/sku/${this.item.id}/update-images`, { images: this.item.images })
                    .then(() => {
                        this.saved = true;
                        this.loading = false;
                    })
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
    .card-content {
        padding: 1rem;
    }
    .sku-images ul {
        margin: 0;
    }
    .image-block {
        width: 20%;
    }
    .upload-icon {
        height: 70px;
    }
    .upload-icon div, .upload-icon label {
        margin: auto;
        width: 100%;
        height: 100%;
    }
    .upload-icon i {
        margin: auto;
    }
</style>
