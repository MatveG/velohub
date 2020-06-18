<template>
    <section class="section is-main-section">
        <div class="buttons is-right">
            <button @click="$router.push({ name: 'category-create' })" class="button is-primary fas fa-plus"></button>
        </div>
        <card-component class="has-table has-mobile-sort-spaced" title="Категории">
            <category-table />
        </card-component>
    </section>
</template>

<script>
    import {mapGetters} from "vuex";
    import CardComponent from "@/components/CardComponent";
    import CategoryTable from "../components/CategoryTable";

    export default {
        name: 'CategoryIndex',

        components: {
            CardComponent,
            CategoryTable
        },

        mounted() {
            this.$store.dispatch('fetchCategories');
        },
    }
</script>
