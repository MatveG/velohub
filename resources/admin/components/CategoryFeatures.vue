<template>
    <div>
        <b-table class="table-valign-center"
                 ref="table"
                 :data="(action === 'add') ? [...items, item] : items"
                 default-sort="ord"
                 custom-row-key="ord"
                 icon-pack="fa"
                 striped
                 hoverable
                 draggable
                 @drop="drop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 :row-class="(row, currIndex) => row.type === 'heading' && 'feature-heading'">

            <template slot-scope="props">
                <b-table-column field="ord" width="5%" sortable centered>
                    {{ props.row.ord }}
                </b-table-column>
                <b-table-column field="title" label="Название" width="25%" sortable>
                    <b-field v-if="props.currIndex === currIndex" :type="{ 'is-danger': $v.currItem.title.$error }">
                        <b-input v-model="currItem.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>
                <b-table-column field="type" label="Тип данных" width="25%" sortable centered>
                    <template v-if="props.currIndex === currIndex">
                        <b-field :type="{ 'is-danger': $v.currItem.type.$error }">
                            <b-select v-model="currItem.type" @change.native="reset" expanded>
                                <option v-for="(title, key) in inputTypes" :value="key">{{ title }}</option>
                            </b-select>
                        </b-field>
                        <template v-if="currItem.type === 'number'">
                            <b-field label="Единицы измерения" label-position="on-border">
                                <b-input v-model="currItem.units" placeholder="кг" />
                            </b-field>
                        </template>
                        <template v-if="currItem.type === 'select'">
                            <b-field label="Список значений" label-position="on-border" :type="{ 'is-danger': $v.currItem.values.$error }">
                                <b-taginput v-model="currItem.values" placeholder="Добавить"  />
                            </b-field>
                        </template>
                    </template>
                    <span v-else>{{ inputTypes[props.row.type] }}</span>
                </b-table-column>
                <b-table-column field="is_required" label="Обязательное" width="10%" sortable centered>
                    <b-checkbox v-if="props.currIndex === currIndex" v-model="currItem.is_required"
                                :disabled="currItem.type === 'heading'" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.currIndex === currIndex" v-model="currItem.is_filter"
                                :disabled="currItem.type === 'text' || currItem.type === 'heading'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.currIndex === currIndex">
                        <button @click="save(props.currIndex)" type="button" class="button fas fa-check is-success is-small" />
                        <button @click="cancel()" type="button" class="button fas fa-times is-warning is-small" />
                    </template>
                    <template v-else>
                        <button @click="edit(props.currIndex)" type="button" class="button fas fa-pen is-small" />
                        <button @click="remove(props.currIndex)" type="button" class="button fas fa-trash-alt is-small" />
                    </template>
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered margin-line">
            <button class="button is-primary" type="button" @click="add">Добавить</button>
        </div>
    </div>
</template>

<script>
    import {required, requiredIf, minLength} from 'vuelidate/lib/validators';
    import {draggable} from "@/mixins/draggable";
    import {createKey} from "@/mixins/createKey";
    import Collection from "@/js/Collection";

    const blank = {
        is_required: false,
        is_filter: false,
        units: null,
        values: null
    };
    const inputTypes = {
        string: 'строка',
        number: 'число',
        text: 'текст',
        boolean: 'да/нет',
        select: 'выбор из списка',
        heading: 'заголовок',
    };

    export default {
        name: "CategoryFeatures",

        mixins: [draggable,createKey],

        props: {
            propItems: {
                type: Array,
                default: () => []
            },
        },

        data () {
            return {
                collection: new Collection({ customKey: 'key', customOrd: 'ord' }),
                action: null,
                currItem: {},
                currIndex: null,
                inputTypes: inputTypes,
            }
        },

        computed: {
            items: function() {
                return this.collection.all();
            },
        },

        mounted() {
            this.collection.collect(this.propItems);
        },

        validations: {
            currItem: {
                title: {
                    required,
                    minLength: minLength(2)
                },
                type: {
                    required,
                },
                values: {
                    required: requiredIf(function () {
                        return this.currItem.type === 'select';
                    }),
                    minLength: minLength(1),
                }
            }
        },

        methods: {
            add() {
                this.$v.$reset();
                this.currItem = { key: this.createKey(), ...blank };
                this.currIndex = this.collection.count();
            },

            edit(key) {
                this.$v.$reset();
                this.currItem = this.collection.get(key);
                this.currIndex = key;
            },

            save(key) {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return this.error('Заполните обязательные поля');
                }
                if (this.list.find(each => each.title === this.currItem.title && each.key !== this.currItem.key)) {
                    return this.error('Уже есть запись с таким Названием');
                }

                if (this.currItem.ord) {
                    this.collection.put(this.currIndex, this.currItem);
                } else {
                    this.collection.push(this.currItem);
                }

                this.cancel();
                this.$emit('update', this.items);
            },

            remove(item) {
                this.confirm('Удалить?', () => {
                    this.collection.remove(item);
                    this.cancel();
                    this.$emit('update', this.items);
                });
            },

            cancel() {
                this.action = null;
                this.currIndex = null;
                this.currItem = {};
            },

            reset() {
                this.currItem = { ...this.currItem, ...blank };
            },

            drop(payload) {
                this.dragdrop(payload);

                if (payload.row.ord === this.draggingRow.ord) {
                    return false;
                }
                if (this.currItem.key) {
                    if (this.draggingRow.key === this.currItem.key) {
                        this.currItem.ord = this.draggingRow.ord;
                    }
                    if (!this.currItem.title || !this.currItem.type) {
                        this.$v.$touch();
                        return false;
                    }
                }
                this.$emit('update', this.items);
            },
        }
    }
</script>

<style>
    tr.feature-heading {
        background: #eee;
        font-weight: bold;
    }
</style>

