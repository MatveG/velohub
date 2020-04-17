<template>
    <div>
        <b-table ref="table" class="table-valign-center"
                 hoverable
                 :data='items'
                 :loading="loading"
                 default-sort="sorting"
                 custom-row-key="sorting"
                 icon-pack="fa"

                 draggable
                 @dragstart="dragstart"
                 @drop="drop"
                 @dragover="dragover"
                 @dragleave="dragleave"

                 detailed
                 :opened-detailed="opened"
                 :show-detail-icon="false"
                 detail-key="sorting"

                 :row-class="(row, index) => row.type === 'heading' && 'feature-heading'">

            <template slot-scope="props">
                <b-table-column field="sorting" label="Порядок" width="10%" sortable centered>
                    {{ props.row.sorting }}
                </b-table-column>

                <b-table-column field="title" label="Название" width="30%" sortable centered>
                    <b-input v-if="opened.includes(props.row.sorting)" v-model="props.row.title" />
                    <span v-else>{{ props.row.title }}</span>
                </b-table-column>
                <b-table-column field="type" label="Тип данных" width="20%" sortable centered>
                    <b-select v-if="opened.includes(props.row.sorting)" v-model="props.row.type" @change.native="resetSettings">
                        <option v-for="(title, key) in inputTypes" :value="key">{{ title }}</option>
                    </b-select>
                    <span v-else>{{ inputTypes[props.row.type] }}</span>
                </b-table-column>
                <b-table-column field="is_required" label="Обязательное" width="10%" sortable centered>
                    <b-checkbox v-if="opened.includes(props.row.sorting)" v-model="props.row.is_required" />
                    <span v-else-if="props.row.is_required" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>
                <b-table-column field="is_filter" label="Фильтр" width="10%" sortable centered>
                    <b-checkbox v-if="opened.includes(props.row.sorting)" v-model="props.row.is_filter" />
                    <span v-else-if="props.row.is_filter" class="icon has-text-dark">
                        <i class="fas fa-check-square"></i>
                    </span>
                </b-table-column>

                <b-table-column width="20%" class="is-actions-cell">
                    <button @click="edit(props.row)" type="button" class="button fas fa-pen is-small" />
                    <button @click="destroy(props.row)" type="button" class="button fas fa-trash-alt is-small" />
                </b-table-column>
            </template>

            <template slot="detail" slot-scope="props">
                <tr>
                    <td colspan="6" style="background: red">

                        <div v-if="['string', 'number', 'select'].includes(item.type)" class="columns">
                            <div class="column">1</div>
                            <div class="column">2</div>
                        </div>

                        <div v-else>
                            <article class="message">
                                <div class="message-body">
                                    <template v-if="item.type === 'boolean'">
                                        <table class="table is-striped is-fullwidth">
                                            <tbody>
                                            <tr>
                                                <td class="half-width">
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                                </td>
                                                <td>Yes</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                    <template v-if="item.type === 'text'">
                                        <p>
                                            <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                        </p>
                                        <i>The iPhone is a smartphone made by Apple that combines a computer, iPod, digital camera and cellular phone into one device with a touchscreen interface. The iPhone runs the iOS operating system (OS), and as of 2017, there were 2.2 million apps available for it through the Apple App Store, according to Statista.</i>
                                    </template>
                                    <template v-if="item.type === 'heading'">
                                        <table class="table is-striped is-fullwidth">
                                            <tbody>
                                            <tr class="has-text-grey-light">
                                                <td class="half-width">OS</td>
                                                <td>iOS 13.0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="is-bold">
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                                </td>
                                            </tr>
                                            <tr class="has-text-grey-light">
                                                <td class="half-width">WLAN</td>
                                                <td>Wi-Fi 802.11b/g</td>
                                            </tr>
                                            <tr class="has-text-grey-light">
                                                <td>Bluetooth</td>
                                                <td>v2.0 (headset support only)</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                </div>
                            </article>
                        </div>


                        <div v-if="item.type" class="columns">
                            <template v-if="['string', 'number', 'select'].includes(item.type)">
                                <div class="column">
                                    <b-field v-if="item.type === 'string' || item.type === 'number'" label="Единицы измерения" label-position="on-border">
                                        <b-input v-model="item.settings.units" placeholder="кг" />
                                    </b-field>
                                    <b-field v-if="item.type === 'number'"  label="Знаков после точки" label-position="on-border">
                                        <b-input v-model.number="item.settings.accuracy" placeholder="0" />
                                    </b-field>
                                    <div v-if="item.type === 'select'">
                                        <b-field label="Список значений" label-position="on-border">
                                            <b-input v-model="item.settings.values" type="textarea" rows="4" placeholder="одна строка - одно значение" />
                                        </b-field>
                                        <b-field>
                                            <b-checkbox v-model="item.settings.multiple">Множественный выбор</b-checkbox>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="column">
                                    <article class="message">
                                        <div class="message-body">
                                            <template v-if="item.type === 'string'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">string value <span class="has-text-grey-light">{{ item.settings.units }}</span></p>
                                            </template>
                                            <template v-if="item.type === 'number'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">
                                                    {{ (100.0000).toFixed(item.settings.accuracy) }}
                                                    <span class="has-text-grey-light">{{ item.settings.units }}</span>
                                                </p>
                                            </template>
                                            <template v-if="item.type === 'select'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">
                                                    <template v-if="item.settings.multiple">
                                                        some value<br>
                                                        another value<br>
                                                        one more value
                                                    </template>
                                                    <template v-else>some value</template>
                                                </p>
                                            </template>
                                        </div>
                                    </article>
                                </div>
                            </template>


                        </div>


                    </td>
                </tr>
            </template>
        </b-table>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>


        <b-modal :active.sync="modal" aria-modal class="modal-edit-variant">
            <div class="box">
                <form @submit.prevent="save" @change.prevent="save()">
                    <card-component>
                        <div class="columns">
                            <div class="column is-7">
                                <b-field label="Название">
                                    <b-input v-model="item.title" placeholder="" />
                                </b-field>
                                <b-field label="Тип данных" label-position="on-border">
                                    <b-select v-model="item.type" @change.native="resetSettings" expanded>
                                        <option v-for="(title, key) in inputTypes" :value="key">{{ title }}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field v-if="!item.type || item.type !== 'heading'" label="Свойства">
                                    <b-switch v-model="item.is_required">Обязательная</b-switch>
                                </b-field>
                                <b-field v-if="!item.type || (item.type !== 'text' && item.type !== 'heading')">
                                    <b-switch v-model="item.is_filter">Фильтр</b-switch>
                                </b-field>
                            </div>
                        </div>




                        <div v-if="item.type" class="columns">
                            <template v-if="['string', 'number', 'select'].includes(item.type)">
                                <div class="column">
                                    <b-field v-if="item.type === 'string' || item.type === 'number'" label="Единицы измерения" label-position="on-border">
                                        <b-input v-model="item.settings.units" placeholder="кг" />
                                    </b-field>
                                    <b-field v-if="item.type === 'number'"  label="Знаков после точки" label-position="on-border">
                                        <b-input v-model.number="item.settings.accuracy" placeholder="0" />
                                    </b-field>
                                    <div v-if="item.type === 'select'">
                                        <b-field label="Список значений" label-position="on-border">
                                            <b-input v-model="item.settings.values" type="textarea" rows="4" placeholder="одна строка - одно значение" />
                                        </b-field>
                                        <b-field>
                                            <b-checkbox v-model="item.settings.multiple">Множественный выбор</b-checkbox>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="column">
                                    <article class="message">
                                        <div class="message-body">
                                            <template v-if="item.type === 'string'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">string value <span class="has-text-grey-light">{{ item.settings.units }}</span></p>
                                            </template>
                                            <template v-if="item.type === 'number'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">
                                                    {{ (100.0000).toFixed(item.settings.accuracy) }}
                                                    <span class="has-text-grey-light">{{ item.settings.units }}</span>
                                                </p>
                                            </template>
                                            <template v-if="item.type === 'select'">
                                                <p>
                                                    <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                                                </p>
                                                <p class="has-text-right">
                                                    <template v-if="item.settings.multiple">
                                                        some value<br>
                                                        another value<br>
                                                        one more value
                                                    </template>
                                                    <template v-else>some value</template>
                                                </p>
                                            </template>
                                        </div>
                                    </article>
                                </div>
                            </template>

                            <div v-else class="column is-full">
                                <article class="message">
                                    <div class="message-body">
                                        <template v-if="item.type === 'boolean'">
                                            <table class="table is-striped is-fullwidth">
                                                <tbody>
                                                <tr>
                                                    <td class="half-width">
                                                        <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                                    </td>
                                                    <td>Yes</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </template>
                                        <template v-if="item.type === 'text'">
                                            <p>
                                                <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                            </p>
                                            <i>The iPhone is a smartphone made by Apple that combines a computer, iPod, digital camera and cellular phone into one device with a touchscreen interface. The iPhone runs the iOS operating system (OS), and as of 2017, there were 2.2 million apps available for it through the Apple App Store, according to Statista.</i>
                                        </template>
                                        <template v-if="item.type === 'heading'">
                                            <table class="table is-striped is-fullwidth">
                                                <tbody>
                                                <tr class="has-text-grey-light">
                                                    <td class="half-width">OS</td>
                                                    <td>iOS 13.0</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="is-bold">
                                                        <b>{{ (item.title) ? item.title : 'Title' }}</b>
                                                    </td>
                                                </tr>
                                                <tr class="has-text-grey-light">
                                                    <td class="half-width">WLAN</td>
                                                    <td>Wi-Fi 802.11b/g</td>
                                                </tr>
                                                <tr class="has-text-grey-light">
                                                    <td>Bluetooth</td>
                                                    <td>v2.0 (headset support only)</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </template>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </card-component>

                    <div class="buttons margin-line is-centered">
                        <button v-if="!item.sorting" @click="save" type="button" class="button is-primary">Добавить</button>
