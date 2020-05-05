<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button @click="$router.push({ name: 'category.create' })" class="button is-primary fas fa-plus"></button>
        </div>
        <card-component class="has-table has-mobile-sort-spaced" title="Товары">
            <category-table v-if="items.length" :prop-items="items" :recursive="false" />
        </card-component>
    </section>
</template>

<script>
    import axios from 'axios';
    import CardComponent from "../../components/CardComponent";
    import CategoryTable from "../../components/CategoryTable";

    export default {
        name: 'Categories',

        components: {
            CardComponent,
            CategoryTable
        },

        data () {
            return {
                items: [],
            }
        },

        mounted () {
            axios.get('/admin/categories/')
                .then((res) => this.items = res.data)
                .catch((error) => core.ajaxError(error))
        },
    }
</script>
