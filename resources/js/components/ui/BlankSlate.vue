<template>
    <div class="blank-slate">
        <div class="slate-body">
            <div class="slate-image">
                <img src="../../images/listings.svg">
            </div>
            <div class="slate-text">
                <h3>There are not data that matches your filter</h3>
                <p><a href="javascript:void(0)" @click="clearFilter">Clear filter</a> to view all data</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BlankSlate",
        props: {
            'name': {type: String, required: true}
        },
        methods: {
            clearFilter: function () {
                this.$eventBus.$emit('filter-slate::clear', {'name': this.name});
            }
        },
        data() {
            return {}
        },
        mounted() {
        },
        watch: {}
    }
</script>

<style scoped>

</style>
