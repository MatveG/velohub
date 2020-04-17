<template>
    <div class="columns">
        <template v-if="['string', 'number', 'select'].includes(dataType.key)">
            <div class="column">
                <b-field v-if="dataType.fields.includes('units')" label="Единицы измерения" label-position="on-border">
                    <b-input v-model="item.units" placeholder="кг" />
                </b-field>
                <b-field v-if="dataType.fields.includes('accuracy')"  label="Знаков после точки" label-position="on-border">
                    <b-input v-model.number="item.accuracy" placeholder="0" />
                </b-field>
                <div v-if="dataType.fields.includes('list')">
                    <b-field label="Список значений" label-position="on-border">
                        <b-input v-model="item.list" type="textarea" rows="4" placeholder="одна строка - одно значение" />
                    </b-field>
                    <b-field>
                        <b-checkbox v-model="item.multiple">Множественный выбор</b-checkbox>
                    </b-field>
                </div>
            </div>

            <div class="column">
                <article class="message">
                    <div class="message-body">

                        <template v-if="dataType.key === 'string'">
                            <p>
                                <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                            </p>
                            <p class="has-text-right">string value <span class="has-text-grey-light">{{ dataType.units }}</span></p>
                        </template>

                        <template v-if="dataType.key === 'number'">
                            <p>
                                <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                            </p>
                            <p class="has-text-right">
                                {{ (100.0000).toFixed(item.accuracy) }}
                                <span class="has-text-grey-light">{{ dataType.units }}</span>
                            </p>
                        </template>

                        <template v-if="dataType.key === 'select'">
                            <p>
                                <b>{{ (item.title) ? item.title : 'Title' }}</b>:
                            </p>
                            <p class="has-text-right">
                                <template v-if="item.multiple">
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
                    <template v-if="dataType.key === 'boolean'">
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
                    <template v-if="dataType.key === 'text'">
                        <p>
                            <b>{{ (item.title) ? item.title : 'Title' }}</b>
                        </p>
                        <i>The iPhone is a smartphone made by Apple that combines a computer, iPod, digital camera and cellular phone into one device with a touchscreen interface. The iPhone runs the iOS operating system (OS), and as of 2017, there were 2.2 million apps available for it through the Apple App Store, according to Statista.</i>
                    </template>
                    <template v-if="dataType.key === 'group'">
                        <table class="table is-striped is-fullwidth">
                            <tbody>
                            <tr>
                                <td colspan="2" class="is-bold">
                                    <b>{{ (item.title) ? item.title : 'Communication' }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="half-width">WLAN</td>
                                <td>Wi-Fi 802.11b/g</td>
                            </tr>
                            <tr>
                                <td>Bluetooth</td>
                                <td>v2.0 (headset support only)</td>
                            </tr>
                            <tr>
                                <td>GPS</td>
                                <td>No</td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </article>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FeatureExamples",

        props: {
            dataTypes: {
                type: Object,
                default: () => {}
            },
        },

        data () {
            return {
                dataType: {},
            }
        },
    }
</script>

<style scoped>
    .half-width {
        width: 50%;
    }
</style>
