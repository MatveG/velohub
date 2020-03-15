<template>
    <b-collapse :open="isOpen" class="card" animation="slide" aria-id="prices-stocks">
        <div slot="trigger" slot-scope="props" class="card-header" aria-controls="prices-stocks">
            <p class="card-header-title">{{ title }}</p>
            <a class="card-header-icon">
                <i :class="props.open ? 'fas fa-angle-down' : 'fas fa-angle-up'" aria-hidden="true"></i>
            </a>
        </div>
        <div class="card-content">
            <div class="content">
                <slot />
            </div>
        </div>
    </b-collapse>
</template>

<script>
    export default {
        name: "CardCollapse",
        props: ['isOpen', 'title']
    }
</script>