<!--                        <button @click="modal=false" type="button" class="button">Закрыть</button>-->
                    </div>
                </form>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import core from "../js/Core";
    import CardComponent from "./CardComponent";

    // const settings = () => {
    //     return {
    //         units: null,
    //         accuracy: 0,
    //         values: null,
    //         multiple: false,
    //     }
    // };

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

        components: { CardComponent },

        props: {
            propItems: {
                type: Array,
                default: []
            },
        },

        data () {
            return {
                inputTypes: inputTypes,
                item: {},
                items: [],
                opened: [1],
                modal: false,
                loading: false,
                saved: true,
            }
        },
        mounted() {
            this.items = this.propItems;
            this.item = this.items[0];
        },

        methods: {
            isOpened(row) {
                return this.opened[0] === row.sorting;
            },

            create() {
                this.item = {
                    is_required: false,
                    is_filter: false,
                    settings: {}
                };

                this.modal = true;
            },

            edit(item) {
                this.item = item;
                this.opened = [item.sorting];
                //this.modal = true;
            },

            save() {
                console.log('save');

                if(!this.item.sorting) {
                    let maxSorting = Math.max(...this.items.map(element => element.sorting));
                    this.item.sorting = (this.items.length) ? maxSorting + 1 : 1;
                    this.items.push(this.item);
                }

                //this.$emit('update', this.items);
                this.modal = false;
            },

            destroy(item) {
                core.confirm('Удалить?', () => {
                    this.items = this.items.filter(element => element !== item);
                    //this.$emit('update', this.items);
                });
            },

            resetSettings() {
                if(this.item.type === 'text' || this.item.type === 'heading') {
                    this.item.is_required = false;
                    this.item.is_filter = false;
                }
                this.item.settings = {};
            },

            // sorting
            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row && this.draggingRow) {
                    let temp = payload.row.sorting;
                    payload.row.sorting = this.draggingRow.sorting;
                    this.draggingRow.sorting = temp;

                    this.$refs.table.initSort();
                    //this.$emit('update', this.items);
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

