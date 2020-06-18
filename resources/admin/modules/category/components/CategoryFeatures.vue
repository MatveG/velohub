<template>
    <div class="table-draggable-nested">
        <b-table ref="table"
                 :data="(method === 'add') ? [...items, item] : items"
                 default-sort="sorting"
                 custom-row-key="index"
                 icon-pack="fa"
                 hoverable
                 draggable
                 @drop="featuresDrop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 detailed
                 detail-key="index"
                 :show-detail-icon="false"
                 :opened-detailed="opened"
                 class="valign-center">

            <template v-slot="props">
                <b-table-column field="sorting" label="↓" width="5%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="30%" sortable>
                    <b-field v-if="props.row.index === item.index || props.row === item" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <template v-else>{{ props.row.title }}</template>
                </b-table-column>

                <b-table-column field="type" label="Тип" width="20%" sortable centered>
                    <template v-if="props.row.index === item.index || props.row === item">
                        <b-field :type="{ 'is-danger': $v.item.type.$error }">
                            <b-select v-model="item.type" @change.native="reset" expanded>
                                <option v-for="(title, key) in inputTypes" :value="key">
                                    {{ title }}
                                </option>
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
                    <template v-else>{{ inputTypes[props.row.type] }}</template>
                </b-table-column>

                <b-table-column field="is_required" label="Обязательное" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.index === item.index || props.row === item" v-model="item.is_required"
                                :disabled="item.type === 'group'" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.index === item.index || props.row === item" v-model="item.is_filter"
                                :disabled="item.type === 'text' || item.type === 'group'" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.row.index === item.index || props.row === item">
                        <button @click="save" type="button" class="button fas fa-check is-success" />
                        <button @click="cancel" type="button" class="button fas fa-times is-warning" />
                    </template>
                    <template v-else>
                        <b-dropdown hoverable :expanded="false" aria-role="list" class="dropdown-buttons">
                            <button @click="edit(props.row)" slot="trigger" class="button is-primary fas fa-pen" />

                            <b-dropdown-item v-if="props.row.type==='group'" @click="addSub(props.row)" aria-role="listitem">
                                <b-icon pack="fas" icon="plus" />
                            </b-dropdown-item>

                            <b-dropdown-item @click="remove(props.row)" aria-role="listitem">
                                <b-icon pack="fas" icon="trash" />
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table-column>
            </template>

            <template slot="detail" slot-scope="props">
                <category-features :prop-items="props.row.sub" :prop-nested="true" :ref="'subTable' + props.row.index"
                           @update="assign(props.row, 'sub', $event)" />
            </template>
        </b-table>

        <div v-if="!propNested" class="buttons is-centered margin-line">
            <button class="button is-primary" type="button" @click="add">Добавить</button>
        </div>
    </div>
</template>

<script>
    import {required, requiredIf, minLength} from "vuelidate/lib/validators";
    import {draggable} from "@/mixins/draggable";
    import {categoryItems} from "../mixins/categoryItems";
    import CategoryFeatures from "./CategoryFeatures";

    const BLANK = {
        is_required: false,
        is_filter: false,
        units: null,
        values: null,
        sub: []
    };
    const GROUP_TYPE = {
        group: 'группа'
    };
    const INPUT_TYPES = {
        string: 'строка',
        number: 'число',
        text: 'текст',
        boolean: 'есть/нет',
        select: 'выбор',
    };

    export default {
        name: "CategoryFeatures",

        components: {CategoryFeatures},

        mixins: [draggable, categoryItems],

        props: {
            propNested: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                opened: [],
                blank: BLANK,
                inputTypes: (this.propNested) ? INPUT_TYPES : {...GROUP_TYPE, ...INPUT_TYPES}
            }
        },

        mounted() {
            this.opened = this.getOpened();
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
            getOpened() {
                this.collection.orderBy('sorting');

                return this.items.filter(el => el.type === 'group').map(el => el.index);
            },

            addSub(row) {
                this.$refs['subTable' + row.index].add();
            },

            featuresDrop() {
                this.drop();

                setTimeout(() => this.opened = [], 0);
                setTimeout(() => this.opened = this.getOpened(), 0);
            }
        }
    }
</script>

<style></style>
