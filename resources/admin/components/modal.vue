
<template>
    <div class="modal" v-bind:class="{'is-active': isActive}" @click="hide">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box" v-bind:style="{ width: this.width }" @click="click">
                <slot></slot>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</template>

<script>
    export default {
        props: ['width'],

        data() {
            return {
                isActive: false,
            }
        },

        mounted() {
            window.addEventListener('keyup', this.checkEsc);
        },

        methods: {
            show() {
                this.isActive = true;
            },
            hide() {
                this.isActive = false;
            },
            click(event) {
                if(event.target.getAttribute('data-hide') !== 'modal') {
                    event.stopPropagation();
                }
            },
            checkEsc() {
                if (event.keyCode === 27) {
                    this.hide();
                }
            }
        }
    }
</script>
