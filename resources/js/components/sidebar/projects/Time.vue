<template>
    <div class="project-filter-list" v-if="showWidget">
        <form action="">
            <div class="filter-block">
                <div class="filter-header">
                    Keyword
                </div>
                <div class="filter-body">
                    <input type="text" v-model="filter.keyword" class="form-control form-control-sm" placeholder="keyword">
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-header">
                    Created Date
                </div>
                <div class="filter-body">
                    <v-select :clearable="clearable"
                        v-model="filter.created_range"
                        label="value"
                        :options="created_options"
                    ></v-select>
                    <div class="date-range" v-if="filter.created_range.id == 1">
                        <div class="date-range-block">
                            <div class="input-group date">
                                <label class="label">Created After</label>
                                <b-input-group size="sm">
                                    <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                    <date-picker v-model="filter.start_date" ref="startDate" placeholder="Start Date"></date-picker>
                                </b-input-group>
                            </div>
                        </div>
                        <div class="date-range-block">
                            <label class="label">Created Before</label>
                            <b-input-group size="sm">
                                <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                <date-picker v-model="filter.end_date" ref="startDate" placeholder="End Date"></date-picker>
                            </b-input-group>
                        </div>
                    </div>

                </div>
            </div>

            <div class="filter-block">
                <div class="filter-header">
                    Logged By
                </div>
                <div class="filter-body">
                    <v-select :clearable="clearable" :taggable="taggable" :multiple="true"
                        v-model="filter.logged_by"
                        label="name"
                        :options="users"
                    ></v-select>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-body">
                    <button @click="applyFilter" type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-filter"></i> Apply Filter</button>
                    <button @click="resetFilter"  class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Reset Filter</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "project-time",
        data(){
            return {
                size:20,
                inline:true,
                avatarStyle: {'margin-right':'5px'},
                filter: {},
                dateOptions: {
                    inline: true
                },
                clearable: false,
                taggable: true,
                due_options: [
                    {id: '0', value: 'Any Time'},
                    {id: '1', value: 'No Due Date'},
                    {id: '2', value: 'No Start Date'},
                    {id: '3', value: 'No Due or Start Date'},
                    {id: '4', value: 'Custom Range'},
                ],
                created_options: [
                    {id: '0', value: 'Any Time'},
                    {id: '1', value: 'Custom Range'},
                ]
            }
        },
        mounted(){
            this.$store.dispatch('users/getUsersList');
        },
        created(){
            this.filter = _.cloneDeep(this.$store.getters['timelog/getFilters']);
            this.$root.$on('filter-bar::clear', (val) => {
                if (val.id == 'project-time-list')
                    this.resetFilter();
            });
            this.$root.$on('filter-slate::clear', (val) => {
                if (val.name == 'project-time-list')
                    this.resetFilter();
            })
        },
        computed:{
            showWidget(){
                return this.$route.name == 'project-time'?  true : false;
            },
            users(){
                return _.cloneDeep(this.$store.getters['users/getUsersList']);
            }
        },
        methods:{
            getTime: function(){
                this.$store.commit('timelog/setPage', 1);
                this.$root.$emit('project-time-loading', true);
                this.$store.dispatch('timelog/getTimeLog')
                    .then(res => {
                        this.$root.$emit('project-time-loading', false);
                });
            },
            applyFilter: function () {
                if (!_.isEqual(this.filter, this.$store.getters['timelog/getFilters'])) {
                    this.$store.commit('timelog/setFilters', this.filter);
                    this.getTime();
                }

            },
            resetFilter: function () {
                this.filter = {...this.$filters.project_time};
                this.$store.commit('timelog/setFilters', this.filter);
                this.getTime();
            }
        }
    }
</script>

<style scoped>

</style>
