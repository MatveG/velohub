<template>
    <div class="is-inline">
        <div>
            <a @click="modal=true">
                <img :src="image" :width="size+'px'" alt="">
            </a>
        </div>
        <b-modal :active.sync="modal" has-modal-card aria-modal scroll="clip">
            <div class="modal-card">
                <div class="modal-card-body modal-image">
                    <img :src="image" class="modal-image" alt="">
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "ModalImage",
        props: ['image', 'size'],

        data() {
            return {
                modal: false,
            }
        }
    }
</script>

<style scoped>
    .modal-card {
        max-height: 100%;
    }
</style>
