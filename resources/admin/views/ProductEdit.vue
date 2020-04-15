<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
            <button class="button fas fa-arrow-circle-left"></button>
        </div>
        <form @submit.prevent="update()" @change="autoUpdate()" @keyup="saved=false">
            <div class="columns">
                <div class="column is-two-thirds">
                    <card-component title="Основная информация">
                        <b-tabs v-model="activeTab" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Пример: Конфеты" horizontal>
                                    <b-input v-model="item.title" required />
                                </b-field>
                                <b-field label="Бренд" message="Пример: M&M's" horizontal>
                                    <b-input v-model="item.brand" required />
                                </b-field>
                                <b-field label="Модель" message="Пример: Milk Chocolate" horizontal>
                                    <b-input v-model="item.model" required />
                                </b-field>
                            </b-tab-item>
                            <b-tab-item label="Описание">
                                <b-field label="Короткое описание" horizontal>
                                    <b-input v-model="item.brief" type="textarea" />
                                </b-field>
                                <b-field label="Полное описание" horizontal>
                                    <b-input v-model="item.text" type="textarea" />
                                </b-field>
                            </b-tab-item>

                            <b-tab-item label="Характеристики">
                                <b-field v-for="(feature, key) in item.category.features" :label="feature.title" horizontal>
                                    <div class="control has-icons-right">
                                        <b-input v-model="item.features[key]" />
                                        <span class="icon is-small is-right">{{ feature.units }}</span>
                                    </div>
                                </b-field>
                            </b-tab-item>

                            <b-tab-item label="SEO">
                                <b-field label="URL товара" horizontal>
                                    <b-input v-model="item.latin" custom-class="is-static" readonly />
                                </b-field>
                                <b-field label="Заголовок" message="Тег title" horizontal>
                                    <b-input v-model="item.seo_title" />
                                </b-field>
                                <b-field label="Описание" message="Тег description" horizontal>
                                    <b-input v-model="item.seo_description" />
                                </b-field>
                                <b-field label="Ключевые слова" message="Тег keywords" horizontal>
                                    <b-input v-model="item.seo_keywords" />
                                </b-field>
                            </b-tab-item>
                        </b-tabs>
                    </card-component>

                    <card-component title="Фотографии" class="margin-line">
                        <images-upload v-if="item.id" @update="imagesUpdate" :images-array="item.images" :web-route="`/admin/product/${item.id}`" image-width="20%" />
                    </card-component>
                </div>

                <div class="column">
                    <card-component :title="`ID товара: ${id}`" class="tile is-child">
                        <b-field class="has-text-centered">
                            <b-switch v-model="item.is_active">Активен</b-switch>
                        </b-field>
                        <div class="has-text-centered">
                            <p><a href="" class="button" target="_blank">Посмотреть на сайте</a></p>
                        </div>
                        <b-field label="Категория" label-position="on-border" class="margin-line">
                            <b-select v-model="item.category_id" @select="autoUpdate()" expanded>
                                <template v-for="category in categories">
                                    <optgroup v-if="category.is_parent" :label="category.title">
                                        <option v-for="child in category.child" :value="child.id">{{ child.title }}</option>
                                    </optgroup>
                                    <option v-else :value="category.id">{{ category.title }}</option>
                                </template>
                            </b-select>
                        </b-field>
                    </card-component>

                    <card-component title="Цена" class="margin-line">
                        <b-field label="Цена" label-position="on-border">
                            <b-input v-model.number="item.price" type="number" step="any" placeholder="0.0" expanded />
                            <div class="control">
                                <div class="button is-static">{{ currency.sign }}</div>
                            </div>
                        </b-field>
                        <b-field class="has-text-centered">
                            <b-switch v-model="item.is_sale" @change.native="toggleDiscount">Скидка</b-switch>
                        </b-field>

                        <div v-if="item.is_sale">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Размер скидки" label-position="on-border">
                                        <b-input v-model="discount.percent" @change.native="computeDiscount" type="number" step="any" placeholder="0" />
                                        <div class="control">
                                            <button class="button is-primary">%</button>
                                        </div>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Цена со скидкой" label-position="on-border">
                                        <b-input v-model.number="item.price_sale" :disabled="!item.is_sale" type="number" step="any" placeholder="0.0" expanded />
                                        <div class="control">
                                            <div class="button is-static">{{ currency.sign }}</div>
                                        </div>
                                    </b-field>
                                </div>
                            </div>
                            <b-field label="Детали акции" label-position="on-border">
                                <b-input v-model="item.sale_text" type="textarea" rows="1" />
                            </b-field>
                        </div>
                    </card-component>

                    <card-component v-if="!variantsCount" title="Наличие" class="margin-line">
                        <b-field label="Артикул" label-position="on-border">
                            <b-input v-model="item.code" />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="item.barcode" />
                        </b-field>
                        <b-field class="has-text-centered">
                            <b-switch v-model="item.is_stock">Наличие</b-switch>
                        </b-field>
                        <div class="columns margin-line">
                            <b-field label="Запас на складе" label-position="on-border" class="column">
                                <b-input v-model.number="item.stock" :disabled="!item.is_stock" type="number" placeholder="0" />
                                <div class="control">
                                    <div class="button is-static">шт</div>
                                </div>
                            </b-field>
                            <b-field label="Вес" label-position="on-border" class="column">
                                <b-input v-model.number="item.weight" type="number" step="any" placeholder="0.0" />
                                <div class="control">
                                    <div class="button is-static">кг</div>
                                </div>
                            </b-field>
                        </div>
                    </card-component>
                </div>
            </div>
        </form>
        <card-component title="Варианты товара" class="margin-line">
            <variants v-if="item.id" @update="variantsUpdate" :product="item" :currency="currency" :discount="discount.amount" />
        </card-component>
    </section>
