
<template>
    <div>
        <b-table :data="variants"
                 :loading="loading"
                 :hoverable="true"
                 default-sort="code"
                 icon-pack="fas"
                 class="table-vertical-center">
            <template slot-scope="props">
                <b-table-column field="images" label="Фото" width="5%" sortable centered>
                    <span v-if="props.row.images.length" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="code" label="Артикул" width="10%" sortable class="has-text-left is-italic">
                    <span :class="[!props.row.code ? 'has-text-grey-light' : '']">{{ (props.row.code) ? props.row.code : '[empty]' }}</span>
                </b-table-column>

                <b-table-column field="parameters" label="Параметры" width="30%" centered>
                    <div class="buttons is-centered">
                        <template v-for="parameter in product.category.parameters">
                            <button v-if="props.row.parameters[parameter.id]" class="button is-rounded is-small is-static">
                                {{ props.row.parameters[parameter.id] }}
                            </button>
                        </template>
                    </div>
                </b-table-column>

                <b-table-column field="stock" label="Остаток" width="15%" sortable centered>
                    <b-field>
                        <b-input v-model.number="props.row.stock" @change.native="update(props.row)"
                                 @keypress.native="banDecimal($event)" type="number" />
                        <div class="control"><div class="button is-static">шт</div></div>
                    </b-field>
                </b-table-column>

                <b-table-column field="surcharge" label="Цена/наценка" width="20%" sortable centered>
                    <b-field>
                        <div class="control has-icons-right">
                            <b-input v-model.number="props.row.price" disabled />
                            <span class="icon is-small is-right">{{ settings('shop', 'currency').sign }}</span>
                        </div>
                        <b-input v-model.number="props.row.surcharge" @input.native="calcPrice(props.row)"
                                 @change.native="update(props.row)" type="number" step="any" />
                    </b-field>
                </b-table-column>

                <b-table-column field="is_sale" label="Скидка" width="10%" sortable centered>
                    <b-checkbox v-model="props.row.is_sale" :disabled="!product.is_sale"
                                @change.native="calcPriceAndUpdate(props.row)" />
                </b-table-column>

                <b-table-column field="id" label="Действия" width="10%" centered>
                    <button class="button fas fa-pen" type="button" @click="edit(props.row)" />
                    <button class="button fas fa-trash-alt" type="button" @click="destroy(props.row)" />
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>

        <b-modal :active.sync="modal" aria-modal class="modal-edit-variant">
            <variant-edit :variant="variant" @close="modal=false" />
        </b-modal>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {states} from '@/mixins/states';
    import Variant from "../classes/Variant";
    import CardComponent from "@/components/CardComponent";
    import VariantEdit from "@/modules/product/components/VariantEdit";

    export default {
        name: 'ProductVariants',

        components: {
            VariantEdit,
            CardComponent,
        },

        mixins: [states],

        props: {
            discount: {
                type: [Number],
                default: 0
            },
        },

        data() {
            return {
                variant: {},
                modal: false,
                timer: {},
            }
        },

        computed: mapGetters(['settings', 'product', 'variants']),

        watch: {
            'discount': function () {
                this.variants.forEach((el) => this.calcPrice(el));
            },

            'product.price': function () {
                this.variants.forEach((el) => this.calcPrice(el));
            },

            'product.is_sale': function () {
                this.variants.forEach((el) => el.is_sale = this.product.is_sale);
            },
        },

        methods: {
            create() {
                this.variant = Variant.fromProduct(this.product);
                this.modal = true;
            },

            edit(row) {
                this.variant = Variant.fromObj(row);
                this.modal = true;
            },

            update(row) {
                clearTimeout(this.timer[row.id]);

                this.timer[row.id] = setTimeout(() => {
                    this.stateLoading();
                    this.$store.dispatch('patchVariant', row).then(() => this.stateSaved());
                }, 2000);
            },

            destroy(row) {
                this.confirm('Удалить?', () => {
                    this.stateLoading();
                    this.$store
                        .dispatch('destroyVariant', row)
                        .then(() => this.stateSaved());
                });
            },

            calcPriceAndUpdate(row) {
                this.calcPrice(row);
                this.update(row);
            },

            calcPrice(row) {
                if(Number.isFinite(+this.product.price) && Number.isFinite(+row.surcharge)) {
                    row.price = +this.product.price + +row.surcharge;
                    row.price -= (this.product.is_sale && row.is_sale) ? this.discount : 0;
                }
            },

            banDecimal(event) {
                this.banDecimal(event);
            },
        }
    }
</script>
