<template>
    <div>
        <ul @change.stop class="images">
            <draggable v-model="images" @end="sortImages" ghost-class="transparent-30" class="has-background-danger">
                <li v-for="(image, key) in images" :style="{ width: imageWidth }">
                    <img :src="image" alt="" class="rounded">
                    <button @click="deleteImage(key)" class="delete" />
                </li>
            </draggable>
            <li :style="{ width: imageWidth }" :class="{ 'upload-image-fullwidth': !images || !images.length }" class="upload-image">
                <b-field class="file">
                    <b-upload v-model="upload" multiple drag-drop>
                        <div class="flex-centered"><i class="fa fa-upload is-size-3 has-text-primary"></i></div>
                    </b-upload>
                </b-field>
            </li>
        </ul>
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

        watch: {
            'upload': function () {
                if(this.upload.length) {
                    this.uploadImage();
                }
            }
        },

        methods: {
            uploadImage: function () {
                this.upload.forEach((file) => {
                    if(!this.validateImage(file)) {
                        return;
                    }

                    let data = new FormData();
                    let settings = { headers: { 'content-type': 'multipart/form-data' } };
                    data.append('image', file);

                    axios.post(`${this.webRoute}/upload-image`, data, settings)
                        .then((res) => {
                            this.images.push(res.data.image);
                            this.$emit('update', this.images)
                        })
                        .catch((error) => console.log(error.response));
                        //.catch((error) => this.axiosError(error.response));
                });

                this.upload = [];
            },

            deleteImage: function (key) {
                this.images.splice(key, 1);

                axios.post(`${this.webRoute}/delete-image/${key}`)
                    .then(() => this.$emit('update', this.images))
                    .catch((error) => this.axiosError(error.response));
            },

            sortImages() {
                axios.post(`${this.webRoute}/update-images`, { images: this.images })
                    .then(() => this.$emit('update', this.images))
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
                core.error('Error ' + response.status + ': ' + response.data.error);
            },
        }
    }
</script>

<style scoped>
    ul.images {
        display: table;
        width: 100%;
        height: 100%;
    }
    ul.images li {
        float: left;
        position: relative;
        height: 100%;
        padding: 1%;
    }
    ul.images .delete {
        position: absolute;
        top: 10%;
        right: 10%;
    }

    .upload-image-fullwidth {
        width: 100% !important;
        height: 8rem !important;
    }
    .upload-image * {
        width: 100%;
        height: 100%;
    }
    .upload-image i {
        width: auto;
        height: auto;
        margin: auto;
    }
</style>

<style>
    .upload-draggable {
        width: 100%;
    }
</style>
