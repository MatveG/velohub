<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button @click="save" :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
            <button class="button fas fa-arrow-circle-left"></button>
        </div>
        <div class="columns">
            <div class="column is-9">
                <form @submit.prevent="save" @change="changed" @keyup="saved=false">
                    <card-component title="Основное">
                        <b-tabs v-model="tab_1" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Полное название" horizontal
                                         :type="{ 'is-danger': $v.item.title.$error }">
                                    <b-input v-model="item.title" />
                                </b-field>
                                <b-field label="Текст ссылки" message="Сокращенное название" horizontal
                                         :type="{ 'is-danger': $v.item.title_short.$error }">
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
                    <b-tabs v-model="tab_2" type="is-boxed">
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
                <card-component :title="`Id: ${item.id}`" class="tile is-child">
                    <b-field>
                        <b-switch v-model="item.is_active" @change.native="changed">Активна</b-switch>
                    </b-field>
                    <b-field>
                        <b-switch v-model="item.is_parent" @change.native="changed">Подкатегории</b-switch>
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
                        <p><a href="" class="button" target="_blank">Посмотреть на сайте</a></p>
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
    import { required, minLength } from 'vuelidate/lib/validators'
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

        props: {
            id: {
                type: String,
                default: null
            },
        },

        data () {
            return {
                item: {},
                categories: [],
                loading: false,
                saved: true,
                tab_1: 0,
                tab_2: 0,
            }
        },

        computed: {
            category: function () {
                return this.categories.find((element) => element.id === this.item.parent_id) || {};
            }
        },

        validations: {
            item: {
                title: {
                    required,
                    minLength: minLength(3)
                },
                title_short: {
                    required,
                    minLength: minLength(3)
                },
            }
        },

        mounted () {
            axios.post('/admin/category/list/', { where: [['is_parent', true]] })
                .then((res) => this.categories = [{ id: 0, title: '(root)' }].concat(res.data.items))
                .catch((error) => this.error(error.response));

            if (this.id) {
                axios.get(`/admin/category/${this.id}/edit/`)
                    .then((res) => this.item = res.data.item)
                    .catch((error) => this.error(error.response));
            }
        },

        methods: {
            // add validation
            // unique title? or generate unique latin for each one

            changed() {
                if(this.item.id) {
                    this.save();
                }
                this.saved = false;
            },

            save() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return core.error('Заполните обязательные поля');
                }
                // if (this.items.find(each => each.title === this.item.title && each.key !== this.item.key)) {
                //     return core.error('Уже есть запись с таким Названием');
                // }

                if (this.item.id) {
                    this.update();
                } else {
                    this.store();
                }
            },

            update() {
                //let url = (this.item.id) ? '`/admin/category/${this.item.id}/update`' : '/admin/category/store';
                this.statusLoading();
                axios.post(`/admin/category/${this.item.id}/update`, this.item)
                    .then((res) => this.item = Object.assign(this.item, res.data))
                    .catch((error) => this.error(error.response))
                    .then(() => this.savedState());
            },

            store() {
                this.statusLoading();
                axios.post(`/admin/category/store`, this.item)
                    .then((res) => this.item = Object.assign(this.item, res.data))
                    .catch((error) => this.error(error.response))
                    .then(() => this.savedState());
            },



            updateParent(value) {
                if(this.item.parent_id !== value.id) {
                    if(this.item.id) {
                        this.update();
                    }
                    this.item.parent_id = value.id;
                }
            },

            updateImages(value) {
                this.item.images = value;
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
