<template>
    <div>
        <div v-if="loaded">
            <div class="row">
                <div class="col-md-12">
                    <div class="list-options">
                        <h2 class="">Files</h2>
                        <div class="btn-options text-right">
<!--                            <button class="btn btn-md btn-success w-10" @click="addTime" ><i class="fa fa-plus-circle"></i> Add Files</button>-->
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
                    <template v-for="row in group_files">
                        <div class="group-sub-heading" v-if="row.label">
                            {{ row.label }}
                        </div>
                        <files-list :files="row.data"></files-list>
                    </template>
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
    import FilesList from "../../components/ui/FileList";

    export default {
        name: "project-files",
        data(){
            return {
                myRoute : {},
                showTimeForm: false,
                project_id : this.$route.params.id,
                loaded: false,
                loading: false,
                showSummary: false,
                sortOptions: [
                    {id: 'name', 'label': 'File Name'},
                    {id: 'updated', 'label': 'Updated on'},
                    {id: 'size', 'label': 'Size'}
                ],
                size:25,
            }
        },
        components:{
            SortFilter, LoadMore, FilterAlert, FilesList
        },
        created(){
            this.$root.$emit('project-info', this.project_id);
            this.$store.commit('files/setProjectId', this.project_id);
            this.$root.$on('project-files-loading', val => {
                this.loading = val;
            });
            this.$root.$on('timeUpdate', val => {
                this.fetchTime();
            });
        },
        computed: {
            files:{
                get() { return this.$store.getters['files/getFiles']; },
                set(value) { this.$store.commit('files/setFiles', value); },
            },
            showFilters: function(){
                return _.isEqual(this.$filters.project_files, this.filters);
            },
            group_files: function () {

                if (this.sortOption != 'updated')
                    return [{ id: '', data: this.files, label: ''}];

                return _.chain(this.files)
                  .groupBy((val)=>{
                      return this.$options.filters.date(val.updated_at);
                  })
                  .map((val, key)=> ({
                      id: key,
                      label: this.$options.filters.date(val[0]['updated_at']),
                      data: val
                      })
                  ).value();
            },
            ...mapGetters({
                pagination: 'files/getPagination',
                filters: 'files/getFilters',
                sortOrder: 'files/getOrderBy',
                sortOption: 'files/getSortBy'
            })
        },
        mounted(){
            this.$store.commit('files/setPage', 1);
            this.fetchFiles();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            handleSortOrder: function(val){
                this.$store.commit('files/setOrderBy', val);
                this.fetchFiles();
            },
            addTime: function(){
                //
            },
            handleSort: function(val){
                this.$store.commit('files/setSortBy', val);
                this.fetchFiles();
            },
            editProject: function(id){
                this.$root.$emit('project-time', id);
            },
            loadMore: function(){
                this.$store.commit('files/setPage', this.pagination.page + 1);
                this.fetchFiles(true);
            },
            fetchFiles: function (val) {
                let mode = val != undefined ? val : false;
                if(!mode)
                    this.$root.$emit('project-time-loading', true);
                this.$store.dispatch('files/getFiles', mode)
                    .then(res => {
                        this.loaded = true;
                        this.loading = false;
                    })
                    .catch(e => {
                        this.loaded = true;
                        this.loading = false;
                    });
            },
            paginate: function (val) {
                this.$store.commit('files/setPage', val);
                this.fetchFiles();
            },
            getTotalHours: function(hours, minutes){
                let sum = parseInt(hours*60) + parseInt(minutes);

                let hrs = (sum/60).toFixed(2);
                let m = (sum%60);
                let h = ((sum-m)/60).toFixed(0);
                let ts = '';
                if (h > 0)
                    ts += h + ' hours ';
                if (m > 0)
                    ts += m + ' minutes ';

                ts += ' ('+hrs+')';
                return ts;
            },
        }
    }
</script>

<style scoped>

</style>
