<template>
    <div>
        <ul @change.stop>
            <draggable v-model="images" @end="sortImages" ghost-class="has-background-light">
                <li v-for="(image, key) in images" :style="{ width: imageWidth }" class="block-image-delete is-square">
                    <img :src="image" alt="">
                    <button @click="deleteImage(key)" class="delete">x</button>
                </li>
            </draggable>
        </ul>

        <b-field class="file field-upload-image">
            <b-upload v-model="upload" multiple drag-drop>
                <div class="is-flex">
                    <i class="fa fa-upload is-size-3 has-text-primary"></i><br>
                </div>
            </b-upload>
        </b-field>
    </div>
</template>

<script>
    import axios from "axios";
    import draggable from 'vuedraggable'
    import core from "../js/Core";

    export default {
        name: "UploadImages",

        props: [
            'webRoute',
            'imagesArray',
            'imageWidth'
        ],

        components: {
            draggable,
        },

        data() {
            return {
                images: this.imagesArray,
                upload: [],
            }
        },

        methods: {
            uploadImage: function () {
                this.files.forEach((file) => {
                    if(!this.validateImage(file)) {
                        return;
                    }
                    // this.loadingState();

                    let data = new FormData();
                    let settings = { headers: { 'content-type': 'multipart/form-data' } };
                    data.append('image', file);

                    axios.post(`${this.webRoute}/upload-image`, data, settings)
                        .then((res) => {
                            this.images.push(res.data.image);
                            // this.savedState();
                        })
                        .catch((error) => this.axiosError(error.response));
                });

                this.files = [];
            },

            deleteImage: function (key) {
                // this.loadingState();
                this.item.images.splice(key, 1);

                axios.post(`${this.webRoute}/delete-image/${key}`)
                    // .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
            },

            sortImages() {
                // this.loadingState();
                //this.drag = false;

                axios.post(`${this.webRoute}/update-images`, { images: this.images })
                    // .then(() => this.savedState())
                    .catch((error) => this.axiosError(error.response));
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

            axiosError(response) {
                // this.savedState();
                core.error('Error ' + response.status + ': ' + response.data.error);
            },
        }
    }
</script>

<style scoped>
    .field-upload-image {
        height: 70px;
    }
    .field-upload-image div, .field-upload-image label {
        margin: auto;
        width: 100%;
        height: 100%;
    }
    .field-upload-image i {
        margin: auto;
    }
</style>
