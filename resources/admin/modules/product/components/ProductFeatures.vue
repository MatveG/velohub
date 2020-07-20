<template>
    <div>
        <template v-for="feature in propFeatures">
            <div v-if="feature.type === 'group'" class="features-group">
                <label class="label is-5 has-text-centered">{{feature.title}}</label>
                <product-features :prop-features="feature.sub" />
            </div>

            <b-field v-else :label="feature.title" horizontal
                     :type="{ 'is-danger': $v.product.features[feature.id] && $v.product.features[feature.id].$error }">
                <div v-if="feature.type === 'number'" class="control has-icons-right">
                    <b-input v-model.number="product.features[feature.id]" type="number" step="any" />
                    <span class="icon is-right is-bold has-text-black">{{ feature.units }}</span>
                </div>

                <b-input v-if="feature.type === 'string'" v-model="product.features[feature.id]" />

                <b-input v-if="feature.type === 'text'" v-model="product.features[feature.id]" type="textarea" maxlength="15000" />

                <template v-if="feature.type === 'bool'">
                    <b-radio-button v-model="product.features[feature.id]" :native-value="1">есть</b-radio-button>
                    <b-radio-button v-model="product.features[feature.id]" :native-value="0">нет</b-radio-button>
                    <b-radio-button v-model="product.features[feature.id]" :native-value="null">не указано</b-radio-button>
                </template>

                <b-select v-if="feature.type === 'select'" v-model="product.features[feature.id]" expanded>
                    <option :value="null"></option>
                    <option v-for="value in feature.values">{{value}}</option>
                </b-select>

                <b-select v-if="feature.type === 'multiple'" v-model="product.features[feature.id]" multiple expanded
                          :init="!product.features[feature.id] ? product.features[feature.id] = [] : true"
                          :native-size="feature.values.length > 5 ? 5 : feature.values.length">
                    <option v-for="value in feature.values">{{value}}</option>
                </b-select>
            </b-field>
        </template>
    </div>
</template>

<script>
    import {required, minLength, maxLength} from "vuelidate/lib/validators"
    import numeric from "vuelidate/lib/validators/numeric"
    import {mapGetters} from "vuex"
    import ProductFeatures from "./ProductFeatures"

    export default {
        name: 'ProductFeatures',

        components: {ProductFeatures},

        props: {
            propFeatures: {
                type: Array,
                default: () => []
            },
        },

        computed: mapGetters(['product']),

        validations() {
            let res = {
                product: {
                    features: {}
                }
            };

            this.propFeatures.filter(el => el.required).forEach(feature => {
                res.product.features[feature.id] = this.validByType(feature);
            });

            this.propFeatures.filter(el => el.type === 'group').forEach(feature => {
                feature.sub.forEach(subFeature => {
                    res.product.features[subFeature.id] = this.validByType(subFeature);
                });
            });

            return res;
        },

        methods: {
            validByType(feature) {
                switch (feature.type) {
                    case 'number':
                        return {
                            required,
                            numeric
                        }
                    case 'text':
                        return {
                            required,
                            minLength: minLength(15),
                            maxLength: maxLength(15000)
                        }
                    case 'bool':
                        return {
                            required
                        }
                    case 'multiple':
                        return {
                            required,
                            minLength: minLength(1)
                        }
                    default:
                        return {
                            required,
                            minLength: minLength(3),
                            maxLength: maxLength(255)
                        }
                }
            }
        }
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
