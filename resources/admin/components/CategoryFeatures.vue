<template>
    <div>
        <b-table class="table-valign-center"
                 ref="table"
                 :data='items'
                 :loading="loading"
                 default-sort="order"
                 icon-pack="fa"
                 hoverable

                 draggable
                 custom-row-key="order"
                 @dragstart="dragstart"
                 @drop="drop"
                 @dragover="dragover"
                 @dragleave="dragleave"

                 detailed
                 detail-key="id"
                 custom-detail-row
                 :opened-detailed="openedDetails"
                 @sort="openedDetails = []">

            <template slot-scope="props">
                <b-table-column field="group" label="111" width="10%" sortable centered>
                    {{ props.row.group }}
                </b-table-column>
                <b-table-column field="title" label="222" width="10%" sortable centered>
                    {{ props.row.title }}
                </b-table-column>
                <b-table-column field="units" label="333" width="10%" sortable centered>
                    {{ props.row.units }}
                </b-table-column>
                <b-table-column field="filter" label="444" width="10%" sortable centered>
                    {{ props.row.filter }}
                </b-table-column>
            </template>
        </b-table>
        <div class="buttons is-centered">
            <button class="button is-primary" type="button" @click="create">Добавить</button>
        </div>



        <b-modal :active.sync="modal" aria-modal class="modal-edit-variant">
            <div class="box">
                <form @submit.prevent="save" @change="autoSave" @keyup="saved=false">
                    <card-component title="Параметры варианта">

                        <article class="message">
                            <div class="message-body">
                                Пример:<br>
                                {{ item.title }}: 55 {{ item.units }}
                            </div>
                        </article>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Название" label-position="on-border">
                                    <b-input v-model="item.title" placeholder="Штрих-код товара" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Тип данных" label-position="on-border">
                                    <b-select v-model="dataType" placeholder="Select a character" expanded>
                                        <option value="text">текстовый</option>
                                        <option value="integer">целое число</option>
                                        <option value="number">любое число</option>
                                        <option value="select">одно из значений</option>
                                        <option value="multiple">несколько значений</option>
                                        <option value="logical">логический</option>
                                        <option value="date">дата</option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>

                        <div class="columns" v-if="dataType !== 'logical' && dataType !== 'date'">
                            <div class="column"></div>
                            <div class="column is-three-fifths">
                                <b-field v-if=" dataType !== 'logical' && dataType !== 'date'" label="Единицы измерения" label-position="on-border">
                                    <b-input v-model="item.units" placeholder="Штрих-код товара" />
                                </b-field>

                                <b-field v-if="dataType === 'text'" label="Пример заполнения" label-position="on-border">
                                    <b-input v-model="item.barcode" placeholder="Штрих-код товара" />
                                </b-field>

                                <b-field v-if="dataType === 'select' || dataType === 'multiple'" label="Список значений" label-position="on-border">
                                    <b-input v-model="item.sale_text" type="textarea" rows="5" />
                                </b-field>
                            </div>
                            <div class="column"></div>
                        </div>
                    </card-component>

                    <div class="buttons margin-line is-centered">
                        <button :disabled="saved" @click="save" :class="{ 'is-loading': loading }"
                                type="button" class="button is-primary">Сохранить</button>
                        <button @click="modal=false" type="button" class="button">Закрыть</button>
                    </div>
                </form>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import core from "../js/Core";
    import CardComponent from "./CardComponent";
    import ImagesUpload from "./ImagesUpload";
    import axios from "axios";

    export default {
        name: "CategoryFeatures",

        components: { CardComponent },

        props: ['propItems'],

        // props: {
        //     propItems: {
        //         type: Object,
        //         default: () => {}
        //     },
        //     // number: {
        //     //     type: Number,
        //     //     default: 0
        //     // },
        // },

        data () {
            return {
                items: [],
                item: {},
                openedDetails: [],

                dataType: 'text',

                modal: true,
                loading: false,
                saved: true,
            }
        },

        mounted() {
            //this.items = Object.values(this.propItems);

            //console.log(Object.values(this.propItems));
        },

        methods: {
            create() {
                this.item = {
                    id: null,
                };

                this.modal = true;
            },

            autoSave() {
                //this.save(false);
            },

            save(submit = true) {
                for(let parameter in this.parameters) {
                    if(!this.item.parameters[parameter]) {
                        if(submit) {
                            core.error('Заполните параметры товара');
                        }
                        return;
                    }
                }
                this[(this.item.id) ? 'update' : 'store'](this.item);
            },

            store(item) {
                this.statusLoading();
                axios.post(`/admin/variant/store`, item)
                    .then((res) => {
                        this.item = res.data.variant;
                        this.items.push(item);
                        this.item.savedCode = this.item.code;
                        this.$emit('update', this.items.length);
                    })
                    .catch((error) => core.ajaxError(error.response))
                    .then(() => this.statusSaved());
            },

            update(item) {
                this.statusLoading();
                axios.post(`/admin/variant/${item.id}/update`, item)
                    .then(() => this.$emit('update', this.items.length))
                    .catch((error) => {
                        core.ajaxError(error.response);
                        this.item.code = this.item.savedCode;
                    })
                    .then(() => this.statusSaved());
            },

            statusLoading() {
                this.saved = false;
                this.loading = true;
            },

            statusSaved() {
                this.saved = true;
                this.loading = false;
            },



            // drag&sort
            dragstart (payload) {
                //this.openedDetails = [];

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

            drop(payload) {
                payload.event.target.closest('tr').classList.remove('is-selected');

                if (payload.row && this.draggingRow) {
                    let temp = payload.row.order;
                    payload.row.order = this.draggingRow.order;
                    this.draggingRow.order = temp;

                    this.$refs.table.initSort();
                }
            }
        }
    }
</script>

<style scoped>
    .box {
        width: 30rem;
    }
</style>
