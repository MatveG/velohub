<template>
    <div>
        <b-table ref="table" class="table-valign-center"
                 :data='items'
                 default-sort="sorting"
                 custom-row-key="sorting"
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
                        <template v-if="item.type === 'select'">
                            <b-field label="Список значений" label-position="on-border" :type="{ 'is-danger': $v.item.values.$error }">
                                <b-taginput v-model="item.values" placeholder="Добавить"  />
                            </b-field>
                        </template>
                    </template>
                    <span v-else>{{ inputTypes[props.row.type] }}</span>
                </b-table-column>
                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.key === item.key" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'heading'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column label="*" width="20%" centered>
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
    import { required, requiredIf, minLength } from 'vuelidate/lib/validators'
    import { customAlphabet } from 'nanoid'

    const nanoid = customAlphabet('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 9);
    const inputTypes = {
        string: 'строка',
        number: 'число',
        select: 'выбор из списка',
    };
    const blank = {
        is_filter: false,
        values: null
    };

    // key
    // sorting
    // title +
    // type +
    // is_filter
    // latin (if is_filter)


    export default {
        name: "CategoryParameters",

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
                this.cancel();
                this.$v.$reset();

                this.item = {
                    key: nanoid(9),
                    sorting: Math.max(0, ...this.items.map(each => each.sorting)) + 1,
                    ...blank
                };
                this.items.push(this.item);
                this.fresh = true;
            },

            edit(item) {
                this.cancel();
                this.item = { ...item };
                this.fresh = false;
            },

            save() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return core.error('Заполните обязательные поля');
                }
                if (this.items.find(each => each.title === this.item.title && each.key !== this.item.key)) {
                    return core.error('Уже есть запись с таким Названием');
                }

                this.items = this.items.map(each => (each.key === this.item.key) ? this.item : each);
                this.item = {};
                this.$emit('update', this.items);
                this.fresh = null;
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.cancel();
                    this.items = this.items.filter((each) => each.key !== item.key);
                    this.items.map((each) => each.sorting = (each.sorting > item.sorting) ? --each.sorting : each.sorting);
                    this.$emit('update', this.items);
                });
            },

            cancel() {
                if (this.item.key) {
                    if (this.fresh) {
                        this.items = this.items.filter((each) => each.key !== this.item.key);
                        this.items.map((each) => each.sorting = (each.sorting > this.item.sorting) ? --each.sorting : each.sorting);
                    }
                    this.item = {};
                    this.fresh = null;
                }
            },

            reset() {
                this.item = Object.assign(this.item, blank);
            },

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row.sorting === this.draggingRow.sorting) {
                    return;
                }
                [payload.row.sorting, this.draggingRow.sorting] = [this.draggingRow.sorting, payload.row.sorting];
                this.$refs.table.initSort();

                if (this.item.key) {
                    if (this.draggingRow.key === this.item.key) {
                        this.item.sorting = this.draggingRow.sorting;
                    }
                    if (!this.item.title || !this.item.type) {
                        this.$v.$touch();
                        return;
                    }
                }
                this.$emit('update', this.items);
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
