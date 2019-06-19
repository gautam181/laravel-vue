<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader"></router-view>
    </div>
</template>

<script>
    export default {
        name: "sale-index",
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            }
        }
    }
</script>

<style scoped>

</style>