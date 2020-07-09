<template>
    <div class="table-draggable-nested">
        <b-table ref="table"
                 :data="(method === 'add') ? [...items, item] : items"
                 default-sort="ord"
                 custom-row-key="id"
                 icon-pack="fa"
                 hoverable
                 draggable
                 @drop="featuresDrop"
                 @dragstart="dragstart"
                 @dragover="dragover"
                 @dragleave="dragleave"
                 detailed
                 detail-key="id"
                 :show-detail-icon="false"
                 :openedRows-detailed="openedRows"
                 class="valign-center">

            <template v-slot="props">
                <b-table-column field="ord" label="↓" width="5%" sortable centered>
                    {{ props.row.ord }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="30%" sortable>
                    <b-field v-if="props.row.id === item.id || props.row === item" :type="{ 'is-danger': $v.item.title.$error }">
                        <b-input v-model="item.title"></b-input>
                    </b-field>
                    <template v-else>{{ props.row.title }}</template>
                </b-table-column>

                <b-table-column field="type" label="Тип" width="20%" sortable centered>
                    <template v-if="props.row.id === item.id || props.row === item">
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

                <b-table-column field="required" label="Обязательное" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.id === item.id || props.row === item" v-model="item.required"
                                :disabled="item.type === 0" />
                    <span v-else-if="props.row.required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column field="filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="props.row.id === item.id || props.row === item" v-model="item.filter"
                                :disabled="item.type === 'text' || item.type === 0" />
                    <span v-else-if="props.row.filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column label="*" width="20%" centered>
                    <template v-if="props.row.id === item.id || props.row === item">
                        <button @click="save" type="button" class="button fas fa-check is-success" />
                        <button @click="cancel" type="button" class="button fas fa-times is-warning" />
                    </template>
                    <template v-else>
                        <b-dropdown hoverable :expanded="false" aria-role="list" class="dropdown-buttons">
                            <button @click="editFeature(props.row)" slot="trigger" class="button is-primary fas fa-pen" />

                            <b-dropdown-item v-if="props.row.type === 0" @click="addSub(props.row)" aria-role="listitem">
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
                <category-features :prop-items="props.row.sub" :prop-sub="true" :ref="`subTable{$props.row.id}`"
                           @update="assign(props.row, 'sub', $event)" />
            </template>
        </b-table>

        <div v-if="!propSub" class="buttons is-centered margin-line">
            <button class="button is-primary" type="button" @click="addFeature">Добавить</button>
        </div>
    </div>
</template>

<script>
    import {draggable} from "@/mixins/draggable";
    import {items} from "../mixins/items";
    import Feature from "../classes/Feature";
    import CategoryFeatures from "./CategoryFeatures";

    export default {
        name: "CategoryFeatures",

        components: {CategoryFeatures},

        mixins: [draggable, items],

        data() {
            return {
                openedRows: [],
                inputTypes: Feature.getTypes(!this.propSub)
            }
        },

        mounted() {
            this.openedRows = this.getOpenedRows();
        },

        validations: {
            item: Feature.validations(),
        },

        methods: {
            addFeature() {
                this.add();
                this.item = new Feature();
            },

            editFeature(row) {
                this.edit();
                this.item = Feature.fromObj(row);

                this.item = row;
            },

            getOpenedRows() {
                this.coll.orderBy('ord');

                console.log(this.items.filter(el => el.type === 0).map(el => el.id));

                return this.items.filter(el => el.type === 0).map(el => el.id);
            },

            addSub(row) {
                console.log(this.$refs[`subTable{$row.id}`]);
                this.$refs[`subTable{$row.id}`].addFeature();
            },

            featuresDrop(payload) {
                this.drop(payload);

                setTimeout(() => this.openedRows = [], 0);
                setTimeout(() => this.openedRows = this.getOpenedRows(), 0);
            }
        }
    }
</script>

<style></style>
