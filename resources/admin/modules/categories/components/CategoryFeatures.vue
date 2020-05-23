<template>
    <div>
        <b-table class="table-valign-center"
                 ref="table"
                 :data="(method === 'add') ? [...items, currItem] : items"
                 custom-row-key="index"
                 icon-pack="fa"
                 striped
                 hoverable
                 draggable
                 @drop="drop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 :row-class="(row) => row.type === 'header' && 'feature-header'">

            <template v-slot="props">
                <b-table-column field="ord" width="5%" sortable centered>
                    {{ props.row.ord }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="25%" sortable>
                    <b-field v-if="props.row.index === currItem.index || props.row === currItem" :type="{ 'is-danger': $v.currItem.title.$error }">
                        <b-input v-model="currItem.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>

                <b-table-column field="type" label="Тип данных" width="25%" sortable centered>
                    <template v-if="props.row.index === currItem.index || props.row === currItem">
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
                    <b-checkbox v-if="props.row.index === currItem.index || props.row === currItem" v-model="currItem.is_required"
                                :disabled="currItem.type === 'header'" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.index === currItem.index || props.row === currItem" v-model="currItem.is_filter"
                                :disabled="currItem.type === 'text' || currItem.type === 'header'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.row.index === currItem.index || props.row === currItem">
                        <button @click="save" type="button" class="button fas fa-check is-success is-small" />
                        <button @click="cancel" type="button" class="button fas fa-times is-warning is-small" />
                    </template>
                    <template v-else>
                        <button @click="edit(props.row.index)" type="button" class="button fas fa-pen is-small" />
                        <button @click="remove(props.row.index)" type="button" class="button fas fa-trash-alt is-small" />
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
    import Collection from "@/services/Collection";

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
        header: 'заголовок',
    };

    export default {
        name: "CategoryFeatures",

        mixins: [draggable, createKey],

        props: {
            propItems: {
                type: Array,
                default: () => []
            },
        },

        data () {
            return {
                method: null,
                currItem: {},
                inputTypes: inputTypes,
                collection: new Collection({ autoOrder: 'ord' }),
            }
        },

        computed: {
            items: function() {
                return this.collection.all(true);
            },
        },

        mounted() {
            this.collection.collect(this.propItems);

            console.log( this.collection.find(el => el.title === 'efwef') );
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
                this.cancel();
                this.method = 'add';
                this.currItem = { key: this.createKey(), ...blank };
            },

            edit(index) {
                this.cancel();
                this.method = 'edit';
                this.currItem = this.collection.get(index);
            },

            save() {
                if (this.validate()) {
                    if (this.method === 'add') {
                        this.collection.push(this.currItem);
                    } else {
                        this.collection.put(this.currItem.index, this.currItem);
                    }

                    this.$emit('update', this.items);
                    this.cancel();
                }
            },

            validate() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    this.toast('Заполните обязательные поля');

                    return false;
                }

                let duplicate = this.collection.findIndex(el => el.title === this.currItem.title);

                if (duplicate !== -1 && duplicate !== this.currItem.index) {
                    this.toast('Уже есть запись с таким Названием');

                    return false;
                }

                return true;
            },

            remove(index) {
                this.confirm('Удалить?', () => {
                    this.collection.remove(index);
                    this.$emit('update', this.items);
                    this.cancel();
                });
            },

            cancel() {
                this.$v.$reset();
                this.method = null;
                this.currItem = {};
            },

            reset() {
                this.currItem = Object.assign(this.currItem, blank);
            },

            drop(payload) {
                this.dragdrop(payload);

                if(Object.keys(this.currItem).length) {
                    return false;
                }

                if (payload.row.ord && this.draggingRow.ord && payload.row.ord !== this.draggingRow.ord) {
                    [payload.row.ord, this.draggingRow.ord] = [this.draggingRow.ord, payload.row.ord];
                    this.$refs.table.initSort();
                    this.$emit('update', this.items);
                }
            },
        }
    }
</script>

<style>
    tr.feature-header {
        background: #eee;
        font-weight: bold;
    }
</style>

