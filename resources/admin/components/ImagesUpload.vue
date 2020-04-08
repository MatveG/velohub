
<template>
    <div>
        <ul @change.stop>
            <draggable v-model="images" @end="updateImages" ghost-class="opacity-30">
                <li v-for="(image, key) in images" :style="{ width: imageWidth }">
                    <img :src="image" alt="" class="rounded">
                    <button @click="deleteImage(key)" class="delete" />
                </li>
            </draggable>
            <li :style="{ width: imageWidth }" :class="{ 'fill-if-empty': !images || !images.length }">
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
        name: "ImagesUpload",

        components: {
            draggable,
        },

        props: [
            'webRoute',
            'imagesArray',
            'imageWidth'
        ],

        data() {
            return {
                images: this.imagesArray,
                upload: [],
            }
        },

        watch: {
            'upload': function () {
                if(this.upload.length) {
                    this.upload.forEach((file) => this.uploadImage(file));
                    this.upload = [];
                }
            }
        },

        methods: {
            uploadImage: function (file) {
                if(!this.validateImage(file)) return;

                let data = new FormData();
                let settings = { headers: { 'content-type': 'multipart/form-data' } };
                data.append('image', file);

                axios.post(`${this.webRoute}/images-upload`, data, settings)
                    .then((res) => {
                        this.images.push(res.data.image);
                        this.$emit('update', this.images)
                    })
                    .catch((error) => core.axiosError(error.response));
            },

            deleteImage: function (key) {
                this.images.splice(key, 1);
                this.updateImages();
            },

            updateImages: function() {
                axios.post(`${this.webRoute}/images-update`, { images: this.images })
                    .then(() => this.$emit('update', this.images))
                    .catch((error) => core.axiosError(error.response));
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
        }
    }
</script>

<style scoped>
    ul {
        display: table;
        width: 100%;
        height: 100%;
    }
    li {
        float: left;
        position: relative;
        height: 100%;
        padding: 1%;
    }
    li:last-child * {
        width: 100%;
        height: 100%;
    }
    li:last-child i {
        width: auto;
        height: auto;
        margin: auto;
    }
    .delete {
        position: absolute;
        top: 10%;
        right: 10%;
    }
    .fill-if-empty {
        width: 100% !important;
        height: 8rem !important;
    }
</style>

