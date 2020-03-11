
<template>
    <div>
        <button class="button" @click="create">add</button>

        <table class="table">
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
            </tbody>
        </table>

        <modal ref="modal">
            <div></div>
            <form v-on:submit.prevent>
                <div class="field">
                    <label class="label is-small">Наименование</label>
                    <div class="control">
                        <input class="input is-small" type="text" v-model="item.title" v-bind:class="{'is-danger': !item.title}">
                    </div>
                </div>
                <div class="field">
                    <label class="label is-small">Штрих-код</label>
                    <div class="control">
                        <input class="input is-small" type="text" v-model="item.barcode">
                    </div>
                </div>
                <div class="field">
                    <label class="label is-small">Артикулы</label>
                    <div class="control">
                        <textarea class="textarea is-small" rows="2" v-model="item.codesText" v-bind:class="{'is-danger': !item.codesText}"></textarea>
                    </div>
                </div>

                <div class="columns">
                    <div class="column" v-for="(option, key) in cols.options">
                        <label class="label is-small">Параметр - {{ option.title }}</label>
                        <input class="input is-small" type="text" v-if="item.options" v-model="item.options[key]">
                    </div>
                </div>
                <div class="columns">
                    <div class="column" v-for="(price, key) in cols.prices">
                        <label class="label is-small">Цена - {{ price.title }}</label>
                        <input class="input is-small" type="text" v-if="item.prices" v-model="item.prices[key]">
                    </div>
                </div>
                <div class="columns">
                    <div class="column" v-for="(stock, key) in cols.stocks">
                        <label class="label is-small">Склад - {{ stock.title }}</label>
                        <input class="input is-small" type="text" v-if="item.stocks" v-model="item.stocks[key]">
                    </div>
                </div>

                <div class="field" v-if="item.id">
                    <label class="label is-small">Фотографии</label>
                    <div class="control">
                        <div class="image-block" v-for="(file, key) in item.images">
                            <img class="image" :src="file" alt="">
                            <button class="delete" @click="deleteImage(key)">x</button>
                        </div>

                        <b-field class="file">
                            <b-upload v-model="file">
                                <a class="button is-primary">
                                    <span>Загрузить</span>
                                </a>
                            </b-upload>
                        </b-field>
                    </div>
                </div>

                <div class="buttons is-centered">
                    <button class="button is-primary" @click="submit">Сохранить</button>
                    <button class="button is-light" data-hide="modal">Закрыть</button>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
    import axios from 'axios'

    const blank = {
        id: null,
        is_active: false,
        is_default: false,
        options: { '-': null },
        prices: { '-': null },
        stocks: { '-': null },
        codesText: '',
        images: [],
    };

    export default {
        props: ['productId'],

        data() {
            return {
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
                this.item = blank;
                this.item.product_id = this.productId;
                this.$refs.modal.show();
            },

            edit(id) {
                this.item = blank;
                this.item = JSON.parse(JSON.stringify(this.items.find((item) => item.id === id)));
                this.item.codesText = this.item.codes.join('\n');

                if(!this.item.images) {
                    this.item.images = [];
                }
                this.$refs.modal.show();
            },

            submit() {
                if (!this.item.title) {
                    return;
                }
                if (!this.item.codesText || this.item.codesText.length < 3) {
                    return;
                }
                this.item.codes = this.item.codesText.split('\n');
                (this.item.id === null) ? this.store() : this.update();
            },

            store() {
                axios.post(`/admin/sku/store`, this.item).then((res) => {
                    this.item.id = res.data.id;
                    this.items.push(this.item);
                    this.edit(this.item.id);
                }).catch(error => console.log(error));
            },

            update() {
                axios.post(`/admin/sku/${this.item.id}/update`, this.item).catch(error => console.log(error));
                this.items.filter(item => (item.id === this.item.id) ? this.item : item);
                this.$refs.modal.hide();
            },

            destroy(id) {
                if (this.items.find((item) => item.id === id).is_default === true) {
                    alert('Невозможно удалить основную запись');
                    return;
                }
                axios.post(`/admin/sku/${id}/destroy`).catch(error => console.log(error));
                this.items.filter(item => item.id !== id);
            },

            setDefault(id) {
                axios.post(`/admin/sku/${id}/set-default`).catch(error => console.log(error));
            },

            uploadImage: function () {
                let settings = { headers: { 'content-type': 'multipart/form-data' } };
                let data = new FormData();
                data.append('image', this.file);

                axios.post(`/admin/sku/${this.item.id}/upload-image`, data, settings).then((res) => {
                    this.item.images.push(res.data.image);
                    this.items.filter(item => (item.id === this.item.id) ? this.item : item);
                    this.file = null;
                }).catch(error => console.log(error));
                //.catch(error => console.log(error.response.data.message) );
            },

            deleteImage: function (key) {
                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`).catch(error => console.log(error));
                this.item.images.splice(key, 1);
                this.items = this.items.filter(item => (item.id === this.item.id) ? this.item : item);
            }
        }
    }
</script>
