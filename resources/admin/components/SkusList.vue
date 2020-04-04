
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
        <button class="button is-primary is-pulled-right fa fa-plus" type="button" @click="create"></button>

        <b-modal :active.sync="modal" has-modal-card aria-modal>
            <div class="modal-card">
                <div class="modal-card-head">
                    <p class="modal-card-title">{{ title }}</p>
                </div>
                <div class="modal-card-body">
                    <form @submit="save()" @change="save()" @keyup="saved=false">
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

                        <upload-images v-if="item.id" @update="updateImages" :images-array="item.images"
                                       :web-route="`/admin/sku/${item.id}`" image-width="20%" />
                    </form>
                </div>

                <footer class="modal-card-foot">
                    <button :disabled="saved" @click="save()" :class="{ 'is-loading': loading }"
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
            draggable,
            ModalImage,
            UploadImages,
        },

        data() {
            return {
                title: 'Артикул',
                item: {},
                items: [],
                cols: [],
                modal: false,
                loading: false,
                saved: true,
            }
        },

        mounted() {
            axios.post(`/admin/sku/${this.productId}`)
                .then((res) => {
                    for (let data in res.data) {
                        this[data] = res.data[data];
                    }
                })
                .catch(error => this.error(error.response));
        },

        methods: {
            setDefault(id) {
                this.items.map((item) => item.is_default = (item.id === id));

                axios.post(`/admin/sku/${id}/set-default`)
                    .catch((error) => this.error(error.response));
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
                            .catch((error) => this.error(error.response));
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
                this.loadingState();

                this.item.codesText = this.item.codesText.replace(/(^[ \t]*\n)/gm, "").trim();
                this.item.codes = this.item.codesText.split('\n');
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
                    .catch((error) => this.error(error.response));
            },

            update() {
                axios.post(`/admin/sku/${this.item.id}/update`, this.item)
                    .then(() => this.savedState())
                    .catch((error) => {
                        this.error(error.response);
                        this.item.codes = this.item.backupCodes;
                        this.item.codesText = this.item.codes.join('\n');
                    });
            },

            updateImages(newImages) {
                this.item.images = newImages;
            },

            loadingState() {
                this.saved = false;
                this.loading = true;
            },

            savedState() {
                this.saved = true;
                this.loading = false;
            },

            formatPrice(value) {
                return core.formatPrice(value);
            },

            error(response) {
                this.savedState();
                core.error('Error ' + response.status + ': ' + response.data.error);
            },
        }
    }
</script>

<style scoped>

</style>
