<template>
    <section class="section is-main-section">

        <div class="buttons is-right">
            <button @click="save" :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
            <button @click="$router.push({ name: 'product' })" class="button fas fa-arrow-circle-left"></button>
        </div>

        <form @submit.prevent="save" @change="changed" @keyup="stateDraft">
            <div class="columns">
                <div class="column is-two-thirds">
                    <card-component title="Основная информация">
                        <b-tabs v-model="activeTab" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Пример: Конфеты" horizontal>
                                    <b-input v-model="product.title" required />
                                </b-field>
                                <b-field label="Бренд" message="Пример: M&M's" horizontal>
                                    <b-input v-model="product.brand" required />
                                </b-field>
                                <b-field label="Модель" message="Пример: Milk Chocolate" horizontal>
                                    <b-input v-model="product.model" required />
                                </b-field>
                            </b-tab-item>
                            <b-tab-item label="Описание">
                                <b-field label="Короткое описание" horizontal>
                                    <b-input v-model="product.summary" type="textarea" />
                                </b-field>
                                <b-field label="Полное описание" horizontal>
                                    <b-input v-model="product.description" type="textarea" />
                                </b-field>
                            </b-tab-item>

                            <b-tab-item label="Характеристики">
                                <template v-if="product.category">
                                    <b-field v-for="feature in product.category.features" :label="feature.title" horizontal>
                                        <div class="control has-icons-right">
                                            <b-input v-model="product.features[feature.key]" />
                                            <span class="icon is-small is-right">{{ feature.units }}</span>
                                        </div>
                                    </b-field>
                                </template>
                            </b-tab-item>

                            <b-tab-item label="SEO">
                                <b-field label="URL товара" horizontal>
                                    <b-input v-model="product.latin" custom-class="is-static" readonly />
                                </b-field>
                                <b-field label="Заголовок" message="Тег title" horizontal>
                                    <b-input v-model="product.seo_title" />
                                </b-field>
                                <b-field label="Описание" message="Тег description" horizontal>
                                    <b-input v-model="product.seo_description" />
                                </b-field>
                                <b-field label="Ключевые слова" message="Тег keywords" horizontal>
                                    <b-input v-model="product.seo_keywords" />
                                </b-field>
                            </b-tab-item>
                        </b-tabs>
                    </card-component>

                    <card-component title="Фотографии" class="margin-line">
                        <images-upload @update="assign('images', $event)" :prop-images="product.images"
                                       :prop-max="10" prop-width="20%" :prop-api="`/admin/products/${product.id}`" />
                    </card-component>
                </div>

                <div class="column">
                    <card-component :title="`ID товара: ${product.id}`" class="tile is-child">
                        <b-field class="has-text-centered">
                            <b-switch v-model="product.is_active">Активен</b-switch>
                        </b-field>
                        <div class="has-text-centered">
                            <p><a href="" class="button" target="_blank">Посмотреть на сайте</a></p>
                        </div>
                        <b-field label="Категория" label-position="on-border" class="margin-line">
                            <b-select v-model="product.category_id" @select="changed()" expanded>
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
                            <b-input v-model.number="product.price" type="number" step="any" placeholder="0.0" expanded />
                            <div class="control">
                                <div class="button is-static">{{ currency.sign }}</div>
                            </div>
                        </b-field>

                        <b-field class="has-text-centered">
                            <b-switch v-model="product.is_sale" @change.native="toggleDiscount">Скидка</b-switch>
                        </b-field>

                        <div v-if="product.is_sale">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Скидка" label-position="on-border">
                                        <b-input v-model="discount.percent" @change.native="calcPriceSale" type="number" step="any" placeholder="0" />
                                        <div class="control">
                                            <button class="button is-primary">%</button>
                                        </div>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Цена со скидкой" label-position="on-border">
                                        <b-input v-model.number="product.price_sale" :disabled="!product.is_sale" type="number" step="any" placeholder="0.0" expanded />
                                        <div class="control">
                                            <div class="button is-static">{{ currency.sign }}</div>
                                        </div>
                                    </b-field>
                                </div>
                            </div>
                            <b-field label="Детали акции" label-position="on-border">
                                <b-input v-model="product.sale_text" type="textarea" rows="1" />
                            </b-field>
                        </div>
                    </card-component>

                    <card-component v-if="!product.variants" title="Наличие" class="margin-line">
                        <b-field label="Артикул" label-position="on-border">
                            <b-input v-model="product.code" />
                        </b-field>
                        <b-field label="Штрих-код" label-position="on-border">
                            <b-input v-model="product.barcode" />
                        </b-field>
                        <b-field class="has-text-centered">
                            <b-switch v-model="product.is_stock">Наличие</b-switch>
                        </b-field>
                        <div class="columns margin-line">
                            <b-field label="Запас на складе" label-position="on-border" class="column">
                                <b-input v-model.number="product.stock" :disabled="!product.is_stock" type="number" placeholder="0" />
                                <div class="control">
                                    <div class="button is-static">шт</div>
                                </div>
                            </b-field>
                            <b-field label="Вес" label-position="on-border" class="column">
                                <b-input v-model.number="product.weight" type="number" step="any" placeholder="0.0" />
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
            <variants v-if="product.id" @update="product.variants=$event" :discount="discount.amount" />
        </card-component>
    </section>
