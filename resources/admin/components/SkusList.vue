
<template>
    <div>
        <b-table :data="items"
                 :striped="true"
                 :hoverable="true"
                 :narrowed="true"
                 default-sort="code"
                 class="table-vertical-center">
            <template slot-scope="props">
                <b-table-column field="code" label="Артикул" class="has-text-left is-italic">
                    {{ props.row.code }}
                </b-table-column>
                <b-table-column field="options" label="Параметры" centered class="nowrap">
                    <button v-for="(option, key) in options" v-if="props.row.options[key]" class="button is-small is-static">
                        {{ props.row.options[key] }}
                    </button>
                </b-table-column>
                <b-table-column field="extra_charge" label="Наценка" centered>
                    <b-input v-model.number="props.row.extra_charge" @input.native="updatePrice(props.row)" @change.native="update(props.row)" type="number" />
                </b-table-column>
                <b-table-column field="price" label="Цена" centered>
                    <b-input v-model.number="props.row.price" @change.native="update(props.row)" disabled />
                </b-table-column>
                <b-table-column field="code" label="Остаток" centered>
                    <b-input v-model.number="props.row.stock" width="5" @change.native="update(props.row)"
                             @keypress.native="banDecimal($event)" type="number" />
                </b-table-column>
                <b-table-column field="images" label="Фото" centered>
                    <span v-if="props.row.images.length" class="icon has-text-info">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column field="id" label="Активен" centered>
                    <b-switch v-model="props.row.is_active"  @change.native="update(props.row)" />
                </b-table-column>
                <b-table-column field="id" label="Действия" centered>
                    <button class="button fas fa-pen" type="button" @click="edit(props.row)"></button>
                    <button class="button fas fa-trash-alt" type="button" @click="destroy(props.row)"></button>
                </b-table-column>
            </template>
        </b-table>
        <br>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>

        <b-modal :active.sync="modal" has-modal-card aria-modal>
            <div class="modal-card">
                <div class="modal-card-head" />
                <div class="modal-card-body">
                    <form @submit.prevent="save" @change="autoSave" @keyup="saved=false">
                        <card-component title="Характеристики">
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
                        <br>
                        <card-component v-if="item.id" title="Фотографии (опционально)">
                            <images-upload @update="updateImages" :images-array="item.images"
                                           :web-route="`/admin/sku/${item.id}`" image-width="20%" />
                        </card-component>
                    </form>
                </div>
                <footer class="modal-card-foot">
                    <button :disabled="saved" @click="save" :class="{ 'is-loading': loading }"
                            class="button is-primary" type="button">Сохранить</button>
                    <button class="button" type="button" @click="modal=false">Закрыть</button>
                </footer>
            </div>
        </b-modal>

    </div>
</template>

<script>
    import axios from 'axios';
    import core from "./../js/Core";
    import ImagesUpload from "./ImagesUpload";
    import CardComponent from "./CardComponent";

    // format price
    // error

    // save sku prices

    export default {
        name: 'SkusList',

        components: {
            ImagesUpload,
            CardComponent
        },

        props: ['product', 'discount'],

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
            'items.length': function () {
                this.$emit('update', this.items.length);
            },

            'product.price': function () {
                this.items.forEach((item) => this.updatePrice(item));
            },

            'discount': function () {
                this.items.forEach((item) => this.updatePrice(item));
            },
        },

        mounted() {
            axios.get(`/admin/sku/${this.product.id}`)
                .then((res) => {
                    this.items = res.data.items;
                    this.options = res.data.options;
                })
                .catch(error => this.error(error.response));
        },

        methods: {
            create() {
                this.modal = true;
                this.item = {
                    id: null,
                    product_id: this.product.id,
                    category_id: this.product.category_id,
                    is_active: true,
                    extra_charge: 0,
                    price: this.product.price,
                    stock: 0,
                    options: {},
                    images: [],
                };
            },

            edit(item) {
                this.item = item;
                this.item.savedCode = this.item.code;
                this.modal = true;
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

            autoSave() {
                this.save(false);
            },

            store(item) {
                this.statusLoading();
                axios.post(`/admin/sku/store`, item)
                    .then((res) => {
                        this.item.id = res.data.id;
                        this.items.push(item);
                        this.edit(item.id);
                        this.statusSaved();
                    })
                    .catch((error) => this.error(error.response));
            },

            update(item) {
                this.statusLoading();
                axios.post(`/admin/sku/update`, { items: [item] })
                    .then(() => this.statusSaved())
                    .catch((error) => {
                        this.error(error.response);
                        this.item.code = this.item.savedCode;
                    });
            },

            destroy(item) {
                this.$buefy.dialog.confirm({ message: 'Удалить?', confirmText: 'Да', cancelText: 'Нет',
                    onConfirm: () => {
                        this.items = this.items.filter((each) => each !== item);

                        axios.post(`/admin/sku/${item.id}/destroy`)
                            .catch((error) => this.error(error.response));
                    }
                });
            },

            updatePrice(item) {
                if(Number.isFinite(+this.product.price) && Number.isFinite(+item.extra_charge)) {
                    item.price = ((+this.product.price + +item.extra_charge) * (100 - this.discount) / 100).toFixed(2);
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

            error(response) {
                this.statusSaved();
                console.log(response);
                core.error(`Error ${response.status}: ${response.data.error}`);
            },
        }
    }
</script>

<style scoped>

</style>
