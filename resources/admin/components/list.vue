
<template>
    <div>
        <button class="button" @click="create">add</button>

        <table class="table">
            <thead>
            <tr>
                <th>default</th>
                <th>is_active</th>
                <th>codes</th>
                <th>title</th>
                <th>barcode</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td>
                        <input type="radio" v-bind:checked="item.is_default"></input>
                    </td>
                    <td>
                        <input type="checkbox" v-bind:checked="item.is_active"></input>
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
                        <input class="input is-small" type="text" v-model="item.title">
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
                        <textarea class="textarea is-small" rows="2" v-model="item.codesText"></textarea>
                    </div>
                </div>

                <div class="columns">
                    <div class="column" v-for="(option, key) in options">
                        <label class="label is-small">{{ option.title }}</label>
                        <input class="input is-small" type="text" v-if="item.options" v-model="item.options[key]">
                    </div>
                </div>
                <div class="columns">
                    <div class="column" v-for="(price, key) in prices">
                        <label class="label is-small">Цена - {{ price.title }}</label>
                        <input class="input is-small" type="text" v-if="item.prices" v-model="item.prices[key]">
                    </div>
                </div>
                <div class="columns">
                    <div class="column" v-for="(stock, key) in stocks">
                        <label class="label is-small">Наличие - {{ stock.title }}</label>
                        <input class="input is-small" type="text" v-if="item.stocks" v-model="item.stocks[key]">
                    </div>
                </div>

                <div class="field">
                    <label class="label is-small">Фотографии</label>
                    <div class="control">
                        <div class="image-block" v-for="(file, key) in item.images">
                            <img class="image" :src="file" alt="">
                            <button class="delete" @click="destroyFile(key)">x</button>
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

    export default {
        data() {
            return {
                item: {},
                items: {},
                options: {},
                prices: {},
                stocks: {},
                file: null,
            }
        },

        mounted() {
            axios.get('/admin/sku/555').then((res) => {
                for (let data in res.data) {
                    this[data] = res.data[data];
                }
            });
        },

        watch: {
            'file': function () {
                if(this.file) {
                    this.uploadFile();
                }
            }
        },

        methods: {
            create() {
                this.item = { id: 0 };
                this.item.options = {};
                this.item.prices = {};
                this.item.stocks = {};
                this.item.is_active = false;
                this.item.is_default = false;
                this.item.images = [];

                this.$refs.modal.show();
            },

            edit(id) {
                this.item = { ...this.items.filter((item) => item.id === id)[0] };
                this.item.codesText = this.item.codes.join('\n');

                this.$refs.modal.show();
            },

            submit() {
                (this.item.id === 0) ? this.store() : this.update();
            },

            store() {
                this.item.codes = this.item.codesText.split('\n');

                axios.post('/admin/sku/555/store', this.item).then((res) => {
                    this.item.id = res.data.id;
                }).catch(function (error) {
                    console.log(error);
                });

                this.items.push(this.item);
            },

            update() {
                this.item.codes = this.item.codesText.split('\n');

                //this.item.options = Object.assign({}, this.item.options);
                console.log(this.item.options);

                axios.post('/admin/sku/555/update', {
                    id: this.item.id,
                    options: this.item.options,
                }).then((res) => {
                    console.log(res);
                }).catch(function (error) {
                    console.log(error);
                });

                this.items.filter(item => (item.id === this.item.id) ? this.item : item);

                this.$refs.modal.hide();
            },

            destroy: function (id) {
                // post destroy to ajax
                this.items = this.items.filter(item => item.id !== id);
            },

            uploadFile: function () {
                // axios post file
                this.files.push(this.file.name);
                this.file = null;
            },

            destroyFile: function (key) {
                // axios destroy file
                this.item.images.splice(key, 1);
            }
        }
    }
</script>


<style>
</style>
