<template>
    <div class="filters" v-if="show" :id="id">
        <div class="alert alert-filter">
            <i class="fa fa-bolt"></i> Showing {{ total }} filtered results <button  class="btn btn-default btn-sm" @click="hideAlert"><i class="fa fa-retweet"></i> Clear Filter</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SortFilter",
        props: {
            total:{type: Number, required: true, default: 0},
            show:{type: Boolean, required: true, default: false},
            id:{type: String, required: true}
        },
        methods: {},
        data() {
            return {
               // sort_icon: this.order == 'asc' ? 'fa-arrow-up' : 'fa-arrow-up'
            }
        },
        mounted() {
        },
        computed: {

        },
        watch: {},
        methods: {
            hideAlert: function () {
                this.$root.$emit('filter-bar::clear', {'id': this.id});
            }
        }
    }
</script>

<style scoped>

</style>
