<template>
    <div>
<!--        <title-bar :title-stack="titleStack"/>-->
        <section class="section is-main-section">
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
                            <div>
                            <b-switch v-model="item.is_active">Активный</b-switch>
                            <b-switch v-model="item.is_sale">Акционный</b-switch>
                            </div>
                        </b-field>
                    </div>
                </div>
            </card-component>

            <br>

            <card-component class="tile is-child">
                <form @submit.prevent="submit">
                    <b-tabs v-model="activeTab" type="is-boxed">
                        <b-tab-item label="Артикулы">
                            <skus-list :product-id="id"></skus-list>
                        </b-tab-item>

                        <b-tab-item label="Фотографии">
                            <upload-images :web-route="'/admin/product/' + item.id" :images-array="item.images" image-width="20%" />
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
                    </b-tabs>

                    <div class="buttons is-centered">
                        <button class="button is-primary">Сохранить</button>
                        <button class="button">Закрыть</button>
                    </div>
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
    import ModalImage from "../components/ModalImage";
    import core from "../js/Core";
    import UploadImages from "./../components/UploadImages";

    const blank = {
        item: { category: {} },
        categories: [],
        activeTab: 0,
        isLoading: false,
        createdReadable: null,
        isProfileExists: false
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
            if (this.id) {
                axios
                    .get('/admin/products/' + this.id + '/edit/')
                    .then(res => {
                        this.item = res.data.item;
                    })
                    .catch(e => {
                        this.$buefy.toast.open({
                            message: `Error: ${e.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    });

                axios
                    .get('/admin/categories/tree/')
                    .then(res => {
                        this.categories = res.data.categories;
                    })
                    .catch(e => {
                        this.$buefy.toast.open({
                            message: `Error: ${e.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    });
            }
        },

        methods: {
            getClearFormObject () {
                return blank;
            },

            getData () {

            },

            submit() {
                //this.isLoading = true;

                if(this.id) {
                    axios.post(`/admin/products/${this.item.id}/update`, this.item)
                        .then(res => {
                            //this.isLoading = false;
                            this.$buefy.snackbar.open('Сохранено');
                        })
                        .catch(error => console.log(error.response));
                }
            },


            uploadImage: function () {
                let url = `/admin/sku/${this.item.id}/upload-image`;

                this.files.forEach((file) => {
                    if(!this.validateImage(file)) {
                        return;
                    }
                    this.loadingState();

                    let data = new FormData();
                    let settings = { headers: { 'content-type': 'multipart/form-data' } };
                    data.append('image', file);

                    axios.post(url, data, settings)
                        .then((res) => {
                            this.item.images.push(res.data.image);
                            this.savedState();
                        })
                        .catch((error) => this.axiosError(error.response));
                });

                this.files = [];
            },

            validateImage: function (file) {
                if(!file.name.match(/\.(jpg|jpeg|gif|png)$/i)) {
                    core.error('Formats allowed: jpg, jpeg, gif, png');
                    return false;
                }

                if(file.size > 1024*1024) {
                    core.error('The maximum supported file sizes is 1 mb');
                    return false;
                }

                return true;
            },

            deleteImage: function (key) {
                this.loadingState();
                this.item.images.splice(key, 1);

                axios.post(`/admin/sku/${this.item.id}/delete-image/${key}`)
                    .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
            },

            sortImages() {
                this.loadingState();
                this.drag = false;

                axios.post(`/admin/sku/${this.item.id}/update-images`, { images: this.item.images })
                    .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
            },
        }
    }
</script>
