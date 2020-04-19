<template>
    <div>
        <b-table ref="table" class="table-valign-center"
                 :data='items'
                 default-sort="sorting"
                 custom-row-key="sorting"
                 icon-pack="fa"
                 hoverable
                 draggable
                 @dragstart="dragstart"
                 @drop="drop"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 :row-class="(row, index) => row.type === 'heading' && 'feature-heading'">
            <template slot-scope="props">
                <b-table-column field="sorting" width="5%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>
                <b-table-column field="title" label="Название" width="25%" sortable>
                    <b-field v-if="props.row.key === item.key" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>
                <b-table-column field="type" label="Тип данных" width="25%" sortable centered>
                    <template v-if="props.row.key === item.key">
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
                    <b-checkbox v-if="props.row.key === item.key" v-model="item.is_required"
                                :disabled="item.type === 'heading'" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.key === item.key" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'heading'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column label="*" width="20%" header-class="qwe" centered>
                    <template v-if="props.row.key === item.key">
                        <button @click="save()" type="button" class="button fas fa-check is-success is-small" />
                        <button @click="cancel()" type="button" class="button fas fa-times is-warning is-small" />
                    </template>
                    <template v-else>
                        <button @click="edit(props.row)" type="button" class="button fas fa-pen is-small" />
                        <button @click="destroy(props.row)" type="button" class="button fas fa-trash-alt is-small" />
                    </template>
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered margin-line">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>
    </div>
</template>

<script>
    import shortid from 'shortid'
    import { required, requiredIf, minLength } from 'vuelidate/lib/validators'
    import core from '../js/Core'

    const inputTypes = {
        string: 'строка',
        number: 'число',
        text: 'текст',
        boolean: 'да/нет',
        select: 'выбор из списка',
        heading: 'заголовок',
    };
    const blank = {
        is_required: false,
        is_filter: false,
        units: null,
        values: null
    };

    export default {
        name: "CategoryFeatures",

        props: {
            propItems: {
                type: Array,
                default: []
            },
        },

        data () {
            return {
                item: {},
                items: this.propItems,
                inputTypes: inputTypes,
            }
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
            create() {
                if (this.item.key) {
                    this.cancel();
                }
                this.$v.$reset();

                this.item = {
                    key: shortid.generate(),
                    sorting: Math.max(0, ...this.items.map(element => element.sorting)) + 1,
                    ...blank
                };
                this.items.push(this.item);
            },

            edit(item) {
                if (this.item.key) {
                    this.cancel();
                }

                this.item = { ...item };
            },

            save() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return core.error('Заполните обязательные поля');
                }
                if (this.items.find(element => element.title === this.item.title && element.key !== this.item.key)) {
                    return core.error('Уже есть запись с таким Названием');
                }

                this.items = this.items.map(element => (element.key === this.item.key) ? this.item : element);
                this.item = {};
                this.$emit('update', this.items);
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.items = this.items.filter(element => element !== item);
                    this.$emit('update', this.items);
                });
            },

            cancel() {
                this.items = this.items.filter(element => element.title && element.type);
                this.item = {};
            },

            reset() {
                this.item = { ...blank };
            },

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row && this.draggingRow) {
                    let temp = payload.row.sorting;
                    payload.row.sorting = this.draggingRow.sorting;
                    this.draggingRow.sorting = temp;

                    if (payload.row.sorting !== this.draggingRow.sorting) {
                        this.$refs.table.initSort();
                        this.$emit('update', this.items);
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
        font-style: italic;
    }
</style>

