<template>
    <div>
        <template v-for="feature in propFeatures">
            <div v-if="feature.type === 'group'" class="features-group">
                <label class="label is-5 has-text-centered">{{feature.title}}</label>
                <product-features :prop-features="feature.sub" />
            </div>

            <b-field v-if="feature.type === 'number'" :label="feature.title" horizontal>
                <div class="control has-icons-right">
                    <b-input v-model.number="product.features[feature.id]" type="number" step="any" />
                    <span class="icon is-right is-bold has-text-black">{{ feature.units }}</span>
                </div>
            </b-field>

            <b-field v-if="feature.type === 'string'" :label="feature.title" horizontal>
                <b-input v-model="product.features[feature.id]" />
            </b-field>

            <b-field v-if="feature.type === 'text'" :label="feature.title" horizontal>
                <b-input v-model="product.features[feature.id]" type="textarea" maxlength="200" />
            </b-field>

            <b-field v-if="feature.type === 'bool'" :label="feature.title" horizontal>
                <b-radio-button v-model="product.features[feature.id]" :native-value="1">есть</b-radio-button>
                <b-radio-button v-model="product.features[feature.id]" :native-value="0">нет</b-radio-button>
                <b-radio-button v-model="product.features[feature.id]" :native-value="null">не указано</b-radio-button>
            </b-field>

            <b-field v-if="feature.type === 'select'" :label="feature.title" horizontal>
                <b-select v-model="product.features[feature.id]" expanded>
                    <option v-for="value in feature.values">{{value}}</option>
                </b-select>
            </b-field>

            <b-field v-if="feature.type === 'multiple'" :label="feature.title" horizontal
                     :init="!product.features[feature.id] ? product.features[feature.id] = [] : true">
                <b-select v-model="product.features[feature.id]" multiple expanded
                          :native-size="feature.values.length > 5 ? 5 : feature.values.length">
                    <option v-for="value in feature.values">{{value}}</option>
                </b-select>
            </b-field>
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
    .features-group {
        border-top: 2px solid #eee;
        border-bottom: 2px solid #eee;
        margin: 1rem 0 1rem 0;
        padding: 1rem 0 1rem 0;
    }
</style>
