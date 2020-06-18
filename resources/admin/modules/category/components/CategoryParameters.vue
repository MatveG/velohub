<template>
    <div>
        <b-table ref="table"
                 :data="(method === 'add') ? [...items, item] : items"
                 default-sort="sorting"
                 custom-row-key="index"
                 icon-pack="fa"
                 hoverable
                 draggable
                 @drop="drop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 class="valign-center">

            <template v-slot="props">
                <b-table-column field="sorting" width="5%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="30%" sortable>
                    <b-field v-if="props.row.index === item.index || props.row === item" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>

                <b-table-column field="type" label="Тип данных" width="20%" sortable centered>
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

                <b-table-column field="is_filter" label="Фильтр" width="15%" sortable centered>
                    <b-checkbox v-if="props.row.index === item.index || props.row === item" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'header'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.row.index === item.index || props.row === item">
                        <button @click="saveParameter" type="button" class="button fas fa-check is-success" />
                        <button @click="cancel" type="button" class="button fas fa-times is-warning" />
                    </template>
                    <template v-else>
                        <b-dropdown hoverable :expanded="false" aria-role="list" class="dropdown-buttons">
                            <button @click="edit(props.row)" slot="trigger" class="button is-primary fas fa-pen" />

                            <b-dropdown-item @click="remove(props.row)" aria-role="listitem">
                                <b-icon pack="fas" icon="trash" />
                            </b-dropdown-item>
                        </b-dropdown>
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
    import {required, requiredIf, minLength} from 'vuelidate/lib/validators'
    import {draggable} from "@/mixins/draggable";
    import {categoryItems} from "../mixins/categoryItems";

    const BLANK = {
        is_filter: false,
        values: null
    };
    const INPUT_TYPES = {
        string: 'строка',
        number: 'число',
        select: 'выбор',
    };

    export default {
        name: "CategoryParameters",

        mixins: [draggable, categoryItems],

        data() {
            return {
                opened: [],
                blank: BLANK,
                inputTypes: INPUT_TYPES
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
            saveParameter() {
                if (this.collection.some((el, i) => el.title === this.item.title && i !== this.item.index)) {
                    this.toast('Уже есть запись с таким Названием');

                    return false;
                }

                this.save();
            },
        }
    }
</script>