</template>

<script>
    import axios from 'axios'
    import CardComponent from './../components/CardComponent'
    import Variants from "../components/Variants";
    import ImagesUpload from "./../components/ImagesUpload";
    import core from "../js/Core";

    // check products codes too
    // modal scroll?
    // timer on auto update

    export default {
        name: 'ClientForm',

        components: {
            Variants,
            CardComponent,
            ImagesUpload,
        },

        props: {
            id: null,
        },

        data () {
            return {
                item: {
                    category: {},
                },
                discount: {
                    amount: 0,
                    percent: null,
                },
                categories: [],
                variantsCount: 0,
                currency: '',
                activeTab: 0,
                loading: false,
                saved: true,
            }
        },

        mounted () {
            if (!this.id) {
                core.error('Error loading product');
            }
            axios.get(`/admin/product/${this.id}/edit/`)
                .then((res) => {
                    this.item = res.data.item;
                    this.variantsCount = res.data.variantsCount;
                    this.currency = res.data.currency;

                    this.$watch('item.is_stock', () => this.item.stock = +this.item.is_stock); // !!!
                })
                .catch((error) => this.error(error.response));

            axios.get('/admin/categories/tree/')
                .then((res) => this.categories = res.data.categories)
                .catch((error) => this.error(error.response));
        },

        watch: {
            'item.price_sale': function () {
                this.discount.amount = this.item.price - this.item.price_sale;
            },
        },

        methods: {
            update() {
                this.statusLoading();
                console.log('update product');
                axios.post(`/admin/product/${this.item.id}/update`, this.item)
                    .then((res) => {
                        if(res.data.latin) {
                            this.item.latin = res.data.latin;
                        }

                        if(res.data.category) {
                            this.item.category = res.data.category;
                        }
                        this.savedState();
                    })
                    .catch((error) => this.error(error.response));
            },

            autoUpdate() {
                this.update();
            },

            toggleDiscount() {
                this.discount.amount = 0;
                this.item.price_sale = (this.item.is_sale) ? this.item.price : 0;
            },

            computeDiscount() {
                this.discount.amount = Math.round(this.item.price * this.discount.percent / 100);
                this.item.price_sale = this.item.price - this.discount.amount;
                this.discount.percent = null;
            },

            imagesUpdate(newImages) {
                this.item.images = newImages;
            },

            variantsUpdate(variantsCount) {
                if(variantsCount > 0) {
                    this.item.code = '';
                    this.item.barcode = '';
                    this.item.stock = '';
                    this.item.weight = '';
                    this.item.is_stock = false;
                }
                this.variantsCount = variantsCount;
            },

            statusLoading() {
                this.saved = false;
                this.loading = true;
            },

            savedState() {
                this.saved = true;
                this.loading = false;
            },

            error(response) {
                this.savedState();
                console.log(response);
                core.error(`Error ${response.status}: ${response.data.error}`);
            },
        }
    }
</script>

<style>
    .w-50 {
        width: 50px;
    }
</style>
