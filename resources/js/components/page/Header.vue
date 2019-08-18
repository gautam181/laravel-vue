<template>
    <div class="small-header" v-if="headerData.label" >
        <div class="panel dark">
            <div class="panel-heading">
                {{ this.headerData.label }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header",
        props: ['headerData']
    }
</script>

<style scoped>

</style>
