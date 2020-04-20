<template>
    <section class="section is-main-section">
        <card-component class="has-table has-mobile-sort-spaced" title="Товары">
            <category-table v-if="items.length" :prop-items="items" />
        </card-component>
    </section>
</template>

<script>
    import axios from 'axios';
    import CardComponent from "../components/CardComponent";
    import CategoryTable from "../components/CategoryTable";

    export default {
        name: 'CategoryIndex',

        components: {
            CardComponent,
            CategoryTable
        },

        data () {
            return {
                items: [],
                loading: false,
            }
        },

        mounted () {
            this.dataUrl = '/admin/category/';
            this.loading = true;

            axios
                .get(this.dataUrl)
                .then(r => {
                    this.loading = false;
                    if (r.data && r.data.items) {
                        this.items = r.data.items
                    }
                })
                .catch(e => {
                    this.loading = false
                    this.$buefy.toast.open({
                        message: `Error: ${e.message}`,
                        type: 'is-danger'
                    })
                });
        },

        methods: {

        }
    }
</script>
