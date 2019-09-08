<template>
    <div>
        <a class="load-more" v-if="view" href="javascript:void(0);" @click="loadMore">
            <i class="fa fa-ellipsis-h fa-lg"></i>
            Load {{ pagination.perPage }} more from the next {{ remaining}}
        </a>
    </div>
</template>

<script>
    export default {
        name: "LoadMore",
        props: {
            pagination:{type: Object, required: true},

        },
        methods: {},
        data() {
            return {

            }
        },
        mounted() {
        },
        computed: {
            view: function(){
                return this.pagination.page < this.pagination.totalPages
            },
            remaining: function () {
                return this.pagination.totalRows - (this.pagination.perPage*this.pagination.page);
            }
        },
        watch: {},
        methods: {
            loadMore: function () {
                this.$emit('load-more');
            }
        }
    }
</script>

<style scoped>

</style>
