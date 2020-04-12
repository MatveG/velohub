
<template>
    <div>
        <b-table :data="items"
                 :hoverable="true"
                 default-sort="code"
                 class="table-vertical-center">
            <template slot-scope="props">
                <b-table-column field="images" label="Фото" centered>
                    <span v-if="props.row.images.length" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="code" label="Артикул" class="has-text-left is-italic">
                    {{ props.row.code }}
                </b-table-column>

                <b-table-column field="options" label="Параметры" width="150" centered>
                    <div class="buttons is-centered">
                        <button v-for="(option, key) in options" v-if="props.row.options[key]" class="button is-rounded is-small is-static">
                            {{ props.row.options[key] }}
                        </button>
                    </div>
                </b-table-column>

                <b-table-column field="code" label="Остаток" width="110" centered>
                    <b-field>
                        <b-input v-model.number="props.row.stock" @change.native="update(props.row)"
                                 @keypress.native="banDecimal($event)" size="is-small" type="number" />
                        <div class="control"><div class="button is-static is-small">шт</div></div>
                    </b-field>
                </b-table-column>

                <b-table-column field="images" label="Скидка" width="50" centered>
                    <b-checkbox v-model="props.row.is_sale" :disabled="!product.is_sale"
                                @change.native="updatePrice(props.row); update(props.row);" />
                </b-table-column>

                <b-table-column field="increment" label="Наценка(+/-)" width="100" centered>
                    <b-field>
                        <b-input v-model.number="props.row.price" size="is-small" disabled />
                        <div class="control"><div class="button is-static is-small">{{ currency.sign }}</div></div>
                    </b-field>
                    <b-input v-model.number="props.row.increment" @input.native="updatePrice(props.row)"
                             @change.native="update(props.row)" size="is-small" type="number" />
                </b-table-column>

                <b-table-column field="id" label="Действия" centered>
                    <button class="button fas fa-pen" type="button" @click="edit(props.row)" />
                    <button class="button fas fa-trash-alt" type="button" @click="destroy(props.row)" />
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>

        <b-modal :active.sync="modal" aria-modal class="modal-edit-sku">
            <div class="box">
                <form @submit.prevent="save" @change="autoSave" @keyup="saved=false">
                    <card-component title="Параметры варианта">
                        <div class="columns">
                            <div class="column">
                                <b-field label="Артикул" label-position="on-border">
                                    <b-input v-model="item.code" placeholder="Уникальный идентификатор" required />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Штрих-код" label-position="on-border">
                                    <b-input v-model="item.barcode" placeholder="Штрих-код товара" />
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div v-for="(option, key) in options" class="column">
                                <b-field :label="option.title" label-position="on-border">
                                    <b-input v-if="item.options" v-model="item.options[key]" :placeholder="'Параметр [' + option.title + ']'" required />
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column" />
                            <div class="column">
                                <b-field label="Вес" label-position="on-border">
                                    <b-input v-model="item.weight" placeholder="Вес доставки" />
                                    <div class="control"><div class="button is-static">кг</div></div>
                                </b-field>
                            </div>
                            <div class="column" />
                        </div>
                    </card-component>
                    <card-component v-if="item.id" title="Собственные фото" class="card-images margin-line">
                        <images-upload @update="updateImages" :web-route="`/admin/sku/${item.id}`" :images-array="item.images" image-width="20%" />
                    </card-component>
                    <div class="buttons margin-line is-centered">
                        <button :disabled="saved" @click="save" :class="{ 'is-loading': loading }"
                                type="button" class="button is-primary">Сохранить</button>
                        <button @click="modal=false" type="button"s class="button">Закрыть</button>
                    </div>
                </form>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import core from "./../js/Core";
    import ImagesUpload from "./ImagesUpload";
    import CardComponent from "./CardComponent";

    export default {
        name: 'SkusList',

        components: {
            ImagesUpload,
            CardComponent
        },

        props: ['product', 'currency', 'discount'],

        data() {
            return {
                item: {},
                items: [],
                options: [],
                modal: false,
                loading: false,
                saved: true,
            }
        },

        watch: {
            'discount': function () {
                this.items.forEach((item) => this.updatePrice(item));
            },

            'product.price': function () {
                this.items.forEach((item) => this.updatePrice(item));
            },

            'product.is_sale': function () {
                this.items.forEach((item) => item.is_sale = this.product.is_sale);
            },
        },

        mounted() {
            axios.get(`/admin/sku/${this.product.id}`)
                .then((res) => {
                    this.items = res.data.items;
                    this.options = res.data.options;
                })
                .catch(error => core.ajaxError(error.response))
                .then(() => this.statusSaved());
        },

        // rename 'name' in Product
        // format info block
        // modal scroll?

        methods: {
            create() {
                this.item = {
                    id: null,
                    product_id: this.product.id,
                    category_id: this.product.category_id,
                    is_active: this.product.is_active,
                    is_sale: this.product.is_sale,
                    price: (this.product.is_sale) ? this.product.price_sale : this.product.price,
                    increment: 0,
                    stock: 0,
                    options: {},
                    images: [],
                };

                this.modal = true;
            },

            edit(item) {
                this.item = item;
                this.item.savedCode = this.item.code;
                this.modal = true;
            },

            autoSave() {
                this.save(false);
            },

            save(submit = true) {
                for(let option in this.options) {
                    if(!this.item.options[option]) {
                        if(submit) {
                            core.error('Заполните параметры товара');
                        }
                        return;
                    }
                }
                this[(this.item.id) ? 'update' : 'store'](this.item);
            },

            store(item) {
                this.statusLoading();
                axios.post(`/admin/sku/store`, item)
                    .then((res) => {
                        this.item.id = res.data.id;
                        this.items.push(item);

                        this.item.savedCode = this.item.code;
                        this.$emit('update', this.items.length);
                    })
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.statusSaved());
            },

            update(item) {
                this.statusLoading();
                console.log('update sku');
                axios.post(`/admin/sku/${item.id}/update`, item)
                    .then(() => this.$emit('update', this.items.length))
                    .catch((error) => {
                        core.ajaxError(error.response);
                        this.item.code = this.item.savedCode;
                    })
                    .then(() => this.statusSaved());
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.items = this.items.filter((each) => each !== item);
                    this.$emit('update', this.items.length);

                    axios.post(`/admin/sku/${item.id}/destroy`)
                        .catch((error) => core.ajaxError(error.response))
                        .then(() => this.statusSaved());
                });
            },

            updatePrice(item) {
                if(Number.isFinite(+this.product.price) && Number.isFinite(+item.increment)) {
                    item.price = +this.product.price + +item.increment;
                    item.price -= (this.product.is_sale && item.is_sale) ? this.discount : 0;
                }
            },

            updateImages(value) {
                this.item.images = value;
            },

            statusLoading() {
                this.saved = false;
                this.loading = true;
            },

            statusSaved() {
                this.saved = true;
                this.loading = false;
            },

            banDecimal(event) {
                core.banDecimal(event);
            },
        }
    }
</script>

<style scoped>
    .field {
        margin-bottom: .2rem !important;
    }
</style>

<style>
    .modal-edit-sku .modal-content {
        width: 650px;
    }
    .modal-edit-sku .box {
        width: 100%;
    }
    .modal-edit-sku .card-images .card-content {
        padding: .5rem;
    }
</style>
