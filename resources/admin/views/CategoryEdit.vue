<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
            <button class="button fas fa-arrow-circle-left"></button>
        </div>
        <div class="columns">
            <div class="column is-9">
                <form @submit.prevent="update" @change="autoSave" @keyup="saved=false">
                    <card-component title="Основное">
                        <b-tabs v-model="tab" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Полное название" horizontal>
                                    <b-input v-model="item.title" />
                                </b-field>
                                <b-field label="Текст ссылки" message="Сокращенное название" horizontal>
                                    <b-input v-model="item.title_short" />
                                </b-field>
                                <b-field label="Описание" horizontal>
                                    <b-input v-model="item.description" type="textarea" />
                                </b-field>
                            </b-tab-item>
                            <b-tab-item label="SEO">
                                <b-field label="URL" horizontal>
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
                </form>

                <card-component v-if="item.id && !item.is_parent" title="Характеристики и параметры" class="margin-line">
                    <b-tabs v-model="tab2" type="is-boxed">
                        <b-tab-item label="Характеристики">
                            <category-features @update="updateFeatures" :prop-items="item.features" />
                        </b-tab-item>
                        <b-tab-item label="Параметры">
                            <category-parameters @update="updateParameters" :prop-items="item.parameters" />
                        </b-tab-item>
                    </b-tabs>
                </card-component>
            </div>
            <div class="column">
                <card-component :title="`Id: ${id}`" class="tile is-child">
                    <b-field>
                        <b-switch v-model="item.is_active" @change.native="autoSave">Активна</b-switch>
                    </b-field>
                    <b-field>
                        <b-switch v-model="item.is_parent" @change.native="autoSave">Подкатегории</b-switch>
                    </b-field>
                    <b-field label="Родительская категория">
                        <b-autocomplete v-if="category"
                                        :value="category.title"
                                        :open-on-focus="true"
                                        :data="categories"
                                        field="title"
                                        @select="(option) => changeParent(option)">
                        </b-autocomplete>
                    </b-field>

                    <div class="has-text-centered">
                        <p>
                            <a href="" class="button" target="_blank">Посмотреть на сайте</a>
                        </p>
                    </div>
                </card-component>

                <card-component v-if="item.id" title="Фотография" class="margin-line">
                    <images-upload v-if="item.id" @update="updateImages" :web-route="`/admin/product/${item.id}`"
                                   :images-array="item.images" max-amount="1" image-width="100%" />
                </card-component>

            </div>
        </div>
    </section>
</template>

<script>
    import core from "../js/Core";
    import axios from 'axios'
    import CardComponent from './../components/CardComponent'
    import ImagesUpload from "./../components/ImagesUpload";
    import CategoryFeatures from "../components/CategoryFeatures";
    import CategoryParameters from "../components/CategoryParameters";

    export default {
        name: 'CategoryEdit',

        components: {
            CardComponent,
            ImagesUpload,
            CategoryFeatures,
            CategoryParameters,
        },

        props: { id: null },

        data () {
            return {
                item: {},
                categories: [],
                tab: 0,
                tab2: 0,
                loading: false,
                saved: true,
            }
        },

        computed: {
            category: function () {
                return this.categories.find((element) => element.id === this.item.parent_id) || {};
            }
        },

        mounted () {
            if (this.id) {
                axios.get(`/admin/category/${this.id}/edit/`)
                    .then((res) => this.item = res.data.item)
                    .catch((error) => this.error(error.response));
            }

            axios.post('/admin/category/list/', { where: [['is_parent', true]] })
                .then((res) => this.categories = [{ id: 0, title: '(root)' }].concat(res.data.items))
                .catch((error) => this.error(error.response));
        },

        methods: {
            changeParent(category) {
                if(this.item.parent_id !== category.id) {
                    this.item.parent_id = category.id;

                    if(this.item.id) {
                        this.update();
                    }
                }
            },

            update() {
                console.log('updating item');

                this.statusLoading();
                // var action?
                // if no id - create
                // redirect to edit?

                // else - update
                axios.post(`/admin/category/${this.item.id}/update`, this.item)
                    .then((res) => {
                        Object.keys(res.data).forEach((key) => this.item[key] = res.data[key]);
                        this.savedState();
                    })
                    .catch((error) => this.error(error.response));
            },

            autoSave() {
                if(this.item.id) {
                    this.update();
                }
                this.saved = false;
            },

            updateImages(newImages) {
                this.item.images = newImages;
                this.update();
            },

            updateFeatures(value) {
                this.item.features = value;
                this.update();
            },

            updateParameters(value) {
                this.item.parameters = value;
                this.update();
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
