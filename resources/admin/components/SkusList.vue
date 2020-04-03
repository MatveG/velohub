
<template>
    <div>
        <b-table :data="items" :striped="true" :hoverable="true" :narrowed="true" class="table-align-center">
            <template slot-scope="props">
                <b-table-column field="id" label="Основной" centered>
                    <input type="radio" name="is_default" :checked="props.row.is_default" @click="setDefault(props.row.id)"></input>
                </b-table-column>
                <b-table-column field="images" label="Фото" centered>
                    <modal-image v-if="props.row.images" :image="props.row.images[0]" :size="75"></modal-image>
                </b-table-column>
                <b-table-column field="codes" label="Артикулы" centered>
                    <div v-for="code in props.row.codes" class="is-italic">{{ code }}</div>
                </b-table-column>
                <b-table-column field="options" label="Параметры" centered>
                    <template v-for="(option, key) in cols.options">
                        <div v-if="props.row.options[key]">
                            <span class="has-text-grey-light is-italic">{{ option.title }}:</span>
                            {{ props.row.options[key] }}
                        </div>
                    </template>
                </b-table-column>
                <b-table-column field="prices" label="Цены" centered>
                    <template v-for="(price, key) in cols.prices">
                        <div v-if="props.row.prices[key]">
                            <span class="has-text-grey-light is-italic">{{ price.title }}:</span>
                            {{ formatPrice(props.row.prices[key]) }} {{ price.sign }}
                        </div>
                    </template>
                </b-table-column>
                <b-table-column field="codes" label="Действия" centered>
                    <button class="button fas fa-pen" type="button" @click="edit(props.row.id)"></button>
                    <button class="button fas fa-trash-alt" type="button" @click="destroy(props.row.id)"></button>
                </b-table-column>
            </template>
        </b-table>
        <button class="button is-primary is-pulled-right" type="button" @click="create">Добавить</button>

        <b-modal :active.sync="modal" has-modal-card aria-modal>
            <div class="modal-card">
                <div class="modal-card-head">
                    <p class="modal-card-title">{{ title }}</p>
                </div>
                <div class="modal-card-body">
                    <form @submit="save(false)" @change="save(false)" @keyup="saved=false">
                        <b-field label="Артикулы" label-position="on-border">
                            <b-input v-model="item.codesText" type="textarea" rows="2" placeholder="Один артикул на строку" required />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="item.barcode"  placeholder="Штрих-код товара" />
                        </b-field>

                        <div v-if="item.id" class="columns">
                            <div v-for="(option, key) in cols.options" class="column pb-0">
                                <b-field :label="option.title" label-position="on-border">
                                    <b-input v-if="item.options" v-model="item.options[key]" :placeholder="'Параметр [' + option.title + ']'" />
                                </b-field>
                            </div>
                        </div>
                        <div v-if="item.id" class="columns">
                            <div v-for="(price, key) in cols.prices" class="column pb-0">
                                <b-field :label="price.title+' ('+price.sign+')'" label-position="on-border">
                                    <b-input v-if="item.prices" v-model="item.prices[key]" :placeholder="'Цена [' + price.title + ']'" />
                                </b-field>
                            </div>
                        </div>
                        <div v-if="item.id" class="columns">
                            <div v-for="(stock, key) in cols.stocks" class="column pb-0">
                                <b-field :label="stock.title" label-position="on-border">
                                    <b-input v-if="item.stocks" v-model="item.stocks[key]" :placeholder="'Склад [' + stock.title + ']'" />
                                </b-field>
                            </div>
                        </div>

                        <div v-if="item.id">
                            <upload-images :web-route="'/admin/sku/' + item.id" :images-array="item.images" image-width="20%">

                            </upload-images>
<!--                            <ul @change.stop>-->
<!--                                <draggable v-model="item.images" @end="sortImages" ghost-class="has-background-light">-->
<!--                                    <li v-for="(image, key) in item.images" class="block-image-delete is-square" style="width: 20%;">-->
<!--                                        <img :src="image" alt="">-->
<!--                                        <button @click="deleteImage(key)" class="delete">x</button>-->
<!--                                    </li>-->
<!--                                </draggable>-->
<!--                            </ul>-->
<!--                            <label v-if="!item.images.length" class="label has-text-centered has-text-grey-light">(Фото)</label>-->
<!--                            <b-field class="file sku-upload-icon">-->
<!--                                <b-upload v-model="files" multiple drag-drop>-->
<!--                                    <div class="is-flex">-->
<!--                                        <i class="fa fa-upload is-size-3 has-text-primary"></i><br>-->
<!--                                    </div>-->
<!--                                </b-upload>-->
<!--                            </b-field>-->
                        </div>
                    </form>
                </div>

                <footer class="modal-card-foot">
                    <button :disabled="saved" @click="save(true)" :class="{ 'is-loading': loading }"
                            class="button is-primary" type="button">Сохранить</button>
                    <button class="button" type="button" @click="modal=false">Закрыть</button>
                </footer>
            </div>
        </b-modal>

    </div>
