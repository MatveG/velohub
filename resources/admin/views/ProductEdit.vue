<template>
    <div>
<!--        <title-bar :title-stack="titleStack"/>-->
        <section class="section is-main-section">
            <div class="buttons is-right">
                <button :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
                <button class="button fas fa-arrow-circle-left"></button>
            </div>

            <div class="columns">
                <div class="column is-three-quarters">
                    <card-component title="Информация">
                        <form @submit="update()" @change="update()" @keyup="saved=false">
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
                                        <b-input v-model="item.preview" type="textarea" />
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
                        </form>
                    </card-component>
                    <br>
                    <card-component title="Фотографии">
                        <upload-images v-if="item.images" @update="updateImages" :images-array="item.images"
                                       :web-route="`/admin/product/${item.id}`" image-width="20%" />
                    </card-component>
                    <br>
                    <card-component title="Варианты товара">
                        <skus-list :product-id="id"></skus-list>
                        <div class="is-clearfix"></div>
                    </card-component>
                </div>

                <div class="column">
                    <card-component :title="`ID товара: ${id}`" class="tile is-child">
                        <div class="has-text-centered">
                            <div>
                                <a href="" class="button is-info">Товар на сайте</a>
                            </div>
                            <br>
                            <b-switch v-model="item.is_active">{{ item.is_active ? 'Активен' : 'Скрыт' }}</b-switch>
                        </div>
                        <b-field label="Категория">
                            <b-select v-model="item.category_id" expanded @select="alert(item.category_id)">
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
                            <b-input v-model="item.seo_keywords" />
                        </b-field>
                        <b-field class="has-text-centered">
                            <b-switch v-model="item.is_sale">{{ (item.is_sale) ? 'Со скидкой' : 'Без скидки' }}</b-switch>
                        </b-field>
                        <br>
                        <div class="columns">
                            <b-field label="Размер скидки" label-position="on-border" class="column">
                                <b-input v-model="item.seo_keywords" :disabled="!item.is_sale" />
                                <div class="control"><div class="button is-static">%</div></div>
                            </b-field>
                            <b-field label="Цена со скидкой" label-position="on-border" class="column">
                                <b-input v-model="item.seo_keywords" :disabled="!item.is_sale" />
                            </b-field>
                        </div>
                    </card-component>
                    <br>
                    <card-component title="Наличие">
                        <b-field label="Артикул" label-position="on-border">
                            <b-input v-model="item.seo_keywords" />
                        </b-field>
                        <b-field class="has-text-centered">
                            <b-switch v-model="item.is_stock">{{ (item.is_stock) ? 'Есть в наличии' : 'Нет в наличии' }}</b-switch>
                        </b-field>
                        <br>
                        <div class="columns">
                            <b-field label="Запас на складе" label-position="on-border" class="column">
                                <b-input v-model="item.seo_keywords" :disabled="!item.is_stock" />
                                <div class="control"><div class="button is-static">шт</div></div>
                            </b-field>
                            <b-field label="Вес" label-position="on-border" class="column">
                                <b-input v-model="item.seo_keywords" :disabled="!item.is_stock" />
                                <div class="control"><div class="button is-static">кг</div></div>
                            </b-field>
                        </div>
                    </card-component>
                    <br>
                    <card-component title="Промо-коды">

                    </card-component>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
    import axios from 'axios'
    import draggable from 'vuedraggable'
    import TitleBar from './../components/TitleBar'
    import CardComponent from './../components/CardComponent'
    import FilePicker from './../components/FilePicker'
    import Notification from './../components/Notification'
    import SkusList from './../components/SkusList'
    import UploadImages from "./../components/UploadImages";
    import core from "../js/Core";

    const blank = {
        item: { category: {} },
        categories: [],
        activeTab: 0,
        isLoading: false,
        createdReadable: null,
        isProfileExists: false,

        loading: false,
        saved: true,
        settings: {
            singlePrice: true,
            singleStock: true,
        }
    };

    export default {
        name: 'ClientForm',

        components: {
            draggable,
            SkusList,
            FilePicker,
            CardComponent,
            TitleBar,
            Notification,
            UploadImages,
        },

        props: {
            id: { default: null },
            files: [],
        },

        data () {
            return blank;
        },

        computed: {
            titleStack: () => {
                return ['Admin', 'Products']
            },
            heroTitle: () => {},
            heroRouterLinkTo: () => {},
            heroRouterLinkLabel: () => {},
            formCardTitle: () => {
                return 'Edit product ID: 555';
            }
        },

        mounted () {
            if (!this.id) {
                core.error('Error loading product');
            }
            axios.get(`/admin/products/${this.id}/edit/`)
                .then((res) => this.item = res.data.item)
                .catch((error) => this.error(error.response));

            axios.get('/admin/categories/tree/')
                .then((res) => this.categories = res.data.categories)
                .catch((error) => this.error(error.response));
        },

        watch: {
            'toggleStock': function () {
                console.log(this.toggleStock);
            }
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

            error(response) {
                this.savedState();
                core.error(`Error ${response.status}: ${response.data.error}`);
            },
        }
    }
</script>
