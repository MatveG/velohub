<template>
    <div>
        <!--        <title-bar :title-stack="titleStack"/>-->
        <section class="section is-main-section">
            <div class="buttons is-right">
                <button :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
                <button class="button fas fa-arrow-circle-left"></button>
            </div>
            <form @submit.prevent="update()" @change="autoUpdate()" @keyup="saved=false">
                <div class="columns">
                    <div class="column is-three-quarters">
                        <card-component title="Информация">
                            <b-tabs v-model="activeTab" type="is-boxed">
                                <b-tab-item label="Название">
                                    <b-field label="Наименование" message="Пример: Конфеты" horizontal>
                                        <b-input v-model="item.name" required />
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
                                    <b-field v-for="(feature, key) in item.category.features" :label="feature.title" :message="feature.units" horizontal>
                                        <b-input v-model="item.features[key]" />
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
                        <br>
                        <card-component title="Фотографии">
                            <images-upload v-if="item.id" @update="imagesUpdate" :images-array="item.images" :web-route="`/admin/product/${item.id}`" image-width="20%" />
                        </card-component>
                        <br>
                        <card-component title="Варианты товара">
                            <skus-list v-if="item.id" @update="skusUpdate" :product="item" :discount="discount" />
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
                            <br>
                            <b-field label="Категория" label-position="on-border">
                                <b-select v-model="item.category_id" @select="autoUpdate()" expanded>
                                    <template v-for="category in categories">
                                        <optgroup v-if="category.is_parent" :label="category.name">
                                            <option v-for="child in category.child" :value="child.id">{{ child.name }}</option>
                                        </optgroup>
                                        <option v-else :value="category.id">{{ category.name }}</option>
                                    </template>
                                </b-select>
                            </b-field>
                        </card-component>
                        <br>
                        <card-component title="Цена">
                            <b-field label="Цена" label-position="on-border">
                                <b-input v-model.number="item.price" type="number" step="any" />
                                <div class="control"><div class="button is-static">{{ item.currency.sign }}</div></div>
                            </b-field>
                            <b-field class="has-text-centered">
                                <b-switch v-model="item.is_sale" @change.native="toggleDiscount">Скидка</b-switch>
                            </b-field>

                            <div v-if="item.is_sale" class="buttons is-centered">
                                <button @click="setDiscount(1)" type="button" class="button is-info is-outlined is-rounded is-small">1%</button>
                                <button @click="setDiscount(3)" type="button" class="button is-info is-outlined is-rounded is-small">3%</button>
                                <button @click="setDiscount(5)" type="button" class="button is-info is-outlined is-rounded is-small">5%</button>
                                <button @click="setDiscount(7)" type="button" class="button is-info is-outlined is-rounded is-small">7%</button>
                                <button @click="setDiscount(15)" type="button" class="button is-info is-outlined is-rounded is-small">15%</button>
                                <button @click="setDiscount(20)" type="button" class="button is-info is-outlined is-rounded is-small">20%</button>
                                <button @click="setDiscount(25)" type="button" class="button is-info is-outlined is-rounded is-small">25%</button>
                            </div>

                            <b-field v-if="item.is_sale" label="Цена со скидкой" label-position="on-border">
                                <b-input v-model.number="item.price_sale" :disabled="!item.is_sale" type="number" step="any" />
                                <div class="control"><div class="button is-static">{{ item.currency.sign }}</div></div>
                            </b-field>
                        </card-component>
                        <br>
                        <card-component title="Наличие" v-if="!skusCount">
                            <b-field label="Артикул" label-position="on-border">
                                <b-input v-model="item.code" />
                            </b-field>
                            <b-field label="Штрих-код" label-position="on-border">
                                <b-input v-model="item.barcode" />
                            </b-field>
                            <b-field class="has-text-centered">
                                <b-switch v-model="item.is_stock">Наличие</b-switch>
                            </b-field>
                            <br>
                            <div class="columns">
                                <b-field label="Запас на складе" label-position="on-border" class="column">
                                    <b-input v-model.number="item.stock" :disabled="!item.is_stock" type="number" />
                                    <div class="control"><div class="button is-static">шт</div></div>
                                </b-field>
                                <b-field label="Вес" label-position="on-border" class="column">
                                    <b-input v-model.number="item.weight" type="number" step="any" />
                                    <div class="control"><div class="button is-static">кг</div></div>
                                </b-field>
                            </div>
                        </card-component>
                    </div>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
    import axios from 'axios'
    import CardComponent from './../components/CardComponent'
    import SkusList from './../components/SkusList'
    import ImagesUpload from "./../components/ImagesUpload";
    import core from "../js/Core";

    export default {
        name: 'ClientForm',

        components: {
            CardComponent,
            SkusList,
            ImagesUpload,
        },

        props: {
            id: null,
        },

        data () {
            return {
                item: {
                    category: {},
                    currency: {},
                },
                categories: [],
                discount: 0,
                activeTab: 0,
                skusCount: 0,
                loading: false,
                saved: true,
            }
        },

        mounted () {
            if (!this.id) {
                core.error('Error loading product');
            }
            axios.get(`/admin/products/${this.id}/edit/`)
                .then((res) => {
                    this.item = res.data.item;
                    //this.discountAmount = 100-this.item.price_sale/this.item.price*100;

                    this.$watch('item.is_stock', () => this.item.stock = +this.item.is_stock);
                })
                .catch((error) => this.error(error.response));

            axios.get('/admin/categories/tree/')
                .then((res) => this.categories = res.data.categories)
                .catch((error) => this.error(error.response));
        },

        watch: {
            // 'item.is_sale': function () {
            //     if (this.item.is_sale) {
            //         this.item.price_sale = this.item.price;
            //     } else {
            //         this.discount = 0;
            //         this.item.price_sale = this.item.price;
            //     }
            // },
            // 'item.price': function () {
            //     this.item.price_sale = (this.item.price*(100-this.discountAmount)/100).toFixed(2);
            // },
            'item.price_sale': function () {
                this.discount = this.item.price - this.item.price_sale;
            },
            // 'discountAmount': function () {
            //     this.item.price_sale = (this.item.price*(100-this.discountAmount)/100).toFixed();
            // },
        },

        methods: {
            update() {
                this.loadingState();
                axios.post(`/admin/products/${this.item.id}/update`, this.item)
                    .then((res) => {
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
                this.discount = 0;
                this.item.price_sale = (this.item.is_sale) ? this.item.price : 0;
            },

            setDiscount(amount) {
                this.discount = Math.round(this.item.price * amount / 100);
                this.item.price_sale = this.item.price - this.discount;
                this.update();
            },

            imagesUpdate(newImages) {
                this.item.images = newImages;
            },

            skusUpdate(skusCount) {
                this.skusCount = skusCount;
            },

            loadingState() {
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
