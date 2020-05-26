<template>
    <div>
        <b-table class="table-valign-center"
                 ref="table"
                 :data="(method === 'add') ? [...items, item] : items"
                 default-sorting="sorting"
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
                <b-table-column field="sorting" width="5%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="25%" sortable>
                    <b-field v-if="props.row.index === item.index || props.row === item" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>

                <b-table-column field="type" label="Тип данных" width="25%" sortable centered>
                    <template v-if="props.row.index === item.index || props.row === item">
                        <b-field :type="{ 'is-danger': $v.item.type.$error }">
                            <b-select v-model="item.type" @change.native="reset" expanded>
                                <option v-for="(title, key) in inputTypes" :value="key">{{ title }}</option>
                            </b-select>
                        </b-field>
                        <template v-if="item.type === 'number'">
                            <b-field label="Единицы измерения" label-position="on-border">
                                <b-input v-model="item.units" placeholder="кг" />
                            </b-field>
                        </template>
                        <template v-if="item.type === 'select'">
                            <b-field label="Список значений" label-position="on-border" :type="{ 'is-danger': $v.item.values.$error }">
                                <b-taginput v-model="item.values" placeholder="Добавить"  />
                            </b-field>
                        </template>
                    </template>
                    <span v-else>{{ inputTypes[props.row.type] }}</span>
                </b-table-column>

                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.index === item.index || props.row === item" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'header'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.row.index === item.index || props.row === item">
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
    import { required, requiredIf, minLength } from 'vuelidate/lib/validators'
    import {draggable} from "@/mixins/draggable";
    import {createKey} from "@/mixins/createKey";
    import Collection from "@/services/Collection";

    const blank = {
        is_filter: false,
        values: null
    };
    const inputTypes = {
        string: 'строка',
        number: 'число',
        select: 'выбор',
    };

    export default {
        name: "CategoryParameters",

        mixins: [draggable, createKey],

        props: {
            propItems: {
                type: Array,
                default: () => []
            },
        },

        data () {
            return {
                item: {},
                method: null,
                inputTypes: inputTypes,
                collection: new Collection(),
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
            item: {
                title: {
                    required,
                    minLength: minLength(2)
                },
                type: {
                    required,
                },
                values: {
                    required: requiredIf(function () {
                        return this.item.type === 'select';
                    }),
                    minLength: minLength(1),
                }
            }
        },

        methods: {
            add() {
                this.cancel();
                this.method = 'add';
                this.item = {
                    key: this.createKey(),
                    ...blank
                };
            },

            edit(index) {
                this.cancel();
                this.item = this.collection.get(index);
            },

            save() {
                if (this.validate()) {
                    (this.method === 'add') ? this.collection.push(this.item) : this.collection.put(this.item.index, this.item);
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

                let duplicate = this.collection.findIndex(el => el.title === this.item.title);

                if (duplicate !== -1 && duplicate !== this.item.index) {
                    this.toast('Уже есть запись с таким Названием');

                    return false;
                }

                return true;
            },

            remove(index) {
                this.confirm('Удалить?', () => {
                    this.cancel();
                    this.collection.remove(index);
                    this.$emit('update', this.items);
                });
            },

            cancel() {
                this.$v.$reset();
                this.method = null;
                this.item = {};
            },

            reset() {
                this.item = Object.assign(this.item, blank);
            },

            drop(payload) {
                this.dragdrop(payload);

                if (!Object.keys(this.item).length && payload.row.sorting !== this.draggingRow.sorting) {
                    this.dragswap(payload);
                    this.$emit('update', this.items);
                }
            },
        }
    }
</script>
