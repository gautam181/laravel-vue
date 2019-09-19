<template>
    <div>
        <div v-if="loaded">
            <div class="row">
                <div class="col-md-12">
                    <div class="list-options">
                        <h2 class="">Current Projects</h2>
                        <div class="btn-options text-right">
                            <button class="btn btn-md btn-success w-10" @click="addTime" ><i class="fa fa-plus-circle"></i> Add Time</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <filter-alert :total="pagination.totalRows" :show="!showFilters" id="time-list"></filter-alert>
                </div>
                <div class="col-md-12">
                    <div class="list-options">
                        <div>{{ pagination.totalRows}} results</div>
                        <div class="btn-options text-right">
                            <sort-filter :order="sortOrder" :selected="sortOption" v-on:update-sort="handleSort"  v-on:update-order="handleSortOrder" :options="sortOptions"></sort-filter>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row  list">
                <loading-spinner label="Loading Time Log" :show="loading"></loading-spinner>
                <div class="col-md-12">
                    <time-list :time_entries="time_entries"></time-list>
                </div>

                <div class="col-md-12">
                    <load-more :pagination="pagination" v-on:load-more="loadMore"></load-more>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import SortFilter from "../../components/ui/SortFilter";
    import LoadMore from "../../components/ui/LoadMore";
    import FilterAlert from "../../components/ui/FilterAlert";
    import TimeList from "../../components/ui/TimeList";

    export default {
        name: "project-time",
        data(){
            return {
                myRoute : {},
                showTimeForm: false,
                project_id : this.$route.params.id,
                loaded: false,
                loading: false,
                sortOptions: [
                    {id: 'logged_by', 'label': 'Who logged time'},
                    {id: 'date', 'label': 'Date'},
                    {id: 'ticket_id', 'label': 'Ticket'}
                ],
                size:25,
            }
        },
        components:{
            SortFilter, LoadMore, FilterAlert, TimeList
        },
        created(){
            this.$eventBus.$emit('project-info', this.project_id);
            this.$store.commit('timelog/setProjectId', this.project_id);
            this.$eventBus.$on('project-time-loading', val => {
                this.loading = val;
            });
        },
        computed: {
            time_entries:{
                get() { return this.$store.getters['timelog/getTimeLog']; },
                set(value) { this.$store.commit('timelog/setTimeLog', value); },
            },
            showFilters: function(){
                return _.isEqual(this.$filters.project_time, this.filters);
            },
            ...mapGetters({
                pagination: 'timelog/getPagination',
                filters: 'timelog/getFilters',
                sortOrder: 'timelog/getOrderBy',
                sortOption: 'timelog/getSortBy'
            })
        },
        mounted(){
            this.$store.commit('timelog/setPage', 1);
            this.fetchTime();
        },
        methods:{
            showTime(val){
                return true;
                if (this.completed){
                    return val == 100 ? true : false;
                } else {
                    return val != 100 ? true : false;
                }

            },
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            handleSortOrder: function(val){
                this.$store.commit('timelog/setOrderBy', val);
                this.fetchTime();
            },
            addTime: function(){
                //
            },
            handleSort: function(val){
                this.$store.commit('timelog/setSortBy', val);
                this.fetchTime();
            },
            editProject: function(id){
                this.$eventBus.$emit('project-time', id);
            },
            loadMore: function(){
                this.$store.commit('timelog/setPage', this.pagination.page + 1);
                this.fetchTime(true);
            },
            fetchTime: function (val) {
                let mode = val != undefined ? val : false;
                if(!mode)
                    this.$eventBus.$emit('project-time-loading', true);
                this.$store.dispatch('timelog/getTimeLog', mode)
                    .then(res => {
                        this.loaded = true;
                        this.loading = false;
                    })
                    .catch(e => {
                        this.loading = false;
                    });
            },
            paginate: function (val) {
                this.$store.commit('timelog/setPage', val);
                this.fetchTime();
            }
        }
    }
</script>

<style scoped>

</style>