</template>

<script>
    import axios from 'axios';
    import draggable from 'vuedraggable'
    import core from "./../js/Core";
    import ModalImage from "./ModalImage";
    import UploadImages from "./UploadImages";

    export default {
        name: 'SkusList',

        props: ['productId'],

        components: {
            UploadImages,
            draggable,
            ModalImage,
        },

        data() {
            return {
                title: 'Артикул',
                modal: false,
                loading: false,
                saved: true,
                item: {},
                items: [],
                cols: [],
                files: [],
            }
        },

        mounted() {
            axios.post(`/admin/sku/${this.productId}`)
                .then((res) => {
                    for (let data in res.data) {
                        this[data] = res.data[data];
                    }
                })
                .catch(error => this.axiosError(error.response));
        },

        watch: {
            'files': function () {
                if(this.files.length) {
                    this.uploadImage();
                }
            }
        },

        methods: {
            setDefault(id) {
                this.items.map((item) => item.is_default = (item.id === id));

                axios.post(`/admin/sku/${id}/set-default`)
                    .catch((error) => this.axiosError(error.response));
            },

            destroy(id) {
                if (this.items.find((item) => item.id === id).is_default === true) {
                    core.error('Cannot delete default code');

                    return;
                }

                this.$buefy.dialog.confirm({
                    message: 'Удалить?',
                    confirmText: 'Да',
                    cancelText: 'Нет',
                    onConfirm: () => {
                        this.items = this.items.filter((item) => item.id !== id);
                        axios.post(`/admin/sku/${id}/destroy`)
                            .catch((error) => this.axiosError(error.response));
                    }
                });
            },

            create() {
                this.modal = true;
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
            },

            edit(id) {
                this.item = this.items.find((item) => item.id === id);
                this.item.codesText = this.item.codes.join('\n');
                this.item.backupCodes = this.item.codes;

                if(!this.item.images) {
                    this.item.images = [];
                }
                this.modal = true;
            },

            save() {
                if(this.drag) {
                    return;
                }

                if (!this.item.codesText || this.item.codesText.length < 3) {
                    core.error('Provide at least one code');
                    return;
                }

                this.item.codesText = this.item.codesText.replace(/(^[ \t]*\n)/gm, "").trim();
                this.item.codes = this.item.codesText.split('\n');

                this.loadingState();
                (this.item.id) ? this.update() : this.store();
            },

            store() {
                axios.post(`/admin/sku/store`, this.item)
                    .then((res) => {
                        this.item.id = res.data.id;
                        this.items.push(this.item);
                        this.edit(this.item.id);

                        this.savedState();
                    })
                    .catch((error) => this.axiosError(error.response));
            },

            update() {
                axios.post(`/admin/sku/${this.item.id}/update`, this.item)
                    .then(() => this.savedState())
                    .catch((error) => {
                        this.axiosError(error.response);
                        this.item.codes = this.item.backupCodes;
                        this.item.codesText = this.item.codes.join('\n');
                    });
            },

            uploadImage: function () {
                let url = `/admin/sku/${this.item.id}/upload-image`;

                this.files.forEach((file) => {
                    if(!this.validateImage(file)) {
                        return;
                    }
                    this.loadingState();

                    let data = new FormData();
                    let settings = { headers: { 'content-type': 'multipart/form-data' } };
                    data.append('image', file);

                    axios.post(url, data, settings)
                        .then((res) => {
                            this.item.images.push(res.data.image);
                            this.savedState();
                        })
                        .catch((error) => this.axiosError(error.response));
                });

                this.files = [];
            },

            validateImage: function (file) {
                if(!file.name.match(/\.(jpg|jpeg|gif|png)$/i)) {
                    core.error('Formats allowed: jpg, jpeg, gif, png');
                    return false;
                }

                if(file.size > 1024*1024) {
                    core.error('The maximum supported file sizes is 1 mb');
                    return false;
                }

                return true;
            },

            deleteImage: function (key) {
                this.loadingState();
                this.item.images.splice(key, 1);

                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`)
                    .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
            },

            sortImages() {
                this.loadingState();
                this.drag = false;

                axios.post(`/admin/sku/${this.item.id}/update-images`, { images: this.item.images })
                    .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
            },

            loadingState() {
                this.saved = false;
                this.loading = true;
            },

            savedState() {
                this.saved = true;
                this.loading = false;
            },

            axiosError(response) {
                this.savedState();
                core.error('Error ' + response.status + ': ' + response.data.error);
            },

            formatPrice(value) {
                return(core.formatPrice(value));
            },
        }
    }
</script>

<style>

</style>
