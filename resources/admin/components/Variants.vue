
<template>
    <div>
        <b-table :data="items"
                 :hoverable="true"
                 default-sort="code"
                 icon-pack="fas"
                 class="table-vertical-center">
            <template slot-scope="props">
                <b-table-column field="images" label="Фото" width="5%" sortable centered>
                    <span v-if="props.row.images.length" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="code" label="Артикул" width="10%" sortable class="has-text-left is-italic">
                    <span :class="[!props.row.code ? 'has-text-grey-light' : '']">{{ (props.row.code) ? props.row.code : '[empty]' }}</span>
                </b-table-column>

                <b-table-column field="parameters" label="Параметры" width="30%" centered>
                    <div class="buttons is-centered">
                        <button v-for="(parameter, key) in parameters" v-if="props.row.parameters[key]" class="button is-rounded is-small is-static">
                            {{ props.row.parameters[key] }}
                        </button>
                    </div>
                </b-table-column>

                <b-table-column field="stock" label="Остаток" width="15%" sortable centered>
                    <b-field>
                        <b-input v-model.number="props.row.stock" @change.native="update(props.row)"
                                 @keypress.native="banDecimal($event)" type="number" />
                        <div class="control"><div class="button is-static">шт</div></div>
                    </b-field>
                </b-table-column>

                <b-table-column field="surcharge" label="Цена/наценка" width="20%" sortable centered>
                    <b-field>
                        <div class="control has-icons-right">
                            <b-input v-model.number="props.row.price" disabled />
                            <span class="icon is-small is-right">{{ currency.sign }}</span>
                        </div>
                        <b-input v-model.number="props.row.surcharge" @input.native="updatePrice(props.row)"
                                 @change.native="update(props.row)" type="number" step="any" />
                    </b-field>
                </b-table-column>

                <b-table-column field="is_sale" label="Скидка" width="10%" sortable centered>
                    <b-checkbox v-model="props.row.is_sale" :disabled="!product.is_sale"
                                @change.native="updatePrice(props.row); update(props.row);" />
                </b-table-column>

                <b-table-column field="id" label="Действия" width="10%" centered>
                    <button class="button fas fa-pen" type="button" @click="edit(props.row)" />
                    <button class="button fas fa-trash-alt" type="button" @click="destroy(props.row)" />
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>

        <b-modal :active.sync="modal" aria-modal class="modal-edit-variant">
            <div class="box">
                <form @submit.prevent="save" @change="autoSave" @keyup="saved=false">
                    <card-component title="Параметры варианта">
                        <div class="columns">
                            <div class="column">
                                <b-field label="Артикул" label-position="on-border">
                                    <b-input v-model="item.code" placeholder="Уникальный идентификатор" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Штрих-код" label-position="on-border">
                                    <b-input v-model="item.barcode" placeholder="Штрих-код товара" />
                                </b-field>
                            </div>
                        </div>

                        <div class="columns">
                            <div v-for="(parameter, key) in parameters" class="column">
                                <b-field :label="parameter.title" label-position="on-border">
                                    <b-input v-if="item.parameters" v-model="item.parameters[key]" :placeholder="'Параметр [' + parameter.title + ']'" required />
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
                        <images-upload @update="updateImages" :web-route="`/admin/variant/${item.id}`" :images-array="item.images" image-width="20%" />
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
        name: 'Variants',

        components: {
            ImagesUpload,
            CardComponent
        },

        props: ['product', 'currency', 'discount'],

        data() {
            return {
                item: {},
                items: [],
                parameters: [],
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
            axios.get(`/admin/variant/${this.product.id}`)
                .then((res) => {
                    this.items = res.data.items;
                    this.parameters = res.data.parameters;
                })
                .catch(error => core.ajaxError(error.response))
                .then(() => this.statusSaved());
        },

        methods: {
            create() {
                this.item = {
                    id: null,
                    product_id: this.product.id,
                    category_id: this.product.category_id,
                    is_active: this.product.is_active,
                    is_sale: this.product.is_sale,
                    price: (this.product.is_sale) ? this.product.surcharge : this.product.price,
                    parameters: {},
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
                for(let parameter in this.parameters) {
                    if(!this.item.parameters[parameter]) {
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
                axios.post(`/admin/variant/store`, item)
                    .then((res) => {
                        this.item = res.data.variant;
                        this.items.push(item);
                        this.item.savedCode = this.item.code;
                        this.$emit('update', this.items.length);
                    })
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.statusSaved());
            },

            update(item) {
                this.statusLoading();
                axios.post(`/admin/variant/${item.id}/update`, item)
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

                    axios.post(`/admin/variant/${item.id}/destroy`)
                        .catch((error) => core.ajaxError(error.response))
                        .then(() => this.statusSaved());
                });
            },

            updatePrice(item) {
                if(Number.isFinite(+this.product.price) && Number.isFinite(+item.surcharge)) {
                    item.price = +this.product.price + +item.surcharge;
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
    .modal-edit-variant .modal-content {
        width: 650px;
    }
    .modal-edit-variant .box {
        width: 100%;
    }
    .modal-edit-variant .card-images .card-content {
        padding: .5rem;
    }
</style>
