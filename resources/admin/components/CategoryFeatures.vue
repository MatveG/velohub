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
                 @dragstart="dragstart"
                 @drop="drop"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 :row-class="(row, index) => row.type === 'heading' && 'feature-heading'">
            <template slot-scope="props">
                <b-table-column field="ord" width="5%" sortable centered>
                    {{ props.row.ord }}
                </b-table-column>
                <b-table-column field="title" label="Название" width="25%" sortable>
                    <b-field v-if="props.index === index" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>
                <b-table-column field="type" label="Тип данных" width="25%" sortable centered>
                    <template v-if="props.index === index">
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
                <b-table-column field="is_required" label="Обязательное" width="10%" sortable centered>
                    <b-checkbox v-if="props.index === index" v-model="item.is_required"
                                :disabled="item.type === 'heading'" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.index === index" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'heading'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.index === index">
                        <button @click="save(props.index)" type="button" class="button fas fa-check is-success is-small" />
                        <button @click="cancel()" type="button" class="button fas fa-times is-warning is-small" />
                    </template>
                    <template v-else>
                        <button @click="edit(props.index)" type="button" class="button fas fa-pen is-small" />
                        <button @click="remove(props.index)" type="button" class="button fas fa-trash-alt is-small" />
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
    import Collection from "@/js/Collection";
    import {createKey} from "@/mixins/createKey";

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

        mixins: [createKey],

        props: {
            propItems: {
                type: Array,
                default: () => []
            },
        },

        data () {
            return {
                collection: new Collection({ customKey: 'key', customOrd: 'ord' }),
                item: null,
                index: null,
                action: null,
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
                this.$v.$reset();
                this.item = {
                    key: this.createKey(),
                    ...blank
                };
                this.index = this.collection.count();
            },

            edit(key) {
                this.$v.$reset();
                this.item = this.collection.get(key);
                this.index = key;
            },

            save(key) {
                // this.$v.$touch();
                //
                // if (this.$v.$invalid) {
                //     return window.error('Заполните обязательные поля');
                // }
                // if (this.list.find(each => each.title === this.item.title && each.key !== this.item.key)) {
                //     return window.error('Уже есть запись с таким Названием');
                // }

                if (this.item.ord) {
                    this.collection.put(this.index, this.item);
                } else {
                    this.collection.push(this.item);
                }

                this.cancel();
                this.$emit('update', this.items);
            },

            remove(item) {
                window.confirm('Удалить?', () => {
                    this.collection.remove(item);
                    this.cancel();
                    this.$emit('update', this.items);
                });
            },

            cancel() {
                this.action = null;
                this.index = null;
                this.item = {};
            },

            reset() {
                this.item = { ...this.item, ...blank };
            },

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row.ord === this.draggingRow.ord) {
                    return;
                }

                [payload.row.ord, this.draggingRow.ord] = [this.draggingRow.ord, payload.row.ord];
                this.$refs.table.initSort();
                this.$emit('update', this.items);

                if (this.item.key) {
                    if (this.draggingRow.key === this.item.key) {
                        this.item.ord = this.draggingRow.ord;
                    }
                    if (!this.item.title || !this.item.type) {
                        this.$v.$touch();
                        return;
                    }
                }
            },

            dragstart (payload) {
                this.draggingRow = payload.row;
                this.draggingRowIndex = payload.index;
                payload.event.dataTransfer.effectAllowed = 'copy';
            },

            dragover(payload) {
                payload.event.dataTransfer.dropEffect = 'copy';
                payload.event.target.closest('tr').classList.add('is-selected');
                payload.event.preventDefault();
            },

            dragleave(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');
                payload.event.preventDefault();
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

