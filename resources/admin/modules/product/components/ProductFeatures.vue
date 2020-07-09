<template>
    <div>
        <template v-for="feature in propFeatures">
            <b-field v-if="feature.type === 'string'" :label="feature.title" horizontal>
                <b-input v-model="product.features[feature.key]" />
            </b-field>

            <b-field v-if="feature.type === 'number'" :label="feature.title" horizontal>
                <div class="control has-icons-right">
                    <b-input v-model="product.features[feature.key]" />
                    <span class="icon is-small is-right is-bold">{{ feature.units }}</span>
                </div>
            </b-field>

            <b-field v-if="feature.type === 'text'" :label="feature.title" horizontal>
                <b-input v-model="product.features[feature.key]" type="textarea"></b-input>
            </b-field>

            <b-field v-if="feature.type === 'select'" :label="feature.title" horizontal>
                <b-select v-model="product.features[feature.key]" expanded>
                    <option v-for="value in feature.values">{{value}}</option>
                </b-select>
            </b-field>

            <b-field v-if="feature.type === 'boolean'" :label="feature.title" horizontal>
                <b-select expanded>
                    <option>есть</option>
                    <option>нету</option>
                </b-select>
            </b-field>

            <div v-if="feature.type === 'group'">
                <h5 class="title is-5 has-text-centered">{{feature.title}}</h5>
                <product-features :prop-features="feature.sub" />
            </div>
        </template>
    </div>
</template>

<script>
    import {required, minLength, maxLength} from 'vuelidate/lib/validators'
    import {mapGetters} from "vuex";
    import ProductFeatures from "./ProductFeatures";

    export default {
        name: "ProductFeatures",

        props: {
            propFeatures: {
                type: Array,
                default: () => []
            },
        },

        computed: mapGetters(['product']),
    }
</script>

<style scoped>

</style>
