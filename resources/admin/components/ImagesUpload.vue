
<template>
    <div>
        <button role="button" class="hidden" />
        <ul @change.stop>
            <draggable v-model="images" @end="emitUpdate" ghost-class="opacity-30">
                <li v-for="(image, key) in images" :style="{ width: propWidth }">
                    <img :src="image" alt="" class="rounded">
                    <button @click="deleteImage(key)" role="button" class="delete"/>
                </li>
            </draggable>

            <li v-if="images.length < propMax" :style="{ width: (images && images.length) ? propWidth : '100%', height: height + 'px' }"
                ref="upload" class="upload-new-image">
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

    export default {
        name: "ImagesUpload",

        components: {
            draggable,
        },

        props: {
            propImages: {
                type: [Array, String],
                default: () => []
            },

            propMax: {
                type: [Number],
                default: 1
            },

            propWidth: {
                type: [String],
                default: '100%'
            },

            propApi: {
                type: [String],
                default: null
            },
        },

        data() {
            return {
                images: [...this.propImages],
                upload: [],
                height: 0,
            }
        },

        watch: {
            'upload': function () {
                if(this.upload.length) {
                    this.uploadImages(this.upload);
                    this.upload = [];
                }
            }
        },

        mounted() {
            this.height = this.$refs.upload.offsetWidth * (this.images.length ? 0.98 : 0.2);
        },

        methods: {
            deleteImage(key) {
                this.images.splice(key, 1);
                this.emitUpdate();
            },

            uploadImages(files) {
                if(!this.validateImage(files)) return;

                this.requestUpload(files).then((res) => {
                    this.images = this.images.concat(res.data);
                    // this.emitUpdate();
                });
            },

            validateImage(files) {
                files.forEach(file => {
                    if(!file.name.match(/\.(jpg|jpeg|gif|png)$/i)) {
                        this.toast('Formats allowed: jpg, jpeg, gif, png');
                        return false;
                    }

                    if(file.size > 1024*1024) {
                        this.toast('The maximum supported file sizes is 1 mb');
                        return false;
                    }
                });

                return true;
            },

            requestUpload(files) {
                const url = `${this.propApi}/upload-images`;
                const data = new FormData();
                const settings = {headers: { 'content-type': 'multipart/form-data' }};

                files.forEach(file => data.append('images[]', file));

                return axios.post(url, data, settings);
            },

            emitUpdate() {
                this.$emit('update', this.images);
            }
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
    .delete {
        position: absolute;
        top: 10%;
        right: 10%;
    }
    .upload-new-image * {
        width: 100%;
        height: 100%;
    }
    .upload-new-image i {
        width: auto;
        height: auto;
        margin: auto;
    }
</style>