</template>

<script>
    import {required, minLength, maxLength} from 'vuelidate/lib/validators'
    import {mapGetters} from "vuex";
    import {states} from '@/mixins/states';
    import CardComponent from '@/components/CardComponent'
    import ImagesUpload from "@/components/ImagesUpload";
    import Variants from "../components/ProductVariants";

    export default {
        name: 'ProductEdit',

        components: {
            CardComponent,
            ImagesUpload,
            Variants
        },

        mixins: [states],

        props: {
            propId: {
                type: [String, Number],
                default: null
            },
        },

        data () {
            return {
                discount: {
                    amount: 0,
                    percent: null,
                },
                currency: {}, // !!!
                activeTab: 0,
            }
        },

        computed: mapGetters(['product', 'categories']),

        validations: {
            product: {
                model: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(255)
                }
            }
        },

        mounted () {
            this.$store.commit('resetProduct');

            if (this.propId) {
                this.$store.dispatch('fetchProduct', {id: this.propId});
            } else if (this.propParent) {
                this.saved = false;
            }

            this.$store.dispatch('fetchCategories');

            this.$watch('product.is_stock', () => this.product.stock = +this.product.is_stock);
        },

        watch: {
            'product.price_sale': function () {
                this.discount.amount = this.product.price - this.product.price_sale;
            },
        },

        methods: {
            assign(property, value) {
                if (this.product[property] !== value) {
                    this.product[property] = value;
                    this.changed();
                }
            },

            changed() {
                this.stateDraft();

                if(this.propId) {
                    this.save();
                }
            },

            save() {
                if (!this.validate()) {
                    return;
                }
                this.stateLoading();

                if (this.propId) {
                    this.$store.dispatch('patchProduct', this.product).then(() => this.stateSaved());
                } else {
                    this.$store.dispatch('storeProduct', this.product).then(() => {
                        this.$router.replace({
                            name: 'product-edit',
                            params: { propId: this.product.id }
                        });
                        this.stateSaved();
                    });
                }
            },

            toggleDiscount() {
                this.discount.amount = 0;
                this.product.sale_text = null;
                this.product.price_sale = (this.product.is_sale) ? this.product.price : 0;
            },

            calcPriceSale() {
                this.discount.amount = Math.round(this.product.price * this.discount.percent / 100);
                this.product.price_sale = this.product.price - this.discount.amount;
                this.discount.percent = null;
            },

            // updateVariants(value) {
            //     this.product.variants = value;
            //
            //     // if(this.product.variants.length > 0) {
            //     //     this.product.code = null;
            //     //     this.product.barcode = null;
            //     //     this.product.stock = null;
            //     //     this.product.weight = null;
            //     // }
            // },
        }
    }
</script>

