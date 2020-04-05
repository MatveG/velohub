<template>
    <div>
<!--        <title-bar :title-stack="titleStack"/>-->
        <section class="section is-main-section">
            <div class="buttons is-right">
                <button :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
                <button class="button fas fa-arrow-circle-left"></button>
            </div>

            <card-component :title="formCardTitle" icon="account-edit" class="tile is-child">
                <div class="columns">
                    <div class="column">
                        <b-field label="ID товара">
                            <b-input v-model="id" disabled />
                        </b-field>
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
                    </div>
                    <div class="column">
                        <b-field label="Последнее редактирование">
                            <b-input v-model="item.updated_at" disabled />
                        </b-field>
                        <b-field label="Свойства">
                            <b-switch v-model="item.is_active">Активный</b-switch>
                        </b-field>
                    </div>
                </div>
            </card-component>

            <br>

            <card-component class="tile is-child">
                <form @submit="update()" @change="update()" @keyup="saved=false">
                    <b-tabs v-model="activeTab" type="is-boxed">
                        <b-tab-item label="Артикулы">
                            <skus-list :product-id="id"></skus-list>
                        </b-tab-item>

                        <b-tab-item label="Фотографии">
                            <upload-images v-if="item.images" @update="updateImages" :images-array="item.images"
                                           :web-route="`/admin/product/${item.id}`" image-width="20%" />
                        </b-tab-item>

                        <b-tab-item label="Описание">
                            <b-field label="Наименование" message="Пример: Конфеты" horizontal>
                                <b-input v-model="item.name" required />
                            </b-field>
                            <b-field label="Бренд" message="Пример: M&M's" horizontal>
                                <b-input v-model="item.brand" required />
                            </b-field>
                            <b-field label="Модель" message="Пример: Milk Chocolate" horizontal>
                                <b-input v-model="item.model" required />
                            </b-field>
                            <hr>
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

                        <b-tab-item label="Скидка">
                            Sale
                        </b-tab-item>
                    </b-tabs>
                </form>
            </card-component>

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
            axios.post(`/admin/products/${this.id}/edit/`)
                .then((res) => this.item = res.data.item)
                .catch((error) => this.error(error.response));

            axios.post('/admin/categories/tree/')
                .then((res) => this.categories = res.data.categories)
                .catch((error) => this.error(error.response));
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
