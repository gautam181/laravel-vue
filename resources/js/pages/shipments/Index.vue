<template>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "shipment-index",
        mounted() {
            console.log('Component mounted.')
            this.$emit('handle-page-header', {label:'Shipments', desc:'All active shipments'})
        },
        data(){
            return {
                childRoutes: this.$router.currentRoute
            }
        }
    }
</script>
