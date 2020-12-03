
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
                        <b-tabs v-model="tab" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Пример: Конфеты" horizontal>
                                    <b-input v-model="product.title" required />
                                </b-field>
                                <b-field label="Бренд" message="Пример: M&M's" horizontal>
                                    <b-input v-model="product.brand" required />
                                </b-field>
                                <b-field label="Модель" message="Пример: Milk Chocolate" horizontal
                                         :type="{ 'is-danger': $v.product.model.$error }">
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
                                <product-features v-if="product.category" :prop-features="product.category.features" ref="features" />
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

                    <card-component v-if="product.id" title="Фотографии" class="margin-line">
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
                        <b-field label="Категория" label-position="on-border" class="margin-line"
                                 :type="{ 'is-danger': $v.product.category_id.$error }">
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
                                <div class="button is-static">{{ settings('shop', 'currency').sign }}</div>
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
                                            <div class="button is-static">{{ settings('shop', 'currency').sign }}</div>
                                        </div>
                                    </b-field>
                                </div>
                            </div>
                            <b-field label="Детали акции" label-position="on-border">
                                <b-input v-model="product.sale_text" type="textarea" rows="1" />
                            </b-field>
                        </div>
                    </card-component>

                    <card-component v-if="!variants.length" title="Наличие" class="margin-line">
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
            <product-variants v-if="product.id" :discount="discount.amount" />
        </card-component>
    </section>
</template>

<script>
    import {required, minLength, maxLength} from 'vuelidate/lib/validators'
    import {mapGetters} from "vuex"
    import {states} from '@/mixins/states'
    import CardComponent from '@/components/CardComponent'
    import ImagesUpload from "@/components/ImagesUpload"
    import ProductFeatures from "../components/ProductFeatures"
    import ProductVariants from "../components/ProductVariants"

    export default {
        name: 'ProductEdit',

        components: {
            CardComponent,
            ImagesUpload,
            ProductFeatures,
            ProductVariants
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
                tab: 0,
                saveTimer: null,
                discountTimer: null
            }
        },

        computed: mapGetters(['settings', 'product', 'categories', 'variants']),

        validations: {
            product: {
                category_id: {
                    required,
                },
                model: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255)
                }
            }
        },

        async mounted () {
            await this.$store.dispatch('fetchCategories');

            if(this.propId) {
                this.$store.dispatch('fetchProduct', this.propId);
                this.$store.dispatch('fetchVariants', { product_id: this.propId });
            } else {
                this.$store.dispatch('resetProduct', this.propId);
            }
        },

        watch: {
            'product.price_sale': function () {
                this.discount.amount = this.product.price - this.product.price_sale;
            },

            'product.is_stock': function () {
                this.product.stock = !this.product.is_stock ? 0 :
                    this.product.stock === 0 ? 1 : this.product.stock;
            }
        },

        methods: {
            assign(property, value) {
                this.product[property] = value;
                this.stateDraft();
                this.save();
            },

            changed() {
                this.stateDraft();

                if(this.propId) {
                    clearTimeout(this.saveTimer);
                    this.saveTimer = setTimeout(() => this.save(), 2000);
                }
            },

            async save() {
                if (!this.validate() || (this.$refs.features && !this.$refs.features.validate())) {
                    return false;
                }

                this.stateLoading();
                clearTimeout(this.saveTimer);

                if (this.propId) {
                    await this.$store.dispatch('patchProduct', this.product);
                } else {
                    let data = await this.$store.dispatch('storeProduct', this.product);
                    await this.$store.dispatch('fetchProduct', data.id);
                    await this.$router.replace({
                        name: 'product-edit',
                        params: {propId: data.id}
                    });
                }
                this.stateSaved();
            },

            toggleDiscount() {
                this.discount.amount = 0;
                this.product.sale_text = null;
                this.product.price_sale = (this.product.is_sale) ? this.product.price : 0;
            },

            calcPriceSale() {
                clearTimeout(this.discountTimer);
                this.discount.amount = Math.round(this.product.price * this.discount.percent / 100);
                this.product.price_sale = this.product.price - this.discount.amount;
                this.discountTimer = setTimeout(() => this.discount.percent = null, 2000);
            },
        }
    }
</script>
