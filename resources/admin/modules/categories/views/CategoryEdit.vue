
<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button @click="save" :disabled="saved" :class="{ 'is-loading': loading }" class="button is-primary fas fa-save"></button>
            <button @click="$router.push({ name: 'categories' })" class="button fas fa-arrow-circle-left"></button>
        </div>

        <div class="columns">
            <div class="column is-9">
                <card-component title="Основное">
                    <form @submit.prevent="save" @change="changed" @keyup="saved=false">
                        <b-tabs v-model="tabs1" type="is-boxed">
                            <b-tab-item label="Название">
                                <b-field label="Название" message="Полное название" horizontal
                                         :type="{ 'is-danger': $v.category.title.$error }">
                                    <b-input v-model="category.title" />
                                </b-field>
                                <b-field label="Текст ссылки" message="Сокращенное название" horizontal
                                         :type="{ 'is-danger': $v.category.title_short.$error }">
                                    <b-input v-model="category.title_short" />
                                </b-field>
                                <b-field label="Описание" horizontal>
                                    <b-input v-model="category.description" type="textarea" />
                                </b-field>
                            </b-tab-item>
                            <b-tab-item label="SEO">
                                <b-field label="URL" horizontal>
                                    <b-input v-model="category.latin" custom-class="is-static" readonly />
                                </b-field>
                                <b-field label="Заголовок" message="Тег title" horizontal>
                                    <b-input v-model="category.seo_title" />
                                </b-field>
                                <b-field label="Описание" message="Тег description" horizontal>
                                    <b-input v-model="category.seo_description" />
                                </b-field>
                                <b-field label="Ключевые слова" message="Тег keywords" horizontal>
                                    <b-input v-model="category.seo_keywords" />
                                </b-field>
                            </b-tab-item>
                        </b-tabs>
                    </form>
                </card-component>

                <card-component v-if="!category.is_parent" title="Характеристики и параметры" class="margin-line">
                    <b-tabs v-model="tabs2" type="is-boxed">
                        <b-tab-item label="Характеристики">
                            <category-features v-if="category.id" :prop-items="category.features" @update="assign('features', $event)" />
                        </b-tab-item>
                        <b-tab-item label="Параметры">
                            <category-parameters v-if="category.id" :prop-items="category.parameters" @update="assign('parameters', $event)" />
                        </b-tab-item>
                    </b-tabs>
                </card-component>
            </div>

            <div class="column">
                <card-component :title="'Id: ' + (category.id || '')" class="tile is-child">
                    <b-field>
                        <b-switch v-model="category.is_active" @change.native="changed">Активна</b-switch>
                    </b-field>
                    <b-field>
                        <b-switch v-model="category.is_parent" @change.native="changed">Подкатегории</b-switch>
                    </b-field>
                    <b-field label="Родительская категория">
                        <b-autocomplete v-if="category"
                                        :value="parent.title"
                                        :open-on-focus="true"
                                        :data="categories"
                                        field="title"
                                        @select="(option) => assign('parent_id', option.id)">
                        </b-autocomplete>
                    </b-field>
                    <div class="has-text-centered">
                        <p><a href="" class="button" target="_blank">Посмотреть на сайте</a></p>
                    </div>
                </card-component>

                <card-component v-if="category.id" title="Фотография" class="margin-line">
                    <images-upload :prop-items="category.images" @update="assign('images', $event)"
                                   :web-route="`/admin/categories/${category.id}`" max-amount="1" image-width="100%" />
                </card-component>
            </div>
        </div>
    </section>
</template>

<script>
    import CardComponent from '@/components/CardComponent'
    import ImagesUpload from '@/components/ImagesUpload';
    import CategoryFeatures from '../components/CategoryFeatures';
    import CategoryParameters from '../components/CategoryParameters';
    import {states} from '@/mixins/states';
    import {required, minLength} from 'vuelidate/lib/validators'

    export default {
        name: 'CategoryEdit',

        components: {
            CardComponent,
            ImagesUpload,
            CategoryFeatures,
            CategoryParameters,
        },

        mixins: [states],

        props: {
            propId: [String, Number],
            default: () => null
        },

        data() {
            return {
                tabs1: 0,
                tabs2: 0,
            }
        },

        computed: {
            category() {
                return this.$store.getters.getOne;
            },

            categories() {
                return this.$store.getters.getAll;
            },

            parent: function () {
                return this.categories.find((element) => element.id === this.category.parent_id) || {};
            }
        },

        validations: {
            category: {
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

        mounted() {
            if (this.propId) {
                this.$store.dispatch('fetchOne', this.propId);
            } else {
                this.saved = false;
            }
            this.$store.dispatch('fetchAllParent');
        },

        methods: {
            assign(property, value) {
                if (this.category[property] !== value) {
                    this.category[property] = value;
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
                    return false;
                }

                this.stateLoading();

                this.$store
                    .dispatch((this.propId) ? 'postOne' : 'storeOne')
                    .then(() => {
                        if (!this.propId) {
                            this.$router.replace({
                                name: 'category.edit',
                                params: { id: this.category.id }
                            });
                        }
                    })
                    .finally(() => this.stateSaved());
            },

            validate() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    this.toast('Заполните обязательные поля');

                    return false;
                }

                return true;
            },
        }
    }
</script>
